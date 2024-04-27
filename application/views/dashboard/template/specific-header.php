finfo_close
<style>
.allOptions {
    min-height: 100px;
    background-color: gainsboro;
    color: #007bff;
    border-radius: 5px;
    -webkit-box-shadow: 2px 2px 5px 0px rgba(0,0,0,0.75);
    -moz-box-shadow: 2px 2px 5px 0px rgba(0,0,0,0.75);
    box-shadow: 2px 2px 5px 0px rgba(0,0,0,0.75);
    display: flex;
    align-items: center;
    justify-content: center;
    padding:20px;
}

.allOptions h3 {
    text-align: center;
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

.CountryUl li a {
    text-decoration: none;
    color: #d68c60;
}

.CountryUl li a.active {
	color: #000;
}

.CountryUl {
    margin-bottom: 30px;
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
				<div class="contentSectionInner contentSection w-100 pl-4 pr-3">




				<section>
					<!-- Nav tabs -->
					<ul class="CountryUl nav nav-tabs" role="tablist">
						<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#GlobalTab" role="tab">Global</a> </li>
						<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#IndiaTab" role="tab">India</a> </li>
						<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#PhilippinesTab" role="tab">Philippines</a> </li>
						<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#SingaporeTab" role="tab">Singapore</a> </li>
						<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#UnitedStatesTab" role="tab">United States</a> </li>						
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane active" id="GlobalTab" role="tabpanel">
							<div class="row">
								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/RFP_Form">
										<div class="allOptions w-100">
											<h3>RFP</h3>
										</div>
									</a>
								</div>

								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/ServiceOrder">
										<div class="allOptions w-100">
											<h3>Service Order</h3>
										</div>
									</a>
								</div>								
							</div>						
						</div>
						<div class="tab-pane" id="IndiaTab" role="tabpanel">

							<!-- Nav tabs -->
							<ul class="CountryUl nav nav-tabs" role="tablist">
								<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#AffordableTab" role="tab">Affordable</a> </li>
								<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#AHITab" role="tab">AHI</a> </li>
								<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#QualityTab" role="tab">Quality</a> </li>
							</ul>	

							<div class="tab-content">
								<div class="tab-pane active" id="AffordableTab" role="tabpanel">
									<div class="row">
										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AQH_Consultant_Contract">
												<div class="allOptions w-100">
													<h3>AQH Consultant Contract</h3>
												</div>
											</a>
										</div>		
										<div class="row">
										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AQH_Consultant_Contract">
												<div class="allOptions w-100">
													<h3>AQH Consultant MyContract</h3>
												</div>
											</a>
										</div>	

										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AQH_Intern_Letter_Non_Financial">
												<div class="allOptions w-100">
													<h3>AQH - Intern Letter Non Financial</h3>
												</div>
											</a>
										</div>													

										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AQH_Service_Contract">
												<div class="allOptions w-100">
													<h3>AQH - Service Contract</h3>
												</div>
											</a>
										</div>	

										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AQH_Contract_Extension_Letter">
												<div class="allOptions w-100">
													<h3>AQH - Contract Extension Letter</h3>
												</div>
											</a>
										</div>	


										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AQH_Offer_Letter">
												<div class="allOptions w-100">
													<h3>AQH Offer Letter</h3>
												</div>
											</a>
										</div>	

									</div>						
								</div>

								<div class="tab-pane" id="AHITab" role="tabpanel">
									<div class="row">


										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AH_Charity_Grant_Agreement">
												<div class="allOptions w-100">
													<h3>AH - Charity Grant Aggreement</h3>
												</div>
											</a>
										</div>



										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AH_Full_Time_Consultant_Contract">
												<div class="allOptions w-100">
													<h3>AH - Fulltime Consultant Contract</h3>
												</div>
											</a>
										</div>

										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AH_Partime_Consultant_Contract">
												<div class="allOptions w-100">
													<h3>AH - Partime Consultant Contract</h3>
												</div>
											</a>
										</div>

										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AH_Services_Contract_Vendor">
												<div class="allOptions w-100">
													<h3>AH - Services Contract For Vendor</h3>
												</div>	
											</a>
										</div>

										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AH_Sub_Service_Contract_BMGF_Grants">
												<div class="allOptions w-100">
													<h3>AH - Sub or Service Contract</h3>
												</div>
											</a>
										</div>

										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AH_Sub_Contract_MultipleParty">
												<div class="allOptions w-100">
													<h3>AH - Sub Contract Multiple Party</h3>
												</div>
											</a>
										</div>


										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AH_Contract_Extension_Letter">
												<div class="allOptions w-100">
													<h3>AH - Contract Extension Letter</h3>
												</div>
											</a>
										</div>

										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AH_Offer_Letter">
												<div class="allOptions w-100">
													<h3>AH Offer Letter</h3>
												</div>
											</a>
										</div>


										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AH_Advisory_Service_Agreement">
												<div class="allOptions w-100">
													<h3>AH Advisory Service Agreement</h3>
												</div>
											</a>
										</div>


										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AH_Subcontract_No_Cost_Extension">
												<div class="allOptions w-100">
													<h3>AH Subcontract No Cost Extension</h3>
												</div>
											</a>
										</div>

										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/AH_Subcontract_Extension_Amendment">
												<div class="allOptions w-100">
													<h3>AH Subcontract Extension Amendment</h3>
												</div>
											</a>
										</div>

									</div>						
								</div>


								<div class="tab-pane" id="QualityTab" role="tabpanel">
									<div class="row">


										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/QH_Advisory_Services_Agreement_HCS">
												<div class="allOptions w-100">
													<h3>QH Advisory Services Agreement</h3>
												</div>
											</a>
										</div>

										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/QH_Centre_Excellence_Contract_Digital_Health">
												<div class="allOptions w-100">
													<h3>QH Centre Excellence Contract</h3>
												</div>
											</a>
										</div>										


										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/QH_Consultant_Contract">
												<div class="allOptions w-100">
													<h3>QH Consultant Contract</h3>
												</div>
											</a>
										</div>


										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/QH_Employment_Agreement">
												<div class="allOptions w-100">
													<h3>QH Employment Agreement</h3>
												</div>
											</a>
										</div>

 
										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/QH_Paid_Internship_Letter">
												<div class="allOptions w-100">
													<h3>QH Paid Internship Letter</h3>
												</div>
											</a>
										</div>										


										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/QH_Volunteer_LOI">
												<div class="allOptions w-100">
													<h3>QH Volunteer LOI</h3>
												</div>
											</a>
										</div>										

										<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
											<a href="<?php echo base_url(); ?>template/loadtemplate/QH_Contract_Extension_Letter">
												<div class="allOptions w-100">
													<h3>QH Contract Extension Letter</h3>
												</div>
											</a>
										</div>

									</div>						
								</div>


							</div>													

						</div>
						<div class="tab-pane" id="PhilippinesTab" role="tabpanel">
							<div class="row">
								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/AHP_Employment_Contract">
										<div class="allOptions w-100">
											<h3>AHP Employment Contract</h3>
										</div>
									</a>
								</div>	

								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/AHP_Contract_Extension_Letter">
										<div class="allOptions w-100">
											<h3>AHP Contract Extension Letter</h3>
										</div>
									</a>
								</div>	


								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/AHP_Consultant_Contract">
										<div class="allOptions w-100">
											<h3>AHP Consultant Contract</h3>
										</div>
									</a>
								</div>	
								
							</div>

							
						</div>
						<div class="tab-pane" id="SingaporeTab" role="tabpanel">
		
							<div class="row">
								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/AHS_Consultant_Contract">
										<div class="allOptions w-100">
											<h3>AHS - Consultant Contract</h3>
										</div>
									</a>
								</div>	
								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/AHS_Employment_Contract">
										<div class="allOptions w-100">
											<h3>AHS - Employment Contract</h3>
										</div>
									</a>
								</div>	

								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/AHS_Service_Contract">
										<div class="allOptions w-100">
											<h3>AHS - Service Contract</h3>
										</div>
									</a>
								</div>

								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/AHS_Services_Contract_Fintech_Health">
										<div class="allOptions w-100">
											<h3>AHS - Services Contract Fintech Health</h3>
										</div>
									</a>
								</div>
								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/AHS_Contract_Extension_Letter">
										<div class="allOptions w-100">
											<h3>AHS - Contract Extension Letter</h3>
										</div>
									</a>
								</div>

							</div>					
						</div>
						<div class="tab-pane" id="UnitedStatesTab" role="tabpanel">
							<div class="row">

								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/AHUS_Consultant_Contract">
										<div class="allOptions w-100">
											<h3>AHUS Consultant Contract</h3>
										</div>
									</a>
								</div>

								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/AHUS_Service_Contract">
										<div class="allOptions w-100">
											<h3>AHUS Service Contract</h3>
										</div>
									</a>
								</div>

								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/AHUS_Contract_Extension_Letter">
										<div class="allOptions w-100">
											<h3>AHUS Contract Extension Letter</h3>
										</div>
									</a>
								</div>

								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/AHUS_Employement_Agreement">
										<div class="allOptions w-100">
											<h3>AHUS Part Time Employement Agreement</h3>
										</div>
									</a>
								</div>

								<div class="allOptionsTop col-lg-3 col-md-6 col-xs-12 col-sm-12">
									<a href="<?php echo base_url(); ?>template/loadtemplate/AHUS_Fulltime_Employement_Agreement">
										<div class="allOptions w-100">
											<h3>AHUS Full Time Employement Agreement</h3>
										</div>
									</a>
								</div>

							</div>
						</div>
					</div>
				</section>
				</div>
				<div class="contentSectionFooterInner w-100">
					<h3>© COPYRIGHT 2020 Auditor Finance ALL RIGHTS RESERVED</h3>
				</div>
			</div>
		</div>
	</div>





