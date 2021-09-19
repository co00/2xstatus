<?php $this->load->view(ADMIN_VIEW.'header'); ?>

<style type="text/css">
    .panel-heading-custome{
        padding-top: 0px !important; 
        padding-bottom: 0px !important;
    }

    .table-th-padding tr  th {
        padding: 8px 8px !important;
    }

    .category-box{
        display: block;
        padding: 3px;
        margin-bottom: 20px;
        line-height: 1.5384616;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 3px;
        -webkit-transition: border .2s ease-in-out;
        -o-transition: border .2s ease-in-out;
        transition: border .2s ease-in-out;
    }

</style>

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
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Category Name" value="<?=set_value('name'); ?>">
                </div>

                <div class="col-md-3">
                    <b class="control-label">Category Image: <span class="text-danger">*</span></b>
                    <input type="file" class="file-styled" id="image" name="image">
                </div>


                <div class="col-md-3">
                    <b class="control-label">Category Type</b>
                    <select class="form-control" id="category_status">
                        <option value="1">Full Screen</option>
                        <!-- <option value="2">Landscape Screen</option> -->
                    </select>
                </div>


                <div class="col-md-2">
                    <br>
                    <button id="add_category" class="btn btn-primary">Add</button>
                </div>

            </div>

            <br>
    </div>
</div>


<!-- Main charts -->
<div class="row">
    <div class="col-lg-12">

<div class="panel panel-flat">
    <!-- <div class="panel-heading">
        <h4 class="panel-title">Category</h4>
        <div class="heading-elements">
            <a href="<?=BASE_URL_ADMIN?>category/add" class="btn btn-primary">Add</a>      
        </div><br>
    </div> -->



    <div class="panel-body" style="padding-top: 10px !important; padding-bottom: 0px !important;" >
<form method="post" action="<?=BASE_URL_ADMIN?>category/preference" enctype="multipart/form-data">

<div class="col-md-12">
    <button class="btn btn-success" style="width: 100%">Submit</button>
    <br><br>
</div>

        <div class="col-md-6 sortable-panel">

        <?php if (!empty($category)) { foreach ($category as $key => $value) { ?>

        <div class="col-md-12 category-box">
            <div class="panel cursor-move">
                <input type="hidden" name="preference[]" value="<?=$value->id?>">
                <img src="<?=BASE_URL.CATEGORY_UPLOADS.$value->image?>" style="width: 70px; height: 50px;">
                <b style="margin-left: 10px; font-size: 15px;"><?=$value->name?></b>
                <a class="p-5 delete text-danger pull-right" style="margin-left: 10px;" href="<?=BASE_URL_ADMIN.'category/delete/'.$value->id?>"><i class="icon-trash"></i></a>
                <a class="p-5 edit pull-right" href="<?=BASE_URL_ADMIN.'category/edit/'.$value->id?>"><i class="icon-pencil3"></i></a>
            </div>  
        </div>

        <?php } } ?>

        </div>
</form>
        <!-- <div class="table-responsive">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div> -->


    </div>
</div>


<div class="modal fade" id="editmodal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" >
        
      </div>

      <div class="modal-footer">
        <button type="submit" id="update_image" class="btn btn-primary">Save changes</button>
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

<script type="text/javascript">

    $(document).ready(function(){


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
                "url": "<?=BASE_URL_ADMIN?>category/datatable",
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

            "columns": [
                    { "data": "id" },
                    { "data": "image" },
                    { "data": "name" },
                    { "data": "category_status" },
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


        $(document).off('click','#add_category').on('click','#add_category',function(e){

            var name = $('#name').val();
            var category_status = $('#category_status').val();

            if(name == ""){
                $('#name').focus();
                show_notify('Name filed is required', 'bg-danger');
            }else if($('#image')[0].files.length === 0){
                $('#image').focus();
                show_notify('Image filed is required', 'bg-danger');
            }else{

                $('.loader').removeClass('hidden');

                var file_data = $("#image").prop("files")[0];

                var form_data = new FormData();
                form_data.append("image",file_data);
                form_data.append("name",name);
                form_data.append("category_status",category_status);

                $.ajax({
                    url: '<?=BASE_URL_ADMIN?>category/storeCategory',
                    type:'POST',
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data:form_data,
                    success: function(response) {
                        if( response.response ) {
                            //table.draw();
                            $('#name').val("");
                            location.reload();
                            show_notify(response.msg, 'bg-success');
                        }else{
                            show_notify(response.msg, 'bg-danger');
                        }

                        $('.loader').addClass('hidden');
                    }
                });   

            }

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

        $(document).off('click','#update_image').on('click','#update_image',function(e){

            var name = $('#update-name').val();
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

                $.ajax({
                    url: '<?=BASE_URL_ADMIN?>category/update',
                    type:'POST',
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data:form_data,
                    success: function(response) {
                        if( response.statuscode ) {
                            //table.draw();
                            location.reload();
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