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

#authBlock {
	padding: 30px 0px;
    background-color: #f2f7ffe6;;
    margin-top: 35px;
    max-height: 250px;
    overflow-y: scroll;
    border: 1px solid gainsboro;
    vertical-align: top;
}

#bankDiv {
	padding: 0px 10px;
}
.rowBankDiv {
    background-color: #eadbba;
    padding-bottom: 25px;
    border-radius: 4px;
    margin-bottom: 20px;
    margin-top: 20px;
    -webkit-box-shadow: 2px 2px 4px 0px rgba(0,0,0,0.75);
    -moz-box-shadow: 2px 2px 4px 0px rgba(0,0,0,0.75);
    box-shadow: 2px 2px 4px 0px rgba(0,0,0,0.75);
}

.contactPersonClass {
    background-color: #eadbba;
    padding-bottom: 25px;
    border-radius: 4px;
    margin-bottom: 20px;
    margin-top: 20px;
    -webkit-box-shadow: 2px 2px 4px 0px rgba(0,0,0,0.75);
    -moz-box-shadow: 2px 2px 4px 0px rgba(0,0,0,0.75);
    box-shadow: 2px 2px 4px 0px rgba(0,0,0,0.75);	
}
.rowBankDiv .btn-danger {
    margin-top: 24px;
}

