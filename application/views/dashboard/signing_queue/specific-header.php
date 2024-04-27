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
</style>

</head>
<body>

<!-- The Modal -->
<div class="modal" id="viewAgreementModal">
  <div class="modal-dialog" style="max-width: 10in;">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">View Agreement</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div id="viewAgreementModalBody" class="modal-body">
        
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
						<h3 class="mb-4">Signing Queue</h3>
						<table id="viewUsertable" class="display">
						    <thead>
						        <tr>
						        	<th>Task Id</th>
						        	<th>First Party</th>
						        	<th>Second Party</th>
						        	<th>Template Name</th>
						            <th>Template Status</th>
						            <th>Actions</th>
						        </tr>
						    </thead>
						    <tbody>
						        <?php foreach ($allMyTemplates as $key => $value) { ?>
						        <tr>
						        	<td><?php echo $value['id']; ?></td>
<td>
						        		<?php
						        		$partyNameJson = $value['companyName'];
						        		$partyNameArray = json_decode($partyNameJson, TRUE);
						        		$tempName = !empty($partyNameArray[0]) ? $partyNameArray[0] : "NA";
						        		if(strlen($tempName) > 15) {
						        			echo '<span title="' . $tempName . '">' . substr($tempName, 0, 15) . '...</span>';
						        		} else {
						        			echo $tempName;
						        		} 
						        		?>
						        		
						        	</td>
						        	<td>
						        		<?php
						        		$tempName = !empty($partyNameArray[1]) ? $partyNameArray[1] : "NA"; 
						        		
						        		if(strlen($tempName) > 15) {
						        			echo '<span title="' . $tempName . '">' . substr($tempName, 0, 15) . '...</span>';
						        		} else {
						        			echo $tempName;
						        		} 
						        		?>
						        		
						        	</td>
						        	<td><?php echo $value['templateName']; ?></td>
						            <td><?php echo $value['status']; ?></td>
						            <td>
						            <a href="<?php echo base_url() . 'template/edittemplate/' . $value['id']; ?>"><button class="btn btn-warning" title="Edit Agreement"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>						            	
						            <a href="<?php echo base_url() . 'assets/created-templates/' . $value['fileName']; ?>" target="_blank" download><button class="btn btn-primary" title="View Template"><i class="fa fa-download" aria-hidden="true"></i></button></a>
									
									<button data-file="<?php echo $value['fileName']; ?>" class="btn btn-info viewTemplate" title="View Template"><i class="fa fa-eye" aria-hidden="true"></i></button>
						            
						            <?php if($value['status'] == 'Draft') { ?>	
						            
						            &nbsp;<button data-id="<?php echo $value['id']; ?>" class="btn btn-warning sendAgreement" title="Send Agreement">
						            <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
						            
						            <?php } ?>	
									
									<button data-file="<?php echo $value['fileName']; ?>" type="button" class="btn btn-danger resetAgreement"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
						            </td>
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
        $(document).on('touchstart click', '.viewTemplate ', function(event){
        	document.getElementById('viewAgreementModalBody').innerHTML = '';
        	var filename = $(this).data('file');

        	var html = '<iframe frameborder="0" width="100%" height="450px" src="https://view.officeapps.live.com/op/embed.aspx?src=' + 
        			   '<?php echo base_url(); ?>assets/created-templates/' + 
        			    filename  + '"></iframe>';

        	document.getElementById('viewAgreementModalBody').innerHTML = html;
        	$('#viewAgreementModal').modal('show');
        });


		$(document).on('touchstart click', '.sendAgreement', function(event) {
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

				var ajaxUrl = base_url + "template/changeStatusTemplate";

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

		            			swal({
								  title: "Success!",
								  text: 'Template Sent to Signing Queue',
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
</script>