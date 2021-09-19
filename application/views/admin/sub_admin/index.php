<?php $this->load->view(ADMIN_VIEW.'header'); ?>
 
<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-title">Sub admin</h4>

        <div class="heading-elements">
            <a href="<?=BASE_URL_ADMIN?>sub_admin/add" class="btn btn-primary">Add</a>
            <a href="javascript:void(0)" data-href="<?=BASE_URL_ADMIN?>sub_admin/export" class="btn btn-primary export">Export</a>                 
        </div><br>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Username</th>
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
<?php $this->load->view(ADMIN_VIEW.'footer'); ?>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/pages/datatables_basic.js"></script>

<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_ASSETS?>js/plugins/forms/styling/switchery.min.js"></script>

<script type="text/javascript">

    $(document).ready(function(){
        var table = $('#table').dataTable({
            "processing": true,
            "serverSide": true,
            "order": [[ 0, "desc" ]],

            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ -1 ]},
                { 'bSearchable': false, 'aTargets': [ -1 ]}
            ],
            "ajax": {
                "url": "<?=BASE_URL_ADMIN?>sub_admin/datatable",
                "type": "POST"
            },
            // "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ":20,
            "oLanguage": {
            // "sProcessing": "<img src='<?php //echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
            },
            initComplete: function (settings, json) {
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
                    { "data": "name" },
                    { "data": "mobile" },
                    { "data": "email" },
                    { "data": "username" },
                    { "data": "status" },
                    { "data": "action" }
            ]
        });

        window.status_changed = true;
        $(document).off('change','.change_status').on('change','.change_status',function(e){
            e.preventDefault();

            if(window.status_changed) {
                var self = $(this);
                if( confirm('Are you sure, you want to change the status?') ) {
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
                    window.status_changed = false;
                    self.click();
                }
            } else {
                window.status_changed = true;
            }
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
                        if( response.statuscode ) {
                            self.closest('tr').remove();
                        }
                        $(".loader").addClass('hidden');
                    }
                });
            }
        });

        $(document).off('click','.export').on('click','.export',function(){
            var href = $(this).attr('data-href');

            window.location.href = href;
        });
    });

</script>