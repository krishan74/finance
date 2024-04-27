<?php $roles = $this->session->UserRole; ?>

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
			<?php $this->load->view('includes/nav'); ?>
		</div>
		<div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
			<div class="row">
				<div class="topHeader pull-right col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php $this->load->view('includes/top-header-section'); ?>
				</div>
				<div class="contentSectionInner contentSection w-100 pl-4 pr-3">
					<div class="row">

    					<?php if (in_array("VetterAccess", $roles) || in_array("ContractAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>

						<div class="allOptionsTop col-lg-3 col-md-4 col-xs-12 col-sm-12">
							<a href="<?php echo base_url(); ?>template/completequeue">
								<div class="allOptions w-100">
									<h3>Final Contracts</h3>
								</div>
							</a>
						</div>
						<?php } ?>


						<?php if (in_array("VetterAccess", $roles) || in_array("ContractAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>

						<div class="allOptionsTop col-lg-3 col-md-4 col-xs-12 col-sm-12">
							<a href="<?php echo base_url(); ?>template/alltaskqueue">
								<div class="allOptions w-100">
									<h3>All Task Queue</h3>
								</div>
							</a>
						</div>
						<?php } ?>

						<?php if (in_array("SigningQueueAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>

						<div class="allOptionsTop col-lg-3 col-md-4 col-xs-12 col-sm-12">
							<a href="<?php echo base_url(); ?>template/signingqueue">
								<div class="allOptions w-100">
									<h3>Signing Queue</h3>
								</div>
							</a>
						</div>
						<?php } ?>


						<?php if (in_array("ProgramLeadAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>

						<div class="allOptionsTop col-lg-3 col-md-4 col-xs-12 col-sm-12">
							<a href="<?php echo base_url(); ?>template/programleadqueue">
								<div class="allOptions w-100">
									<h3>Program Leads Queue</h3>
								</div>
							</a>
						</div>
						<?php } ?>




						<?php
						
						if(in_array("VetterAccess", $roles) || in_array("SuperAdmin", $roles)) { 
						?>

						<div class="allOptionsTop col-lg-3 col-md-4 col-xs-12 col-sm-12">
							<a href="<?php echo base_url(); ?>template/vetterqueue">
								<div class="allOptions w-100">
									<h3>Vetter Queue</h3>
								</div>
							</a>
						</div>

						<?php } ?>

						<?php if (in_array("ContractAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>

						<div class="allOptionsTop col-lg-3 col-md-4 col-xs-12 col-sm-12">
							<a href="<?php echo base_url(); ?>template/creatorqueue">
								<div class="allOptions w-100">
									<h3>Creator Queue</h3>
								</div>
							</a>
						</div>

						<?php } ?>

						<?php if (in_array("VetterAccess", $roles) || in_array("ContractAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>

						<div class="allOptionsTop col-lg-3 col-md-4 col-xs-12 col-sm-12">
							<a href="<?php echo base_url(); ?>template/draft">
								<div class="allOptions w-100">
									<h3>My Draft</h3>
								</div>
							</a>
						</div>

						<div class="allOptionsTop col-lg-3 col-md-4 col-xs-12 col-sm-12">
							<a href="<?php echo base_url(); ?>client/manage">
								<div class="allOptions w-100">
									<h3>Manage Clients</h3>
								</div>
							</a>
						</div>

						<div class="allOptionsTop col-lg-3 col-md-4 col-xs-12 col-sm-12">
							<a href="<?php echo base_url(); ?>signingauthority/manage">
								<div class="allOptions w-100">
									<h3>Manage Signatory</h3>
								</div>
							</a>
						</div>

						<div class="allOptionsTop col-lg-3 col-md-4 col-xs-12 col-sm-12">
							<a href="<?php echo base_url(); ?>template/create">
								<div class="allOptions w-100">
									<h3>Create Contract</h3>
								</div>
							</a>
						</div>						

						<?php } ?>	

						<?php if(in_array("UserAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>

						<div class="allOptionsTop col-lg-3 col-md-4 col-xs-12 col-sm-12">
							<a href="<?php echo base_url(); ?>user/manage">
								<div class="allOptions w-100">
									<h3>Manage Users</h3>
								</div>
							</a>
						</div>

						<?php } ?>

					</div>
				</div>
				<div class="contentSectionFooterInner w-100">
					<h3>© COPYRIGHT 2020 Auditor Finance ALL RIGHTS RESERVED</h3>
				</div>
			</div>
		</div>
	</div>