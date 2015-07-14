<?php
	
	$orderBy = null;
	
	
	if (!isset($database) && isset($_GET['order-by'])) {
		require '../core/session.php';
		$protector->protectPageSetMinAccessLevel('MANAGER');
		
		$database->prepareForDefaultTableQueries();
		$orderBy = $_GET['order-by'];
	}
	
	
?><tbody><?php
	$dbusers = $database->getDBUsers($orderBy);
	if ($dbusers->num_rows > 0) {
		$i = 0;
		while($row = $dbusers->fetch_assoc()) {
			$i++;
		?>
		<tr>
			<?php if ($orderBy == 'ID_DB_USER') { ?>
			<td><?=$row['ID_DB_USER'];?></td>
			<?php } else if ($orderBy == 'TRAFFIC') { ?>
			<td><?=$row['LOGIN_ACT_COUNT_MONTH'];?></td>
			<?php } ?>
			<a href="#" data-toggle="popover" data-placement="right" 
			data-title="Информация о клиенте"  
			data-content='<table class="no-word-wrap"><tr><td>Логин:</td><td><?=$row['LOGIN'];?></td></tr>
				<tr><td>Email:</td><td><?=$row['EMAIL'];?></td></tr>
				
				<tr><td>Логин&nbsp;роутера:</td><td><?=$row['ROUTER_LOGIN'];?></td></tr>
				<tr><td>Пароль&nbsp;роутера:</td><td><?=htmlentities($row['ROUTER_PASSWORD'], ENT_QUOTES);?></td></tr>
				
				<?php if ($database->meetsAccessLevel('PRIV_MANAGER')) { ?>
				<tr><td>Посетителей за сегодня:</td><td><?=$row['LOGIN_ACT_COUNT_TODAY'];?></td></tr>
				<tr><td>Посетителей за месяц:</td><td><?=$row['LOGIN_ACT_COUNT_MONTH'];?></td></tr>
				<tr><td>Посетителей за год:</td><td><?=$row['LOGIN_ACT_COUNT_YEAR'];?></td></tr>
				<?php } ?>
				
				<tr><td>Дата&nbsp;создания:</td><td><?=$row['DATE_CREATED'];?></td></tr>
				<tr><td>Дата&nbsp;изменения:</td><td><?=$row['DATE_MODIFIED'];?></td></tr>
				<tr><td>Последний&nbsp;раз&nbsp;изменен:</td><td><?=$row['DB_USER_MODIFIED'];?></td></tr>
				
				<tr><td>Ведется обслуживание:</td><td><?=$row['IS_ACTIVE'] == 'T' ? 'да' : 'нет';?></td></tr>
				<tr><td>Заблокирован<br>по причине многократного<br>неверного ввода пароля:</td><td><?=$row['UNLOCK_AT']? 'да, будет разблокирован '.$row['UNLOCK_AT'] : 'нет';?></td></tr>
				
				<?php if ($database->meetsAccessLevel('ROOT')) { ?><tr><td>ID:</td><td><?=$row['ID_DB_USER'];?></td></tr><?php } ?>
				
				<tr><td>Комментарий:</td><td><?=$row['COMMENT'];?></td></tr></table>'>
			<td class="text-left superadmin-clients-popover-container"><?=$row['COMPANY_NAME'];?></td></a>

			<?php if ($database->meetsAccessLevel('ROOT')) { ?>
				<td class="text-right">
					<form action="admin-dashboard.php" method="post">
						<input type="hidden" name="form-name" value="pretend-to-be">
						<input type="hidden" name="pretend-to-be" value="<?=$row['ID_DB_USER'];?>">
						<button type="submit" class="btn btn-link" data-toggle="tooltip" data-placement="left" title="Просмотреть личный кабинет">
							<i class="fa fa-line-chart"></i>
						</button>
					</form>
				</td>
			<?php }
				
			if ($database->meetsAccessLevel('PRIV_MANAGER')) { 
				
				if ($row['IS_ACTIVE'] =='T') { ?>
					<td class="text-right">
						<a href="#" data-id="enabled" data-id-db-user="<?=$row['ID_DB_USER'];?>" data-toggle="tooltip" data-placement="left" title="Приостановить обслуживание">
							<i class="fa fa-circle" ></i>
						</a>
					</td>
				<?php } else { ?>
					<td class="text-right">
						<a href="#" data-id="disabled" data-id-db-user="<?=$row['ID_DB_USER'];?>" data-toggle="tooltip" data-placement="left" title="Возобновить обслуживание">
							<i class="fa fa-circle-thin"></i>
						</a>
					</td>
				<?php }
					
			} ?>
		</tr>
<?php 
		}
	} else { ?>
		<tr><td colspan="1" class="text-center">Пусто</td></tr>
<?	} ?>
</tbody>
<script>
	makeTableDOMConnections();
</script>