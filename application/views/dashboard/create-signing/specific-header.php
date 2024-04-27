<style>

.red {
	color:red;
}

.allOptions{
	min-height: 200px;
	background-color: gainsboro;
	color: #007bff;
	border-radius: 5px;
	-webkit-box-shadow: 2px 2px 5px 0px rgba(0,0,0,0.75);
	-moz-box-shadow: 2px 2px 5px 0px rgba(0,0,0,0.75);
	box-shadow: 2px 2px 5px 0px rgba(0,0,0,0.75);
}

.allOptions h3 {
	text-align: center;
	vertical-align: middle;
	line-height: 200px; 
	text-transform: uppercase;
	font-size: 20px;
	font-family: impact;
}


.allOptions:hover {
	background-color: #37444c;
	color: #fff;
	cursor: pointer;
}

.allOptionsTop {
	padding: 10px!important;
}

.createUserBtn {
    margin-top: 10px;
}

#sendEmailWithCredentials {
    margin-top: 65px;
}

</style>

</head>
<body>
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

						<?php 
						$attributes = ['id' => 'modifyUserForm'];	
						echo form_open('signingauthority/saveAuthority', $attributes) 
						?>

							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<h3>Add Signing Authority</h3>
								</div>
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
							<button type="button" id="createSignBtn" class="createSignBtn btn btn-success">Add Signing Authority</button>

							
							</div>


						</div>

				
						</form>
					</div>
					
				</div>
				<div class="contentSectionFooterInner w-100">
					<h3>© COPYRIGHT 2020 Auditor Finance ALL RIGHTS RESERVED</h3>
				</div>
			</div>
		</div>
	</div>

	<script>
		$( document ).ready(function() {
			$(document).on('touchstart click', '#createSignBtn', function(event){
				
				var authorityName = document.getElementById('authorityName').value;
				var authorityDesignation = document.getElementById('authorityDesignation').value;
				var authorityPhone = document.getElementById('authorityPhone').value;
				var authorityEmail = document.getElementById('authorityEmail').value;
				var authorityAddress = document.getElementById('authorityAddress').value;
				
				if(authorityName == "" || authorityDesignation == "" || authorityPhone == "" || authorityEmail == "" || authorityAddress == "") {

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
					  text: "Please enter a valid Company Email!",
					  icon: "warning",
					});	
					return false;						
				}

				//sending ajax after validation.

				swal({
					title: "Are you sure?",
					text: "You are about to create the Signing Authority!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						//Send ajax here
						var form = document.getElementById("modifyUserForm");
						var formData = new FormData(form);
						var ajaxUrl = "<?php echo base_url(); ?>" + "signingauthority/saveAuthority";
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

		function addContactPerson() {
			var NumberOfContact = document.getElementById('NumberOfContact').value;
			NumberOfContact = parseInt(NumberOfContact);
			NumberOfContact++;
			var i;
			var html = "";
			for(i = 1; i <= NumberOfContact; i++) {
				 
				html += '<div class="row">' +
				'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
				'<lable>Conatct Person Name<span class="red">*</span></lable>' +
				'<input type="text" class="form-control" name="contactPersonName' + i + '" id="contactPersonName' + i + '" placeholder="Contact Person ' + i + ' Details">' +
				'</div>' +
				'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
				'<lable>Contact Person Email<span class="red">*</span></lable>' +
				'<input type="text" class="form-control" name="contactPersonEmail' + i + '" id="contactPersonEmail' + i + '" placeholder="Contact Person ' + i + ' Details">' +
				'</div>' +
				'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
				'<lable>Contact Person Phone<span class="red">*</span></lable>' +
				'<input type="text" class="form-control" name="contactPersonPhone' + i + '" id="contactPersonPhone' + i + '" placeholder="Contact Person ' + i + ' Details">' +
				'</div>' +
				'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
				'<lable>Designation<span class="red">*</span></lable>' +
				'<input type="text" class="form-control" name="designation' + i + '" id="designation' + i + '" placeholder="Contact Person ' + i + ' Details">' +
				'</div>';
				if(NumberOfContact != 1 && i != NumberOfContact) {
					html += '<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12"><hr></div>'; 
				}
				html += '</div>';				
			}

			document.getElementById('contactPersonDiv').innerHTML = html; 
			document.getElementById('NumberOfContact').value = NumberOfContact;
		}

		function minusContactPerson() {
			var NumberOfContact = document.getElementById('NumberOfContact').value;
			NumberOfContact = parseInt(NumberOfContact);
			NumberOfContact--;
			if(NumberOfContact == 0) {
				return false;
			}
			var i;
			var html = "";
			for(i = 1; i <= NumberOfContact; i++) {
				 
				html += '<div class="row">' +
				'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
				'<lable>Conatct Person Name<span class="red">*</span></lable>' +
				'<input type="text" class="form-control" name="contactPersonName' + i + '" id="contactPersonName' + i + '" placeholder="Contact Person ' + i + ' Details">' +
				'</div>' +
				'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
				'<lable>Contact Person Email<span class="red">*</span></lable>' +
				'<input type="text" class="form-control" name="contactPersonEmail' + i + '" id="contactPersonEmail' + i + '" placeholder="Contact Person ' + i + ' Details">' +
				'</div>' +
				'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
				'<lable>Contact Person Phone<span class="red">*</span></lable>' +
				'<input type="text" class="form-control" name="contactPersonPhone' + i + '" id="contactPersonPhone' + i + '" placeholder="Contact Person ' + i + ' Details">' +
				'</div>' +
				'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
				'<lable>Designation<span class="red">*</span></lable>' +
				'<input type="text" class="form-control" name="designation' + i + '" id="designation' + i + '" placeholder="Contact Person ' + i + ' Details">' +
				'</div>';
				if(NumberOfContact != 1 && i != NumberOfContact) {
					html += '<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12"><hr></div>'; 
				}
				html += '</div>';				
			}

			document.getElementById('contactPersonDiv').innerHTML = html; 
			document.getElementById('NumberOfContact').value = NumberOfContact;
		}				
	</script>