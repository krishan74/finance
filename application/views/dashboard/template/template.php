<style>

    .allOptions{
        min-height: 200px;
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
        line-height: 200px; 
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

    .createUserBtn {
        margin-top: 10px;
    }

    #sendEmailWithCredentials {
        margin-top: 65px;
    }

    .red {
        color: red;
        font-weight: 900;
        font-size: 18px;
    }

    .contentSectionInner h3 {
        margin-top: 20px;
    }

    .diffColor {
        background-color: gainsboro;
        padding-bottom: 15px;
        padding-top: 15px;
    }

    .formBtn {
        width: 110px;
        margin-right: 0px;
    }

    .hideDiv {
        display: none;
    }

    .height120 {
        height: 120px;
    }

    .displayToggleClass1, .displayToggleClass2, .displayToggleClass3, .displayToggleClass4, .displayToggleClass5, .displayToggleClass6, .displayToggleClass7, .displayToggleClass8, .displayToggleClass9, .displayToggleClass10, .displayToggleClass11, .displayToggleClass12, .displayToggleClass13, .displayToggleClass14, .displayToggleClass15, .displayToggleClass16, .displayToggleClass17, .displayToggleClass18, .displayToggleClass19, .displayToggleClass20 {
        display: none;
    }

    .rowDivCompany {
        background-color: #eadbba;
        padding-bottom: 25px;
        border-radius: 4px;
        margin-bottom: 20px;
        margin-top: 20px;
        -webkit-box-shadow: 2px 2px 4px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: 2px 2px 4px 0px rgba(0,0,0,0.75);
        box-shadow: 2px 2px 4px 0px rgba(0,0,0,0.75);
    }

    .rowDivCompany h3 {
        font-family: impact;
        font-size: 21px;
    }

    .custom-margin-top {
        margin-top: 30px!important;
    }

    .addressTextArea {
        margin-top: 98px;
    }
    .signatoryTextArea {
        margin-top: 8px;
    }

    .bankTextArea {
        margin-top: 8px;
        height: 88px!important;
    }

