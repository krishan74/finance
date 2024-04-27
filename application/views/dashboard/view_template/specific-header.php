<?php 
$roles = $this->session->UserRole;
?>

<style>
 
#viewUsertable th, #viewUsertable td {
	text-align: center;
	vertical-align: middle;
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

.sendEmailToggle {
    font-size: 18px;
    font-weight: 500;
}

span.contractSentClass {
    color: #0c690c;
    font-weight: 600;
}

span.contractNoSentClass {
    color: #dc3545;
    font-weight: 600;
}
</style>

</head>
<body>

<!-- The Modal -->
<div class="modal" id="sendEmailToClientModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Send Email To Client with Attachment</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div id="sendEmailToClientBody" class="modal-body">
      	<?php 
      	$attributes = array('id' => 'sendEmailToClientForm');
      	echo form_open('template/sendemailtoclient', $attributes);
      	?>
      	<div id="clientDiv" class="row">
      		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label class="mt-3">To</label>
		        <input type="hidden" id="sendEmailTemplateCode" name="sendEmailTemplateCode">
		        <input type="text" id="clientETo" name="clientETo" class="form-control" value="" placeholder="Seperated By comma & space">
		    </div>
		    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label class="mt-3">CC</label>
		        <input type="text" id="clientECC" name="clientECC" class="form-control" value="" placeholder="Seperated By comma & space">
		    </div>
		    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label class="mt-3">BCC</label>
		        <input type="text" id="clientEBCC" name="clientEBCC" class="form-control" value="" placeholder="Seperated By comma & space">
		    </div>		    
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		        <label class="mt-3">Subject</label>
		        <input type="text" id="clientSubject" name="clientSubject" class="form-control" value="">
		    </div>
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		        <label class="mt-3">Email Body</label>
		        <textarea id="clientENotes" name="clientENotes" rows="6" class="form-control"></textarea>
		        <input type="hidden" name="hiddenClientTaskId" id="hiddenClientTaskId" value="">
		    </div>
		</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      	<button type="button" id="sendEmailToClientBtn" class="btn btn-success"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;Send</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    	</form>
      </div>

    </div>
  </div>
</div>



