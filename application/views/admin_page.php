<div class="col-sm-10">
	<!-- <?php echo form_open_multipart('image_controller/do_upload'); ?> -->
	<form enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/image_controller/do_upload" method = "post">

	<input type="file" name="userfile" size="20" />
	<input type="hidden" name="latitude" id = "latitude">
	<input type="hidden" name="longitude" id="longitude">

	<br /><br />

	<input type="submit" name="submit">

	</form>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		if (navigator.geolocation) {
       navigator.geolocation.getCurrentPosition(setPosition);
    } else { 
        console.log("Geolocation is not supported by this browser.");
    }
    function setPosition(position) {
    	$('#longitude').val(position.coords.longitude);
    	$('#latitude').val(position.coords.latitude);
		}
	});

</script>