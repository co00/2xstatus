<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=APP_NAME?></title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/minified/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/minified/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/minified/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->


	<!-- Theme JS files -->
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/app.js"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Page container -->
	<div class="page-container login-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- Simple login form -->
					<form action="<?=BASE_URL_ADMIN?>login/authenticate" method="post">
						<div class="panel panel-body login-form">
							<div class="text-center">
								<!-- <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div> -->
								<img src="<?=ADMIN_ASSETS?>images/logo.png" style="width: 100px; height: 100px">
								<h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5>
							</div>

							<?php if( !empty($_SESSION['error']) ): ?>
								<div class="alert alert-danger">
									<?=$_SESSION['error']?>
								</div>
							<?php endif; ?>

							<div class="form-group has-feedback has-feedback-left">
								<input type="text" class="form-control" name="username" placeholder="Username">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
								<?php echo form_error('username', '<div class="text-danger">', '</div>'); ?>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="password" class="form-control" name="password" placeholder="Password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
								<?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="radio" name="check" value="1" >
								<b>Admin</b>
								<input type="radio" name="check" value="2" >
								<b>Sub Admin</b>
								<?php echo form_error('check', '<div class="text-danger">', '</div>'); ?>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
							</div>
						</div>
					</form>
					<!-- /simple login form -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>
