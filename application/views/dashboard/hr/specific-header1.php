<style>
.allOptions{
	min-height: 100px;
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
	line-height: 100px; 
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

.margintopminus {
    margin-top: -140px;
}

.navImage {
	display: none;
}

.custom-navbar h3 {
    display: none;
}

@media only screen 
and (min-device-width : 768px) 
and (max-device-width : 1024px) 
and (orientation : portrait){
	.contentSectionInner {
	    padding-right: 33px!important;
	}	
}

/*for ipad landscape*/
@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : landscape) {
	.contentSectionInner {
	    padding-right: 33px!important;
	}	
}

/* Ipad Pro Landscape */
@media only screen 
  and (min-width: 1024px) 
  and (max-height: 1366px) 
  and (orientation: landscape) 
  and (-webkit-min-device-pixel-ratio: 1.5) {
	.contentSectionInner {
	    padding-right: 42px!important;
	}
}


/* Ipad Pro Portrait */
@media only screen 
  and (min-width: 1024px) 
  and (max-height: 1366px) 
  and (orientation: portrait) 
  and (-webkit-min-device-pixel-ratio: 1.5) {
		
}

/* New Code */
</style>

</head>
<body>
	<div class="row">
		<div class="custom-navbar col-lg-2 col-md-3 col-sm-12 col-xs-12">
			<?php $this->load->view('includes/nav1'); ?>
		</div>
		<div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
			<div class="row">
				<div class="topHeader pull-right col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php $this->load->view('includes/top-header-section1'); ?>
				</div>
				<div class="contentSectionInner contentSection w-100 pl-4 pr-3">
					<?php echo form_open('user_auth/save'); ?>
					<div class="row">
						<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 mb-4">
							<label>SMTP Host</label>
							<input type="text" class="form-control" name="smtp_host" value="<?php echo $emailDetails['smtp_host']; ?>" required>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 mb-4">
							<label>SMTP User/Email</label>
							<input type="text" class="form-control" name="smtp_user" value="<?php echo $emailDetails['smtp_user']; ?>" required>
						</div>
					</div>					

					<div class="row">
						<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 mb-4">
							<label>SMTP Password</label>
							<input type="password" class="form-control" name="smtp_password" value="<?php echo $emailDetails['smtp_pass']; ?>" required>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 mb-4">
							<label>SMTP Port</label>
							<input type="text" name="smtp_port" class="form-control" value="<?php echo $emailDetails['smtp_port']; ?>" required>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 mb-4">
							<input type="submit" class="btn btn-primary" name="" value="Save">
						</div>
					</div>
				</form>
				<?php if(!empty($this->session->saveEmailMessage)) { ?>
					<div id="dangerDiv" class="alert alert-danger" role="alert">
					<?php 
						echo $this->session->saveEmailMessage;
						$this->session->unset_userdata('saveEmailMessage');
					?>
					</div>
				<?php } ?>
				</div>
				<div class="contentSectionFooterInner w-100">
					<h3>© COPYRIGHT 2020 Auditor Finance ALL RIGHTS RESERVED</h3>
				</div>
			</div>
		</div>
	</div>