<!-- The Modal -->
<div class="modal" id="sendContractModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Send Contract <button id="toggleNotesBtn" onclick="toggleNotesFunc()" class="btn btn-warning">Toggle Previous Notes</button></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div id="sendContractModalBody" class="modal-body">
      	<?php 
      	$attributes = array('id' => 'sendContractForm');
      	echo form_open('template/savefinalcontract', $attributes);
      	?>
      	
      	<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<input type="hidden" id="taskCreatedBy">
				<input type="hidden" id="fetchedTemplateCode" name="templateCode">
		        <label>Select Queue</label>
		        <select id="queueName" name="queueName" class="form-control" onchange="changeQueue()">
		        	<option value="">Select Queue</option>
					<option value='CreateQueue'>CreateQueue</option>
					<option value='VetterQueue'>VetterQueue</option>
					<option value='ProgramLeadQueue'>ProgramLeadQueue</option>
					<option value='SigningQueue'>SigningQueue</option>
					<option value='FinalQueue'>Upload Document</option>
					<option value='Completed'>Completed</option>
		        </select>
		    </div>      		

			<div id="statusDiv" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label>Status</label>
		        <select id="statusName" name="statusName" class="form-control">
		        			        	
		        </select>
		        
		    </div>      		

      	</div>

      	

		<div id="CompletedDiv" class="row mt-3">
      		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label>To</label>
		        <input type="text" name="completedTo" id="completedTo" class="form-control" placeholder="Optional"> 
		    </div>
		    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label>CC</label>
		        <input type="text" id="completedCC" name="completedCC" class="form-control" placeholder="Seperated by comma and space." value="">
		    </div>
		    <div class="mt-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label>BCC</label>
		        <input type="text" id="completedBCC" name="completedBCC" class="form-control" placeholder="Seperated by comma and space." value="">
		    </div>
		    <div class="mt-3 col-lg-12 col-md-12 col-sm-12 col-xs-12">
		        <label>Subject</label>
		        <input type="text" id="completedSubject" name="completedSubject" class="form-control">
		    </div>
      		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
		        <label>Upload Final Signed Document (PDF or Docx) </label>
		        <input type="file" id="completedFinalFile" name="completedFinalFile" value="">
		    </div>		    
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		        <label class="mt-3">Email Message</label>
		        <textarea id="completedEmailNotes" name="completedEmailNotes" rows="6" class="form-control"></textarea>
		    </div>
		</div>

      	<div id="vetterDiv" class="row mt-3">
      		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label>To</label>
		        <select id="toEmail" name="toEmail" class="form-control">
		        </select>
		    </div>
		    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label>CC</label>
		        <input type="text" id="ccEmail" name="ccEmail" class="form-control" placeholder="Seperated by comma and space." value="">
		    </div>
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		        <label class="mt-3">Notes</label>
		        <textarea id="emailNotes" name="emailNotes" rows="6" class="form-control"></textarea>
		        <input type="hidden" name="hiddenTaskId" id="hiddenTaskId" value="">
		    </div>
		</div>

      	<div id="ProgramLeadDiv" class="row mt-3">
      		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label>To</label>
		        <select id="toPLEmail" name="toPLEmail" class="form-control">
		        </select>
		    </div>
		    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label>CC</label>
		        <input type="text" id="ccPLEmail" name="ccPLEmail" class="form-control" placeholder="Seperated by comma and space." value="">
		    </div>
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		        <label class="mt-3">Notes</label>
		        <textarea id="emailPLNotes" name="emailPLNotes" rows="6" class="form-control"></textarea>
		    </div>
		</div>

      	<div id="creatorDiv" class="row mt-3">
      		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label>To</label>
		        <select id="creatorTo" name="creatorTo" class="form-control">
		        	
		        </select>
		    </div>
		    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label>CC</label>
		        <input type="text" id="creatorCC" name="creatorCC" class="form-control" placeholder="Seperated by comma and space." value="">
		    </div>
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		        <label class="mt-3">Notes</label>
		        <textarea id="creatorNotes" name="creatorNotes" rows="6" class="form-control"></textarea>
		    </div>
		</div>

      	<div id="signatoryDiv" class="row mt-3">
      		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label>To</label>
		        <select id="signatoryTo" name="signatoryTo" class="form-control">
		        	
		        </select>
		    </div>
		    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		        <label>CC</label>
		        <input type="text" id="signatoryCC" name="signatoryCC" class="form-control" placeholder="Seperated by comma and space." value="">
		    </div>
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		        <label class="mt-3">Notes</label>
		        <textarea id="signatoryNotes" name="signatoryNotes" rows="6" class="form-control"></textarea>
		    </div>
		</div>
      	<div id="finalDiv" class="row mt-3">
      		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
		        <label class="sendEmailToggle">Upload Document</label>
		        <input type="file" id="finalFile" name="finalFile" value="">
		    </div>
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
		        <label class="mt-3">Notes</label>
		        <textarea id="finalNotes" name="finalNotes" rows="6" class="form-control"></textarea>
		    </div>		    
		</div>


      	<div class="row mt-3">
      		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      			<button type="button" class="mt-3 btn btn-success sendContractBtn"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;Send</button>
        		<button type="button" class="mt-3 btn btn-danger" data-dismiss="modal">Close</button>
		    </div>
		</div>

      	<div id="toggleNotesDiv" class="row mt-3">
      		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      			<textarea readonly class="form-control" rows="7" id="previousNotesTextarea"></textarea>
      			<button type="button" class="mt-3 btn btn-success sendContractBtn"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;Send</button>
        		<button type="button" class="mt-3 btn btn-danger" data-dismiss="modal">Close</button>
		    </div>
		</div>								
      </div>
		</form>

    </div>
  </div>