</style>
<script type="text/javascript" src="<?php echo base_url(); ?>externalLibrary/ckeditor/ckeditor.js"></script>
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
                        <?php
                        $attributes = array('id' => 'createTemplateForm');
                        echo form_open('template/processContactForm', $attributes);
                        ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h3>Edit Contract using 
                                    <?php
                                    $templateLabel = ucfirst($templateName);
                                    echo $templateLabel;
                                    ?></h3>
                                <input type="hidden" id="oldFileName" name="oldFileName" value="">

                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="mt-3 col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <lable>Contract Date</lable>
                                <input type="date" id="custom1" name="custom[]" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="mt-3 col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <lable>Contract Start Date w.e.f</lable>
                                <input type="date" id="custom2" name="custom[]" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>


                        <?php for($i = 0; $i < 2; $i++) { ?>
                        <!-- Company Start -->
                        <div class="row rowDivCompany">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <h3 class="mt-3">Select Party No. <?php echo $i + 1; ?></h3>
                                        <select onchange="changeCompanyById(<?php echo $i + 1; ?>)" class="form-control" id="party<?php echo $i + 1; ?>CompanyId" name="CompanyId[]">
                                            <option value="">Select Company</option>
                                            <?php
                                            foreach ($clientNameArr as $key => $value) {
                                                echo '<option value="' . $value['id'] . '">' . $value['partyName'] . " (" . $value['partyAlias'] . " )</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>


                                    <div class="custom-margin-top col-lg-4 col-md-4 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <label>Address</label>
                                    </div>
                                    <div class="custom-margin-top col-lg-8 col-md-8 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <input type="radio" onchange="changeAddressById(<?php echo $i + 1; ?>)" name="party<?php echo $i + 1; ?>AddressType" value="1" checked>
                                        <label>Primary</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" onchange="changeAddressById(<?php echo $i + 1; ?>)" name="party<?php echo $i + 1; ?>AddressType" value="2">
                                        <label>Alternate</label>
                                    </div>
                                    <div class="custom-margin-top col-lg-4 col-md-4 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <label>Select Signatory: &nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="custom-margin-top col-lg-8 col-md-8 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <select id="party<?php echo $i + 1; ?>SigningAuthorityId" name="SigningAuthorityId[]" class="form-control" onchange="signingDropdown(<?php echo $i + 1; ?>, this.value)">

                                        </select>
                                    </div>

                                    <div class="mt-5 col-lg-4 col-md-4 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <label>Bank Details</label>
                                    </div>
                                    <div class="mt-5 col-lg-8 col-md-8 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <select id="bankIndex<?php echo $i + 1; ?>" name="bankIndex[]" class="form-control" onchange="changeBankById(<?php echo $i + 1; ?>)">
                                            <option value="">Select Bank Account</option>
                                            <option value="0">Bank Account 1</option>
                                            <option value="1">Bank Account 2</option>
                                            <option value="2">Bank Account 3</option>
                                        </select>
                                    </div>







                                </div>
                            </div>


                            <div class="displayToggleClass<?php echo $i + 1; ?> col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                
                                <textarea class="form-control addressTextArea" id="party<?php echo $i + 1; ?>FullAddress" name="FullAddress[]" readonly></textarea>
                                
                                <textarea id="party<?php echo $i + 1; ?>AllSigningDetails" name="AllSigningDetails[]" class="form-control signatoryTextArea" readonly></textarea>
                                
                                <textarea id="party<?php echo $i + 1; ?>AllBankDetail" name="AllBankDetail[]" class="form-control bankTextArea" readonly></textarea>
                            </div>




                            <input type="hidden" id="party<?php echo $i + 1; ?>CompanyName" name="CompanyName[]">

                            <input type="hidden" id="party<?php echo $i + 1; ?>CompanyAlias" name="CompanyAlias[]">

                            <input type="hidden" id="party<?php echo $i + 1; ?>SigningAuthorityName" name="SigningAuthorityName[]">

                            <input type="hidden" id="party<?php echo $i + 1; ?>SigningAuthorityEmail" name="SigningAuthorityEmail[]">   

                            <input type="hidden" id="party<?php echo $i + 1; ?>SigningAuthorityPhone" name="SigningAuthorityPhone[]">   

                            <input type="hidden" id="party<?php echo $i + 1; ?>SigningAuthorityDesignation" name="SigningAuthorityDesignation[]">

                            <input type="hidden" id="party<?php echo $i + 1; ?>AddressLine1" name="AddressLine1[]">

                            <input type="hidden" id="party<?php echo $i + 1; ?>AddressLine2" name="AddressLine2[]">

                            <input type="hidden" id="party<?php echo $i + 1; ?>City" name="City[]">

                            <input type="hidden" id="party<?php echo $i + 1; ?>State" name="State[]">

                            <input type="hidden" id="party<?php echo $i + 1; ?>Country" name="Country[]">              
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>Zip" name="Zip[]">                              
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>Benficiary" name="Benficiary[]" required readonly>
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>BankName" name="BankName[]" required readonly>
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>BankAddress" name="BankAddress[]" required readonly>
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>AccoountNo" name="AccoountNo[]" required readonly>
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>RtgsNeftIfsCode" name="RtgsNeftIfsCode[]" required readonly>
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>SwiftCode" name="SwiftCode[]" required readonly>


                        </div>

                        <!-- Company Close -->
                        <?php } ?>


                        <!--Company Closes Here -->		

                        <div id="customCompanyDivs" class="w-100 mt-4">
                            <div id="appendBtn" class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 text-right">
                                    <input type="hidden" id="companyCounter" value="2">
                                    <button type="button" onclick="addCompanyDiv()" class="btn btn-info pull-right">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" onclick="minusCompanyDiv()" class="btn btn-info pull-right">
                                        <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 mt-4">
                            <label>Notice Period (Optional)</label>
                            <select id="custom3" name="custom[]" class="form-control">
                                <option value="NA">NA</option>
                                <option value="one week">One Week</option>
                                <option value="two weeks">Two Weeks</option>
                                <option value="fifteen days">Fifteen Days</option>
                                <option value="one month">One Month</option>
                                <option value="one month and fifteen days">One Month and Fifteen Days</option>
                                <option value="two months">Two Months</option>
                                <option value="two months and fifteen days">Two Months and Fifteen Days</option>
                                <option value="three months">Three Months</option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 mt-4">
                            <label>First Name (Optional)</label>
                            <input type="text" id="custom4" name="custom[]" class="form-control" placeholder="NA">
                        </div>

                        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 mt-4">
                            <label>Ref Contract No. (Optional)</label>
                            <input type="text" id="custom5" name="custom[]" class="form-control" placeholder="NA">
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 mt-4">
                            <label>Contract End Date (Optional)</label>
                            <input type="date" id="custom6" name="custom[]" class="form-control">
                        </div>  
                        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 mt-4">
                            <label>Annual Salary/Total Cost (Optional)</label>
                            <input type="text" id="custom7" name="custom[]" class="form-control" placeholder="NA">
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 mt-4">
                            <label>Monthly Salary (Optional)</label>
                            <input type="text" id="custom8" name="custom[]" class="form-control" placeholder="NA">
                        </div>                                                      
                    </div>


                        <!-- Other Custom Details -->
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 mt-4">
                            <h5>Schedule A/RFP Options</h5>
                            <input type="radio" name="scheduleAoption" onchange="changeScheduleA(this.value)" value="1" checked>
                            <label>Upload Schedule A/RFP</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="scheduleAoption" onchange="changeScheduleA(this.value)" value="2">
                            <label>Schedule A/RFP Editor</label>
                            
                        </div>

                        <div id="scheduleAeditor" class="col-lg-12 col-md-12 col-xs-12 col-sm-12 mt-4">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h5>Schedule A/RFP</h5>
                                    <input class="uploadFileBtn" type="file" onchange="readFile('customTextArea1', this.files, this.value)">
                                    <textarea class="form-control" name="customTextArea[]" id="customTextArea1"></textarea>
                                </div>
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="display:none;">
                                    <div class="row">                                
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h5>Schedule A Bank Section</h5>
                                            <textarea id="party2AllBankDetail2" class="form-control" readonly></textarea>
                                        </div>
                                    </div>
                                </div>                                  
                            </div>
                        </div>

                        <div id="scheduleAupload" class="col-lg-12 col-md-12 col-xs-12 col-sm-12 mt-4">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h5>Upload Schedule A/RFP</h5>
                                    <input type="file" id="scheduleA">
                                    <input type="hidden" name="uploadedFilename" id="uploadedFilename"> 
                                </div>
                                <div id="displayUploadedScheduleA" class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
 
                                </div>                                  
                            </div>
                        </div>

                        <div id="btn-section" class="col-lg-12 col-md-12 col-xs-12 col-sm-12 mt-5">
                            <button id="createAgreement" type="button" class="btn btn-success">Create Contract</button>
                        </div>											
                        </form>		

                    </div>
                </div>
                <div class="contentSectionFooterInner w-100">
                    <h3>© COPYRIGHT 2020 Auditor Finance ALL RIGHTS RESERVED</h3>
                </div>
            </div>
        </div>
    </div>

    <?php require(FCPATH . "assets/js/template-js.php");