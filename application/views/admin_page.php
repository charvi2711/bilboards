

<style>

.hide {position :absolute; top: -1px; }
</style>



<div class="col-sm-10">
	<!-- <?php echo form_open_multipart('image_controller/do_upload'); ?> -->
	

	<form enctype="multipart/form-data" action="http://192.168.43.30:5000/uploader" method = "post" id="myForm" target="hiddenframe">

	<input type="file" name="file" size="20" />
	<input type="hidden" name="longitude" id="longitude">
	<input type="hidden" name="latitude" id = "latitude">

	<br /><br />

	<input type="submit" name="submit" id="name">

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