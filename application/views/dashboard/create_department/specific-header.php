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
						<h3 class="mb-3">Create Departments</h3>
						<div class="row">
							<form id="createDepartmentForm">
								
							</form>
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