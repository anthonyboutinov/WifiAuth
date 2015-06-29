<?php	include 'includes/core/vars.php'; ?>
<?php 

 $birthdays = $database->getBirthdays($offset, $limit);
 
?>
<html lang="ru">
	<head>
		<?php include 'includes/base/headBootstrapAndBasics.php'; ?>
		<title>Добавить клиента</title>
	</head>

	<body class="admin-page simple-page">
		<div class="container glass-panel">
			<?php include 'includes/base/superadmin-navbar.php'; ?>			
		
			<div class = "row">
				<div class = "col-md-4">

					<h1><i class="fa fa-users"></i> Клиенты</h1> 
					
					<div class="page-wrapper">

					 	<table class="table table-hover table-condensed">
							<?php
								}
								
								if ($birthdays->num_rows > 0) {
									$i = 0;
									while($row = $birthdays->fetch_assoc()) {
										$i++;
							?>

									<tr>
										<?php if ($drawFullContent) { ?><td id="table-scrollable-part-col-1" class="text-right"><?=$i;?></td><?php } ?>
										<td id="table-scrollable-part-col-2" class="text-left"><a href="<?=$row['LINK'];?>" target="blank"><?=$row['NAME'];?></a></td>
										<td id="table-scrollable-part-col-3"><?=$row['BIRTHDAY'];?></td>
									</tr>
							<?php 
									}
								} else { ?>
									<tr><td colspan="<?php if ($drawFullContent) echo '3'; else echo '2'; ?>" class="text-center">Пусто</td></tr>
							<?	} ?>
					 	</table>

				 	</div>
				</div>
			<div class="col-md-8">

				<h1><i class="fa fa-user-plus"></i> Добавить клиента</h1> 
				
				<div class="page-wrapper close-follow">
					
					<h2>Компания</h2>
					<div class="form-horizontal">

						<div class="form-group">
								<label class="col-sm-3 control-label" for="company-name">Название</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="company-name" autocomplete="off" maxlength="255">
								</div>

						</div>

						<div class="form-group">
								<label class="col-sm-3 control-label" for="email">E-mail</label>							
								<div class="col-sm-9">
									<input type="text" class="form-control" name="email" autocomplete="off" maxlength="255">
								</div>
							</div>
					</div>
					
				</div>
				<div class="page-wrapper close-follow">
					
					<h2>Роутеры</h2>
					<div class="form-horizontal">
						
						<div class="form-group">
						  <label class="col-sm-3 control-label" for="mac-adress">MAC-адрес</label>							
							<div class="col-sm-9">
								<input type="text" class="form-control" name="mac-adress" autocomplete="off" maxlength="1024">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label" for="mac-adress">Токен</label>	
							<div class="col-sm-9">
								<div class="input-group">
									<input type="text" class="form-control default-cursor"
										name="router-token" id="router-token" autocomplete="off" maxlength="32" disabled>
					                <span class="input-group-btn">
										<span class="btn btn-black" id="generate-token">
											Генерировать <i class="fa fa-key"></i>
										</span>
					                </span>
								</div>
							</div>
						</div>

					</div>
					
				</div>
				<div class="page-wrapper close-follow">
						
					<h2>Личный кабинет</h2>
					<div class="form-horizontal">
						<div class="form-group">
						  <label class="col-sm-3 control-label" for="mac-adress">Логин</label>							
							<div class="col-sm-9">
								<input type="text" class="form-control" name="login" autocomplete="off" maxlength="255">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label" for="password">Пароль</label>	
							<div class="col-sm-9">
								<div class="input-group">
									<input type="text" class="form-control"
										name="password" id="password" autocomplete="off" maxlength="32">
					                <span class="input-group-btn">
										<span class="btn btn-black" id="generate-password">
											Генерировать <i class="fa fa-key"></i>
										</span>
					                </span>
								</div>
							</div>
						</div>

					</div>								
			 	
			 	</div>
				<div class="page-wrapper">
					<div class="action-buttons-mid-way-panel only-child">
						<button type="submit" class="btn btn btn-black gradient">Добавить <i class="fa fa-plus"></i></button>
					</div>
				</div>
				
				<div class="page-wrapper">
					<div class="action-buttons-mid-way-panel only-child">
						<button type="button" class="btn btn btn-black gradient">Сохранить <i class="fa fa-floppy-o"></i></button>
						<button type="button" class="btn btn btn-red gradient">Приостановить обслуживание <i class="fa fa-toggle-off"></i></button>
					</div>
				</div>
				
				<div class="page-wrapper">
					<div class="action-buttons-mid-way-panel only-child">
						<button type="button" class="btn btn btn-black gradient">Сохранить и активировать <i class="fa fa-toggle-on"></i></button>
					</div>
				</div>
				 	
         	</div>
    	</div>
		<?php include 'includes/base/jqueryAndBootstrapScripts.html'; ?>
		<script src="includes/js/superadmin-clients.js"></script>
		
 	</body>
</html>