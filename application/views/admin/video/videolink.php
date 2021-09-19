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
                            <li class="active"><?= !empty($this->uri->segment(3)) ? ucwords(str_replace('_',' ',$this->uri->segment(3))) : 'Dashboard' ?></li>
                        </ul>
                    </div>
                </div>
                <!-- /page header -->


<!-- Content area -->
<div class="content">

<div class="panel panel-flat">
    <!-- <div class="panel-heading">
        <h4 class="panel-title">Add Video</h4>
        <div class="heading-elements"></div><br>
    </div> -->

    <div class="panel-body">

            <div class="row">
                
                <div class="col-md-2">
                    <b class="control-label">Category: <span class="text-danger">*</span></b>
                    <select class="select" name="category_id" id="category_id">
                            <option value="">Select Category</option>
                            <?php foreach($category as $key => $value): ?> 
                                <option value="<?=$value->id?>" <?=set_select('category_id',$value->id)?>><?=$value->name?></option> 
                            <?php endforeach; ?>
                        </select>
                </div>

                <div class="col-md-3 link-content">
                    <b class="control-label">Image Link: <span class="text-danger">*</span></b>
                    <input type="text" name="image_link" id="image_link" class="form-control" placeholder="Enter image Link" value="<?=set_value('image_link'); ?>">
                </div>
            
                <div class="col-md-3 link-content">
                    <b class="control-label">Video Link: <span class="text-danger">*</span></b>
                    <input type="text" name="video_link" id="video_link" class="form-control" placeholder="Enter Video Link" value="<?=set_value('video_link'); ?>">
                </div>

                <div class="col-md-2">
                    <b class="control-label">Status: <span class="text-danger">*</span></b>
                    <select class="select" name="status" id="status">
                        <option value="1" <?php echo set_select('status', '1', TRUE); ?>>Active</option>
                        <option value="0" <?php echo set_select('status', '0'); ?>>Inactive</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <b class="control-label">Watermark <span class="text-danger">*</span></b>
                    <select class="select" name="status" id="watermark_status">
                        <option value="0" <?php echo set_select('status', '0', TRUE); ?>>Disable</option>
                        <option value="1" <?php echo set_select('status', '1'); ?>>Enable</option>
                    </select>
                </div>

                

                <div class="col-md-3" style="margin-top: 10px; display: none;">
                    <b class="control-label">Name: <span class="text-danger">*</span></b>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Category Name" value="<?=set_value('name'); ?>">
                </div>

                <div class="col-md-2">
                    <br>
                    <button id="add_videolink" style="width: 100%;" class="btn btn-success">Add</button>
                </div>

            </div>

            <br>
    </div>
</div>


<!-- Main charts -->
<div class="row">
    <div class="col-lg-12">

<div class="panel panel-flat">
	<div class="panel-heading">
		<h4 class="panel-title">Video</h4>
	</div>

    <div class="panel-body">
    	<div class="table-responsive">
    		<table class="table" id="table">
    			<thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <!-- <th>Video</th> -->
                        <th>Category</th>
                        <th>Name</th>
                        <!-- <th>View</th> -->
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
    			<tbody></tbody>
    		</table>
    	</div>
    </div>
</div>
<!-- /traffic sources -->


<div class="modal fade" id="editmodal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #383838">
        <h5 class="modal-title" style="color: #FFF; padding-bottom: 10px;" align="center">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" >
        
      </div>

      <div class="modal-footer">
        <button type="submit" id="updateVideo" class="btn btn-primary updateVideo">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<?php $this->load->view(ADMIN_VIEW.'footer'); ?>


<script type="text/javascript" src="<?=base_url()?>assets/admin/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/admin/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/styling/switchery.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){
enable_switchery();
$('.select').select2({
        minimumResultsForSearch: "1"
});

