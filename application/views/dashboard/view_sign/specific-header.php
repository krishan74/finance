<style>
 
#viewUsertable th, #viewUsertable td {
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
}    

.spanOk {
    color: darkgreen;
    font-family: impact;
    font-size: 20px;
    text-transform: uppercase;
}

.spanFailed {
    color: red;
    font-family: impact;
    font-size: 18px;	
}

.tableBtn {
    width: 119px;
    padding: 5px 10px;
    height: 38px;
    border-radius: 5px;
}
.roleBtn {
    padding: 7px 13px!important;
}

.modal-custom-width {
	max-width: 80%;
}

#modifyUserbtn {
	margin-top: 106px;
}

.red {
	color: red;
}
</style>

</head>
<body>


<!-- The Modal -->
<div class="modal" id="editClientModal">
  <div class="modal-dialog modal-custom-width">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modify Signatory</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div id="editClientModalBody" class="modal-body">
        	<?php 
				$attributes = ['id' => 'modifySigningForm'];	
				echo form_open('client/saveClient', $attributes) ?>

							<div class="row">
								<div class=" mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<lable>Signing Authority Name<span class="red">*</span></lable>
									<input type="text" class="form-control" name="authorityName" id="authorityName">
								</div>


								<div class=" mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<lable>Designation<span class="red">*</span></lable>
									<input type="text" class="form-control" name="authorityDesignation" id="authorityDesignation">
								</div>



								<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<lable>Phone<span class="red">*</span></lable>
									<input type="text" class="form-control" name="authorityPhone" id="authorityPhone">
								</div>


								<div class=" mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<lable>Email<span class="red">*</span></lable>
									<input type="text" class="form-control" name="authorityEmail" id="authorityEmail">
								</div>


								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
									<label>Address <span class="red">*</span></label>
									<textarea class="form-control" name="authorityAddress" id="authorityAddress">
									</textarea>
								</div>
								<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<input type="hidden" name="hiddenId" id="hiddenId" value="">
									<button type="button" id="modifySignBtn" class="modifySignBtn btn btn-success">Modify Signing Authority</button>
								</div>
							</div>


			</form>
        </div>


      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
      </div>


	<div class="row">
		<div class="custom-navbar col-lg-2 col-md-3 col-sm-12 col-xs-12">
			<?php $this->load->view('includes/nav'); ?>
		</div>
		<div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
			<div class="row">
				<div class="topHeader pull-right col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php $this->load->view('includes/top-header-section'); ?>
				</div>
				<div class="contentSection">
					<div class="contentSectionInner">
						<h3 class="mb-4">List of Signatory<a href="<?php echo base_url(); ?>signingauthority/create"><button type="button" class="ml-3 btn btn-warning">Add Signatory</button></a></h3>
						<table id="viewUsertable" class="display">
						    <thead>
						        <tr>
						        	<th>Action</th>
						        	<th class="text-left">Name</th>
						        	<th class="text-left">Designation</th>
						            <th class="text-left">Phone</th>
						            <th class="text-left">Email</th>
						        </tr>
						    </thead>
						    <tbody>
						        <?php foreach ($AllSignAuthority as $key => $value) { ?>
						        <tr>
									<td>
						            	<button title="Edit Signing Authority" data-id="<?php echo $value['id']; ?>" class="btn btn-info editSigningFunc"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>&nbsp;
						            	<button data-id="<?php echo $value['id']; ?>" title="Delete Signing Authority" class="btn btn-danger deleteClientById"><i class="fa fa-trash" aria-hidden="true"></i></button>
						            </td>						        	
						        	<td class="text-left"><?php echo $value['authorityName']; ?></td>
						        	<td class="text-left"><?php echo $value['authorityDesignation']; ?></td>
						            <td class="text-left"><?php echo $value['authorityPhone']; ?></td>
						            <td class="text-left"><?php echo $value['authorityEmail']; ?></td>
						            						            
						        </tr>
						    	<?php } ?>
						    </tbody>
						</table>

					</div>
				</div>
				<div class="contentSectionFooterInner w-100">
					<h3>© COPYRIGHT 2020 Auditor Finance ALL RIGHTS RESERVED</h3>
				</div>
			</div>
		</div>
	</div>

<script>
	$(document).ready( function () {
    $('#viewUsertable').DataTable();
} );
</script>


