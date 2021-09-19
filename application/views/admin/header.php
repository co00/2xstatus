<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=APP_NAME?> | Admin Panel</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/minified/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/minified/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/minified/colors.min.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/custom.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->




	<!-- Theme JS files -->
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/notifications/pnotify.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/app.js"></script>
	<!-- /theme JS files -->

	<!-- Global stylesheets -->
	<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/minified/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/minified/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/minified/colors.min.css" rel="stylesheet" type="text/css">
	<link href="<?=ADMIN_ASSETS?>css/custom.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/loaders/blockui.min.js"></script> 

	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/notifications/pnotify.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/app.js"></script>
 
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/wizards/steps.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/libraries/jasny_bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/validation/validate.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/extensions/cookie.js"></script>

	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/pages/wizard_steps.js"></script>
	
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/libraries/jquery_ui/datepicker.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/libraries/jquery_ui/effects.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/notifications/jgrowl.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/pickers/daterangepicker.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/pickers/anytime.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/pickers/pickadate/picker.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/pickers/pickadate/picker.date.js"></script>

	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/pickers/pickadate/picker.time.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/pickers/pickadate/legacy.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/pages/picker_date.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/pages/invoice_grid.js"></script>


	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/pages/form_multiselect.js"></script>

	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/libraries/jquery_ui/interactions.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/libraries/jquery_ui/touch.min.js"></script>
	<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/pages/appearance_draggable_panels.js"></script> -->


</head>

<style type="text/css">
	.heading-elements .btn {
		margin-bottom: 20px;
	}
	.switchery-sm.checkbox-switchery .switchery {
		margin-top: -8px;
	}
	.card_image {
		max-height: 15vh;
    	max-width: 50px;
    	border: 1px solid #ccc;
    	border-radius: 12px;
	}
	.user_image {
		width: 100px;
		height: 100px;
	}
</style>

<body>
	<div class="loader hidden">
		<i class="icon-spinner6 spinner"></i>
	</div>
	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?=base_url()?>"><?=APP_NAME?></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
			
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="<?=BASE_URL_ADMIN?>login/logout">Logout</a>
				</li>
			</ul>
		</div>

	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<?php $this->load->view(ADMIN_VIEW.'sidebar'); ?>

			