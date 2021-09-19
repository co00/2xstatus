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
				<h5 class="panel-title"><b>Dialog Banner Ads</b> <button class="btn btn-success pull-right" id="update_image">Update</button></h5>
				<div class="heading-elements">
            	</div>
			<a class="heading-elements-toggle"><i class="icon-menu"></i></a>
		</div>

		<div class="table-responsive">
			<table class="table text-nowrap">
				<tbody>
					<tr class="active border-double">
						<td colspan="5"><b>Status Enable/Disale<b></td>
						<td colspan="5">
							<div class="col-md-10 checkbox checkbox-switchery switchery-sm "><input type="checkbox" class="switchery change_status" <?=($dialog_banner->status == '1') ? 'checked' : '' ?>  data-href="<?=BASE_URL_ADMIN.'dialog_banner/change_status/'.$dialog_banner->id.'/'.$dialog_banner->status?>"></div>
						</td>
					</tr>

					<tr class="active border-double">
						<td colspan="10">
							<img src="<?=BASE_URL.BANNER_UPLOADS.$dialog_banner->imageurl?>" id="image" style="width: 100%;">
							<br>
							<input type="file" id="imageurl" class="file-styled">
							<input type="hidden" id="old_img" value="<?=$dialog_banner->imageurl?>">
						</td>
					</tr>

					<tr class="active border-double">
						<td colspan="5"><b>Ads Link<b></td>
						<td colspan="5">
							<input type="text" class="form-control" value="<?=$dialog_banner->link?>" placeholder="Ads Link" id="link">
						</td>
					</tr>


					<tr class="active border-double">
						<td colspan="5"><b>Ads Name<b></td>
						<td colspan="5">
							<input type="text" class="form-control" value="<?=$dialog_banner->name?>" placeholder="Ads Title" id="name">
						</td>
					</tr>

					<tr class="active border-double">
						<td colspan="5"><b>Ads Description<b></td>
						<td colspan="5">
							<input type="text" class="form-control " value="<?=$dialog_banner->name?>" placeholder="Ads Description" id="description">
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
            $('#image').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imageurl").change(function(){
    readURL(this);
});

$(document).off('click','#update_image').on('click','#update_image',function(e){

            var link = $('#link').val();
            var name = $('#name').val();
            var description = $('#description').val();
            var old_img = $('#old_img').val();

            if(link == ""){
                $('#link').focus();
                show_notify('Link filed is required', 'bg-danger');
            }else{

                $('.loader').removeClass('hidden');

                var file_data = $("#imageurl").prop("files")[0];

                var form_data = new FormData();
                form_data.append("imageurl",file_data);
                form_data.append("link",link);
                form_data.append("name",name);
                form_data.append("description",description);
                form_data.append("old_image",old_img);

                $.ajax({
                    url: '<?=BASE_URL_ADMIN?>dialog_banner/update',
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


	window.status_changed = true;
        $(document).off('change','.change_status').on('change','.change_status',function(e){
            e.preventDefault();

            if(window.status_changed) {
                var self = $(this);
                    var url = self.attr('data-href');

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(response) {
                            if(response.statuscode) {
                                self.attr('data-href',response.new_url);
                                show_notify(response.message, 'bg-success');
                                window.status_changed = true;
                            } else {
                                show_notify(response.message, 'bg-danger');
                                window.status_changed = false;
                                self.click();
                            }
                        }
                    });


            } else {
                window.status_changed = true;
            }
        });

        $(document).off('change','.change_value').on('keypress',".change_value",function(e){
            //e.preventDefault();

           if(e.which == 13) 
           {
           		var self = $(this);
           		var id = self.attr('data-id');
           		var value = $(this).val();

           		$.ajax({
                        url: '<?=BASE_URL_ADMIN?>dashboard/change_value',
                        type: 'POST',
                        dataType: 'JSON',
                        data:{
                        	id:id,
                        	value,value
                        },
                        success: function(response) {
                            if(response.statuscode) {
                                show_notify(response.message, 'bg-success');
                            } else {
                                show_notify(response.message, 'bg-danger');
                            }
                        }
                });
           		
           }
           
        });

});

	
</script>