<?php $this->load->view(ADMIN_VIEW.'header'); ?>
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4>
								<span class="text-semibold">Admin</span> - <?= !empty($this->uri->segment(2)) ? $this->uri->segment(2) : 'Dashboard' ?>
							</h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?=BASE_URL_ADMIN?>"><i class="icon-home2 position-left"></i> Admin</a></li>
							<li class="active"><?= !empty($this->uri->segment(2)) ? ucwords(str_replace('_',' ',$this->uri->segment(2))) : 'Dashboard' ?></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


<!-- Content area -->
<div class="content">

	<!-- Main charts -->
	<div class="row">
		<div class="col-lg-12">

<div class="col-md-6">
	<div class="panel panel-flat">
		<div class="panel-heading">
				<h5 class="panel-title"><b>App Updates</b> <button class="btn btn-success pull-right" id="update_image">Update</button></h5>
				<div class="heading-elements">
            	</div>
			<a class="heading-elements-toggle"><i class="icon-menu"></i></a>
		</div>

		<div class="table-responsive">
			<table class="table text-nowrap">
				<tbody>
					<tr class="active border-double">
						<td colspan="5"><b>Status Update/InApp Update<b></td>
						<td colspan="5">
							<div class="col-md-10 checkbox checkbox-switchery switchery-sm "><input type="checkbox" class="switchery change_status" <?=($in_app_update_status == 'active') ? 'checked' : '' ?>  data-href="<?=BASE_URL_ADMIN.'app_update/change_status/'.$in_app_update_id.'/'.$in_app_update_status?>"></div>
						</td>
					</tr>

					<tr class="active border-double">
						<td colspan="10">

                            <div class="col-md-4">
                                <img src="<?=BASE_URL.BANNER_UPLOADS.$app_update->image?>" id="imageprev" style="width: 100px; height: 100px;">
                                <br>
                                <input type="file" id="image" class="file-styled">
                                <input type="hidden" id="old_img" value="<?=$app_update->image?>">
                            </div>

                            <div class="col-md-8">
                                <b>Name<b>
                                <input type="text" class="form-control" value="<?=$app_update->name?>" placeholder="Title" id="name">

                                <br>

                                <b>Download Size<b><br>
                                <input type="text" class="form-control" value="<?=$app_update->size?>" placeholder="Download Size" id="size">
                            </div>


							
						</td>
					</tr>

                    <tr class="active border-double">
                        <td colspan="5"><b>Description<b></td>
                        <td colspan="5">
                            <input type="text" class="form-control " value="<?=$app_update->name?>" placeholder="Description" id="description">
                        </td>
                    </tr>

					<tr class="active border-double">
						<td colspan="5"><b>Link<b></td>
						<td colspan="5">
							<input type="text" class="form-control" value="<?=$app_update->link?>" placeholder="Link" id="link">
						</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>	
</div>

<div class="col-md-6">
    <div class="panel panel-flat">
        <div class="panel-heading">
                <h5 class="panel-title"><b>Update Setting</b></h5>
                <div class="heading-elements">
                </div>
            <a class="heading-elements-toggle"><i class="icon-menu"></i></a>
        </div>

        <div class="table-responsive">
            <table class="table text-nowrap">
                <tbody>
                    <tr class="active border-double">
                        <td colspan="5"><b>Update<b></td>
                        <td colspan="5">
                            <div class="col-md-10 checkbox checkbox-switchery switchery-sm "><input type="checkbox" class="switchery change_status" <?=($update_status == 'active') ? 'checked' : '' ?>  data-href="<?=BASE_URL_ADMIN.'app_update/change_status/'.$update_id.'/'.$update_status?>"></div>
                        </td>
                    </tr>
                    <tr class="active border-double">
                        <td colspan="5"><b>App Link<b></td>
                        <td colspan="5">

                            <textarea class="form-control change_value" rows="10" data-id="<?=$update_id?>" placeholder="App Link" name="change_value"><?=$update_value?></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>  
</div>


	

<?php $this->load->view(ADMIN_VIEW.'footer'); ?>

<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/pages/datatables_basic.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/styling/switchery.min.js"></script>

<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/styling/uniform.min.js"></script>

<script type="text/javascript">
	enable_switchery();

$(document).ready(function(){ 


	$(".file-styled").uniform({
        fileButtonHtml: '<i class="icon-googleplus5"></i>',
        wrapperClass: 'bg-warning'
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imageprev').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#image").change(function(){
    readURL(this);
});

$(document).off('click','#update_image').on('click','#update_image',function(e){

            var size = $('#size').val();
            var link = $('#link').val();
            var name = $('#name').val();
            var description = $('#description').val();
            var old_img = $('#old_img').val();

            if(link == ""){
                $('#link').focus();
                show_notify('Link filed is required', 'bg-danger');
            }else{

                $('.loader').removeClass('hidden');

                var file_data = $("#image").prop("files")[0];

                var form_data = new FormData();
                form_data.append("image",file_data);
                form_data.append("link",link);
                form_data.append("size",size);
                form_data.append("name",name);
                form_data.append("description",description);
                form_data.append("old_image",old_img);

                $.ajax({
                    url: '<?=BASE_URL_ADMIN?>app_update/update',
                    type:'POST',
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data:form_data,
                    success: function(response) {
                        if( response.statuscode ) {
                            //location.reload();
                            show_notify(response.message, 'bg-success');
                        }else{
                            show_notify(response.message, 'bg-danger');
                        }
                        $('.loader').addClass('hidden');
                    }
                });   

            }

        });

});

	
</script>