#contactPersonDiv {
    padding: 10px;
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
        <h4 class="modal-title">Modify Client</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div id="editClientModalBody" class="modal-body">
        	<?php 
				$attributes = ['id' => 'modifyClientForm'];	
				echo form_open('client/saveClient', $attributes) ?>


							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<h3>Create Party</h3>
								</div>

								<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable>Party Name<span class="red">*</span></lable>
									<input type="text" class="form-control" name="partyName" id="partyName">
								</div>

								<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable>Party Alias<span class="red">*</span></lable>
									<input type="text" class="form-control" name="partyAlias" id="partyAlias">
								</div>								
								
								<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable>Party Email <span class="red">*</span></lable>
									<input type="text" class="form-control" name="partyEmail" id="partyEmail">
								</div>	
								<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable>Alternate Email</lable>
									<input type="text" class="form-control" name="partyAlternateEmail" id="partyAlternateEmail">
								</div>									
								<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable>Party Phone <span class="red">*</span></lable>
									<input type="text" class="form-control" name="partyPhone" id="partyPhone">
								</div>	

								<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<lable> Party Alternate Phone</lable>
									<input type="text" class="form-control" name="partyAlternatePhone" id="partyAlternatePhone">
								</div>
													
							</div>
							<div class="row">


								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<div class="row">
										<div class="mt-5 col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<h3>Address Details</h3>
										</div>
										<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<lable> Address Line 1 <span class="red">*</span></lable>
											<input type="text" class="form-control" name="partyAddressLine1" id="partyAddressLine1">		
										</div>
										<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<lable> Address Line 2 <span class="red">*</span></lable>
											<input type="text" class="form-control" name="partyAddressLine2" id="partyAddressLine2">		
										</div>
										<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<lable> City <span class="red">*</span></lable>
											<input type="text" class="form-control" name="partyCity" id="partyCity">		
										</div>										
										<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<lable> State <span class="red">*</span></lable>
											<input type="text" class="form-control" name="partyState" id="partyState">		
										</div>
										<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<lable> Country <span class="red">*</span></lable>
											<input type="text" class="form-control" name="partyCountry" id="partyCountry">		
										</div>

										<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<lable> Zip <span class="red">*</span></lable>
											<input type="text" class="form-control" name="partyZip" id="partyZip">		
										</div>																												
									</div>
								</div>


								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<div class="row">
									<div class="mt-5 col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<h3>Alternate Address Details</h3>
								</div>
										<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<lable> Address Line 1 </lable>
											<input type="text" class="form-control" name="partyOtherAddressLine1" id="partyOtherAddressLine1">		
										</div>
										<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<lable> Address Line 2 </lable>
											<input type="text" class="form-control" name="partyOtherAddressLine2" id="partyOtherAddressLine2">		
										</div>
										<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<lable> City </lable>
											<input type="text" class="form-control" name="partyOtherCity" id="partyOtherCity">		
										</div>										
										<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<lable> State </lable>
											<input type="text" class="form-control" name="partyOtherState" id="partyOtherState">		
										</div>
										<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<lable> Country </lable>
											<input type="text" class="form-control" name="partyOtherCountry" id="partyOtherCountry">		
										</div>										

										<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<lable> Zip </lable>
											<input type="text" class="form-control" name="partyOtherZip" id="partyOtherZip">		
										</div>
									</div>
								</div>								
					
							</div>

							<div class="row">
								<div class="mt-5 col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h3>Bank Details</h3>
								</div>
								<div class="mt-5 col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
									<input type="hidden" id="bankCounter" name="bankCounter" value="0">
                                    <button type="button" onclick="addBankDiv()" class="btn btn-info">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
								</div>								
							</div>

							<div id="bankDiv">


							</div>						




							
							<div class="row">
								<div class="mt-5 col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h4>Default Signatory</h4>
									<select class="mt-3 form-control" name="defaultSigningAuthority" id="defaultSigningAuthority">
										<option value="">Select Signatory</option>
										<?php 
										foreach($AllSignAuth as $key => $value) {
										?>
										<option value="<?php echo $value['id']; ?>"><?php echo $value['authorityName'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>


				<div id="authBlock" class="row">
					
					<div class="pl-3 pr-3 mb-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h3>Select Signatory</h3>
					</div>
					<?php 
					foreach($AllSignAuth as $key => $value) {
					?>
					<div class="mb-2 pl-3 pr-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 repeatedDiv">
						<input type="checkbox" name="signAuthCheckbox[]" id="signAuthCheckbox<?php echo $value['id']; ?>" value="<?php echo $value['id']; ?>"> 
						<span title="<?php echo $value['authorityEmail']; ?>"><?php echo $value['authorityName'] ?></span>

					</div>	
					<?php } ?>
				
				</div>


				<div class="row">
					<div class="mb-4 mt-4 col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<h3>Contact Person Details  </h3>
					</div>

					<div class="mb-4 mt-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right">
						<button type="button" onclick="addContactPerson()" class="btn btn-info" id="">
							<i class="fa fa-plus" aria-hidden="true"></i>
						</button>
					
					</div>	

				</div>
				<div id="contactPersonDiv" class="w-100">
					

				</div>
				<div class="row">
				<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<input type="hidden" id="hiddenId" name="hiddenId" value="">
					<input type="hidden" name="NumberOfContact" id="NumberOfContact" value="1"> 
				</div>
			</div>			
			
        </div>


      <!-- Modal footer -->
      <div class="modal-footer">
      	<button type="button" id="modifyClientBtn" class="createUserBtn btn btn-success">&nbsp;Save&nbsp;</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      </form>
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
						<h3 class="mb-4">List of Parties<a href="<?php echo base_url(); ?>client/create"><button type="button" class="ml-3 btn btn-warning">Add Party</button></a></h3>
						<table id="viewUsertable" class="display">
						    <thead>
						        <tr>
						        	<th>Action</th>
						        	<th class="text-left">Party Name</th>
						        	<th class="text-left">Party Email</th>
						            <th class="text-left">Party Phone</th>
						            
						        </tr>
						    </thead>
						    <tbody>
						        <?php foreach ($AllClientDetails as $key => $value) { ?>
						        <tr>
									<td>
						            	<button title="Edit User" data-id="<?php echo $value['id']; ?>" class="btn btn-info editClientFunc"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>&nbsp;
						            	<button data-id="<?php echo $value['id']; ?>" title="Delete User" class="btn btn-danger deleteClientById"><i class="fa fa-trash" aria-hidden="true"></i></button>
						            </td>						        	
						        	<td class="text-left"><?php echo $value['partyName']; ?></td>
						        	<td class="text-left"><?php echo $value['partyEmail']; ?></td>
						            <td class="text-left"><?php echo $value['partyPhone']; ?></td>
						            						            
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

        $(document).on('touchstart click', '.editClientFunc', function(event){
        	$('#modifyClientForm')[0].reset();
        	
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
                url: '<?php echo base_url() ?>' + 'client/fetchClientbyid',
                data: {
                	id: id
                },
                type: 'POST',
                success : function(result){
	                var obj = JSON.parse(result);

					document.getElementById('partyName').value = obj.output[0].partyName;
					document.getElementById('partyAlias').value = obj.output[0].partyAlias;
					document.getElementById('partyEmail').value = obj.output[0].partyEmail;
					document.getElementById('partyAlternateEmail').value = obj.output[0].partyAlternateEmail;
					document.getElementById('partyPhone').value = obj.output[0].partyPhone;
					document.getElementById('partyAlternatePhone').value = obj.output[0].partyAlternatePhone;
					document.getElementById('partyAddressLine1').value = obj.output[0].partyAddressLine1;
					document.getElementById('partyAddressLine2').value = obj.output[0].partyAddressLine2;
					document.getElementById('partyCity').value = obj.output[0].partyCity;
					document.getElementById('partyState').value = obj.output[0].partyState;
					document.getElementById('partyCountry').value = obj.output[0].partyCountry;
					document.getElementById('partyZip').value = obj.output[0].partyZip;
					document.getElementById('partyOtherAddressLine1').value = obj.output[0].partyOtherAddressLine1;
					document.getElementById('partyOtherAddressLine2').value = obj.output[0].partyOtherAddressLine2;
					document.getElementById('partyOtherCity').value = obj.output[0].partyOtherCity;
					document.getElementById('partyOtherState').value = obj.output[0].partyOtherState;
					document.getElementById('partyOtherCountry').value = obj.output[0].partyOtherCountry;
					document.getElementById('partyOtherZip').value = obj.output[0].partyOtherZip;
					document.getElementById('hiddenId').value = obj.output[0].id;
					
					var defaultSigningAuthority = obj.output[0].defaultSigningAuthority;

					$("#defaultSigningAuthority").val(defaultSigningAuthority);
					
					var contactPersonObj = JSON.parse(obj.output[0].contactPersonDetail);
					try {
						var signingAuthorityObj = JSON.parse(obj.output[0].signingAuthority);

						var i;
						var j;
						var element;
						var tmpName;
						for(j = 0; j < signingAuthorityObj.length; j++) {

							tmpName = 'signAuthCheckbox' + signingAuthorityObj[j].toString();
							element = document.getElementById(tmpName);
							element.checked = true;
						}
					} catch (e) {
						console.log(e);
					}

					var html = "";
					for(i = 1; i <= contactPersonObj.length; i++) {

						html += '<div id="rowContactPersonDiv' + i + '" class="row contactPersonClass">' +
						'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
						'<lable>Contact Person Name<span class="red">*</span></lable>' +
						'<input type="text" class="form-control" name="contactPersonName[]" value="' + contactPersonObj[i - 1].contactPersonName + '">' +
						'</div>' +
						'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
						'<lable>Contact Person Email<span class="red">*</span></lable>' +
						'<input type="text" class="form-control" name="contactPersonEmail[]" value="' + contactPersonObj[i - 1].contactPersonEmail + '">' +
						'</div>' +
						'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
						'<lable>Contact Person Phone<span class="red">*</span></lable>' +
						'<input type="text" class="form-control" name="contactPersonPhone[]" value="' + contactPersonObj[i - 1].contactPersonPhone + '">' +
						'</div>' +
						'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
						'<lable>Designation<span class="red">*</span></lable>' +
						'<input type="text" class="form-control" name="designation[]" value="' + contactPersonObj[i - 1].designation + '">' +
						'</div>' +
						'<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">' +
						'<button type="button" onclick="minusContactPerson(' + i + ')" class="btn btn-danger" id="">Remove</button>' +
						'</div>' +
						'</div>';
						
					}

					var bankDetail = JSON.parse(obj.output[0].bankDetail);
					var index;
					var bankHtml = "";
					for(index = 1; index <= bankDetail.length; index++) {

						bankHtml += '<div id="bankDetail' + index +'" class="row rowBankDiv">' + 
						'<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">' + 
						'<lable>Beneficiary Name<span class="red">*</span></lable>' + 
						'<input type="text" class="form-control" name="beneficiaryName[]" value="' + bankDetail[index - 1].beneficiaryName + '">' +
						'</div>' +
						'<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">' +
						'<lable>Bank Name<span class="red">*</span></lable>' +
						'<input type="text" class="form-control" name="bankName[]" value="' + bankDetail[index - 1].bankName + '">' +
						'</div>' +
						'<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">' +
						'<lable>Bank Address <span class="red">*</span></lable>' +
						'<input type="text" class="form-control" name="bankAddress[]" value="' + bankDetail[index - 1].bankAddress + '">' +
						'</div>' +
						'<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">' +
						'<lable>Account No <span class="red">*</span></lable>' +
						'<input type="text" class="form-control" name="accountNo[]" value="' + bankDetail[index - 1].accountNo + '">' +
						'</div>' +
						'<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">' +
						'<lable> RTGS/NEFT/IFS Code <span class="red">*</span></lable>' +
						'<input type="text" class="form-control" name="rtgsNeftIfsCode[]" value="' + bankDetail[index - 1].rtgsNeftIfsCode + '">' +
						'</div>' +
						'<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">' +
						'<lable> Swift Code<span class="red">*</span></lable>' +
						'<input type="text" class="form-control" name="swiftCode[]" value="' + bankDetail[index - 1].swiftCode + '">' +
						'</div>' +
						'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">' + 
						'<button type="button" onclick="minusBankDiv(' + index + ')" class="btn btn-danger">' +
						'Remove' + 
						'</button>' +
						'</div>' +
						'</div>';

					}

					document.getElementById('bankDiv').innerHTML = bankHtml;
					document.getElementById('bankCounter').value = bankDetail.length;
					document.getElementById('contactPersonDiv').innerHTML = html; 
					document.getElementById('hiddenId').value = obj.output[0].id;	
					document.getElementById('NumberOfContact').value = contactPersonObj.length;
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
				text: "You are about to delete an user!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {

		            //Sending Ajax
		            $.ajax({
		                url: '<?php echo base_url() ?>' + 'client/deleteclientbyid',
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

	function removeBlock(id) {
		$("#contactBlock" + id).remove();
	}

	function addContactPerson() {
		var NumberOfContact = document.getElementById('NumberOfContact').value;
		NumberOfContact = parseInt(NumberOfContact);
		NumberOfContact++;
		var index = NumberOfContact;
		var html;

		html = '<div id="rowContactPersonDiv' + index + '" class="row contactPersonClass">' +
		'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
		'<lable>Contact Person Name<span class="red">*</span></lable>' +
		'<input type="text" class="form-control" name="contactPersonName[]">' +
		'</div>' +
		'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
		'<lable>Contact Person Email<span class="red">*</span></lable>' +
		'<input type="text" class="form-control" name="contactPersonEmail[]">' +
		'</div>' +
		'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
		'<lable>Contact Person Phone<span class="red">*</span></lable>' +
		'<input type="text" class="form-control" name="contactPersonPhone[]">' +
		'</div>' +
		'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
		'<lable>Designation<span class="red">*</span></lable>' +
		'<input type="text" class="form-control" name="designation[]">' +
		'</div>' +
		'<div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">' +
		'<button type="button" onclick="minusContactPerson(' + index + ')" class="btn btn-danger" id="">Remove</button>' +
		'</div>' +
		'</div>';

		$('#contactPersonDiv').append(html); 
		document.getElementById('NumberOfContact').value = NumberOfContact;
	}     

	function minusContactPerson(index) {  

		var element = document.getElementsByClassName('contactPersonClass');
		if(element.length <= 1) {
			return false;
		}
		try{
			$('#rowContactPersonDiv' + index).remove();
		} catch(e) {
			console.log(e);
		}
	}


	$( document ).ready(function() {

		$(document).on('touchstart click', '#modifyClientBtn', function(event){
			
			var partyName = document.getElementById('partyName').value;
			var partyAlias = document.getElementById('partyAlias').value;
			var partyEmail = document.getElementById('partyEmail').value;
			var partyPhone = document.getElementById('partyPhone').value;

			var partyAddressLine1 = document.getElementById('partyAddressLine1').value;
			var partyAddressLine2 = document.getElementById('partyAddressLine2').value;
			var partyCity = document.getElementById('partyCity').value;
			var partyState = document.getElementById('partyState').value;
			var partyCountry = document.getElementById('partyCountry').value;
			var partyZip = document.getElementById('partyZip').value;

			var defaultSigningAuthority = document.getElementById('defaultSigningAuthority').value;

			var NumberOfContact = document.getElementById('NumberOfContact').value;
			NumberOfContact = parseInt(NumberOfContact);
			
			var partyAlternateEmail = document.getElementById('partyAlternateEmail').value;

			if(partyName == "" || partyAlias == "" || partyEmail == "" || partyPhone == "" || partyAddressLine1 == "" || partyAddressLine2 == "" || partyCity == "" || partyState == "" || partyCountry == "" || partyZip == "" || defaultSigningAuthority == "") {

				swal({
				  title: "Failed!",
				  text: "Please fill all the Mandatory Client Details!",
				  icon: "warning",
				});
				return false;					
			}

			if(!validateEmail(partyEmail)) {
				swal({
				  title: "Failed!",
				  text: "Please enter a valid Email!",
				  icon: "warning",
				});	
				return false;						
			}

			if(partyAlternateEmail != "" && !validateEmail(partyAlternateEmail)) {
				swal({
				  title: "Failed!",
				  text: "Please enter a valid Alternate Email!",
				  icon: "warning",
				});	
				return false;						
			}

			var i;
			var personLength = document.getElementsByClassName('contactPersonClass').length;
			var contactPersonName = document.getElementsByName("contactPersonName[]");
			var contactPersonEmail = document.getElementsByName("contactPersonEmail[]");
			var contactPersonPhone = document.getElementsByName("contactPersonPhone[]");
			var designation = document.getElementsByName("designation[]");
							
			for(i = 0; i < personLength; i++) {
				
				if(contactPersonName[i].value == "" || contactPersonEmail[i].value == "" || contactPersonPhone[i].value == "" || designation[i].value == "") {
					swal({
					  title: "Failed!",
					  text: "Please fill all the Mandatory Contact Person Details!",
					  icon: "warning",
					});
					return false;					
				}

			}	

			var bankLength = document.getElementsByClassName('rowBankDiv').length;
			var beneficiaryName = document.getElementsByName("beneficiaryName[]");
			var bankName = document.getElementsByName("bankName[]");
			var bankAddress = document.getElementsByName("bankAddress[]");
			var accountNo = document.getElementsByName("accountNo[]");
			var rtgsNeftIfsCode = document.getElementsByName("rtgsNeftIfsCode[]");
			var swiftCode = document.getElementsByName("swiftCode[]");
			var bankI;


			for(bankI = 0; bankI < bankLength; bankI++) {

				if(beneficiaryName[bankI].value == "" || bankName[bankI].value == "" || bankAddress[bankI].value == "" || accountNo[bankI].value == "" || rtgsNeftIfsCode[bankI].value == "" || swiftCode[bankI].value == "") {
					swal({
					  title: "Failed!",
					  text: "Please fill all the Mandatory Bank Details!",
					  icon: "warning",
					});
					return false;						
				}
			}


			//sending ajax after validation.

			swal({
				title: "Are you sure?",
				text: "You are about to modify this Client!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					//Send ajax here
					var form = document.getElementById("modifyClientForm");
					var formData = new FormData(form);
					var ajaxUrl = "<?php echo base_url(); ?>" + "client/modifyclient";
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

    function addBankDiv() {
        
        var bankCounter = document.getElementById('bankCounter').value;
        bankCounter = parseInt(bankCounter);
        bankCounter++;
        document.getElementById('bankCounter').value = bankCounter;
        var index = bankCounter;

		var html = '<div id="bankDetail' + index +'" class="row rowBankDiv">' + 
		'<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">' + 
		'<lable>Beneficiary Name<span class="red">*</span></lable>' + 
		'<input type="text" class="form-control" name="beneficiaryName[]">' +
		'</div>' +
		'<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">' +
		'<lable>Bank Name<span class="red">*</span></lable>' +
		'<input type="text" class="form-control" name="bankName[]">' +
		'</div>' +
		'<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">' +
		'<lable>Bank Address <span class="red">*</span></lable>' +
		'<input type="text" class="form-control" name="bankAddress[]">' +
		'</div>' +
		'<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">' +
		'<lable>Account No <span class="red">*</span></lable>' +
		'<input type="text" class="form-control" name="accountNo[]">' +
		'</div>' +
		'<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">' +
		'<lable> RTGS/NEFT/IFS Code <span class="red">*</span></lable>' +
		'<input type="text" class="form-control" name="rtgsNeftIfsCode[]">' +
		'</div>' +
		'<div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">' +
		'<lable> Swift Code<span class="red">*</span></lable>' +
		'<input type="text" class="form-control" name="swiftCode[]">' +
		'</div>' +
		'<div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">' + 
		'<button type="button" onclick="minusBankDiv(' + index + ')" class="btn btn-danger">' +
		'Remove' + 
		'</button>'
		'</div>'
		'</div>'; 

        $('#bankDiv').append(html);
    }

    function minusBankDiv(bankCounter) {

		var element = document.getElementsByClassName('rowBankDiv');
		if(element.length <= 1) {
			return false;
		}
        
        $('#bankDetail' + bankCounter).remove();
    } 			
</script>