<style>

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
						$attributes = ['id' => 'createUserForm'];	
						echo form_open('user/saveUser', $attributes) ?>
							<div id="sendEmailCustomDiv" class="row">
								<div class="mb-4 col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<h3>Create New User</h3>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable>First Name <span class="red">*</span></lable>
									<input type="text" class="form-control" name="firstName" id="firstName">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable>Last Name <span class="red">*</span></lable>
									<input type="text" class="form-control" name="lastName" id="lastName">
								</div>		
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable>Phone <span class="red">*</span></lable>
									<input type="text" class="form-control" name="phoneNo" id="phoneNo">
								</div>	
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable>Mobile <span class="red">*</span></lable>
									<input type="text" class="form-control" name="mobileNo" id="mobileNo">
								</div>	
													
							</div>
							<div class="row">
								<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<lable>Email <span class="red">*</span></lable>
									<input onfocusout="checkUniqueEmail()" type="text" class="form-control" name="email" id="email">
								</div>	
								<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable>office No</lable>
									<input type="text" class="form-control" name="officePhoneNo" id="officePhoneNo">
								</div>		
								<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable>Gender <span class="red">*</span></lable>
									<select class="form-control" name="gender" id="gender">
										<option value="">Select Gender</option>
										<option>Male</option>
										<option>Female</option>
										<option>Others</option>
									</select>
								</div>
								<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable>Date Of Birth <span class="red">*</span></lable>
									<input type="date" class="form-control" name="dateOfBirth" id="dateOfBirth">
								</div>		
								<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<lable>Address <span class="red">*</span></lable>
									<textarea class="form-control" id="address" name="address"></textarea>
								</div>
								<div class="mb-4 mt-4 col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<h3>Login Details</h3>
								</div>	
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable>User Name <span class="red">*</span></lable>
									<input  onfocusout="checkUniqueUsername()" type="text" class="form-control" name="username" id="username">
								</div>																	
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable>Password <span class="red">*</span></lable>
									<input type="password" class="form-control" name="password" id="password">
								</div>	
							</div>
							<div class="row">
								<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<lable>Roles <span class="red">*</span></lable>
									<select class="form-control" name="roles[]" id="roles" multiple>
										<option>SuperAdmin</option>
										<option>UserAccess</option>
										<option>ProgramLeadAccess</option>
										<option>ContractAccess</option>
										<option>VetterAccess</option>
										<option>SigningQueueAccess</option>
									</select>
								</div>	
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<input id="sendEmailWithCredentials" type="checkbox" name="sendEmailWithCredentials" value="1">
									<label>Send email to user with credentials.</label><br>
									<button type="button" id="createUserBtn" class="createUserBtn btn btn-success">Create User</button>
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
			$(document).on('touchstart click', '#createUserBtn', function(event){
				var firstName = document.getElementById('firstName').value;
				var lastName = document.getElementById('lastName').value;
				var phoneNo = document.getElementById('phoneNo').value;
				var mobileNo = document.getElementById('mobileNo').value;
				var email = document.getElementById('email').value;
				var gender = document.getElementById('gender').value;
				var dateOfBirth = document.getElementById('dateOfBirth').value;
				var address = document.getElementById('address').value;
				var username = document.getElementById('username').value;
				var password = document.getElementById('password').value;
				var roles = $('#roles').val(); 

				if(firstName == "" || lastName == "" || (phoneNo == "" && mobileNo == "") || email == "" || gender == "" || dateOfBirth == "" || address == "" || username == "" || password == "") {

					swal({
					  title: "Failed!",
					  text: "Please fill all the Mandatory Details!",
					  icon: "warning",
					});
					return false;					
				}

				if(!validateEmail(email)) {
					swal({
					  title: "Failed!",
					  text: "Please enter a valid email!",
					  icon: "warning",
					});	
					return false;						
				}

				if(roles.length < 1) {
					swal({
					  title: "Failed!",
					  text: "Please select a Role!",
					  icon: "warning",
					});	
					return false;					
				}

				//sending ajax after validation.

				swal({
					title: "Are you sure?",
					text: "You are about to create this user!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						//Send ajax here
						var form = document.getElementById("createUserForm");
						var formData = new FormData(form);
						var ajaxUrl = "<?php echo base_url(); ?>" + "user/saveuser";
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
										location.reload();
					            	} else if(obj.code == 0) {
										swal({
										  title: "Failed!",
										  text: obj.msg,
										  icon: "warning",
										});	
					            	} else {
										swal({
										  title: "Failed!",
										  text: 'Error Occured While Creating User',
										  icon: "warning",
										});
					            	}
					            } catch (e) {
					            	console.log(e);
									swal({
									  title: "Failed!",
									  text: 'Error Occured While Creating User',
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

		function checkUniqueEmail() {
			
			var email = document.getElementById('email').value;
			if(email.length < 3) {
				document.getElementById('email').style.border = "1px solid #ced4da";
				document.getElementById('createUserBtn').style.display = "block";
				return false;
			}
			$.ajax({
			    url: "<?php echo base_url(); ?>" + 'user/checkuniqueemail',
			    data: {
			    	email: email
			    },
			    type: 'POST',
			    success : function(data){
	            	
	            	if(data == 0) {
						swal({
						  title: "Success!",
						  text: email + " already exists, please select a different email address.",
						  icon: "warning",
						});	
						document.getElementById('email').style.border = "2px solid red";
						document.getElementById('createUserBtn').style.display = "none"; 
	            	} else {
	            		document.getElementById('email').style.border = "1px solid #ced4da";
	            		document.getElementById('createUserBtn').style.display = "block";
	            	}
	            }
			});

		}

		function checkUniqueUsername() {
			
			var username = document.getElementById('username').value;
			if(username.length < 3) {
				document.getElementById('email').style.border = "1px solid #ced4da";
				return false;
			}
			$.ajax({
			    url: "<?php echo base_url(); ?>" + 'user/checkuniqueusername',
			    data: {
			    	username: username
			    },
			    type: 'POST',
			    success : function(data){
	            	
	            	if(data == 0) {
						swal({
						  title: "Success!",
						  text: username + " already exists, please select a different Username.",
						  icon: "warning",
						});	
						document.getElementById('username').style.border = "2px solid red"; 
						document.getElementById('createUserBtn').style.display = "none";
	            	} else {
	            		document.getElementById('username').style.border = "1px solid #ced4da";

	            		document.getElementById('createUserBtn').style.display = "block";
	            	}

	            }
			});

		}			
	</script>