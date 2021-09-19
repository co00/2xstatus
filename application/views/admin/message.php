<?php
	if( isset($_SESSION['response']) && isset($_SESSION['error']) ) {
		if( $_SESSION['response'] == 'success' ) {
			$type = 'bg-success';
		} else {
			$type = 'bg-danger';
		}

		if( !empty($_SESSION['error']) ) {
			$msg = $_SESSION['error'];
		}
?>		
		<script type="text/javascript">
			$(document).ready(function(){
				new PNotify({
		            text: '<?=$msg?>',
		            addclass: '<?=$type?>'
		        });
		        
			});
		</script>
<?php
	}  
?>