</div>

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
						<h3 class="mb-4"><?php echo $sentQueueName; ?></h3>
						<table id="viewUsertable" class="display">
						    <thead>
						        <tr>
						        	<th>Actions</th>
						        	<th>Date</th>
						        	<th class="text-left">Created By</th>
						        	<th class="text-left">First Party</th>
						        	<th class="text-left">Second Party</th>
						        	<th class="text-left">Template Name</th>
						        	<th class="text-left">Assigned To</th>
						            <th class="text-left">Contract Status</th>
						            <th class="text-left">Queue Name</th>
						            <th class="text-left">Task Id</th>
						        </tr>

						    </thead>
						    <tbody>
						        <?php foreach ($allMyTemplates as $key => $value) { ?>
						        <tr>
									<td style="white-space: nowrap;">
									<?php if ((in_array("VetterAccess", $roles) || in_array("ContractAccess", $roles) || in_array("SuperAdmin", $roles)) && $value['status'] != 'Completed') { ?>

						           	<a href="<?php echo base_url() . 'template/edittemplate/' . $value['id']; ?>"><button class="btn btn-warning btn-sm" title="Edit Contract"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>

						           <?php } ?>
						            <a href="<?php echo base_url() . 'assets/created-templates/' . $value['fileName']; ?>" target="_blank" download><button class="btn btn-primary btn-sm" title="Download Generated Contract"><i class="fa fa-download" aria-hidden="true"></i></button></a>

									<button data-file="<?php echo $value['fileName']; ?>" class="btn btn-info btn-sm viewTemplate" title="View Generated Contract"><i class="fa fa-eye" aria-hidden="true"></i></button>
						            <?php if($value['status'] != 'Completed') { ?>
									<button data-id="<?php echo $value['id']; ?>" class="btn btn-warning btn-sm sendAgreement" title="Send Contract">
						            <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
						        	<?php } ?>
									<?php if ((in_array("VetterAccess", $roles) || in_array("ContractAccess", $roles) || in_array("SuperAdmin", $roles)) && $value['status'] != 'Completed') { ?>
									
									<button data-file="<?php echo $value['fileName']; ?>" type="button" title="Delete Contract" class="btn btn-danger btn-sm resetAgreement"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
			
									<?php } ?>

									<br>
									<?php if(!empty($value['finalSignedContract'])) { ?>
						            <a href="<?php echo base_url() . 'assets/final-contract/' . $value['finalSignedContract']; ?>" target="_blank" download><button class="btn btn-success btn-sm mt-2" title="Download Attached Document"><i class="fa fa-download" aria-hidden="true"></i></button></a>
						        	
									<button data-id="<?php echo $value['id']; ?>" class="btn btn-danger btn-sm sendEmailToClient mt-2" title="Send Email with Attached Document.">
						            <i class="fa fa-paper-plane" aria-hidden="true"></i></button>						        	

						        	<?php } ?>
						            </td>						        	
						        	<td class="text-left" style="white-space: nowrap;"><?php echo $value['currentDate']; ?></td>
						        	<td class="text-left" style="white-space: nowrap;">
						        		<?php 

						        		$username = $value['cfirstName'] . " " . $value["clastName"];
						        		if(strlen($username) > 15) {
						        			echo '<span title="' . $value["cemail"] . '">' . rtrim(substr($username, 0, 15), " ") . '...</span>';
						        		} else {
						        			echo '<span title="' . $value["cemail"] . '">' . $username . '</span>';
						        		} 

						        		?></td>
						        	<td class="text-left">
						        		<?php
						        		$partyNameJson = $value['companyName'];
						        		$partyNameArray = json_decode($partyNameJson, TRUE);
						        		$tempName = !empty($partyNameArray[0]) ? $partyNameArray[0] : "NA";
						        		if(strlen($tempName) > 15) {
						        			echo '<span title="' . $tempName . '">' . rtrim(substr($tempName, 0, 15), " ") . '...</span>';
						        		} else {
						        			echo $tempName;
						        		} 
						        		?>
						        		
						        	</td>
						        	<td class="text-left">
						        		<?php
						        		$tempName = !empty($partyNameArray[1]) ? $partyNameArray[1] : "NA"; 
						        		
						        		if(strlen($tempName) > 15) {
						        			echo '<span title="' . $tempName . '">' . rtrim(substr($tempName, 0, 15), " ") . '...</span>';
						        		} else {
						        			echo $tempName;
						        		} 
						        		?>
						        		
						        	</td>
						        	
						        	<td class="text-left"><?php echo $value['templateName']; ?></td>
						            <td class="text-left" style="white-space: nowrap;">
						            	<?php 
						            	$assignedToVal = empty($value['assignedTo']) ? "" : $value['afirstName'] . " " . $value['alastName']; 
										if(strlen($assignedToVal) > 15) {
						        			echo '<span title="' . $value['aemail'] . '">' . substr($assignedToVal, 0, 15) . '...</span>';
						        		} else {
						        			echo '<span title="' . $value['aemail'] . '">' . $assignedToVal . '</span>';
						        		}						            	
						            	?></td>
						            <td><?php 
						            if($value['status'] == "Document Uploaded") {
						            	echo '<span title="Email not sent to client" class="contractNoSentClass"><i class="fas fa-exclamation-triangle"></i>&nbsp;' . $value['status'] . '</span>';
						            } else if($value['status'] == "Completed") {
						            	echo '<span class="contractSentClass"><i class="fas fa-check"></i>&nbsp;' . $value['status'] . '</span>';
						            } else if($value['status'] == "Email Sent") {
						            	echo '<span class="contractSentClass"><i class="fas fa-paper-plane"></i></i>&nbsp;' . $value['status'] . '</span>';
						            }else {
						            	echo $value['status'];
						            }
						            ?></td>
						            <td><?php echo $value['queueName']; ?></td>
						        	<td class="text-left" style="white-space: nowrap;"><?php echo $value['templateCode']; ?></td>						            
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

<?php require(FCPATH . "assets/js/view-template-js.php");