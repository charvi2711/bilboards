<div class="col-sm-10" style="overflow:auto">
	<form action="#" id="form" class="form-horizontal">
		<input type="hidden" value="" name="id"/> 
		<div class="grid-form">
		    <div data-row-span="3">
		        <div data-field-span="1">
		        	<label>District</label>
		        	<input type="text" name="district_name" id="district_name">
		        </div>
                <div data-field-span="1">
                    <label>State</label>
                    <select class="selectpicker" data-live-search = "true" name="state_id" id="state_id">
                      <?php
                      foreach ($state as $values) {
                        foreach ($values as $value) {
                            echo '<option value="'.$value->id.'">'.$value->state_name.'</option>';
                        } 
                      }
                      ?>
                    </select>
                </div>
		    </div>
		</div>
	</form>

	<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>

	<br>
	<br>

	<h3>Data</h3>
	<br>
	<button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
	<br />
	<br />
	<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
	    <thead>
	        <tr>
	            <th>districts</th>
                <th>State</th>
	            <th style="width:125px;">Action</th>
	        </tr>
	    </thead>
	    <tbody>
	    </tbody>
	    <tfoot>
	        <tr>
	            <th>districts</th>
                <th>State</th>
                <th>Action</th>
	        </tr>
	    </tfoot>
	</table>
</div>
<script type="text/javascript">
 
    var save_method = 'add'; //for save method string
    var table;
     
    $(document).ready(function() {
     
        // $('[name="rate_as_per"]').selectpicker('val', data.bilty_rate_as_per);

        // $('select').on('change', function(e){
        //   console.log(this.value,
        //               this.options[this.selectedIndex].value,
        //               $(this).find("option:selected").val(),);
        // });

        //datatables
        table = $('#table').DataTable({ 
     
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
     
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('district/ajax_list')?>",
                "type": "POST"
            },
     
            //Set column definition initialisation properties.
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            ],
     
        });
    });

    function epmty_form(){
        $("#district_name").val("");
    }
     
    function edit_person(id){
        save_method = 'update';
        $('#btnSave').text('update');
     
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('district/ajax_edit/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.id);
                $('[name="district_name"]').val(data.district_name);
                $('[name="state_id"]').selectpicker('val', data.state_id);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
     
    function reload_table(){
        table.ajax.reload(null,false); //reload datatable ajax 
    }
     
    function save(){
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        var url;
     
        if(save_method == 'add') {
            url = "<?php echo site_url('district/ajax_add')?>";
        } else {
            url = "<?php echo site_url('district/ajax_update')?>";
        }
     
        // ajax adding data to database

        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                reload_table();
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
     
            }
        });

        save_method = 'add';
        epmty_form();
    }
     
    function delete_person(id){
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('district/ajax_delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
     
        }
    }
 
</script>
