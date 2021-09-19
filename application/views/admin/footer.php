

						</div>

						
					</div>
					<!-- /main charts -->

					<!-- Footer -->
					<div class="footer text-muted">
						&copy; 2019. <a href="<?=base_url()?>" target="_blank"><?=APP_NAME?></a> by <a href="javascript:void(0)" target="_blank">Techno Teamme</a>
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
<?php $this->load->view(ADMIN_VIEW.'message'); ?>
<script type="text/javascript">
	function show_notify(text, bg_class) {
		new PNotify({
            text: text,
            addclass: bg_class
        });
	}

	function enable_switchery() {
        if (Array.prototype.forEach) {
            var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
            elems.forEach(function(html) {
                var switchery = new Switchery(html);
            });
        }
        else {
            var elems = document.querySelectorAll('.switchery');
            for (var i = 0; i < elems.length; i++) {
                var switchery = new Switchery(elems[i]);
            }
        }
    }

$(document).ready(function(){
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
</body>
</html>
