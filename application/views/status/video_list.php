<?php $this->load->view(STATUS_VIEW.'header'); ?>

<div class="container-fluid no-gutters">
        <div class="row">
            <div class="col-lg-12 p-0 ">
                <div class="header_iner d-flex justify-content-between align-items-center">
                    <div class="sidebar_icon d-lg-none">
                        <i class="ti-menu"></i>
                    </div>
                    <label class="switch_toggle d-none d-lg-block" for="checkbox">
                        <input type="checkbox" id="checkbox">
                        <div class="slider round open_miniSide"></div>
                    </label>

                    <div class="header_right d-flex justify-content-between align-items-center">
                        <div class="header_notification_warp d-flex align-items-center">
                            <li>
                                <div class="serach_button">
                                    <i class="ti-search"></i>
                                    <div class="serach_field-area d-flex align-items-center">
                                        <div class="search_inner">
                                            <form action="#">
                                                <div class="search_field">
                                                    <input type="text" placeholder="Search here..." >
                                                </div>
                                                <button class="close_search"> <i class="ti-search"></i> </button>
                                            </form>
                                        </div>
                                        <span class="f_s_14 f_w_400 ml_25 white_text text_white" >Apps</span>
                                    </div>
                                </div>
                            </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="main_content_iner overly_inner ">
        <div class="container-fluid p-0 ">
            <!-- page title  -->
            <div class="row">
                <div class="col-12">
                    <div class="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                        <div class="page_title_left">
                            <h3 class="f_s_25 f_w_700 dark_text" >Video List</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 ">
                    <div class="white_card mb_30 card_height_100">

                        <div class="pagination_body">
                            
                        </div>
                    </div>


                </div>
            </div>

            

            <div class="row video_list_body"></div>

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
        <button type="submit" id="updateVideo" class="btn btn-primary updateVideo">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<div class="modal fade" id="editmodal_link" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #383838">
        <h5 class="modal-title" style="color: #FFF; padding-bottom: 10px;" align="center">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body-link" >
        
      </div>

      <div class="modal-footer">
        <button type="submit" id="updateVideo" class="btn btn-primary updateVideolink">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



<?php $this->load->view(STATUS_VIEW.'footer'); ?>

<script type="text/javascript">

$(document).ready(function(){

$(document).off('click','.pagination-button').on('click','.pagination-button',function(e){
e.preventDefault();

var page = $(this).data('page');

list_video(page);

});


list_video(1);

function list_video(page)
{

    $(".loader").removeClass('hidden');

    $.ajax({
                url: '<?=BASE_URL_2XSTATUS?>Video_list/list_video/'+page,
                type:'GET',
                dataType: 'JSON',
                success: function(response) {
                    if(response.response ) {
                        
                        $('.pagination_body').html(response.pagination);
                        $('.video_list_body').html(response.post_video);

                        $(".loader").addClass('hidden');
                    }
                },
                error: function(repsonse){
                    $(".loader").addClass('hidden');
                }
            });
} 


$(document).off('click','.edit_upload').on('click','.edit_upload',function(e){
            e.preventDefault();
            var self = $(this);
            
                $(".loader").removeClass('hidden');
                var url = self.attr('href');

                $.ajax({
                    url: url,
                    dataType: 'JSON',
                    success: function(response) {
                        if( response.response ) {
                            $('#editmodal').modal('show');
                            $('.modal-body').html(response.data);
                        }
                        $(".loader").addClass('hidden');
                    }
                });
    });

    $(document).off('click','.edit_link').on('click','.edit_link',function(e){
        e.preventDefault();
        var self = $(this);
        
            $(".loader").removeClass('hidden');
            var url = self.attr('href');

            $.ajax({
                url: url,
                dataType: 'JSON',
                success: function(response) {
                    if( response.response ) {
                        $('#editmodal_link').modal('show');
                        $('.modal-body-link').html(response.data);
                    }
                    $(".loader").addClass('hidden');
                }
            });
    });

    $(document).off('click','.updateVideo').on('click','.updateVideo',function(e){
            e.preventDefault();
            var self = $(this);

            $(".loader").removeClass('hidden');

            var form_data = new FormData();
            form_data.append("id",$('#id_upload').val());
            form_data.append("category_id",$('#category_id_value').val());
            form_data.append("name",$('#name_value').val());
            form_data.append("image_thumbnail", $("#image_upload_value").prop("files")[0]);
            form_data.append("video_link",$("#video_upload_value").prop("files")[0]);
            form_data.append("old_image",$('#old_image').val());
            form_data.append("old_video",$('#old_video').val());
                
                $.ajax({
                    url: '<?=BASE_URL_2XSTATUS?>Video_list/update',
                    type:'POST',
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data:form_data,
                    success: function(response) {

                        $('#editmodal').modal('hide');
                        $(".loader").addClass('hidden');

                        if( response.statuscode ) {
                            show_notify(response.message, 'bg-success');
                            //table.draw();
                        }else{
                            show_notify(response.message, 'bg-danger');
                        }
                        
                    }
                });
            
                
        });


    $(document).off('click','.updateVideolink').on('click','.updateVideolink',function(e){
            e.preventDefault();
            var self = $(this);

            $(".loader").removeClass('hidden');
                
                $.ajax({
                    url: '<?=BASE_URL_2XSTATUS?>Video_list/updateLink',
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