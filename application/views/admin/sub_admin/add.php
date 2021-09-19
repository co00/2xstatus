<?php $this->load->view(ADMIN_VIEW.'header'); ?>

<div class="panel panel-flat">
	<div class="panel-heading">
		<h4 class="panel-title">Add</h4>
		<div class="heading-elements"></div><br>
	</div>

	<div class="panel-body">
		<form method="post" action="<?=BASE_URL_ADMIN?>sub_admin/store" enctype="multipart/form-data" class="form-horizontal">
			 
			
			<div class="form-group">
				<label class="col-md-2 control-label ">Name: <span class="text-danger">*</span></label>
				
				<div class="col-md-10">
					<input type="text" name="name" class="form-control"  value="<?=set_value('name'); ?>">
					<?=form_error('name', '<div class="text-danger">', '</div>'); ?>
				</div>
			</div> 
			<div class="form-group">
				<label class="col-md-2 control-label">Mobile: <span class="text-danger">*</span></label>
				<div class="col-md-10">
					<input type="text" name="mobile" class="form-control file-styled"  value="<?=set_value('mobile'); ?>">
					<?=form_error('mobile', '<div class="text-danger">', '</div>'); ?>
				</div>
			</div> 
			<div class="form-group">
				<label class="col-md-2 control-label">Email: <span class="text-danger">*</span></label>
				<div class="col-md-10">
					<input type="text" name="email" class="form-control file-styled"  value="<?=set_value('email'); ?>">
					<?=form_error('email', '<div class="text-danger">', '</div>'); ?>
				</div>
			</div> 
			<div class="form-group">
				<label class="col-md-2 control-label">Username: <span class="text-danger">*</span></label>
				<div class="col-md-10">
					<input type="text" name="username" class="form-control file-styled"  value="<?=set_value('username'); ?>">
					<?=form_error('username', '<div class="text-danger">', '</div>'); ?>
				</div>
			</div> 
			<div class="form-group">
				<label class="col-md-2 control-label">Password: <span class="text-danger">*</span></label>
				<div class="col-md-10">
					<input type="text" name="password" class="form-control file-styled"  value="<?=set_value('password'); ?>">
					<?=form_error('password', '<div class="text-danger">', '</div>'); ?>
				</div>
			</div> 
			
			
			<div class="form-group">
				<label class="col-md-2 control-label">Status: <span class="text-danger">*</span></label>
				<div class="col-md-10">
					<select class="select" name="status">
						<option value="1" <?php echo set_select('status', '1', TRUE); ?>>Active</option>
						<option value="0" <?php echo set_select('status', '0'); ?>>Inactive</option>
					</select>
					<?=form_error('status', '<div class="text-danger">', '</div>'); ?>
				</div>
			</div>

			<hr>
		<div class="table-responsive">
			<h3>Assign Access Permissions & Roles</h3>
			<table class="table">
				<thead>
					<tr>
						<th style="width: 33%;">Modules</th>
						<th style="width: 33%;">Grant Access</th>
						<th style="width: 33%;">Assign Roles</th>
					</tr>
				</thead>
			
				<tbody>
			<?php
				$modules = json_decode(MODULES);

				if(!empty($modules)) {
					foreach($modules as $key => $value) {
			?>
						<tr>
							<td>
								<h6><?=ucwords(str_replace("_", " ", $value))?></h6>
							</td>
							<td class="modules_container">
								<input type="checkbox" name="modules[]" class="switchery modules" value="<?=$value?>" >
							</td>
							<td class="modules_actions_container">
								<select class="select modules_actions" name="modules_actions[<?=$value?>][]" multiple disabled>
									<?php
										$modules_actions = json_decode(MODULES_ACTIONS, true);
										if(isset($modules_actions[$value])) {
											if(!empty($modules_actions[$value]) && is_array($modules_actions[$value])) {

												foreach($modules_actions[$value] as $makey => $mavalue) {
									?>
												<option value="<?=$mavalue?>">
													<?=ucwords(str_replace("_"," ",$mavalue))?>
												</option>
									<?php
												}
											}
										}
									?>
								</select>
							</td>
						</tr>
			<?php
					}
				}
			?>
				</tbody>
			</table>
		</div>
			
			<div class="form-group">
				<input type="submit" value="Submit" class="btn btn-success">
				<a href="<?=BASE_URL_ADMIN.'sub_admin/'?>" class="btn btn-danger">Cancel</a>
			</div>
		</form>
	</div>
</div>
<!-- /traffic sources -->
<?php $this->load->view(ADMIN_VIEW.'footer'); ?>	


<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/styling/switchery.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		enable_switchery();
		
	    $('.select').select2();

	    $(document).off('change','.modules').on('change','.modules',function(){
	    	if($(this).is(':checked')) {

	    		$(this).closest('.modules_container').siblings('.modules_actions_container').find('.modules_actions').removeAttr('disabled');
	    	} else {
	    		$(this).closest('.modules_container').siblings('.modules_actions_container').find('.modules_actions').attr('disabled',true);
	    	}
	    });
	});
</script>