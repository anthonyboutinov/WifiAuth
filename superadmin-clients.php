<?php	include 'includes/core/vars.php'; ?>
<html lang="ru">
	<head>
		<?php include 'includes/base/headBootstrapAndBasics.php'; ?>
		<title>Панель добавления клиентов></title>
	</head>

	<body class="admin-page simple-page">
		<div class="container glass-panel">
			<?php include 'includes/base/superadmin-navbar.php'; ?>			
		
			<div class = "row">
				<div class = "col-sm-6">

					<h1><i class="fa fa-users"></i> Клиенты</h1> 
					
					<div class="page-wrapper">

					 	<table class="table table-hover table-condensed">
		 					<tr><td class="text-right">1</td><td class="text-center">Дубровин Добромысл</td></tr>
		 					<tr><td class="text-right">2</td><td class="text-center">Дубровин Добромысл</td></tr>
		 					<tr><td class="text-right">3</td><td class="text-center">Дубровин Добромысл</td></tr>
		 					<tr><td class="text-right">4</td><td class="text-center">Дубровин Добромысл</td></tr>
		 					<tr><td class="text-right">5</td><td class="text-center">Дубровин Добромысл</td></tr>
		 					<tr><td class="text-right">6</td><td class="text-center">Дубровин Добромысл</td></tr>
		 					<tr><td class="text-right">7</td><td class="text-center">Дубровин Добромысл</td></tr>
		 					<tr><td class="text-right">8</td><td class="text-center">Дубровин Добромысл</td></tr>
		 					<tr><td class="text-right">9</td><td class="text-center">Дубровин Добромысл</td></tr>
		 					<tr><td class="text-right">10</td><td class="text-center">Дубровин Добромысл</td></tr>
		 					<tr><td class="text-right">11</td><td class="text-center">Дубровин Добромысл</td></tr>
					 	</table>

				 	</div>
				</div>
			<div class = "col-sm-6">

					<h1><i class="fa fa-user"></i> Профиль</h1> 
					
					<div class="page-wrapper">
						<div class="form-horizontal">

							<div class="form-group">
									<label class="col-sm-2 col-xs-2 control-label" for="company-name">Название</label>
									<div class="col-sm-10 col-xs-10col-sm-10 col-xs-10">
										<input type="text" class="form-control" name="company-name" placeholder="Название">
									</div>

							</div>

							<div class="form-group">
									<label class="col-sm-2 col-xs-2 control-label" for="email">E-mail</label>							
									<div class="col-sm-10 col-xs-10">
										<input type="text" class="form-control" name="email" placeholder="E-mail">
									</div>
								</div>
						</div>
						
						<h1>Роутеры</h1>
							<h1>
							<div class="form-horizontal">
								<div class="form-group">
								  <label class="col-sm-3 col-xs-3 control-label" for="mac-adress"><h5>MAC-адрес</h5></label>							
									<div class="col-sm-8 col-xs-8">
										<input type="text" class="form-control" name="mac-adress">
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-8 col-xs-8">
										 <label class="col-sm-3 col-xs-3  col-xs-offset-1 control-label" for="mac-adress"><h5>Пароль</h5></label>	
										<div class="input-group">
											<input type="text" class=" form-control" name="password" >										
								                <span class="input-group-btn">
													<span class="btn btn-black btn-file">
														Генрировать
													</span>
								                </span>
										</div>
									</div>
								</div>

							</div>
							</h1>
						<div>	
						<h1 style="border-top: 2px solid rgba(255, 255, 255, 0.48);
   						 padding-top: 40px;">Личный кабинет</h1>
							<h1>
							<div class="form-horizontal">
								<div class="form-group">
									<div class="col-sm-10 col-xs-10 col-sm-offset-1 col-xs-offset-1">
										<input type="text" class="form-control" name="login" placeholder="Логин">
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-10 col-xs-10 col-sm-offset-1 col-xs-offset-1">
										<div class="input-group">
											<input type="text" class="form-control" name="password" placeholder="Пароль">										
							                <span class="input-group-btn">
												<span class="btn btn-black btn-file">
													Генрировать
												</span>
							                </span>
										</div>
									</div>
								</div>

							</div>
							</h1>
						</div>								
				 	</div>
				</div>
         	</div>
    	</div>
		<?php include 'includes/base/jqueryAndBootstrapScripts.html'; ?>
	 	</body>
</html>