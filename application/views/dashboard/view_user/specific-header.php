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
</style>

</head>
<body>


<!-- The Modal -->
<div class="modal" id="editUserModal">
  <div class="modal-dialog modal-custom-width">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modify User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div id="editUserModalBody" class="modal-body">
        <div class="row pl-5 pr-5">
			<?php 
			$attributes = ['id' => 'modifyUserForm'];	
			echo form_open('user/saveUser', $attributes) ?>
				<div class="row">
					<div class="mb-4 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h3>Modify User Details</h3>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<lable>First Name <span class="red">*</span></lable>
						<input type="text" class="form-control" name="firstName" id="firstName">
						<input type="hidden" name="hiddenId" id="hiddenId">
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
						<input type="text" class="form-control" name="email" id="email">
						<input type="hidden" id="hiddenEmail" name="hiddenEmail">
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
						<h3>Modify Login Details</h3>
					</div>	
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<lable>User Name <span class="red">*</span></lable>
						<input type="text" class="form-control" name="username" id="username">
					</div>	

					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<lable>Status <span class="red">*</span></lable>
						<select name="status" id="status" class="form-control">
							<option value="0">InActive</option>
							<option value="1">Active</option>
						</select>
					</div>																			
				</div>
				<div class="row">
					<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<lable>Roles<span class="red">*</span></lable>
						<select class="form-control" name="roles[]" id="roles" multiple>
							<option value="SuperAdmin">SuperAdmin</option>
							<option value="UserAccess">UserAccess</option>
							<option value="ProgramLeadAccess">ProgramLeadAccess</option>
							<option value="ContractAccess">ContractAccess</option>
							<option value="VetterAccess">VetterAccess</option>
							<option value="SigningQueueAccess">SigningQueueAccess</option>
						</select>
					</div>	
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<button type="button" id="modifyUserbtn" class="modifyUserbtn btn btn-success">Modify User</button>
					</div>													
				</div>
			</form>        	
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


	<div class="row">
		<div class="custom-navbar col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<?php $this->load->view('includes/nav'); ?>
		</div>
		<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
			<div class="row">
				<div class="topHeader pull-right col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php $this->load->view('includes/top-header-section'); ?>
				</div>
				<div class="contentSection">
					<div class="contentSectionInner">
						<h3 class="mb-4">List of Users<a href="<?php echo base_url(); ?>user/create"><button type="button" class="ml-3 btn btn-warning">Add User</button></a></h3>
						<table id="viewUsertable" class="display">
						    <thead>
						        <tr>
						        	<th>Action</th>
						        	<th class="text-left">Name</th>
						        	<th class="text-left">Email</th>
						            <th class="text-left">Phone No.</th>
						            <th class="text-left">Office No.</th>
						            <th class="text-left">role</th>
						            <th class="text-left">Status</th>
						            
						        </tr>
						    </thead>
						    <tbody>
						        <?php foreach ($AllUserDetails as $key => $value) { ?>
						        <tr>
						        	<td>
						            	<button data-id="<?php echo $value['id']; ?>" title="Reset and Send Password" class="btn btn-primary resetPasswordFunc"><i class="fa fa-unlock-alt" aria-hidden="true"></i></button>&nbsp;
						            	<button title="Edit User" data-id="<?php echo $value['id']; ?>" class="btn btn-info editUserFunc"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>&nbsp;
						            	<button data-id="<?php echo $value['id']; ?>" title="Delete User" class="btn btn-danger deleteUserById"><i class="fa fa-trash" aria-hidden="true"></i></button>
						            </td>
						        	<td class="text-left"><?php echo $value['firstName'] . " " . $value['lastName']; ?></td>
						        	<td class="text-left"><?php echo $value['email']; ?></td>
						            <td class="text-left">
						            <?php
									if(!empty($value['phoneNo'])) {
										echo $value['phoneNo'];
									} else if($value['mobileNo']) {
										echo $value['mobileNo'];
									} else {
										echo "NA";
									}
						            ?></td>
						            <td class="text-left"><?php echo empty($value['officePhoneNo']) ? "NA" : $value['officePhoneNo']; ?></td>
						            <td class="text-left">
						            	<?php 
						            	$rolesFetched = json_decode($value['role'], true); 
						            	?>
						            	    <ul class="navbar-nav">
										      <li class="nav-item dropdown">
										        <a class="nav-link dropdown-toggle btn btn-primary roleBtn" id="navbarDropdownMenuLink<?php echo $key; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										          Roles
										        </a>
										        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink<?php echo $key; ?>">
										        	<?php foreach ($rolesFetched['role'] as $roleKey => $roleValue) {
										        		echo '<a class="dropdown-item">' . $roleValue . '</a>';
										        	}
										        	?>
										        </div>
										      </li>
										  </ul>
						            </td>
						            <td class="text-left"><?php echo ($value['status'] == 1) ? 'Active' : 'Inactive'; ?></td>
						            						            
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

        $(document).on('touchstart click', '.editUserFunc', function(event){
        	$('#modifyUserForm')[0].reset();
        	
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
                url: '<?php echo base_url() ?>' + 'user/fetchuserbyid',
                data: {
                	id: id
                },
                type: 'POST',
                success : function(result){
	                var obj = JSON.parse(result);

					document.getElementById('firstName').value = obj.output[0].firstName;
					document.getElementById('lastName').value = obj.output[0].lastName;
					document.getElementById('phoneNo').value = obj.output[0].phoneNo;
					document.getElementById('mobileNo').value = obj.output[0].mobileNo;
					document.getElementById('officePhoneNo').value = obj.output[0].officePhoneNo;				
					document.getElementById('email').value = obj.output[0].email;
					document.getElementById('hiddenEmail').value = obj.output[0].email;
					document.getElementById('gender').value = obj.output[0].gender;
					document.getElementById('dateOfBirth').value = obj.output[0].dateOfBirth;
					document.getElementById('address').value = obj.output[0].address;
					document.getElementById('username').value = obj.output[0].username;
					document.getElementById('hiddenId').value = obj.output[0].id;
					$('#status option[value="' + obj.output[0].status + '"]').attr("selected", "selected");
					try {
						var roles = obj.output[0].role;
						var roleObj = JSON.parse(roles);
						var roleArray = roleObj.role;

						var i = 0;
						for(i = 0; i < roleArray.length; i++) {

							$('#roles option[value="' + roleArray[i] + '"]').attr("selected", "selected");
						}
					} catch (e) { }

					$('#editUserModal').modal('show');
				}
            });
        }); 

        $(document).on('touchstart click', '.deleteUserById', function(event){
        	        	
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
				text: "You are about to delete an user!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {

		            //Sending Ajax
		            $.ajax({
		                url: '<?php echo base_url() ?>' + 'user/deleteuserbyid',
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

        $(document).on('touchstart click', '.resetPasswordFunc', function(event){
        	        	
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
				text: "You are about to reset password!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {

		            //Sending Ajax
		            $.ajax({
		                url: '<?php echo base_url() ?>' + 'user/resetpassword',
		                data: {
		                	id: id
		                },
		                type: 'POST',
		                success : function(result){
			                var obj = JSON.parse(result);

			                if(obj.code == 1) {
								swal({
								  title: "Success!",
								  text: "Password is successfully reset and mail sent to user!",
								  icon: "success",
								});	                	
			                } else {
								swal({
								  title: "Failed!",
								  text: "Failed to Reset Password!",
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
		$(document).on('touchstart click', '#modifyUserbtn', function(event){
			var firstName = document.getElementById('firstName').value;
			var lastName = document.getElementById('lastName').value;
			var phoneNo = document.getElementById('phoneNo').value;
			var mobileNo = document.getElementById('mobileNo').value;
			var email = document.getElementById('email').value;
			var gender = document.getElementById('gender').value;
			var dateOfBirth = document.getElementById('dateOfBirth').value;
			var address = document.getElementById('address').value;
			var username = document.getElementById('username').value;
			var hiddenId = document.getElementById('hiddenId').value;
			var roles = $('#roles').val(); 

			if(hiddenId == "") {
				swal({
				  title: "Failed!",
				  text: "Unexpected Error Occured, ID Missing!",
				  icon: "warning",
				});
				return false;					
			}

			if(firstName == "" || lastName == "" || (phoneNo == "" && mobileNo == "") || email == "" || gender == "" || dateOfBirth == "" || address == "" || username == "") {

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
				text: "You are about to modify this user!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					//Send ajax here
					var form = document.getElementById("modifyUserForm");
					var formData = new FormData(form);
					var ajaxUrl = "<?php echo base_url(); ?>" + "user/modifyuser";
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
									  text: 'Error Occured While Modifying User',
									  icon: "warning",
									});
				            	}
				            } catch (e) {
				            	console.log(e);
								swal({
								  title: "Failed!",
								  text: 'Error Occured While Modifying User',
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