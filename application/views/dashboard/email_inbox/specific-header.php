<style>
 
#emails-inbox-table th, #emails-inbox-table td {
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
</style>

</head>
<body>
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

						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<a href="<?php echo base_url() ?>dashboard/refresh_email"><button class="btn btn-warning">Refresh Emails</button></a>
							</div>
							<div class="mt-4 col-lg-12 col-md-12 col-sm-12 col-xs-12">

								<table id="emails-inbox-table" class="display">
								    <thead>
								        <tr>
								            <th>Receive Date</th>
								            <th>Serial No</th>
								            <th>From</th>
								            <th>Subject</th>
								            <th>EML File</th>
								            <th><i class="fa fa-download" aria-hidden="true"></i>&nbsp;Status</th>
								            <th><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;Status</th>
								            <th>Actions</th>
								        </tr>
								    </thead>
								    <tbody>
								    	<?php foreach($emailData as $key => $value) { 
								    		$date = date("Y-m-d H:i:s", $value['unixTimeStamp']);
								    	?>

								        <tr>
								            <td><?php echo $date; ?></td>
								            <td><?php echo $value['id']; ?></td>
								            <td><?php echo $value['fromEmail']; ?></td>
								            <td><?php echo $value['subject']; ?></td>
								            <td><a href="<?php echo base_url(); ?>assets/email-attachments/<?php echo $value['attachment']; ?>"><i class="fa fa-download" aria-hidden="true"></i></a></td>
								            <td> 
								            <?php 
								            if($value['attachmentStatus']) { 
								            	echo "<span class='spanOk'>OK</span>";
								            } else {
								            	echo "<span class='spanFailed'>Failed</span>";
								            } 
								            ?>
								            	</td>
								            <td><?php 
								            if($value['status'] == 'New') { 
								            	echo "<span class='spanOk'>" . $value['status'] . '</span>'; 
								            	} else {
								            		echo $value['status'];
								            	}
								            	?></td>
								            <td>
								            	<button data-file="<?php echo $value['attachment']; ?>" class="viewEmailByFile mb-1 tableBtn btn btn-primary">View Email</button>
								            	<button class="mb-1 tableBtn btn-info">Email History</button>
								            	<button class="mb-1 tableBtn btn-success">Link To Task</button>
								            </td>								            	
								        </tr>
								    	<?php } ?>
								    </tbody>
								</table>

							</div>
						</div>
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
    $('#emails-inbox-table').DataTable();
} );
</script>


<script>
    $( document ).ready(function() {
        $(document).on('touchstart click', '.viewEmailByFile ', function(event){
        	var filename = $(this).data('file');
            
            if(filename == "") {
	            swal({
	              title: "Failed!",
	              text: "File Doesn't Exist!",
	              icon: "warning",
	            });
	            return false;
	        }

            //Sending Ajax
            $.ajax({
                url: '<?php echo base_url() ?>' + 'ajaxcontroller/fetchemail',
                data: {
                	filename: filename
                },
                type: 'POST',
                success : function(result){
                    console.log(result);

                }
            });

        });
    });  
</script>