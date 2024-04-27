<?php
$totalCount = count($allDataArr['CompanyId']); 

if($totalCount < 2) {
    echo "Invalid Contract, Please delete and recreate this contract.";
}

for($i = 0; $i < $totalCount; $i++) {
    $allDataArr['AddressType'][$i] = empty($allDataArr['party' . ($i + 1) . 'AddressType']) ? "" : $allDataArr['party' . ($i + 1) . 'AddressType'];
}

$templateName = $taskDetail[0]['templateName'];
$ucTemplateName = $templateName;

$scheduleAoption = $allDataArr['scheduleAoption'];
$scheduleAFilename = !empty($taskDetail[0]['scheduleAFilename']) ? $taskDetail[0]['scheduleAFilename'] : "";
?>


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
                        <?php
                        $attributes = array('id' => 'createTemplateForm');
                        echo form_open('template/processContactForm', $attributes);
                        ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h3>Edit Contract using <?php echo $ucTemplateName; ?></h3>
                                <input type="hidden" id="oldFileName" name="oldFileName" value="<?php echo $taskDetail[0]['fileName']; ?>">

                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <lable>Contract Date</lable>
                                <input type="date" id="custom1" name="custom[]" class="form-control" required value="<?php echo $allDataArr['custom'][0]; ?>">
                            </div>
                            <div class="mt-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <lable>Contract Start Date w.e.f</lable>
                                <input type="date" id="custom2" name="custom[]" class="form-control" required value="<?php echo $allDataArr['custom'][1]; ?>">
                            </div>
                        </div>

                        <?php 


                        for($i = 0; $i < 2; $i++) { ?>
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
                                                if($value['id'] == $allDataArr['CompanyId'][$i]) {

                                                        echo '<option selected value="' . $value['id'] . '">' . $value['partyName'] . " (" . $value['partyAlias'] . " )</option>";
                                               
                                                    } else {
                                               
                                                        echo '<option value="' . $value['id'] . '">' . $value['partyName'] . " (" . $value['partyAlias'] . " )</option>";
                                               
                                                    }
                                            }
                                            ?>                                    
                                        </select>
                                    </div>


                                    <div class="custom-margin-top col-lg-4 col-md-4 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <label>Address Details: &nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="custom-margin-top col-lg-8 col-md-8 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <input type="radio" onchange="changeCompanyById(<?php echo $i + 1; ?>)" name="party<?php echo $i + 1; ?>AddressType" value="1" 
                                        <?php 
                                        if($allDataArr['AddressType'][$i] == 1) {
                                        echo "checked";    
                                        }
                                        ?>>
                                        <label>Primary Address</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" onchange="changeCompanyById(<?php echo $i + 1; ?>)" name="party<?php echo $i + 1; ?>AddressType" value="2" 
                                        <?php 
                                        if($allDataArr['AddressType'][$i] == 2) {
                                        echo "checked";    
                                        }
                                        ?>>
                                        <label>Alternate Address</label>
                                    </div>
                                    <div class="custom-margin-top col-lg-4 col-md-4 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <label>Select Signatory: &nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="custom-margin-top col-lg-8 col-md-8 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <select id="party<?php echo $i + 1; ?>SigningAuthorityId" name="SigningAuthorityId[]" class="form-control" onchange="signingDropdown(<?php echo $i + 1; ?>, this.value)">
                                            <?php 
                                            $signingAll = $allClient[$allDataArr['CompanyId'][$i]]['signing'];
                                            foreach ($signingAll as $signkey => $signvalue) {
                                                if($signvalue['id'] == $allDataArr['SigningAuthorityId'][$i]) {
                                                    echo "<option selected value='" . $signvalue['id'] . "'>" . $signvalue['authorityName'] . "</option>";
                                                } else {
                                                    echo "<option value='" . $signvalue['id'] . "'>" . $signvalue['authorityName'] . "</option>";                                                    
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mt-5 col-lg-4 col-md-4 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <label>Bank Details</label>
                                    </div>
                                    <div class="mt-5 col-lg-8 col-md-8 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <select id="bankIndex<?php echo $i + 1; ?>" name="bankIndex[]" class="form-control" onchange="changeBankById(<?php echo $i + 1; ?>)">
                                            <option value="">Select Bank Account</option>
<?php 
                                            $bDetail = $allClient[$allDataArr['CompanyId'][$i]]['bankDetail'];
                                            foreach ($bDetail as $signkey => $signvalue) {
                                                if($signkey == $allDataArr['bankIndex'][$i]) {
                                                    echo "<option selected value='" . $signkey . "'>" . $signvalue['beneficiaryName'] . "</option>";
                                                } else {
                                                    echo "<option value='" . $signkey . "'>" . $signvalue['beneficiaryName'] . "</option>";                                           
                                                }
                                            }
                                            ?>                                        </select>
                                    </div>







                                </div>
                            </div>


                            <div class="displayToggleClass<?php echo $i + 1; ?> col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <textarea class="form-control addressTextArea" id="party<?php echo $i + 1; ?>FullAddress" name="FullAddress[]" readonly><?php echo $allDataArr['FullAddress'][$i]; ?></textarea>
                                
                                <textarea id="party<?php echo $i + 1; ?>AllSigningDetails" name="AllSigningDetails[]" class="form-control signatoryTextArea" readonly><?php echo $allDataArr['AllSigningDetails'][$i]; ?></textarea>
                                
                                <textarea id="party<?php echo $i + 1; ?>AllBankDetail" name="AllBankDetail[]" class="form-control bankTextArea" readonly><?php echo "Benificiary: " . $allDataArr['Benficiary'][$i] . ", Bank Name: " . $allDataArr['BankName'][$i] . ", Bank Address: " . $allDataArr['BankAddress'][$i] . ", Account No. " .  $allDataArr['AccoountNo'][$i] . ", IFSC Code: " . $allDataArr['RtgsNeftIfsCode'][$i] . ", Swift Code: " . $allDataArr['SwiftCode'][$i]; ?></textarea>
                            </div>




                            <input type="hidden" id="party<?php echo $i + 1; ?>CompanyName" name="CompanyName[]" value="<?php echo $allDataArr['CompanyName'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>CompanyAlias" name="CompanyAlias[]" value="<?php echo $allDataArr['CompanyAlias'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>SigningAuthorityName" name="SigningAuthorityName[]" value="<?php echo $allDataArr['SigningAuthorityName'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>SigningAuthorityEmail" name="SigningAuthorityEmail[]" value="<?php echo $allDataArr['SigningAuthorityEmail'][$i]; ?>">   

                            <input type="hidden" id="party<?php echo $i + 1; ?>SigningAuthorityPhone" name="SigningAuthorityPhone[]" value="<?php echo $allDataArr['SigningAuthorityPhone'][$i]; ?>">   

                            <input type="hidden" id="party<?php echo $i + 1; ?>SigningAuthorityDesignation" name="SigningAuthorityDesignation[]" value="<?php echo $allDataArr['SigningAuthorityDesignation'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>AddressLine1" name="AddressLine1[]" value="<?php echo $allDataArr['AddressLine1'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>AddressLine2" name="AddressLine2[]" value="<?php echo $allDataArr['AddressLine2'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>City" name="City[]" value="<?php echo $allDataArr['City'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>State" name="State[]" value="<?php echo $allDataArr['State'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>Country" name="Country[]" value="<?php echo $allDataArr['Country'][$i]; ?>">              
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>Zip" name="Zip[]" value="<?php echo $allDataArr['Zip'][$i]; ?>">                              
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>Benficiary" name="Benficiary[]" value="<?php echo $allDataArr['Benficiary'][$i]; ?>">
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>BankName" name="BankName[]" value="<?php echo $allDataArr['BankName'][$i]; ?>">
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>BankAddress" name="BankAddress[]" value="<?php echo $allDataArr['BankAddress'][$i]; ?>">
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>AccoountNo" name="AccoountNo[]" value="<?php echo $allDataArr['AccoountNo'][$i]; ?>">
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>RtgsNeftIfsCode" name="RtgsNeftIfsCode[]" value="<?php echo $allDataArr['RtgsNeftIfsCode'][$i]; ?>">
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>SwiftCode" name="SwiftCode[]" value="<?php echo $allDataArr['SwiftCode'][$i]; ?>">


                        </div>

                        <!-- Company Close -->

                        <?php } ?> 
                        <!--Company Closes Here -->		

                        <div id="customCompanyDivs" class="w-100 mt-4">
                            <div id="appendBtn" class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 text-right">
                                    <input type="hidden" id="companyCounter" value="<?php echo $totalCount; ?>">
                                    <button type="button" onclick="addCompanyDiv()" class="btn btn-info pull-right">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" onclick="minusCompanyDiv()" class="btn btn-info pull-right">
                                        <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>



                        <?php 

                        if($totalCount > 2) {
                        for($i = 2; $i < $totalCount; $i++) { ?>

                        <!-- Other Companies-->
                        
                        <div  id="companyDiv<?php echo $i + 1; ?>" class="row rowDivCompany">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <h3 class="mt-3">Select Party No. <?php echo $i + 1; ?></h3>
                                        <select onchange="changeCompanyById(<?php echo $i + 1; ?>)" class="form-control" id="party<?php echo $i + 1; ?>CompanyId" name="CompanyId[]">
                                            <option value="">Select Company</option>
                                            <?php
                                            foreach ($clientNameArr as $key => $value) {
                                                if($value['id'] == $allDataArr['CompanyId'][$i]) {

                                                        echo '<option selected value="' . $value['id'] . '">' . $value['partyName'] . " (" . $value['partyAlias'] . " )</option>";
                                               
                                                    } else {
                                               
                                                        echo '<option value="' . $value['id'] . '">' . $value['partyName'] . " (" . $value['partyAlias'] . " )</option>";
                                               
                                                    }
                                            }
                                            ?>
                                        </select>
                                    </div>


                                    <div class="custom-margin-top col-lg-4 col-md-4 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <label>Address Details: &nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="custom-margin-top col-lg-8 col-md-8 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <input type="radio" onchange="changeCompanyById(<?php echo $i + 1; ?>)" name="party<?php echo $i + 1; ?>AddressType" value="1" 
                                        <?php 
                                        if($allDataArr['AddressType'][$i] == 1) {
                                        echo "checked";    
                                        }
                                        ?>>
                                        <label>Primary Address</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" onchange="changeCompanyById(<?php echo $i + 1; ?>)" name="party<?php echo $i + 1; ?>AddressType" value="2" 
                                        <?php 
                                        if($allDataArr['AddressType'][$i] == 2) {
                                        echo "checked";    
                                        }
                                        ?>>
                                        <label>Alternate Address</label>
                                    </div>
                                    <div class="custom-margin-top col-lg-4 col-md-4 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <label>Select Signatory: &nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="custom-margin-top col-lg-8 col-md-8 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <select id="party<?php echo $i + 1; ?>SigningAuthorityId" name="SigningAuthorityId[]" class="form-control" onchange="signingDropdown(<?php echo $i + 1; ?>, this.value)">
                                            <?php 
                                            $signingAll = $allClient[$allDataArr['CompanyId'][$i]]['signing'];
                                            foreach ($signingAll as $signkey => $signvalue) {
                                                if($signvalue['id'] == $allDataArr['SigningAuthorityId'][$i]) {
                                                    echo "<option selected value='" . $signvalue['id'] . "'>" . $signvalue['authorityName'] . "</option>";
                                                } else {
                                                    echo "<option value='" . $signvalue['id'] . "'>" . $signvalue['authorityName'] . "</option>";                                                    
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mt-5 col-lg-4 col-md-4 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <label>Bank Details</label>
                                    </div>
                                    <div class="mt-5 col-lg-8 col-md-8 col-sm-12 col-xs-12 displayToggleClass<?php echo $i + 1; ?>">
                                        <select id="bankIndex<?php echo $i + 1; ?>" name="bankIndex[]" class="form-control" onchange="changeBankById(<?php echo $i + 1; ?>)">
                                            <option value="">Select Bank Account</option>
                                            <?php 
                                            $bDetail = $allClient[$allDataArr['CompanyId'][$i]]['bankDetail'];
                                            foreach ($bDetail as $signkey => $signvalue) {
                                                if($signkey == $allDataArr['bankIndex'][$i]) {
                                                    echo "<option selected value='" . $signkey . "'>" . $signvalue['beneficiaryName'] . "</option>";
                                                } else {
                                                    echo "<option value='" . $signkey . "'>" . $signvalue['beneficiaryName'] . "</option>";                                           
                                                }
                                            }
                                            ?>                                        </select>
                                    </div>







                                </div>
                            </div>


                            <div class="displayToggleClass<?php echo $i + 1; ?> col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                
                                <textarea class="form-control addressTextArea" id="party<?php echo $i + 1; ?>FullAddress" name="FullAddress[]" readonly><?php echo $allDataArr['FullAddress'][$i]; ?></textarea>
                                
                                <textarea id="party<?php echo $i + 1; ?>AllSigningDetails" name="AllSigningDetails[]"class="form-control signatoryTextArea" readonly><?php echo $allDataArr['AllSigningDetails'][$i]; ?></textarea>
                                
                                <textarea id="party<?php echo $i + 1; ?>AllBankDetail" name="AllBankDetail[]" class="form-control bankTextArea" readonly><?php echo "Benificiary: " . $allDataArr['Benficiary'][$i] . ", Bank Name: " . $allDataArr['BankName'][$i] . ", Bank Address: " . $allDataArr['BankAddress'][$i] . ", Account No. " .  $allDataArr['AccoountNo'][$i] . ", IFSC Code: " . $allDataArr['RtgsNeftIfsCode'][$i] . ", Swift Code: " . $allDataArr['SwiftCode'][$i]; ?></textarea>
                            </div>




                            <input type="hidden" id="party<?php echo $i + 1; ?>CompanyName" name="CompanyName[]" value="<?php echo $allDataArr['CompanyName'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>CompanyAlias" name="CompanyAlias[]" value="<?php echo $allDataArr['CompanyAlias'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>SigningAuthorityName" name="SigningAuthorityName[]" value="<?php echo $allDataArr['SigningAuthorityName'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>SigningAuthorityEmail" name="SigningAuthorityEmail[]" value="<?php echo $allDataArr['SigningAuthorityEmail'][$i]; ?>">   

                            <input type="hidden" id="party<?php echo $i + 1; ?>SigningAuthorityPhone" name="SigningAuthorityPhone[]" value="<?php echo $allDataArr['SigningAuthorityPhone'][$i]; ?>">   

                            <input type="hidden" id="party<?php echo $i + 1; ?>SigningAuthorityDesignation" name="SigningAuthorityDesignation[]" value="<?php echo $allDataArr['SigningAuthorityDesignation'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>AddressLine1" name="AddressLine1[]" value="<?php echo $allDataArr['AddressLine1'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>AddressLine2" name="AddressLine2[]" value="<?php echo $allDataArr['AddressLine2'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>City" name="City[]" value="<?php echo $allDataArr['City'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>State" name="State[]" value="<?php echo $allDataArr['State'][$i]; ?>">

                            <input type="hidden" id="party<?php echo $i + 1; ?>Country" name="Country[]" value="<?php echo $allDataArr['Country'][$i]; ?>">              
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>Zip" name="Zip[]" value="<?php echo $allDataArr['Zip'][$i]; ?>">                              
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>Benficiary" name="Benficiary[]" value="<?php echo $allDataArr['Benficiary'][$i]; ?>">
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>BankName" name="BankName[]" value="<?php echo $allDataArr['BankName'][$i]; ?>">
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>BankAddress" name="BankAddress[]" value="<?php echo $allDataArr['BankAddress'][$i]; ?>">
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>AccoountNo" name="AccoountNo[]" value="<?php echo $allDataArr['AccoountNo'][$i]; ?>">
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>RtgsNeftIfsCode" name="RtgsNeftIfsCode[]" value="<?php echo $allDataArr['RtgsNeftIfsCode'][$i]; ?>">
                            <input type="hidden" class="form-control" id="party<?php echo $i + 1; ?>SwiftCode" name="SwiftCode[]" value="<?php echo $allDataArr['SwiftCode'][$i]; ?>">


                        </div>





                        <?php } } ?> 

                        </div>

                        <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 mt-4">
                            <label>Notice Period</label>
                            <select id="custom3" name="custom[]" class="form-control">
                                <option <?php if($allDataArr['custom'][2] == 'NA') { echo "selected"; } ?>value="NA">NA</option>

                                <option <?php if($allDataArr['custom'][2] == 'one week') { echo "selected"; } ?> value="one week">One Week</option>

                                <option <?php if($allDataArr['custom'][2] == 'two weeks') { echo "selected"; } ?> value="two weeks">Two Weeks</option>

                                <option <?php if($allDataArr['custom'][2] == 'fifteen days') { echo "selected"; } ?> value="fifteen days">Fifteen Days</option>

                                <option <?php if($allDataArr['custom'][2] == 'one month') { echo "selected"; } ?> value="one month">One Month</option>

                                <option <?php if($allDataArr['custom'][2] == 'one month and fifteen days') { echo "selected"; } ?> value="one month and fifteen days">One Month and Fifteen Days</option>

                                <option <?php if($allDataArr['custom'][2] == 'two months') { echo "selected"; } ?> value="two months">Two Months</option>

                                <option <?php if($allDataArr['custom'][2] == 'two months and fifteen days') { echo "selected"; } ?> value="two months and fifteen days">Two Months and Fifteen Days</option>
                                
                                <option <?php if($allDataArr['custom'][2] == 'three months') { echo "selected"; } ?> value="three months">Three Months</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 mt-4">
                            <label>First Name (Optional)</label>
                            <input type="text" id="custom4" name="custom[]" class="form-control" placeholder="NA" value="<?php echo $allDataArr['custom'][3]; ?>">
                        </div>

                        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 mt-4">
                            <label>Ref Contract No. (Optional)</label>
                            <input type="text" id="custom5" name="custom[]" class="form-control" placeholder="NA" value="<?php echo $allDataArr['custom'][4]; ?>">
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 mt-4">
                            <label>Contract End Date (Optional)</label>
                            <input type="date" id="custom6" name="custom[]" class="form-control" value="<?php echo $allDataArr['custom'][5]; ?>">
                        </div>      
                        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 mt-4">
                            <label>Annual Salary/Total Cost (Optional)</label>
                            <input type="text" id="custom7" name="custom[]" class="form-control" value="<?php echo !empty($allDataArr['custom'][6]) ? $allDataArr['custom'][6] : ""; ?>" placeholder="NA">
                        </div> 
                        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 mt-4">
                            <label>Monthly Salary (Optional)</label>
                            <input type="text" id="custom8" name="custom[]" class="form-control" value="<?php echo !empty($allDataArr['custom'][7]) ? $allDataArr['custom'][7] : ""; ?>" placeholder="NA">
                        </div> 
                    </div>

                        <!-- Other Custom Details -->
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 mt-4">
                            <h5>Schedule A/RFP Options</h5>
                            <input type="radio" name="scheduleAoption" onchange="changeScheduleA(this.value)" value="1" 
                            <?php if($scheduleAoption == 1) { echo "checked"; } ?>
                            >
                            <label>Upload Schedule A/RFP</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="scheduleAoption" onchange="changeScheduleA(this.value)" value="2" 
                            <?php if($scheduleAoption == 2) { echo "checked"; } ?>
                            >
                            <label>Schedule A/RFP Editor</label>
                            
                        </div>

                        <div id="scheduleAeditor" class="col-lg-12 col-md-12 col-xs-12 col-sm-12 mt-4">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h5>Schedule A/RFP</h5>
                                    <input class="uploadFileBtn" type="file" onchange="readFile('customTextArea1', this.files, this.value)">
                                    <textarea class="form-control" name="customTextArea[]" id="customTextArea1"><?php echo $allDataArr['customTextArea'][0]; ?></textarea>
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


                        <!-- Other Custom Textarea -->

                        <div id="btn-section" class="col-lg-12 col-md-12 col-xs-12 col-sm-12 mt-5">
	                       	<button id="updateAgreement" type="button" class="btn btn-success">Edit Contract</button>
                            <button type="button" onclick="location.reload();" class="btn btn-danger" style="width: 120px;">Reload</button>
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

<!-- Including JS -->
<?php require(FCPATH . "assets/js/edit-template-js.php");