<script>
    $( document ).ready(function() {

        $(document).on('touchstart click', '.editSigningFunc', function(event){
        	$('#modifySigningForm')[0].reset();
        	
        	var id = $(this).data('id');
 			
            if(id == "") {
	            swal({
	              title: "Failed!",
	              text: "ID Doesn't Exist!",
	              icon: "warning",
	            });
	            return false;
	        }

            //Sending Ajax
            $.ajax({
                url: '<?php echo base_url() ?>' + 'signingauthority/fetchSigningById',
                data: {
                	id: id
                },
                type: 'POST',
                success : function(result){
	                var obj = JSON.parse(result);

					document.getElementById('authorityName').value = obj.output[0].authorityName;
					document.getElementById('authorityDesignation').value = obj.output[0].authorityDesignation;
					document.getElementById('authorityPhone').value = obj.output[0].authorityPhone;
					document.getElementById('authorityEmail').value = obj.output[0].authorityEmail;
					document.getElementById('authorityAddress').value = obj.output[0].authorityAddress;				
					document.getElementById('hiddenId').value = obj.output[0].id;
					$('#editClientModal').modal('show');
				}
            });
        }); 

        $(document).on('touchstart click', '.deleteClientById', function(event){
        	        	
        	var id = $(this).data('id');
 			
            if(id == "") {
	            swal({
	              title: "Failed!",
	              text: "ID Doesn't Exist!",
	              icon: "warning",
	            });
	            return false;
	        }

			swal({
				title: "Are you sure?",
				text: "You are about to delete a Signing Authority!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {

		            //Sending Ajax
		            $.ajax({
		                url: '<?php echo base_url() ?>' + 'signingauthority/deletesigningbyid',
		                data: {
		                	id: id
		                },
		                type: 'POST',
		                success : function(result){
			                var obj = JSON.parse(result);

			                if(obj.code == 1) {
					            swal({
					              title: "Success!",
					              text: "Deleted User Successfully!",
					              icon: "success",
					            });

					            setTimeout(function(){ 
					            	location.reload(); 
					            }, 3000);	                	
			                } else {
					            swal({
					              title: "Failed!",
					              text: obj.msg,
					              icon: "warning",
					            });	                	
			                }
						}
		            });
		        }
		    });
        }); 

         
    }); 

     
</script>

<script>
	$( document ).ready(function() {


			$(document).on('touchstart click', '#modifySignBtn', function(event){


				var authorityName = document.getElementById('authorityName').value;
				var authorityDesignation = document.getElementById('authorityDesignation').value;
				var authorityPhone = document.getElementById('authorityPhone').value;
				var authorityEmail = document.getElementById('authorityEmail').value;
				var authorityAddress = document.getElementById('authorityAddress').value;
				var hiddenId = document.getElementById('hiddenId').value;
				

				if(authorityName == "" || authorityDesignation == "" || authorityPhone == "" || authorityEmail == "" || authorityAddress == "" || hiddenId == "") {

					swal({
					  title: "Failed!",
					  text: "Please fill all the Mandatory Details!",
					  icon: "warning",
					});
					return false;					
				}

				if(!validateEmail(authorityEmail)) {
					swal({
					  title: "Failed!",
					  text: "Please enter a valid mail!",
					  icon: "warning",
					});	
					return false;						
				}

				//sending ajax after validation.

				swal({
					title: "Are you sure?",
					text: "You are about to modify the Signing Authority!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						//Send ajax here
						var form = document.getElementById("modifySigningForm");
						var formData = new FormData(form);
						var ajaxUrl = "<?php echo base_url(); ?>" + "signingauthority/modifySigning";
						$.ajax({
						    url: ajaxUrl,
						    data: formData,
						    type: 'POST',
						    contentType: false, 
						    processData: false, 
						    success : function(data){
				            	try {
					            	var obj = JSON.parse(data);
					            	if(obj.code == 1) {
										swal({
										  title: "Success!",
										  text: obj.msg,
										  icon: "success",
										});	

										setTimeout(function(){ 
											location.reload(); 
										}, 3000);
										
					            	} else if(obj.code == 0) {
										swal({
										  title: "Failed!",
										  text: obj.msg,
										  icon: "warning",
										});	
					            	} else {
										swal({
										  title: "Failed!",
										  text: 'Error Occured While Processing Request',
										  icon: "warning",
										});
					            	}
					            } catch (e) {
					            	console.log(e);
									swal({
									  title: "Failed!",
									  text: 'Error Occured While Processing Request',
									  icon: "warning",
									});					            	
					            }
				            }
						});						
					}
				});
				
				
			});



	}); 

	function validateEmail(emailID) {
		atpos = emailID.indexOf("@");
		dotpos = emailID.lastIndexOf(".");
		if (atpos < 1 || ( dotpos - atpos < 2 )) {
			
			return false;
		}
		return true;
	}		
</script>