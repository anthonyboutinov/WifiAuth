<?php
	
	include 'DBInterface.php';

	class DBWiFiInterface extends DBInterface {
		
		var $is_router;
		var $id_db_user = null;
		var $id_db_user_editor = null;
		var $id_min_access_level = null;
		
		var $superadmin_name = null;
		
		var $tablePageLimit = null;
		var $dashboardTablePreviewLimit = null;
		
		var $access_level_accepted = null;
		
		function    __construct($servername, $username, $password, $dbname, $router_login, $router_pasword, $cli_login, $cli_password, $id_cli) {
			parent::__construct($servername, $username, $password, $dbname);
						
			if        ($router_login && $router_pasword && !$cli_login && !$cli_password && !$id_cli) {
				// Get web user credentials (from router)
				$this->id_db_user = $this->getWebUserByAuthenticatingViaRouterData($router_login, $router_pasword);
				
			} else if (!$router_login && !$router_pasword && $cli_login && $cli_password && !$id_cli) {
				// Get web user credentials (from live user) (login act)
				$this->setWebUser($cli_login, $cli_password);
				
			} else if (!$router_login && !$router_pasword && !$cli_login && !$cli_password && $id_cli) {
				// Set id
				$this->setWebUserByID($id_cli);
			
			} else if (!$router_login && !$router_pasword && !$cli_login && !$cli_password && !$id_cli) {
				// Ничего не делать, база данных подключена.
				
			} else {
				die('Error: DBWiFiTinterface constructor received bad parameters');
			}
						
			if($this->is_valid()) {
				$this->pretendToBe();
				
				// Get other data
				$this->tablePageLimit = $this->getValueByShortName('TABLE_PAGE_LIMIT')['NUMBER_VALUE'];
				$this->dashboardTablePreviewLimit = $this->getValueByShortName('DASHBOARD_TABLE_PREVIEW_LIMIT')['NUMBER_VALUE'];
				
			}
			
// 			Notification::add("Database interface constructor performed ".$this->num_queries_performed.' queries');
						
		}
		
		public function getNumQueriesPerformed() {
			return $this->num_queries_performed;
		}
		
		# ========================================================================= #
		# ==== PUBLIC ОПРЕДЕЛЕНИЕ ТИПА ПОЛЬЗОВАТЕЛЯ И ПРАВ ДОСТУПА ==== #
		# ========================================================================= #

		
		public function is_router() {
			return $this->is_router;
		}
		
		public function is_superadmin() {
			return isset($this->id_db_user_editor);
		}
		
		public function is_valid() {
			return (isset($this->id_db_user_editor) || isset($this->id_db_user));
		}
		
		public function is_db_user() {
			return isset($this->id_db_user);
		}
		
		public function meetsAccessLevel($accl_short_name) {
			foreach ($this->access_level_accepted as $value) {
				if ($accl_short_name == $value) {
					return true;
				}
			}
			return false;
		}
		
		# ==== КОНЕЦ PUBLIC ОПРЕДЕЛЕНИЕ ТИПА ПОЛЬЗОВАТЕЛЯ И ПРАВ ДОСТУПА ==== #
		# ========================================================================= #		
		
		# =============================================================== #
		# ==== PUBLIC ПОЛУЧЕНИЕ ID ПОЛЬЗОВАТЕЛЯ ==== #
		# =============================================================== #

		
		public function getBDUserID() {
			return isset($this->id_db_user_editor) ? $this->id_db_user_editor : $this->id_db_user;
		}
		
		public function getSuperadminName() {
			return $this->superadmin_name;
		}

		# ==== КОНЕЦ PUBLIC ПОЛУЧЕНИЕ ID ПОЛЬЗОВАТЕЛЯ ==== #
		# =============================================================== #
		
		# ======================================================================== #
		# ==== ПЕРВИЧНАЯ ОБРАБОТКА ПОЛЬЗОВАТЕЛЯ (АВТОРИЗАЦИЯ)                 ==== #
		# ======================================================================== #
		
		private function setAcceccLevelAcceptedArray() {
			$sql = 'SELECT AL.ID_ACCESS_LEVEL, AL.SHORT_NAME FROM CM$ACCESS_LEVEL AL ORDER BY AL.ORDER ASC';
			$result = $this->toArray($this->getQueryResultWithErrorNoticing($sql));
			$result = CommonFunctions::extractSingleValueFromMultiValueArray($result, 'SHORT_NAME', 'ID_ACCESS_LEVEL');
			
			$out = array();
			foreach ($result as $key => $value) {
				if ($key >= $this->id_min_access_level) {
					$out[] = $value;
				}
			}
			
			$this->access_level_accepted = $out;
		}
		
		private function getWebUserByAuthenticatingViaRouterData($router_login, $routerPassword) {
			$this->sanitize($router_login);
			$this->sanitize($routerPassword);
			
			$sql = 'SELECT ID_DB_USER, IS_ACTIVE, ROUTER_PASSWORD FROM CM$DB_USER WHERE IS_SUPERADMIN=\'F\' AND ROUTER_LOGIN=\''.$router_login.'\'';
			$result = $this->conn->query($sql);
			if ($result === false) {
				die("Error with query $sql");
			}
			
			if ($result->num_rows == 1) {
				while($row = $result->fetch_assoc()) {
					if (password_verify($row['ROUTER_PASSWORD'], $routerPassword)) {
						if ($row["IS_ACTIVE"] == 'F') {
							die("Error #1: Router $router_login is disabled.");
						} else {
							$this->is_router = true;
							return $row['ID_DB_USER'];
						}
					} else {
						die("Error #2: Credentials for router $router_login are incorrect.");
					}
				}
			} else {
				die("Error #2: Credentials for router $router_login are incorrect.");
			}
		}

		private function processVerifiedUser($row, $web_user) {
			if ($row["IS_ACTIVE"] == 'F') {
				Notification::add("Обслуживание аккаунта $web_user приостановлено", 'danger');
				return false;
			} else {
				if ($row['IS_SUPERADMIN'] == 'T') {
					$this->id_db_user_editor = $row['ID_DB_USER'];
					$this->id_min_access_level = $row['ID_ACCESS_LEVEL'];
					$this->superadmin_name = $row['LOGIN'];
					$this->setAcceccLevelAcceptedArray();
				} else {
					$this->id_db_user = $row['ID_DB_USER'];
				}
				$this->is_router = false;
				return true;
			}
		}

		private function setWebUserByID($id) {
			$this->sanitize($id);
			
			$sql = 
			'SELECT U.ID_DB_USER, U.IS_ACTIVE, U.LOGIN, U.PASSWORD, U.ID_ACCESS_LEVEL, U.IS_SUPERADMIN
			FROM CM$DB_USER U WHERE U.ID_DB_USER='.$id;
			
			$result = $this->getQueryFirstRowResultWithErrorNoticing($sql, $id);
			return $this->processVerifiedUser($result, $id);
		}
		
		private function updateNumFailedAttempts($id_db_user) {
			$sql =
			'update CM$DB_USER set
				LAST_FAILED_ATTEMPT=NOW(),
				NUM_FAILED_ATTEMPTS=IFNULL(NUM_FAILED_ATTEMPTS, 0)+1,
				ID_DB_USER_MODIFIED='.$id_db_user.'
			where ID_DB_USER='.$id_db_user;
			$this->getQueryResultWithErrorNoticing($sql);
			Notification::add("Логин и(или) пароль неверны", 'danger');
		}
		
		private function resetFailedLoginAtteptFields($id_db_user) {
			// Сбросить счетчики неверных паролей
			$sql =
			'update CM$DB_USER set
				UNLOCK_AT=NULL,
				LAST_FAILED_ATTEMPT=NULL,
				NUM_FAILED_ATTEMPTS=NULL,
				ID_DB_USER_MODIFIED='.$id_db_user.'
			where ID_DB_USER='.$id_db_user;
			$this->getQueryResultWithErrorNoticing($sql);
		}
		
		private function setWebUser($web_user, $web_password) {
			$this->sanitize($web_user);
			$this->sanitize($web_password);
			
			$maxAttempts = 6; // Максимальное количество попыток, разрешенное на непрерывные попытки ввести пароль
			$caution_wait_time_interval = 30; /* 30 минут: если неверно ввел пароль и с момента этого ввода пароля прошло больше 30 минут, то в новую попытку ввода пароля счетчик неверных попыток сбросится */
			
			$sql = 
			'SELECT U.ID_DB_USER, U.IS_ACTIVE, U.LOGIN, U.PASSWORD, U.ID_ACCESS_LEVEL, U.IS_SUPERADMIN, U.NUM_FAILED_ATTEMPTS, U.LAST_FAILED_ATTEMPT,
			CASE WHEN U.UNLOCK_AT IS NOT NULL
		       THEN \'T\' ELSE \'F\'
			END AS IS_LOCKED,
			CASE WHEN U.UNLOCK_AT IS NOT NULL AND U.UNLOCK_AT < NOW()
		       THEN \'T\' ELSE \'F\'
			END AS PERFORM_UNLOCK,
			CASE WHEN U.LAST_FAILED_ATTEMPT IS NOT NULL AND U.LAST_FAILED_ATTEMPT < DATE_SUB(NOW(), INTERVAL '.$caution_wait_time_interval.' MINUTE)
		       THEN \'T\' ELSE \'F\'
			END AS LAST_FAILED_ATTEMPT_WAS_LONG_AGO
			FROM CM$DB_USER U WHERE LOWER(U.LOGIN)=LOWER(\''.$web_user.'\')';
			
			$result = $this->getQueryFirstRowResultWithErrorNoticing($sql, $web_user, true);
			
			// Если логин найден
			if ($result) {
				
				// если пользователь заблокирован
				if ($result['IS_LOCKED'] == 'T') {
					
					// Если наступило время его разблокировать
					if ($result['PERFORM_UNLOCK'] == 'T') {
						
						// Разблокировать его:
						$sql =
						'update CM$DB_USER set
							UNLOCK_AT=NULL,
							LAST_FAILED_ATTEMPT=NULL,
							ID_DB_USER_MODIFIED='.$result['ID_DB_USER'].'
						where ID_DB_USER='.$result['ID_DB_USER'];
						$this->getQueryResultWithErrorNoticing($sql);
						// Продолжить после этого if'а проверку пароля...
						
					} else { // Если время разблокировки еще не наступило
						// Оповестить, что еще рано
						Notification::add("Доступ к аккаунту ".$web_user." временно заблокирован по причине многократных попыток ввода неверного пароля в течение короткого времени. Блокировка истечет через час.", 'danger');
						return false;
						
					}
				}
				
				// Если пароли совпадают
				if (password_verify($web_password, $result['PASSWORD'])) {
					
					// Сбросить счетчики неверных паролей
					$this->resetFailedLoginAtteptFields($result['ID_DB_USER']);
					
					// Обработать верифицированного пользователя: запомнить в себе (this)
					return $this->processVerifiedUser($result, $web_user);
					
				} else /* Если пароли не совпдают */ {

					// Если уже были неверные попытки ввода пароля
					if ($result['NUM_FAILED_ATTEMPTS'] != null) {

						// Если эти попытки были давно
						if ($result['LAST_FAILED_ATTEMPT_WAS_LONG_AGO'] == 'T') {
							// То сбросить счетчики неверных паролей
							$this->resetFailedLoginAtteptFields($result['ID_DB_USER']);
						}

						// Если лимит ошибок превышен
						if ($result['NUM_FAILED_ATTEMPTS'] >= $maxAttempts - 1) {

							// Заблокировать временно
							$sql =
							'update CM$DB_USER set
								LAST_FAILED_ATTEMPT=NULL,
								NUM_FAILED_ATTEMPTS=NULL,
								UNLOCK_AT=DATE_ADD(NOW(), INTERVAL 1 HOUR),'./* 1 час: установить момент разблокировки на «через 1 час» */'
								ID_DB_USER_MODIFIED='.$result['ID_DB_USER'].'
							where ID_DB_USER='.$result['ID_DB_USER'];
							$this->getQueryResultWithErrorNoticing($sql);
							Notification::add("Вы несколько раз неверно ввели пароль в течение короткого времени. Доступ в личный кабинет заблокирован на 1 час.", 'danger');
							
						} else /* Если не превышен еще*/ {

							// Увеличить счетчик и выдать предупреждение
							$this->updateNumFailedAttempts($result['ID_DB_USER']);
							
							// Если осталось 3 попытки ввода пароля
							if ($result['NUM_FAILED_ATTEMPTS'] >= $maxAttempts - 3) {
								
								// Предупредить об этом
								$num_tries_left = $maxAttempts - $result['NUM_FAILED_ATTEMPTS'] - 1;
								$postfix = $num_tries_left == 1 ? 'а' : 'и';
								Notification::add('У вас осталось '.$num_tries_left.' попытк'.$postfix.' ввода пароля, прежде чем вход в Личный кабинет будет (временно) заблокирован.', 'warning');
							}
						}
						
					} else /* Если пароль введен неверно в первый раз */ {
						// Увеличить счетчик и выдать предупреждение
						$this->updateNumFailedAttempts($result['ID_DB_USER']);
					}
					
					return false;
				}
			} else /* Если логин не найден */ {
				Notification::add("Логин и(или) пароль неверны", 'danger');
				return false;
			}
		}
				
		private function pretendToBe() {
			if (isset($_POST['form-name']) && $_POST['form-name'] == 'pretend-to-be' && isset($_POST['pretend-to-be'])) {
				$_SESSION['pretend-to-be'] = $_POST['pretend-to-be'];
			}
						
			if (isset($_SESSION['pretend-to-be']) && $this->is_superadmin()) {
				if (CommonFunctions::startsWith('/superadmin-', "{$_SERVER['REQUEST_URI']}")) {
					unset($_SESSION['pretend-to-be']);
				} else {
					$this->id_db_user = $_SESSION['pretend-to-be'];
				}
			}
		}
		
		protected function getMixedDBUserID() {
			if (!isset($_SESSION['pretend-to-be']) && $this->id_db_user_editor) {
				return $this->id_db_user_editor;
			} else {
				return $this->id_db_user;
			}
		}
		
		# ==== КОНЕЦ ПЕРВИЧНАЯ ОБРАБОТКА ПОЛЬЗОВАТЕЛЯ (АВТОРИЗАЦИЯ) ==== #
		# ======================================================================== #
		
		
		# ============================================================= #
		# ==== ПОЛУЧЕНИЕ ДАННЫХ ИЗ СЛОВАРЯ ==== #
		# ============================================================= #

		
		
		public function getValueByShortName($short_name) {
			$this->sanitize($short_name);
			$sql = 'SELECT V.VALUE, CONVERT(V.VALUE, SIGNED) AS NUMBER_VALUE, V.BLOB_VALUE, V.ID_VAR FROM SP$VAR V WHERE V.ID_DICTIONARY IN (SELECT D.ID_DICTIONARY FROM CM$DICTIONARY D WHERE SHORT_NAME="'.$short_name.'") AND V.ID_DB_USER='.$this->getMixedDBUserID();
			$result = $this->getQueryFirstRowResultWithErrorNoticing($sql, $short_name);
			if ($result['VALUE'] == 'T' || $result['VALUE'] == 't') {
				$result['VALUE'] = true;
			} else if ($result['VALUE'] == 'F' || $result['VALUE'] == 'f') {
				$result['VALUE'] = false;
			}
			return $result;
		}
		
		public function getValueByID($id) {
			$this->sanitize($id);
			$sql = 'SELECT V.VALUE, CONVERT(V.VALUE, SIGNED) AS NUMBER_VALUE, V.BLOB_VALUE, V.ID_VAR FROM SP$VAR V WHERE V.ID_DICTIONARY='.$id.' AND V.ID_DB_USER='.$this->getMixedDBUserID();
			return $this->getQueryFirstRowResultWithErrorNoticing($sql, $id);
		}
		
		# ==== КОНЕЦ ПОЛУЧЕНИЕ ДАННЫХ ИЗ СЛОВАРЯ ==== #
		# ============================================================= #
		
		# ===================================================================================== #
		# ==== PROTECTED ОБЩИЕ МЕТОДЫ ПРЕОБРАЗОВАНИЯ ДАННЫХ ==== #
		# ===================================================================================== #
		
		protected function sanitizeFromTo(&$from, &$to) {
			$this->sanitize($from);
			if ($to == null) {
				$to = $this->tablePageLimit;
			} else {
				$this->sanitize($to);
			}
		}
		
		protected function appendToSQLIsOrInArrayOfValues($values, &$sql) {
			if (is_array($values)) {
				$sql = $sql.' in (';
				$isFirst = true;
				foreach ($values as $value) {
					if ($isFirst) {
						$isFirst = false;	
					} else {
						$sql = $sql.', ';
					}
					$sql = $sql.'\''.$value.'\'';
				}
				$sql = $sql.')';
			} else {
				$sql = $sql.'="'.$values.'"';
			}
		}
		
		# ==== КОНЕЦ PROTECTED ОБЩИЕ МЕТОДЫ ПРЕОБРАЗОВАНИЯ ДАННЫХ ==== #
		# ===================================================================================== #
		
		
		/**
		 *	getValuesForParentByShortName
		 *	
		 *	Получить значения по заданному родителю (или нескольким родителям)
		 *	(словарь имеет древовидную структуру, в результате запроса 
		 *	возвращаются все записи, относящиеся к требуемой ветке словаря)
		 *
		 *	@author		Anthony Boutinov
		 *
		 *	@param ($short_names) (string или array(string))	название ветки или нескольких веток словаря, например 'VARS'
		 *	@return (array)										сложный массив, где каждая строка результата доступна по ключу SHORT_NAME
		 */
		public function getValuesForParentByShortName($short_names) {
			$this->sanitize($short_names);
			$short_name = $short_names;
			
			$sql =
			'SELECT
				V.VALUE,
				CONVERT(V.VALUE, SIGNED) AS NUMBER_VALUE,
				V.BLOB_VALUE,
				V.ID_VAR,
				Y.SHORT_NAME,
				Y.NAME,
				Y.COMMENT,
				Y.ID_PARENT,
				W.NAME AS PARENT_NAME,
				DT.NAME AS DATA_TYPE
			FROM SP$VAR V
			LEFT JOIN CM$DICTIONARY Y ON V.ID_DICTIONARY=Y.ID_DICTIONARY
			LEFT JOIN CM$DICTIONARY W ON Y.ID_PARENT=W.ID_DICTIONARY
			LEFT JOIN CM$DICTIONARY DT ON DT.ID_DICTIONARY=Y.ID_DATA_TYPE
			WHERE
				V.ID_DICTIONARY IN (
					SELECT D.ID_DICTIONARY
					FROM CM$DICTIONARY D
					WHERE ID_PARENT IN (
						SELECT T.ID_DICTIONARY
						FROM CM$DICTIONARY T
						WHERE T.SHORT_NAME';
			$this->appendToSQLIsOrInArrayOfValues($short_name, $sql);
			$sql = $sql.'
					)
				)
				AND V.ID_DB_USER="'.$this->id_db_user.'"
				ORDER BY W.ORDER, Y.ORDER ASC';

			$result = $this->getQueryResultWithErrorNoticing($sql);
			return $this->keyRowsByColumn('SHORT_NAME', $result);
		}
		
		public function getDataTypesForParentByShortName($short_names) {
			$this->sanitize($short_names);
			$short_name = $short_names;
			
			$sql = '
			select
				D.ID_DICTIONARY,
				D.SHORT_NAME,
				DT.NAME as DATA_TYPE
			from CM$DICTIONARY D
			left join CM$DICTIONARY DT on DT.ID_DICTIONARY=D.ID_DATA_TYPE
			where D.ID_PARENT IN (
				SELECT P.ID_DICTIONARY FROM CM$DICTIONARY P where P.SHORT_NAME';
			$this->appendToSQLIsOrInArrayOfValues($short_name, $sql);
			$sql = $sql.') order by D.ORDER ASC';
						
			$result = $this->getQueryResultWithErrorNoticing($sql);
			return $this->keyRowsByColumn('SHORT_NAME', $result);
		}
		
		public function getLoginActs($from = 0, $to = null) {
			$this->sanitizeFromTo($from, $to);
			$sql = 'select * from VW_SP$LOGIN_ACT
			where ID_DB_USER='.$this->id_db_user.' limit '.$from.', '.$to;
			return $this->getQueryResultWithErrorNoticing($sql);
		}
		
		public function getTopUsers($from = 0, $to = null) {
			$this->sanitizeFromTo($from, $to);
			$sql = 'select * from VW_SP$USER_LOGIN_COUNT
			where ID_DB_USER='.$this->id_db_user.' limit '.$from.', '.$to;
			return $this->getQueryResultWithErrorNoticing($sql);
		}
		
		public function getUsers($from = 0, $to = null) {
			$this->sanitizeFromTo($from, $to);
			$sql = 'SELECT DISTINCT LOGIN_OPTION_NAME, LINK, NAME, BIRTHDAY, ID_LOGIN_OPTION
			FROM VW_SP$LOGIN_ACT
			WHERE ID_DB_USER='.$this->id_db_user.' limit '.$from.', '.$to;
			return $this->getQueryResultWithErrorNoticing($sql);
		}
		
		public function getBirthdays($from = 0, $to = null, $intellectual_view = 1) {
			$this->sanitizeFromTo($from, $to);
			$intellectual_view = $intellectual_view == 1 ? true : false;
			
			if (!$intellectual_view) {
				$sql = 'SELECT * FROM VW_SP$USER_BIRTHDAY WHERE ID_DB_USER='.$this->id_db_user.' limit '.$from.', '.$to;
			} else {
				$sql = 
				'select 
					Z.LINK,
					Z.NAME,
					Z.BIRTHDAY,
					Z.DAYS_UNTIL,
					Z.WILL_TURN,
					Z.LOGIN_OPTION_NAME,
					Z.LOGIN_OPTION_SHORT_NAME,
					Z.LOGIN_COUNT,
					Z.LOGIN_COUNT_INV + DAYS_UNTIL as COEF
				from (
					SELECT
						Y.LINK,
						Y.NAME,
						Y.BIRTHDAY,
						CASE
							WHEN DATEDIFF(Y.CURRBIRTHDAY, CURDATE()) < 0 THEN
								DATEDIFF(Y.NEXTBIRTHDAY, CURDATE())
							ELSE 
								DATEDIFF(Y.CURRBIRTHDAY, CURDATE())
						END AS DAYS_UNTIL,
						TIMESTAMPDIFF(YEAR, Y.B_DATE, CURDATE()) AS WILL_TURN,
						Y.LOGIN_OPTION_NAME,
						Y.LOGIN_OPTION_SHORT_NAME,
						CAST(1 / Y.LOGIN_COUNT * 30'./*коэффициент*/' AS UNSIGNED) as LOGIN_COUNT_INV,
						Y.LOGIN_COUNT
						
					from (
				
						SELECT DISTINCT
							W.LINK,
							W.NAME,
							W.BIRTHDAY AS B_DATE,
							DATE_FORMAT(W.BIRTHDAY, "%d.%m.%Y") AS BIRTHDAY,
							W.BIRTHDAY + INTERVAL(YEAR(CURRENT_TIMESTAMP) - YEAR(W.BIRTHDAY)) + 0 YEAR AS CURRBIRTHDAY,
							W.BIRTHDAY + INTERVAL(YEAR(CURRENT_TIMESTAMP) - YEAR(W.BIRTHDAY)) + 1 YEAR AS NEXTBIRTHDAY,
							W.LOGIN_OPTION_NAME,
							W.LOGIN_OPTION_SHORT_NAME,
							(
								select COUNT(E.ID_USER)
								from SP$LOGIN_ACT E
								where E.ID_DB_USER=W.ID_DB_USER
								and E.ID_USER=W.ID_USER
								and DATEDIFF(E.DATE_CREATED, CURDATE()) < 81'./*количество дней захода, которые учитываются*/'
							) AS LOGIN_COUNT
						FROM VW_SP$LOGIN_ACT W
						WHERE W.BIRTHDAY IS NOT NULL
						AND W.ID_DB_USER='.$this->id_db_user.'
				
					) Y
					order by DAYS_UNTIL = 0 desc, DAYS_UNTIL asc
				) Z
				where Z.DAYS_UNTIL < 32'./*максимальное количество дней до дня рождения*/'
				ORDER BY COEF = 0 ASC, COEF ASC;';
			}
			return $this->getQueryResultWithErrorNoticing($sql);
		}
		
		public function getLoginOptionsIgnoringDisabledOnes() {
			$sql = 'select LO.SHORT_NAME
			from VW_CM$LOGIN_OPTION LO
			left join SP$VAR V on LO.ID_LOGIN_OPTION=V.ID_DICTIONARY
			WHERE V.VALUE=\'T\' and V.ID_DB_USER='.$this->id_db_user;
			$result = $this->toArray($this->getQueryResultWithErrorNoticing($sql));
			return CommonFunctions::extractSingleValueFromMultiValueArray($result, 'SHORT_NAME');
		}
		
		var $loginOptions = null;
		
		public function getLoginOptions() {
			if ($this->loginOptions != null) {
				return $this->loginOptions;
			}
			$sql = 'select * from VW_CM$LOGIN_OPTION';
			$this->loginOptions = $this->toArray($this->getQueryResultWithErrorNoticing($sql));
			return $this->loginOptions;
		}
		
		public function getColors() {
			$sql = 'select * from VW_CM$COLOR';
			$result = $this->toArray($this->getQueryResultWithErrorNoticing($sql));
			return CommonFunctions::extractSingleValueFromMultiValueArray($result, 'COLOR');
		}
		
		public function getMainStatsTable($num_days) {

			$login_options = $this->getLoginOptions();

			$sql =
			'SELECT
				DATE_FORMAT(D.DATE, "new Date(%Y, %m, %d)") AS JSON_DATE,';			
			
			$isFirst = true;
			foreach ($login_options as $login_option) {
				$name = $login_option['NAME'];
				
				if ($isFirst === true) {
					$isFirst = false;
				} else {
					$sql = $sql.',';
				}
				
				$sql = $sql.
				'(
					SELECT COUNT(LA.ID_LOGIN_ACT) AS TOTAL
					FROM SP$LOGIN_ACT LA
					INNER JOIN CM$USER U ON U.ID_USER=LA.ID_USER
					LEFT JOIN VW_CM$LOGIN_OPTION LO ON LO.ID_LOGIN_OPTION=U.ID_LOGIN_OPTION
					WHERE LA.ID_DB_USER='.$this->id_db_user.'
					AND LO.ID_LOGIN_OPTION='.$login_option['ID_LOGIN_OPTION'].'
					AND DATE(LA.DATE_CREATED)=D.DATE
					) AS \''.$login_option['SHORT_NAME'].'\'';
				
			}

			$sql = $sql.
			'FROM (
				SELECT A.DATE 
				FROM (
					SELECT CURDATE( ) - INTERVAL( A.A + ( 10 * B.A ) + ( 100 * C.A ) ) DAY AS DATE
					FROM (
						SELECT 0 AS A
						UNION ALL SELECT 1 
						UNION ALL SELECT 2 
						UNION ALL SELECT 3 
						UNION ALL SELECT 4 
						UNION ALL SELECT 5 
						UNION ALL SELECT 6 
						UNION ALL SELECT 7 
						UNION ALL SELECT 8 
						UNION ALL SELECT 9
						) AS A
						CROSS JOIN (
			
						SELECT 0 AS A
						UNION ALL SELECT 1 
						UNION ALL SELECT 2 
						UNION ALL SELECT 3 
						UNION ALL SELECT 4 
						UNION ALL SELECT 5 
						UNION ALL SELECT 6 
						UNION ALL SELECT 7 
						UNION ALL SELECT 8 
						UNION ALL SELECT 9
						) AS B
						CROSS JOIN (
			
						SELECT 0 AS A
						UNION ALL SELECT 1 
						UNION ALL SELECT 2 
						UNION ALL SELECT 3 
						UNION ALL SELECT 4 
						UNION ALL SELECT 5 
						UNION ALL SELECT 6 
						UNION ALL SELECT 7 
						UNION ALL SELECT 8 
						UNION ALL SELECT 9
						) AS C
					) A
				WHERE A.DATE BETWEEN DATE_SUB(CURDATE(), INTERVAL '.$num_days.' DAY) AND CURDATE() 
			) D
			ORDER BY D.DATE DESC';
						
			return $this->toArray($this->getQueryResultWithErrorNoticing($sql));
		}
		
		var $loginCountByLoginOption = null;
		
		public function getLoginCountByLoginOption($num_days) {
			
			if ($this->loginCountByLoginOption != null) {
				return $this->loginCountByLoginOption;
			}
			
			$this->sanitize($num_days);
			
			$sql = '
			select
				count(A.ID_LOGIN_ACT) AS LOGIN_COUNT,
				U.ID_LOGIN_OPTION AS ID_LOGIN_OPTION,
				O.SHORT_NAME,
				O.NAME,
				A.ID_DB_USER AS ID_DB_USER
			from SP$LOGIN_ACT A
			inner join CM$USER U on A.ID_USER = U.ID_USER
			left join VW_CM$LOGIN_OPTION O on U.ID_LOGIN_OPTION = O.ID_LOGIN_OPTION
			where
				A.ID_DB_USER='.$this->id_db_user.'
				and DATE(A.DATE_CREATED) >= DATE_SUB(CURDATE(), INTERVAL '.$num_days.' DAY)
			group by U.ID_LOGIN_OPTION, A.ID_DB_USER, O.SHORT_NAME, O.NAME
			order by U.ID_LOGIN_OPTION;';
									
			$result = $this->getQueryResultWithErrorNoticing($sql);
			$out = $this->toArray($result);
			
			$total_count = 0;
			foreach ($out as $value) {
				$total_count += $value['LOGIN_COUNT'];
			}
			
			$i = 0;
			foreach ($out as $value) {
				$value['PERCENTAGE'] = (int)($value['LOGIN_COUNT'] / $total_count * 100);
				$out[$i++] = $value;
			}
			
			$this->loginCountByLoginOption = $out;
			return $out;
		}
		
		public function getShortReport() {
			$sql = 'select count(A.ID_LOGIN_ACT) as COUNT from SP$LOGIN_ACT A where DATE(A.DATE_CREATED) = CURDATE() and A.ID_DB_USER='.$this->id_db_user; // today
			$sql = $sql.' union all '.'select count(A.ID_LOGIN_ACT) as COUNT from SP$LOGIN_ACT A where DATE(A.DATE_CREATED) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) and A.ID_DB_USER='.$this->id_db_user; // yesterday
			$sql = $sql.' union all select Z.* from ('.'select count(A.ID_LOGIN_ACT) as COUNT from SP$LOGIN_ACT A where DATE(A.DATE_CREATED) > DATE_SUB(CURDATE(), INTERVAL 7 DAY) and A.ID_DB_USER='.$this->id_db_user; // last week
			$sql = $sql.' union '.'select count(A.ID_LOGIN_ACT) as COUNT from SP$LOGIN_ACT A where DATE(A.DATE_CREATED) > DATE_SUB(CURDATE(), INTERVAL 30 DAY) and A.ID_DB_USER='.$this->id_db_user; // last month
			$sql = $sql.' union '.'select count(A.ID_LOGIN_ACT) as COUNT from SP$LOGIN_ACT A where DATE(A.DATE_CREATED) > DATE_SUB(CURDATE(), INTERVAL 365 DAY) and A.ID_DB_USER='.$this->id_db_user; // last year
			$sql = $sql.' union '.'select count(A.ID_LOGIN_ACT) as COUNT from SP$LOGIN_ACT A where A.ID_DB_USER='.$this->id_db_user.') Z'; // all time

			$result = $this->getQueryResultWithErrorNoticing($sql);
			
			$out = array();
			$names = ['сегодня', 'вчера', 'неделю', 'месяц', 'год', 'все время'];
			$i = 0;
			while($row = $result->fetch_assoc()) {
				$out[$names[$i++]] = $row['COUNT'];
			}
			return $out;
			
		}
		
		
		// ========= Функции, изменяющие данные в БД =========
		
		public function addUser($first_name, $last_name, $user_href, $log_opt, $b_date)
		{
			$this->sanitize($first_name);
			$this->sanitize($last_name);
			$this->sanitize($user_href);
			$this->sanitize($log_opt);
			$this->sanitize($b_date);
			
            if($log_opt=='vk')
            	{
            		$log_opt = 1;
            	}
            else
            {
            	$log_opt =2;
            }
            $sql  = 'select ID_USER from CM$USER where LINK="'.$user_href.'"';

            $result = $this->getQueryFirstRowResultWithErrorNoticing($sql, $user_href, true /*не логировать, если нет результатов в запросе*/);

            if($result == null) {
            	
            	$sql = 'insert into CM$USER 
            	         (ID_LOGIN_OPTION,BIRTHDAY,NAME,LINK,ID_DB_USER_MODIFIED)  values( '
            		     .$log_opt.', STR_TO_DATE("'
            			 .$b_date.'","%d.%m.%Y "),"'
                         .$first_name.' '
                         .$last_name.'","'
                         .$user_href.'", '
                         .$this->id_db_user.')';

            	$this->getQueryResultWithErrorNoticing($sql);

            	$sql = 'select ID_USER from CM$USER order by ID_USER desc limit 0, 1';

            	$result = $this->getQueryFirstRowResultWithErrorNoticing($sql);

            	$id = $result['ID_USER'];
            } else {
            	$id = $result['ID_USER'];
            }


            $sql = 'insert into SP$LOGIN_ACT (ID_DB_USER,ID_USER) values ('.$this->id_db_user.', '.$id.')';
            $this->getQueryResultWithErrorNoticing($sql);

		}
		
		
		protected function postIsFine($rows, $allowEmptyStrings = false) {
			$post_is_fine = true;
			foreach ($rows as $value) {				
				if (!isset($_POST[$value])) {
					Notification::add("$POST значение для '$value' не задано!", 'danger');
					$post_is_fine = false;
				} else if ($allowEmptyStrings === false && $_POST[$value] == '') {
					$post_is_fine = false;
				}
			}
			return $post_is_fine;
		}
		

		public function processPostRequestUpdateVars($short_names) {
			
			function processFileToSQL($key, &$sql) {
				$user_file_key = $key.'_file';
					
				$fileName = $_FILES[$user_file_key]['name'];
				$tmpName  = $_FILES[$user_file_key]['tmp_name'];
				$fileSize = $_FILES[$user_file_key]['size'];
				$fileType = $_FILES[$user_file_key]['type'];
				
				$fp      = fopen($tmpName, 'r');
				$content = fread($fp, filesize($tmpName));
				$content = addslashes($content);
				fclose($fp);
				
				if(!get_magic_quotes_gpc()) {
				    $fileName = addslashes($fileName);
				}
				
				$sql = $sql.'BLOB_VALUE="'.$content.'"';
			}
			
			$rows = $this->getDataTypesForParentByShortName($short_names); // sanitized inside
			
			$post_is_fine = true;
			foreach ($rows as $key => $value) {
								
				if ($value['DATA_TYPE'] == 'file' || $value['DATA_TYPE'] == 'text&file') {
					if ($_FILES[$key.'_file']['size'] == 0) {
						$rows[$key]['field_doesnt_need_an_update'] = true;
					}
				} else if ($value['DATA_TYPE'] == 'checkbox') {
					if (isset($_POST[$key])) {
						$_POST[$key] = "T";
					} else {
						$_POST[$key] = "F";
					}
				} else if (!isset($_POST[$key])) {
					Notification::add("POST value for '$key' is not set.", 'danger');
					$post_is_fine = false;
				}
				
			}
			
			if (!$post_is_fine) {
				return false;
			}
			
			foreach ($rows as $key => $value) {
				
				if (isset($value['field_doesnt_need_an_update']) && $value['field_doesnt_need_an_update']) {
					continue;
				}
				
				$sql = 'update SP$VAR set ';
				if ($value['DATA_TYPE'] == 'file') {
					processFileToSQL($key, $sql);
				} else {
					if ($value['DATA_TYPE'] == 'text&file') {
						processFileToSQL($key, $sql);
						$sql = $sql.', ';
					}
					$sql = $sql.'VALUE="'.htmlspecialchars($_POST[$key]).'"';
				}
				
				$sql = $sql.' WHERE ID_DB_USER='.$this->id_db_user.' AND ID_DICTIONARY='.$value['ID_DICTIONARY'];
								
				$this->getQueryResultWithErrorNoticing($sql);
			}
			
			Notification::add("Изменения сохранены!", 'success');
			return true;
			
		}
		
		public function getDBUsers(){



			$sql='SELECT * FROM CM$DB_USER WHERE IS_SUPERADMIN=\'F\' ORDER BY LOGIN ASC';

			return  $this->getQueryResultWithErrorNoticing($sql);



		}
		
		public function addDBUser ($name, $email,$routerLogin,$routerPassword,$login,$password) {
			if (!$this->is_superadmin()) {
				CommonFunctions::addNextPage('Access Level Violation Error', 'danger');
				CommonFunctions::redirect($adminMainPage);
			}

			$this->sanitize($routerLogin);
			$this->sanitize($routerPassword);
			$this->sanitize($login);
			$this->sanitize($password);
			$this->sanitize($name);
			$this->sanitize($email);

			$password = password_hash($password, PASSWORD_BCRYPT);

			$sql='INSERT INTO CM$DB_USER 
			( IS_SUPERADMIN, ROUTER_LOGIN, 
			ROUTER_PASSWORD, LOGIN, PASSWORD, ID_DB_USER_MODIFIED) 
			VALUES ("F","'.$routerLogin.'","'
							 .$routerPassword.'","'
							 .$login.'","'
							 .$password.'","'
							 .$this->id_db_user_editor.'")';


			$this->getQueryResultWithErrorNoticing($sql);



			$sql = 'SELECT ID_DB_USER FROM CM$DB_USER WHERE IS_SUPERADMIN=\'F\' ORDER BY ID_DB_USER DESC LIMIT 0, 1';







			$id_db_client = $this->getQueryFirstRowResultWithErrorNoticing($sql)['ID_DB_USER'];





			 $sql = 'SELECT E.ID_DICTIONARY, E.SHORT_NAME, E.DEFAULT_VALUE FROM CM$DICTIONARY E WHERE E.ID_PARENT in 

				(SELECT B.ID_DICTIONARY FROM 

				CM$DICTIONARY B WHERE B.ID_PARENT IN

				(SELECT F.ID_DICTIONARY FROM 

				 CM$DICTIONARY F WHERE F.SHORT_NAME = "VARS"))';

			$dictionary_result = $this->getQueryResultWithErrorNoticing($sql);



			$sql = "";

			while ($row = $dictionary_result->fetch_assoc()) {



				if ($row['SHORT_NAME']=='EMAIL'){



				$sql = 'INSERT INTO SP$VAR (ID_DICTIONARY,VALUE,ID_DB_USER) VALUES ('.$row['ID_DICTIONARY'].',"'.$email.'",'.$id_db_client.');';

				} else if ($row['SHORT_NAME']=='COMPANY_NAME'){



				$sql =  'INSERT INTO SP$VAR (ID_DICTIONARY,VALUE,ID_DB_USER) VALUES ('.$row['ID_DICTIONARY'].',"'.$name.'",'.$id_db_client.');';

				} else {



					$val = isset($row['DEFAULT_VALUE']) ? "'".$row['DEFAULT_VALUE']."'" : 'NULL';

					$sql = 'INSERT INTO SP$VAR (ID_DICTIONARY,VALUE,ID_DB_USER) VALUES ('.$row['ID_DICTIONARY'].','.$val.','.$id_db_client.');';	



				}

				$this->getQueryResultWithErrorNoticing($sql);

			}

					

		}

		public function setActiveDBUser($active,$db_user) {

			$this->sanitize($active);
			$this->sanitize($db_user);

			$sql = 'update  CM$DB_USER set IS_ACTIVE="'.$active.'" where ID_DB_USER='.$db_user;
			$this->getQueryResultWithErrorNoticing($sql);
		}
		
		public function updateDBUserPassowrd() {

			if (!$this->postIsFine(['old-password', 'password', 'repeat-password'])) {
				Notification::add('Не все поля были заполнены!', 'danger');
				return false;
			}
			
			$old_password = 	$_POST['old-password'];
			$password =			$_POST['password'];
			$repeat_password = 	$_POST['repeat-password'];
			
			if ($password != $repeat_password) {
				Notification::add('Пароли не совпадают!', 'danger');
				return false;
			}
			
			// get login and password
			$sql = 'select U.LOGIN, U.PASSWORD from CM$DB_USER U where U.ID_DB_USER='.$this->id_db_user;
			$result = $this->getQueryFirstRowResultWithErrorNoticing($sql);
			
			// check old password
			if (!password_verify($old_password, $result['PASSWORD'])) {
				Notification::add('Был введен неверный пароль!', 'danger');
				return false;
			}
			
			$sql = 'update CM$DB_USER set PASSWORD="'.password_hash($password, PASSWORD_BCRYPT).'" where ID_DB_USER='.$this->id_db_user;
			$this->getQueryResultWithErrorNoticing($sql);
			
			Notification::add("Пароль обновлен!", 'success');
			return true;
			
		}
		
		// ========= EOF Функции, изменяющие данные в БД =========
		
	}
?>