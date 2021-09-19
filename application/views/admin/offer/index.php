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


<div class="panel panel-flat">
    <!-- <div class="panel-heading panel-heading-custome">
        <h4 class="panel-title">Add Category</h4>
        <div class="heading-elements"></div><br>
    </div>
 -->
    <div class="panel-body" style="padding-top: 10px !important; padding-bottom: 0px !important;">

            <div class="row">
                
                <div class="col-md-4">
                    <b class="control-label">Name: <span class="text-danger">*</span></b>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter App Name" value="<?=set_value('name'); ?>">
                </div>

                

                <div class="col-md-3">
                    <b class="control-label">App Logo: <span class="text-danger">*</span></b>

                    <input type="file" class="file-styled" id="image" name="image">
                </div>


                <div class="col-md-4">
                    <b class="control-label">Link: <span class="text-danger">*</span></b>
                    <input type="text" name="link" id="link" class="form-control" placeholder="Enter App link" value="<?=set_value('link'); ?>">
                </div>

                <div class="col-md-8">
                    <b class="control-label">Offer description: <span class="text-danger">*</span></b>
                     <input type="text" name="description" id="description" class="form-control" placeholder="Enter Offer description" value="<?=set_value('description'); ?>">
                </div>

                <div class="col-md-2">
                    <b class="control-label">Status: <span class="text-danger">*</span></b>
                    <select class="select" name="status" id="status">
                        <option value="1" <?php echo set_select('status', '1', TRUE); ?>>Active</option>
                        <option value="0" <?php echo set_select('status', '0'); ?>>Inactive</option>
                    </select>
                </div>


                <div class="col-md-2">
                    <br>
                    <button id="add_offer" class="btn btn-primary">Add</button>
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
        <h4 class="panel-title">Offer</h4>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Link(URL)</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

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
        <button type="submit" id="update_edit" class="btn btn-primary update_edit">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- /traffic sources -->
<?php $this->load->view(ADMIN_VIEW.'footer'); ?>
<script type="text/javascript" src="<?=base_url()?>assets/admin/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/admin/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/libraries/jquery_ui/interactions.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/core/libraries/jquery_ui/touch.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/pages/appearance_draggable_panels.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/styling/switchery.min.js"></script>

<script type="text/javascript">

    $(document).ready(function(){


$('.btn-copylink').on("click", function(){
        value = $(this).data('clipboard-text'); //Upto this I am getting value
        var $temp = $("<input>");
          $("body").append($temp);
          $temp.val($(value).text()).select();
          document.execCommand("copy");
          $temp.remove();
          show_notify('clipboard success', 'bg-success');
    });


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
                { 'bSortable': false, 'aTargets': [ 2 ]},
                { 'bSearchable': false, 'aTargets': [ -1 ] }
            ],
            "ajax": {
                "url": "<?=BASE_URL_ADMIN?>offer/datatable",
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
                    { "data": "image" },
                    { "data": "name" },
                    { "data": "link" },
                    { "data": "description" },
                    { "data": "status" },
                    { "data": "action" }
            ]
        });

        $(document).off('click','.delete').on('click','.delete',function(e){
            e.preventDefault();
            var self = $(this);

            $('.loader').removeClass('hidden');

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


        $(document).off('click','#add_offer').on('click','#add_offer',function(e){

            var name = $('#name').val();
            var link = $('#link').val();
            var description = $('#description').val();
            var status = $('#status').val();


                $('.loader').removeClass('hidden');

                var file_data = $("#image").prop("files")[0];

                var form_data = new FormData();
                form_data.append("image",file_data);
                form_data.append("name",name);
                form_data.append("link",link);
                form_data.append("description",description);
                form_data.append("status",status);

                $.ajax({
                    url: '<?=BASE_URL_ADMIN?>offer/store',
                    type:'POST',
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data:form_data,
                    success: function(response) {
                        if( response.statuscode ) {
                            table.draw();
                            $('#name').val("");
                            $('#link').val("");
                            $('#description').val("");
                            show_notify(response.message, 'bg-success');
                        }else{
                            show_notify(response.message, 'bg-danger');
                        }

                        $('.loader').addClass('hidden');
                    }
                });   


        });

        $(document).off('click','.edit').on('click','.edit',function(e){
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
                            $(".file-styled").uniform({
                                fileButtonHtml: '<i class="icon-googleplus5"></i>',
                                wrapperClass: 'bg-warning'
                            });
                        }
                        $(".loader").addClass('hidden');
                    }
                });
        });

        $(document).off('click','#update_edit').on('click','#update_edit',function(e){

            var name = $('#update-name').val();
            var description = $('#update-description').val();
            var link = $('#update-link').val();
            var id = $('#update-id').val();
            var old_img = $('#update-old-img').val();

            if(name == ""){
                $('#update-name').focus();
                show_notify('Name filed is required', 'bg-danger');
            }else{

                $('.loader').removeClass('hidden');

                var file_data = $("#update-image").prop("files")[0];

                var form_data = new FormData();
                form_data.append("image",file_data);
                form_data.append("name",name);
                form_data.append("old_image",old_img);
                form_data.append("id",id);
                form_data.append("description",description);
                form_data.append("link",link);

                $.ajax({
                    url: '<?=BASE_URL_ADMIN?>Offer/update',
                    type:'POST',
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data:form_data,
                    success: function(response) {
                        if( response.statuscode ) {
                            table.draw();
                            $('#editmodal').modal('hide');
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