<script>
    $( document ).ready(function() {

	    $('#viewUsertable').DataTable({
        	"order": [[ 1, "asc" ], [ 9, "asc" ]]
    	} );
	    $('#vetterDiv').hide();
	    $('#creatorDiv').hide();
	    $('#signatoryDiv').hide();
	    $('#finalDiv').hide();
	    $('#statusDiv').hide();
	    $('#toggleNotesDiv').hide();
	    $('#clientTo').hide();
	    $('#ProgramLeadDiv').hide();
	    $('#CompletedDiv').hide();

        $(document).on('touchstart click', '.viewTemplate ', function(event){
        	document.getElementById('viewAgreementModalBody').innerHTML = '';
        	var filename = $(this).data('file');

        	var html = '<iframe frameborder="0" width="100%" height="450px" src="https://view.officeapps.live.com/op/embed.aspx?src=' + 
        			   '<?php echo base_url(); ?>assets/created-templates/' + 
        			    filename  + '"></iframe>';

        	document.getElementById('viewAgreementModalBody').innerHTML = html;
        	$('#viewAgreementModal').modal('show');
        });

		$(document).on('touchstart click', '.sendEmailToClient', function(event) {

				var id = $(this).data('id');

				if(id == "") {
					swal({
					  title: "Failed!",
					  text: "Please Refresh this page!",
					  icon: "warning",
					});	
					return false;					
				}

				var ajaxUrl = "<?php echo base_url(); ?>" + "user/fetchvetter";

				$.ajax({
				    url: ajaxUrl,
				    data: {
				    	id: id
				    },
				    type: 'POST',
				    success : function(data){
				    	var obj = JSON.parse(data);
		            	try {
		            		if(obj.code == 1) {
								document.getElementById('hiddenClientTaskId').value = id;
								document.getElementById('clientETo').value = obj.companyEmail;
								document.getElementById('sendEmailTemplateCode').value = obj.templateCode;
								$('#sendEmailToClientModal').modal('show');
			            	} else {
								console.log(obj);
			            	} 
			            } catch (e) {
			            	console.log(obj);
			            }
		            }
				});








			});
			
		$(document).on('touchstart click', '.sendAgreement', function(event) {

				$('#previousNotesText').text = "";
				
				var base_url = "<?php echo base_url(); ?>";
				var id = $(this).data('id');

				if(id == "") {
					swal({
					  title: "Failed!",
					  text: "Please Refresh this page!",
					  icon: "warning",
					});	
					return false;					
				}

				var ajaxUrl = base_url + "user/fetchvetter";

				$.ajax({
				    url: ajaxUrl,
				    data: {
				    	id: id
				    },
				    type: 'POST',
				    success : function(data){

				    	var obj = JSON.parse(data);
		            	try {
		            		if(obj.code == 1) {

		            			var vetterEmail = obj.toEmail;
		            			var vIndex;
		            			var vetterOptions = "";
		            			for(vIndex = 0; vIndex < vetterEmail.length; vIndex++) {
									vetterOptions += '<option value="' + vetterEmail[vIndex].email + '">' + vetterEmail[vIndex].email + ' (' + vetterEmail[vIndex].name + ')</option>';
								}
								document.getElementById('toEmail').innerHTML = vetterOptions;

								var programLead = obj.programLead;
								var plIndex;
		            			var programLeadOptions = "";
		            			for(plIndex = 0; plIndex < programLead.length; plIndex++) {
									programLeadOptions += '<option value="' + programLead[plIndex].email + '">' + programLead[plIndex].email + ' (' + programLead[plIndex].name + ')</option>';
								}

								document.getElementById('toPLEmail').innerHTML = programLeadOptions;								
								document.getElementById('hiddenTaskId').value = id;
								document.getElementById('previousNotesTextarea').innerHTML = obj.note;
								var creator = obj.creator;
								var creatorIndex;
								var options = "";
								for(creatorIndex = 0; creatorIndex < creator.length; creatorIndex++) {
									if(obj.createdBy == creator[creatorIndex].id) {
										options += '<option value="' + creator[creatorIndex].email + '" selected>' + creator[creatorIndex].email + ' (' + creator[creatorIndex].name + ')</option>';
									} else {
										options += '<option value="' + creator[creatorIndex].email + '">' + creator[creatorIndex].email + ' (' + creator[creatorIndex].name + ')</option>';			
									}
								}	
								document.getElementById('creatorTo').innerHTML = options;

								var signatory = obj.signatory;
								var signatoryIndex;
								var signatoryOptions = "";

								for(signatoryIndex = 0; signatoryIndex < signatory.length; signatoryIndex++) {
									signatoryOptions += '<option value="' + signatory[signatoryIndex].email + '">' + signatory[signatoryIndex].email + ' (' + signatory[signatoryIndex].name + ')</option>';
								}

								document.getElementById('signatoryTo').innerHTML = signatoryOptions;

								document.getElementById('fetchedTemplateCode').value = obj.templateCode;

								document.getElementById('completedTo').value = obj.companyEmail;
								
								$('#sendContractModal').modal('show');
			            	} else {
								console.log(obj);
			            	} 
			            } catch (e) {
			            	console.log(obj);
			            }
		            }
				});	
			});


//

			$(document).on('touchstart click', '#sendEmailToClientBtn', function(event) {
				var ajaxUrl = "<?php echo base_url(); ?>" + "template/sendemailtoclient";

				var id = document.getElementById('hiddenClientTaskId').value;
				var clientETo = document.getElementById('clientETo').value;
				var clientECC = document.getElementById('clientECC').value;
				var clientEBCC = document.getElementById('clientEBCC').value;

				if(clientETo.indexOf(";") != -1 || clientECC.indexOf(";") != -1 || clientEBCC.indexOf(";") != -1) {
					swal({
					  title: "Failed!",
					  text: "Separate Email with comma and space",
					  icon: "warning",
					});	
					return false;
				}

				if(id == "" || clientETo == "") {
					swal({
					  title: "Failed!",
					  text: "Please fill mandatory Information!",
					  icon: "warning",
					});	
					return false;					
				}
				
				/////////////////Ajax
				swal({
					title: "Are you sure?",
					text: "You are about to send email to client.",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						//Send ajax here
						var form = document.getElementById("sendEmailToClientForm");
	                    var formData = new FormData(form);	

						$.ajax({
						    url: ajaxUrl,
						    data: formData,
						    type: 'POST',
							contentType: false,
				            cache: false,
				            processData:false,
						    success : function(data){
				            	try {
					            	var obj = JSON.parse(data);
					            	if(obj.code == 1) {
										swal({
										  title: "Success!",
										  text: "Email Sent To Client",
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


			$(document).on('touchstart click', '.sendContractBtn', function(event) {
				var ajaxUrl = "<?php echo base_url(); ?>" + "template/sendtovetter";

				var queueName = document.getElementById('queueName').value;
				var statusName = document.getElementById('statusName').value;
				var jsonData;
				var hiddenTaskId = document.getElementById('hiddenTaskId').value;
				var hiddentTemplateCode = document.getElementById('fetchedTemplateCode').value;

				if(queueName == "") {
					
					swal({
						  title: "Failed!",
						  text: "Please Fill Mandatory Details",
						  icon: "warning",
						});	
					return false;

				} else if(queueName == 'Completed') {
					
					var toEmail = document.getElementById('completedTo').value;
					var ccEmail = document.getElementById('completedCC').value; 
					var bccEmail = document.getElementById('completedBCC').value; 
					var filename = document.getElementById('completedFinalFile').value;
					var emailNotes = document.getElementById('completedEmailNotes').value;

					if(toEmail.indexOf(";") != -1 || ccEmail.indexOf(";") != -1 || bccEmail.indexOf(";") != -1) {

						swal({
						  title: "Failed!",
						  text: "Separate Email with comma and space",
						  icon: "warning",
						});	
						return false;

					}

					if(emailNotes == "" || hiddenTaskId == "" || statusName == '' || filename == "") {
						swal({
						  title: "Failed!",
						  text: "Please Fill Mandatory Details",
						  icon: "warning",
						});	
						return false;					
					}

					var allowedExtensions = /(\.pdf|\.docx)$/i;

			        if(!allowedExtensions.exec(filename)){
				        swal({
				          title: "Failed!",
				          text: "Please upload an PDF or Docx file.",
				          icon: "warning",
				        });

				        document.getElementById('completedFinalFile').value = "";
				        return false;
			        }

					var form = document.getElementById("sendContractForm");
                    var formData = new FormData(form);					 

					swal({
						title: "Are you sure?",
						text: "Please verify the details, you are uploading a final signed contract.",
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((willDelete) => {
						if (willDelete) {

		                    $.ajax({
		                        url: "<?php echo base_url(); ?>" + 'template/savecompletedsignedcontract',
		                        data: formData,
		                        type: 'POST',
								contentType: false,
					            cache: false,
					            processData:false,                        
					            success : function(data){
		                            try {
		                                var obj = JSON.parse(data);
		                                if(obj.code == 1) {
		                                    swal({
		                                      title: "Success!",
		                                      text: "Final Contract Uploaded",
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
		                                      text: 'Error Occured!',
		                                      icon: "warning",
		                                    });
		                                }
		                            } catch (e) {
		                                console.log(e);
		                                swal({
		                                  title: "Failed!",
		                                  text: 'Error Occured!',
		                                  icon: "warning",
		                                });                                    
		                            }
		                        }
		                    });
	                	}
                	});
					///////////// Ajax
				} else if(queueName == 'VetterQueue') {
					
					var toEmail = document.getElementById('toEmail').value;
					var ccEmail = document.getElementById('ccEmail').value; 
					var emailNotes = document.getElementById('emailNotes').value;

					if(toEmail.indexOf(";") != -1 || ccEmail.indexOf(";") != -1) {

						swal({
						  title: "Failed!",
						  text: "Separate Email with comma and space",
						  icon: "warning",
						});	
						return false;

					}

					if(toEmail == "" || emailNotes == "" || hiddenTaskId == "" || statusName == '') {
						swal({
						  title: "Failed!",
						  text: "Please Fill Mandatory Details",
						  icon: "warning",
						});	
						return false;					
					}

					jsonData = {
						queueName: queueName,
						statusName: statusName,
						to: toEmail,
						cc: ccEmail,
						note: emailNotes,
						taskId: hiddenTaskId,
						templateCode: hiddentTemplateCode
					};

					/////////////////Ajax
					swal({
						title: "Are you sure?",
						text: "You are about to send the contract to " + queueName,
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((willDelete) => {
						if (willDelete) {
							//Send ajax here
							
							$.ajax({
							    url: ajaxUrl,
							    data: jsonData,
							    type: 'POST',
							    success : function(data){
					            	try {
						            	var obj = JSON.parse(data);
						            	if(obj.code == 1) {
											swal({
											  title: "Success!",
											  text: "Contract Sent",
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
					///////////// Ajax

				} else if(queueName == 'ProgramLeadQueue') {
					
					var toEmail = document.getElementById('toPLEmail').value;
					var ccEmail = document.getElementById('ccPLEmail').value; 
					var emailNotes = document.getElementById('emailPLNotes').value;

					if(toEmail.indexOf(";") != -1 || ccEmail.indexOf(";") != -1) {

						swal({
						  title: "Failed!",
						  text: "Separate Email with comma and space",
						  icon: "warning",
						});	
						return false;

					}

					if(toEmail == "" || emailNotes == "" || hiddenTaskId == "" || statusName == '') {
						swal({
						  title: "Failed!",
						  text: "Please Fill Mandatory Details",
						  icon: "warning",
						});	
						return false;					
					}

					jsonData = {
						queueName: queueName,
						statusName: statusName,
						to: toEmail,
						cc: ccEmail,
						note: emailNotes,
						taskId: hiddenTaskId,
						templateCode: hiddentTemplateCode
					};

					/////////////////Ajax
					swal({
						title: "Are you sure?",
						text: "You are about to send the contract to " + queueName,
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((willDelete) => {
						if (willDelete) {
							//Send ajax here
							
							$.ajax({
							    url: ajaxUrl,
							    data: jsonData,
							    type: 'POST',
							    success : function(data){
					            	try {
						            	var obj = JSON.parse(data);
						            	if(obj.code == 1) {
											swal({
											  title: "Success!",
											  text: "Contract Sent",
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
					///////////// Ajax

				} else if(queueName == 'CreateQueue') {
					var creatorTo = document.getElementById('creatorTo').value;
					var creatorCC = document.getElementById('creatorCC').value;
					var creatorNotes = document.getElementById('creatorNotes').value;

					if(creatorTo.indexOf(";") != -1 || creatorCC.indexOf(";") != -1) {

						swal({
						  title: "Failed!",
						  text: "Separate Email with comma and space",
						  icon: "warning",
						});	
						return false;

					}

					if(creatorTo == "" || creatorNotes == "" || hiddenTaskId == "" || statusName == '') {
						swal({
						  title: "Failed!",
						  text: "Please Fill Mandatory Details",
						  icon: "warning",
						});	
						return false;					
					}

					jsonData = {
						queueName: queueName,
						statusName: statusName,
						to: creatorTo,
						cc: creatorCC,
						note: creatorNotes,
						taskId: hiddenTaskId,
						templateCode: hiddentTemplateCode
					};					

					/////////////////Ajax
					swal({
						title: "Are you sure?",
						text: "You are about to send the contract to " + queueName,
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((willDelete) => {
						if (willDelete) {
							//Send ajax here
							
							$.ajax({
							    url: ajaxUrl,
							    data: jsonData,
							    type: 'POST',
							    success : function(data){
					            	try {
						            	var obj = JSON.parse(data);
						            	if(obj.code == 1) {
											swal({
											  title: "Success!",
											  text: "Contract Sent",
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
					///////////// Ajax



				} else if(queueName == 'SigningQueue') {
					
					var signatoryTo = document.getElementById('signatoryTo').value;
					var signatoryCC = document.getElementById('signatoryCC').value;
					var signatoryNotes = document.getElementById('signatoryNotes').value;

					if(signatoryTo.indexOf(";") != -1 || signatoryCC.indexOf(";") != -1) {

						swal({
						  title: "Failed!",
						  text: "Separate Email with comma and space",
						  icon: "warning",
						});	
						return false;

					}
					
					if(signatoryTo == "" || signatoryNotes == "" || hiddenTaskId == "" || statusName == '') {
						swal({
						  title: "Failed!",
						  text: "Please Fill Mandatory Details",
						  icon: "warning",
						});	
						return false;					
					}

					jsonData = {
						queueName: queueName,
						statusName: statusName,
						to: signatoryTo,
						cc: signatoryCC,
						note: signatoryNotes,
						taskId: hiddenTaskId,
						templateCode: hiddentTemplateCode
					};

					/////////////////Ajax
					swal({
						title: "Are you sure?",
						text: "You are about to send the contract to " + queueName,
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((willDelete) => {
						if (willDelete) {
							//Send ajax here
							
							$.ajax({
							    url: ajaxUrl,
							    data: jsonData,
							    type: 'POST',
							    success : function(data){
					            	try {
						            	var obj = JSON.parse(data);
						            	if(obj.code == 1) {
											swal({
											  title: "Success!",
											  text: 'Contract Sent',
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
					///////////// Ajax

				} else if(queueName == 'FinalQueue') {

					var ajaxUrl = "<?php echo base_url(); ?>" + "template/savefinalcontract";
					var finalFile = document.getElementById('finalFile').value;
					var finalNotes = document.getElementById('finalNotes').value;
											
					if(finalFile == "" || finalNotes == "") {
						swal({
						  title: "Failed!",
						  text: 'Please Enter Mandatory Fields!',
						  icon: "warning",
						});
						return false;
					}

					var form = document.getElementById("sendContractForm");
                    var formData = new FormData(form);					 

					swal({
						title: "Are you sure?",
						text: "You are about to upload a file.",
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((willDelete) => {
						if (willDelete) {

		                    $.ajax({
		                        url: ajaxUrl,
		                        data: formData,
		                        type: 'POST',
								contentType: false,
					            cache: false,
					            processData:false,                        
					            success : function(data){
		                            try {
		                                var obj = JSON.parse(data);
		                                if(obj.code == 1) {
		                                    swal({
		                                      title: "Success!",
		                                      text: "Document Uploaded",
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
		                                      text: 'Error Occured!',
		                                      icon: "warning",
		                                    });
		                                }
		                            } catch (e) {
		                                console.log(e);
		                                swal({
		                                  title: "Failed!",
		                                  text: 'Error Occured!',
		                                  icon: "warning",
		                                });                                    
		                            }
		                        }
		                    });
	                	}
                	});			 
				}
			});		


		$(document).on('touchstart click', '.resetAgreement', function(event) {
				var base_url = "<?php echo base_url(); ?>";
				var oldFileName = $(this).data('file');

				if(oldFileName == "") {
					swal({
					  title: "Failed!",
					  text: "Please Regenerate the Agreement!",
					  icon: "warning",
					});	
					return false;					
				}

				var ajaxUrl = base_url + "template/deletetemplate";

				$.ajax({
				    url: ajaxUrl,
				    data: {
				    	oldFileName: oldFileName
				    },
				    type: 'POST',
				    success : function(data){
				    	var obj = JSON.parse(data);
		            	try {
		            		if(obj.code == 1) {

		            			swal({
								  title: "Success!",
								  text: 'Template Deleted Successfully',
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
			            } catch (e) {
			            	console.log(e);
			            }
		            }
				});	
			});

    });  

	function changeQueue() {

		var queueName = document.getElementById('queueName').value;
		var html = "";
		var pageName = "<?php echo $sentQueueName; ?>";

		if(queueName == "") {

			$('#signatoryDiv').hide();
			$('#finalDiv').hide();
			$('#CompletedDiv').hide();
			$('#creatorDiv').hide();
			$('#ProgramLeadDiv').hide();
			$('#vetterDiv').hide();

		} else if(queueName == 'VetterQueue') {

			$('#signatoryDiv').hide();
			$('#finalDiv').hide();
			$('#CompletedDiv').hide();
			$('#creatorDiv').hide();
			$('#ProgramLeadDiv').hide();
			$('#vetterDiv').show();

			html += '<option value="Sent to Vetter">Sent to Vetter</option>'; 
			
			document.getElementById('statusName').innerHTML = html;
			$('#statusDiv').show();

		} else if(queueName == 'ProgramLeadQueue') {

			$('#vetterDiv').hide();
			$('#signatoryDiv').hide();
			$('#finalDiv').hide();
			$('#CompletedDiv').hide();
			$('#creatorDiv').hide();
			$('#ProgramLeadDiv').show();

			html += '<option value="Sent to Program Leads">Sent to Program Leads</option>'; 
			
			document.getElementById('statusName').innerHTML = html;
			$('#statusDiv').show();

		} else if(queueName == 'CreateQueue') {

			$('#vetterDiv').hide();
			$('#signatoryDiv').hide();
			$('#ProgramLeadDiv').hide();
			$('#finalDiv').hide();
			$('#CompletedDiv').hide();
			$('#creatorDiv').show();

			if(pageName == "Vetter Queue") {
				
				html += '<option value="Send to Creator">Sent to Creator</option>' + 
				'<option value="Approved By Signatory">Approved By Signatory</option>' +
				'<option value="Rejected By Signatory">Rejected By Signatory</option>' +
				'<option value="Approved By Program Lead">Approved By Program Lead</option>' +
				'<option value="Rejected By Program Lead">Rejected By Program Lead</option>' + 
				'<option value="Approved By Vetter" selected>Approved By Vetter</option>' +
			    '<option value="Rejected By Vetter">Rejected By Vetter</option>';			
			} else if(pageName == "Signing Queue") {

				html += '<option value="Send to Creator">Sent to Creator</option>' + 
				'<option value="Approved By Signatory" selected>Approved By Signatory</option>' +
				'<option value="Rejected By Signatory">Rejected By Signatory</option>' +
				'<option value="Approved By Program Lead">Approved By Program Lead</option>' +
				'<option value="Rejected By Program Lead">Rejected By Program Lead</option>' + 
				'<option value="Approved By Vetter">Approved By Vetter</option>' +
			    '<option value="Rejected By Vetter">Rejected By Vetter</option>';
			
			} else if(pageName == "Program Lead Queue") {

				html += '<option value="Send to Creator">Sent to Creator</option>' + 
				'<option value="Approved By Signatory">Approved By Signatory</option>' +
				'<option value="Rejected By Signatory">Rejected By Signatory</option>' +
				'<option value="Approved By Program Lead" selected>Approved By Program Lead</option>' +
				'<option value="Rejected By Program Lead">Rejected By Program Lead</option>' + 
				'<option value="Approved By Vetter">Approved By Vetter</option>' +
			    '<option value="Rejected By Vetter">Rejected By Vetter</option>';
			} else {

				html += '<option value="Send to Creator" selected>Sent to Creator</option>' + 
				'<option value="Approved By Signatory">Approved By Signatory</option>' +
				'<option value="Rejected By Signatory">Rejected By Signatory</option>' +
				'<option value="Approved By Program Lead">Approved By Program Lead</option>' +
				'<option value="Rejected By Program Lead">Rejected By Program Lead</option>' + 
				'<option value="Approved By Vetter">Approved By Vetter</option>' +
			    '<option value="Rejected By Vetter">Rejected By Vetter</option>';

			}
			document.getElementById('statusName').innerHTML = html;
			$('#statusDiv').show();

		} else if(queueName == 'SigningQueue') {

			$('#vetterDiv').hide();
			$('#creatorDiv').hide();
			$('#ProgramLeadDiv').hide();
			$('#finalDiv').hide();
			$('#CompletedDiv').hide();
			$('#signatoryDiv').show();

			html += '<option value="Send to Signatory">Sent to Signatory</option>'; 
			
			document.getElementById('statusName').innerHTML = html;			
			$('#statusDiv').show();

		} else if(queueName == 'Completed') {

			$('#vetterDiv').hide();
			$('#creatorDiv').hide();
			$('#signatoryDiv').hide();
			$('#ProgramLeadDiv').hide();
			$('#finalDiv').hide();
			$('#CompletedDiv').show();

			html += '<option value="Completed">Completed</option>'; 
			
			document.getElementById('statusName').innerHTML = html;			
			$('#statusDiv').show();

		} else {
			$('#CompletedDiv').hide();
			$('#vetterDiv').hide();
			$('#creatorDiv').hide();
			$('#signatoryDiv').hide();
			$('#ProgramLeadDiv').hide();
			$('#finalDiv').show();
			
			html += '<option value="Document Uploaded">Document Uploaded</option>'; 
			
			document.getElementById('statusName').innerHTML = html;			
			$('#statusDiv').show();
		}
	}

	function toggleNotesFunc() {
		$('#toggleNotesDiv').toggle();
	}

</script>