$(".file-styled").uniform({
        fileButtonHtml: '<i class="icon-googleplus5"></i>',
        wrapperClass: 'bg-warning'
});

         var table = $('#table').DataTable( {
            "processing": true,
            "serverSide": true,
            "order": [[ 0, "desc" ]],

            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 3 ]},
                { 'bSearchable': false, 'aTargets': [ -1 ] }
            ],
            "ajax": {
                "url": "<?=BASE_URL_ADMIN?>video/videolink/datatable",
                "type": "POST"
            },
            // "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ":20,
            "oLanguage": {
            // "sProcessing": "<img src='<?php //echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
            },   
            initComplete: function() {
                $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');


                    // Enable Select2 select for the length option
                    $('.dataTables_length select').select2({
                        minimumResultsForSearch: "-1"
                    });
            },
             "drawCallback": function( settings ) {
                enable_switchery();
            },  

            "columns": [
                    { "data": "id" },
                    { "data": "image_thumbnail" },
                    // { "data": "video_link" },
                    { "data": "category" },
                    { "data": "name" },
                    // { "data": "video_view" },
                    { "data": "status" },
                    { "data": "action" }
            ]
        });

        $(document).off('click','.delete').on('click','.delete',function(e){
            e.preventDefault();
            var self = $(this);
            if( confirm('Are you sure, you want to delete this record?') ) {
                $(".loader").removeClass('hidden');
                var url = self.attr('href');
                $.ajax({
                    url: url,
                    dataType: 'JSON',
                    success: function(response) {
                        if( response.response ) {
                            self.closest('tr').remove();
                        }
                        $(".loader").addClass('hidden');
                    }
                });
            }
        });

        window.is_add = true;

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

        $(document).off('click','#add_videolink').on('click','#add_videolink',function(e){

            $(".loader").removeClass('hidden');

            $.ajax({
                    url: '<?=BASE_URL_ADMIN?>video/videolink/store',
                    type:'POST',
                    dataType: 'JSON',
                    data:{
                        category_id:$('#category_id').val(),
                        upload_type:'link',
                        image_thumbnail:$('#image_link').val(),
                        video_link:$('#video_link').val(),
                        video_type:'1',
                        watermark_status:$('#watermark_status').val(),
                        status:$('#status').val(),
                    },
                    success: function(response) {
                        if(response.statuscode ) {
                            $(".loader").addClass('hidden');
                            $('#image_link').val('');
                            $('#video_link').val('');
                            table.draw();
                            show_notify(response.message, 'bg-success');
                        }else{
                            $(".loader").addClass('hidden');
                            show_notify(response.message, 'bg-danger');
                        }
                    },
                    error: function(repsonse){
                        $(".loader").addClass('hidden');
                        show_notify('Something went wrong.','bg-danger');
                    }
                });
        });


        $(document).off('click','.edit-link').on('click','.edit-link',function(e){
            e.preventDefault();
            var self = $(this);
            
                $(".loader").removeClass('hidden');
                var url = self.attr('href');

                $.ajax({
                    url: url,
                    dataType: 'JSON',
                    success: function(response) {
                        if( response.response ) {
                            //self.closest('.image-container').remove();
                            $('#editmodal').modal('show');
                            $('.modal-body').html(response.data);
                            $('#category_id').select2();
                            $(".file-styled").uniform({
                                fileButtonHtml: '<i class="icon-googleplus5"></i>',
                                wrapperClass: 'bg-warning'
                            });
                            //$('.select').select2();
                        }
                        $(".loader").addClass('hidden');
                    }
                });
        });

        $(document).off('click','.updateVideo').on('click','.updateVideo',function(e){
            e.preventDefault();
            var self = $(this);

            $(".loader").removeClass('hidden');
                
                $.ajax({
                    url: '<?=BASE_URL_ADMIN?>video/videolink/updateLink',
                    type:'POST',
                    dataType: 'JSON',
                    data:{
                        id:$('#id_link').val(),
                        image_thumbnail:$('#image_link_value').val(),
                        video_link:$('#video_link_value').val(),
                        category_id:$('#category_id_value').val(),
                        name:$('#name_link').val(),
                        watermark_status:$('#watermark_status_value').val(),
                    },
                    success: function(response) {
                        if( response.statuscode ) {
                            show_notify(response.message, 'bg-success');
                            //table.draw();
                        }else{
                            show_notify(response.message, 'bg-danger');
                        }
                        $(".loader").addClass('hidden');
                    }
                });
            
                
        });

	});



</script>