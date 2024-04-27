<script>
    var base_url = "<?php echo base_url(); ?>";
    $(document).ready(function () {
        
        $('#scheduleAeditor').hide();

        $(document).on('touchstart click', '#createAgreement', function (event) {
            
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            var party1CompanyId = document.getElementById('party1CompanyId').value;
            var party2CompanyId = document.getElementById('party2CompanyId').value;

            if (party1CompanyId == "" || party2CompanyId == "") {
                swal({
                    title: "Failed!",
                    text: 'Please Fill all the Details',
                    icon: "warning",
                });
                return false;
            }

            var scheduleAoption =$('input[name="scheduleAoption"]:checked').val();

            if(scheduleAoption == 1) {
                var uploadedFilename = document.getElementById('uploadedFilename').value;
                if(uploadedFilename == "") {
                    swal({
                        title: "Failed!",
                        text: 'Uploading Schedule A file is mandatory',
                        icon: "warning",
                    });
                    return false;
                }
            } else {
                var editorInput = CKEDITOR.instances['customTextArea1'].getData();
                if(editorInput == "") {
                    swal({
                        title: "Failed!",
                        text: 'Please fill Schedule A Section in the editor.',
                        icon: "warning",
                    });
                    return false;                    
                }
            }

            //Send ajax here
            $('#loadingModel').modal('show');

            var form = document.getElementById("createTemplateForm");
            var formData = new FormData(form);
            var ajaxUrl = base_url + "template/savecontact/" + "<?php echo $templateName; ?>";

            $.ajax({
                url: ajaxUrl,
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    $('#loadingModel').modal('hide');
                    var obj = JSON.parse(data);
                    try {
                        if (obj.code == 1) {

                            html = '<a href="' + base_url + 'assets/created-templates/' + obj.fileName + '" target="_blank" download><button id="viewAgreement" title="Download Agreement" type="button" class="btn btn-info"><i class="fa fa-download" aria-hidden="true"></i></button></a>&nbsp;';

                            html += '<button data-file="' + obj.fileName + '" class="btn btn-info viewTemplate"  type="button" title="View Template"><i class="fa fa-eye" aria-hidden="true"></i></button>&nbsp;';
                            html += '<button id="updateAgreement" type="button" class="btn btn-primary formBtn">Update</button>&nbsp;';

                            html += '<button id="resetAgreement" type="button" class="btn btn-danger formBtn">Delete</button>&nbsp;';

                            html += '<a href="' + "<?php echo base_url(); ?>template/draft" + '"><button id="sendAgreement" type="button" class="btn btn-warning formBtn">Finish</button></a>';
                            document.getElementById('btn-section').innerHTML = html;
                            document.getElementById('oldFileName').value = obj.fileName;

                            swal({
                                title: "Success!",
                                text: "Contract Created Succesfully!",
                                icon: "success",
                            });

                        } else if (obj.code == 0) {
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
        });

        $(document).on('touchstart click', '#updateAgreement', function (event) {
            $('#loadingModel').modal('show');
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            var party1CompanyId = document.getElementById('party1CompanyId').value;
            var party2CompanyId = document.getElementById('party2CompanyId').value;

            if (party1CompanyId == "" || party2CompanyId == "") {
                swal({
                    title: "Failed!",
                    text: 'Please Fill all the Details',
                    icon: "warning",
                });
            }

            //Send ajax here
            var form = document.getElementById("createTemplateForm");
            var formData = new FormData(form);
            var ajaxUrl = base_url + "template/saveContact/" + "<?php echo $templateName; ?>";

            $.ajax({
                url: ajaxUrl,
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#loadingModel').modal('hide');
                    var obj = JSON.parse(data);
                    try {
                        if (obj.code == 1) {

                            html = '<a href="' + base_url + 'assets/created-templates/' + obj.fileName + '" target="_blank" download><button id="viewAgreement" title="Download Agreement" type="button" class="btn btn-info"><i class="fa fa-download" aria-hidden="true"></i></button></a>&nbsp;';

                            html += '<button data-file="' + obj.fileName + '" class="btn btn-info viewTemplate"  type="button" title="View Template"><i class="fa fa-eye" aria-hidden="true"></i></button>&nbsp;';
                            html += '<button id="updateAgreement" type="button" class="btn btn-primary formBtn">Update</button>&nbsp;';

                            html += '<button id="resetAgreement" type="button" class="btn btn-danger formBtn">Delete</button>&nbsp;';

                            html += '<a href="' + "<?php echo base_url(); ?>template/draft" + '"><button id="sendAgreement" type="button" class="btn btn-warning formBtn">Finish</button></a>';

                            document.getElementById('btn-section').innerHTML = html;
                            document.getElementById('oldFileName').value = obj.fileName;

                            swal({
                                title: "Success!",
                                text: "Contract Updated Succesfully!",
                                icon: "success",
                            });

                        } else if (obj.code == 0) {
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
        });


        $(document).on('touchstart click', '#resetAgreement', function (event) {

            var oldFileName = document.getElementById('oldFileName').value;

            if (oldFileName == "") {
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
                success: function (data) {
                    var obj = JSON.parse(data);
                    try {
                        if (obj.code == 1) {

                            html = '<button id="createAgreement" type="button" class="btn btn-success">Create Contract</button>';

                            document.getElementById('btn-section').innerHTML = html;
                            document.getElementById('oldFileName').value = '';
                            $('#createTemplateForm')[0].reset();

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

        $(document).on('touchstart click', '.viewTemplate ', function (event) {
            document.getElementById('viewAgreementModalBody').innerHTML = '';
            var filename = $(this).data('file');

            var html = '<iframe frameborder="0" width="100%" height="450px" src="https://view.officeapps.live.com/op/embed.aspx?src=' +
                    '<?php echo base_url(); ?>assets/created-templates/' +
                    filename + '"></iframe>';

            document.getElementById('viewAgreementModalBody').innerHTML = html;
            $('#viewAgreementModal').modal('show');
        });

        try {
            CKEDITOR.replace('customTextArea1',
                    {
                        customConfig: 'customConfig.js',
                        height: '200px'
                    }
            );

            CKEDITOR.replace('customTextArea2',
                    {
                        customConfig: 'customConfig.js',
                        height: '200px'
                    }
            );         
        } catch (e) {}
   
    });

    function validateEmail(emailID) {
        atpos = emailID.indexOf("@");
        dotpos = emailID.lastIndexOf(".");
        if (atpos < 1 || (dotpos - atpos < 2)) {

            return false;
        }
        return true;
    }

    function changeCompanyById(partyNo) {

        try {
            var companyId = document.getElementById('party' + partyNo + 'CompanyId').value;
            var radioValue = $("input[name='party" + partyNo + "AddressType']:checked").val();
            if (companyId == "") {
                $("#party" + partyNo + "CompanyName").val('');
                $("#party" + partyNo + "CompanyAlias").val('');
                $("#party" + partyNo + "AddressLine1").val('');
                $("#party" + partyNo + "AddressLine2").val('');
                $("#party" + partyNo + "City").val('');
                $("#party" + partyNo + "State").val('');
                $("#party" + partyNo + "Country").val('');
                $("#party" + partyNo + "Zip").val('');
                $("#party" + partyNo + "FullAddress").val('');
                $("#party" + partyNo + "SigningAuthorityId").val('');
                $("#party" + partyNo + "SigningAuthorityName").val('');
                $("#party" + partyNo + "SigningAuthorityEmail").val('');
                $("#party" + partyNo + "SigningAuthorityPhone").val('');
                $("#party" + partyNo + "SigningAuthorityDesignation").val('');
                $("#party" + partyNo + "Benficiary").val('');
                $("#party" + partyNo + "BankName").val('');
                $("#party" + partyNo + "BankAddress").val('');
                $("#party" + partyNo + "AccoountNo").val('');
                $("#party" + partyNo + "RtgsNeftIfsCode").val('');
                $("#party" + partyNo + "SwiftCode").val('');
                var elements = document.getElementsByClassName("displayToggleClass" + partyNo);

                for (var i = 0; i < elements.length; i++) {
                    elements[i].style.display = 'none';
                }

                if (partyNo == 2) {

                    $("#party" + partyNo + "Benficiary2").val('');
                    $("#party" + partyNo + "BankName2").val('');
                    $("#party" + partyNo + "BankAddress2").val('');
                    $("#party" + partyNo + "AccoountNo2").val('');
                    $("#party" + partyNo + "RtgsNeftIfsCode2").val('');
                    $("#party" + partyNo + "SwiftCode2").val('');

                }
                return false;
            }
            $.ajax({
                url: "<?php echo base_url(); ?>" + "client/fetchClientById",
                data: {
                    id: companyId
                },
                type: 'POST',
                success: function (data) {
                    var obj = JSON.parse(data);
                    try {
                        if (obj.code == 1) {

                            $("#party" + partyNo + "CompanyName").val(obj.output[0].partyName);
                            $("#party" + partyNo + "CompanyAlias").val(obj.output[0].partyAlias);
                            if (radioValue == 1) {
                                var al1 = obj.output[0].partyAddressLine1;
                                al1 = al1.trim();
                                var al2 = obj.output[0].partyAddressLine2;
                                al2 = al2.trim();
                                var city = obj.output[0].partyCity;
                                city = city.trim();
                                var state = obj.output[0].partyState;
                                state = state.trim();
                                var country = obj.output[0].partyCountry
                                country = country.trim();
                                var zip = obj.output[0].partyZip;
                                zip = zip.trim();
                                var fullAddress = al1 + ', ' + al2 + ', ' + city + ', ' + state + ', ' + country + ' - ' + zip;
                            } else {
                                var al1 = obj.output[0].partyOtherAddressLine1;
                                al1 = al1.trim();
                                var al2 = obj.output[0].partyOtherAddressLine2;
                                al2 = al2.trim();
                                var city = obj.output[0].partyOtherCity;
                                city = city.trim();
                                var state = obj.output[0].partyOtherState;
                                state = state.trim();
                                var country = obj.output[0].partyOtherCountry
                                country = country.trim();
                                var zip = obj.output[0].partyOtherZip;
                                zip = zip.trim();
                                var fullAddress = al1 + ', ' + al2 + ', ' + city + ', ' + state + ', ' + country + ' - ' + zip;
                            }
                            $("#party" + partyNo + "AddressLine1").val(al1);
                            $("#party" + partyNo + "AddressLine2").val(al2);
                            $("#party" + partyNo + "City").val(city);
                            $("#party" + partyNo + "State").val(state);
                            $("#party" + partyNo + "Country").val(country);
                            $("#party" + partyNo + "Zip").val(zip);
                            $("#party" + partyNo + "FullAddress").val(fullAddress);
                            
                            var bankDetail = obj.bankDetail;
                            // console.log(bankDetail);

                            var benficiary = bankDetail[0].beneficiaryName;
                            var bankName = bankDetail[0].bankName;
                            var bankAddress = bankDetail[0].bankAddress;
                            var accountNo = bankDetail[0].accountNo;
                            var rtgsNeftIfsCode = bankDetail[0].rtgsNeftIfsCode;
                            var swiftCode = bankDetail[0].swiftCode;

                            $("#party" + partyNo + "Benficiary").val(benficiary);
                            $("#party" + partyNo + "BankName").val(bankName);
                            $("#party" + partyNo + "BankAddress").val(bankAddress);
                            $("#party" + partyNo + "AccoountNo").val(accountNo);
                            $("#party" + partyNo + "RtgsNeftIfsCode").val(rtgsNeftIfsCode);
                            $("#party" + partyNo + "SwiftCode").val(swiftCode);

                            $("#party" + partyNo + "AllBankDetail").val('Benificiary: ' + benficiary + ", Bank Name: " + bankName + ", Bank Address: " + bankAddress + ", Account No: " + accountNo + ", IFSC Code: " + rtgsNeftIfsCode + ", Swift Code: " + swiftCode);

                            if (partyNo == 2) {
                                $("#party" + partyNo + "AllBankDetail2").val('Benificiary: ' + benficiary + ", Bank Name: " + bankName + ", Bank Address: " + bankAddress + ", Account No: " + accountNo + ", IFSC Code: " + rtgsNeftIfsCode + ", Swift Code: " + swiftCode);
                            }

                            $("#party" + partyNo + "SigningAuthorityName").val(obj.sign[0].authorityName);
                            $("#party" + partyNo + "SigningAuthorityDesignation").val(obj.sign[0].authorityDesignation);
                            $("#party" + partyNo + "SigningAuthorityEmail").val(obj.sign[0].authorityEmail);
                            $("#party" + partyNo + "SigningAuthorityPhone").val(obj.sign[0].authorityPhone);


                            var bIndex;
                            var bHtml = "";
                            var tmpBankStr;
                            for(bIndex = 0; bIndex < bankDetail.length; bIndex++) {
                                if(bankDetail[bIndex].beneficiaryName.length > 15) {
                                    tmpBankStr = bankDetail[bIndex].beneficiaryName.substr(0, 15) + '... (' + bankDetail[bIndex].accountNo + ')';    
                                } else {
                                    tmpBankStr = bankDetail[bIndex].beneficiaryName + ' (' + bankDetail[bIndex].accountNo + ')';    
                                }
                                
                                bHtml += '<option value="' + bIndex + '">' + tmpBankStr + '</option>';
                            }


                            var allSigning = obj.allSigning;
                            var signIndex;
                            var signHtml = '<option value="">Select/Change Signing Authority</option>';
                            for (signIndex = 0; signIndex < allSigning.length; signIndex++) {
                                signHtml += '<option value="' + allSigning[signIndex].id + '">' + allSigning[signIndex].authorityName + '</option>';
                            }



                            var name = obj.sign[0].authorityName;
                            var designation = obj.sign[0].authorityDesignation;
                            var email = obj.sign[0].authorityEmail;
                            var phone = obj.sign[0].authorityPhone;

                            var val = "Name: " + name + ", " + designation + "\nEmail: " + email + ", Phone: " + phone
                            $("#party" + partyNo + "AllSigningDetails").val(val);


                            document.getElementById('party' + partyNo + 'SigningAuthorityId').innerHTML = signHtml;

                            var elements = document.getElementsByClassName("displayToggleClass" + partyNo);

                            for (var i = 0; i < elements.length; i++) {
                                elements[i].style.display = 'block';
                            }
                            $("#party" + partyNo + "SigningAuthorityId").val(obj.sign[0].id);
                            $("#bankIndex" + partyNo).html(bHtml);



                        }
                    } catch (e) {
                        console.log(e);
                    }
                }
            });
        } catch (e) {
            console.log(e);
        }
    }

    function signingDropdown(partyNo, signId) {

        if (signId == "") {

            $("#party" + partyNo + "SigningAuthorityName").val('');
            $("#party" + partyNo + "SigningAuthorityDesignation").val('');
            $("#party" + partyNo + "SigningAuthorityEmail").val('');
            $("#party" + partyNo + "SigningAuthorityPhone").val('');
            return false;
        }

        $.ajax({
            url: "<?php echo base_url(); ?>" + "signingauthority/fetchsigningbyid",
            data: {
                id: signId
            },
            type: 'POST',
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.code == 1) {

                    $("#party" + partyNo + "SigningAuthorityName").val(obj.output[0].authorityName);
                    $("#party" + partyNo + "SigningAuthorityDesignation").val(obj.output[0].authorityDesignation);
                    $("#party" + partyNo + "SigningAuthorityEmail").val(obj.output[0].authorityEmail);
                    $("#party" + partyNo + "SigningAuthorityPhone").val(obj.output[0].authorityPhone);

                    var name = obj.output[0].authorityName;
                    var designation = obj.output[0].authorityDesignation;
                    var email = obj.output[0].authorityEmail;
                    var phone = obj.output[0].authorityPhone;
                    var val = "Name: " + name + ", " + designation + "\nEmail: " + email + ", Phone: " + phone
                    $("#party" + partyNo + "AllSigningDetails").val(val);


                } else {
                    console.log(obj);
                }
            }
        });
    }

    function addCompanyDiv() {
        var date = "<?php echo date('Y-m-d') ?>";
        var companyCounter = document.getElementById('companyCounter').value;
        companyCounter = parseInt(companyCounter);
        companyCounter++;
        document.getElementById('companyCounter').value = companyCounter;
        var index = companyCounter;
        
        html = '<div id="companyDiv' + index + '" class="row rowDivCompany">' +
        '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">' + 
        '<div class="row">' + 
        '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">' +
        '<h3 class="mt-3">Select Party No. ' + index + '</h3>' +
        '<select onchange="changeCompanyById(' + index + ')" class="form-control" id="party' + index + 'CompanyId" name="CompanyId[]">' +
        '<option value="">Select Company</option>' +
        '</select>' +
        '</div>' +
        '<div class="custom-margin-top col-lg-4 col-md-4 col-sm-12 col-xs-12 displayToggleClass' + index + '">' +
        '<label>Address</label>' +
        '</div>' +
        '<div class="custom-margin-top col-lg-8 col-md-8 col-sm-12 col-xs-12 displayToggleClass' + index + '">' +
        '<input type="radio" onchange="changeAddressById(' + index + ')" name="party' + index + 'AddressType" value="1" checked>' + 
        '<label>Primary</label>&nbsp;&nbsp;&nbsp;&nbsp;' +
        '<input type="radio" onchange="changeAddressById(' + index + ')" name="party' + index + 'AddressType" value="2">' +
        '<label>Alternate</label>' +
        '</div>' +
        '<div class="custom-margin-top col-lg-4 col-md-4 col-sm-12 col-xs-12 displayToggleClass' + index + '">' +
        '<label>Select Signatory: &nbsp;&nbsp;&nbsp;&nbsp;</label>' +
        '</div>' +
        '<div class="custom-margin-top col-lg-8 col-md-8 col-sm-12 col-xs-12 displayToggleClass' + index + '">' +
        '<select id="party' + index + 'SigningAuthorityId" name="SigningAuthorityId[]" class="form-control" onchange="signingDropdown(' + index + ', this.value)">' +

        '</select>' +
        '</div>' +
        '<div class="mt-5 col-lg-4 col-md-4 col-sm-12 col-xs-12 displayToggleClass' + index + '">' +
        '<label>Bank Details</label>' +
        '</div>' +
        '<div class="mt-5 col-lg-8 col-md-8 col-sm-12 col-xs-12 displayToggleClass' + index + '">' +
        '<select id="bankIndex' + index + '" name="bankIndex[]" class="form-control" onchange="changeBankById(' + index + ')">' +
        '<option value="">Select Bank Account</option>' +
        '<option value="0">Bank Account 1</option>' +
        '<option value="1">Bank Account 2</option>' +
        '<option value="2">Bank Account 3</option>' +
        '</select>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="displayToggleClass' + index + ' col-lg-6 col-md-6 col-sm-12 col-xs-12">' +
        '<textarea class="form-control addressTextArea" id="party' + index + 'FullAddress" name="FullAddress[]" readonly></textarea>' +
        '<textarea id="party' + index + 'AllSigningDetails" name="AllSigningDetails[]" class="form-control signatoryTextArea" readonly></textarea>' +
        '<textarea id="party' + index + 'AllBankDetail" name="AllBankDetail[]" class="form-control bankTextArea" readonly></textarea>' +
        '</div>' +
        '<input type="hidden" id="party' + index + 'CompanyName" name="CompanyName[]">' +
        '<input type="hidden" id="party' + index + 'CompanyAlias" name="CompanyAlias[]">' +
        '<input type="hidden" id="party' + index + 'SigningAuthorityName" name="SigningAuthorityName[]">' +
        '<input type="hidden" id="party' + index + 'SigningAuthorityEmail" name="SigningAuthorityEmail[]">' +   
        '<input type="hidden" id="party' + index + 'SigningAuthorityPhone" name="SigningAuthorityPhone[]">' +   
        '<input type="hidden" id="party' + index + 'SigningAuthorityDesignation" name="SigningAuthorityDesignation[]">' +
        '<input type="hidden" id="party' + index + 'AddressLine1" name="AddressLine1[]">' +
        '<input type="hidden" id="party' + index + 'AddressLine2" name="AddressLine2[]">' +
        '<input type="hidden" id="party' + index + 'City" name="City[]">' +
        '<input type="hidden" id="party' + index + 'State" name="State[]">' +
        '<input type="hidden" id="party' + index + 'Country" name="Country[]">' +              
        '<input type="hidden" class="form-control" id="party' + index + 'Zip" name="Zip[]">' +
        '<input type="hidden" class="form-control" id="party' + index + 'Benficiary" name="Benficiary[]" required readonly>' +
        '<input type="hidden" class="form-control" id="party' + index + 'BankName" name="BankName[]" required readonly>' +
        '<input type="hidden" class="form-control" id="party' + index + 'BankAddress" name="BankAddress[]" required readonly>' +
        '<input type="hidden" class="form-control" id="party' + index + 'AccoountNo" name="AccoountNo[]" required readonly>' +
        '<input type="hidden" class="form-control" id="party' + index + 'RtgsNeftIfsCode" name="RtgsNeftIfsCode[]" required readonly>' +
        '<input type="hidden" class="form-control" id="party' + index + 'SwiftCode" name="SwiftCode[]" required readonly>' +
        '</div>';

        $('#customCompanyDivs').append(html);

        var companySelection = document.getElementById('party1CompanyId').innerHTML;
        document.getElementById('party' + index + 'CompanyId').innerHTML = companySelection;
        document.getElementById('party' + index + 'CompanyId').value = "";
    }

    function minusCompanyDiv() {

        var companyCounter = document.getElementById('companyCounter').value;
        companyCounter = parseInt(companyCounter);

        if (companyCounter <= 2) {
            return false;
        }

        $('#companyDiv' + companyCounter).remove();
        companyCounter--;
        document.getElementById('companyCounter').value = companyCounter;

    }


    function changeAddressById(partyNo) {

        try {
            var companyId = document.getElementById('party' + partyNo + 'CompanyId').value;
            var radioValue = $("input[name='party" + partyNo + "AddressType']:checked").val();

            $.ajax({
                url: "<?php echo base_url(); ?>" + "client/fetchClientById",
                data: {
                    id: companyId
                },
                type: 'POST',
                success: function (data) {
                    var obj = JSON.parse(data);
                    try {
                        if (obj.code == 1) {
                            
                            if (radioValue == 1) {
                                var al1 = obj.output[0].partyAddressLine1;
                                al1 = al1.trim();
                                var al2 = obj.output[0].partyAddressLine2;
                                al2 = al2.trim();
                                var city = obj.output[0].partyCity;
                                city = city.trim();
                                var state = obj.output[0].partyState;
                                state = state.trim();
                                var country = obj.output[0].partyCountry
                                country = country.trim();
                                var zip = obj.output[0].partyZip;
                                zip = zip.trim();
                                var fullAddress = al1 + ', ' + al2 + ', ' + city + ', ' + state + ', ' + country + ' - ' + zip;
                            } else {
                                var al1 = obj.output[0].partyOtherAddressLine1;
                                al1 = al1.trim();
                                var al2 = obj.output[0].partyOtherAddressLine2;
                                al2 = al2.trim();
                                var city = obj.output[0].partyOtherCity;
                                city = city.trim();
                                var state = obj.output[0].partyOtherState;
                                state = state.trim();
                                var country = obj.output[0].partyOtherCountry
                                country = country.trim();
                                var zip = obj.output[0].partyOtherZip;
                                zip = zip.trim();
                                var fullAddress = al1 + ', ' + al2 + ', ' + city + ', ' + state + ', ' + country + ' - ' + zip;
                            }
                            $("#party" + partyNo + "AddressLine1").val(al1);
                            $("#party" + partyNo + "AddressLine2").val(al2);
                            $("#party" + partyNo + "City").val(city);
                            $("#party" + partyNo + "State").val(state);
                            $("#party" + partyNo + "Country").val(country);
                            $("#party" + partyNo + "Zip").val(zip);
                            $("#party" + partyNo + "FullAddress").val(fullAddress);
                            
                        }
                    } catch (e) {
                        console.log(e);
                    }
                }
            });
        } catch (e) {
            console.log(e);
        }
    }

    function changeBankById(partyNo) {

        try {
            var companyId = document.getElementById('party' + partyNo + 'CompanyId').value;
            var bankIndex = document.getElementById('bankIndex' + partyNo).value;

            $.ajax({
                url: "<?php echo base_url(); ?>" + "client/fetchClientById",
                data: {
                    id: companyId
                },
                type: 'POST',
                success: function (data) {
                    var obj = JSON.parse(data);
                    try {
                        if (obj.code == 1) {
                            
                            var bankDetail = obj.bankDetail;

                            var benficiary = bankDetail[bankIndex].beneficiaryName;
                            var bankName = bankDetail[bankIndex].bankName;
                            var bankAddress = bankDetail[bankIndex].bankAddress;
                            var accountNo = bankDetail[bankIndex].accountNo;
                            var rtgsNeftIfsCode = bankDetail[bankIndex].rtgsNeftIfsCode;
                            var swiftCode = bankDetail[bankIndex].swiftCode;

                            $("#party" + partyNo + "Benficiary").val(benficiary);
                            $("#party" + partyNo + "BankName").val(bankName);
                            $("#party" + partyNo + "BankAddress").val(bankAddress);
                            $("#party" + partyNo + "AccoountNo").val(accountNo);
                            $("#party" + partyNo + "RtgsNeftIfsCode").val(rtgsNeftIfsCode);
                            $("#party" + partyNo + "SwiftCode").val(swiftCode);

                            $("#party" + partyNo + "AllBankDetail").val('Benificiary: ' + benficiary + ", Bank Name: " + bankName + ", Bank Address: " + bankAddress + ", Account No: " + accountNo + ", IFSC Code: " + rtgsNeftIfsCode + ", Swift Code: " + swiftCode);

                            if (partyNo == 2) {
                                $("#party" + partyNo + "AllBankDetail2").val('Benificiary: ' + benficiary + ", Bank Name: " + bankName + ", Bank Address: " + bankAddress + ", Account No: " + accountNo + ", IFSC Code: " + rtgsNeftIfsCode + ", Swift Code: " + swiftCode);
                            }

                        }
                    } catch (e) {
                        console.log(e);
                    }
                }
            });
        } catch (e) {
            console.log(e);
        }
    }


    function readFile(id, fileInput, filename) {

        var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

        if(!allowedExtensions.exec(filename)){
        swal({
          title: "Failed!",
          text: "Please upload an image file.",
          icon: "warning",
        });
        
        return false;
        }

        var previousValue = CKEDITOR.instances[id].getData();  
        var html;
        if (fileInput && fileInput[0]) {

        var FR= new FileReader();

        FR.addEventListener("load", function(e) {
            try {
                html = '<table class="imgCustomUnique">' +
                '<tr><td>' +
                '<img style="max-width: 100%; margin: 0 auto;" src="' + e.target.result + '">' +
                '</td><tr>' +
                '</p>';
                CKEDITOR.instances[id].setData(previousValue + html);
            } catch(e) {
                console.log(e);
            }
        }); 
        FR.readAsDataURL( fileInput[0] );
        }
    }

    function changeScheduleA(opts) {
        if(opts == 1) {
            $('#scheduleAeditor').hide();
            $('#scheduleAupload').show();
        } else if(opts == 2) {
            $('#scheduleAupload').hide(); 
            $('#scheduleAeditor').show();

            //New Change 21st.
            
            document.getElementById('displayUploadedScheduleA').innerHTML = "";
            document.getElementById('uploadedFilename').value = "";  
            document.getElementById('scheduleA').value = "";  
        }
    }

    $('#scheduleA').on('change', function(){  
        
        document.getElementById('displayUploadedScheduleA').innerHTML = "";
        document.getElementById('uploadedFilename').value = "";

        var filename = document.getElementById('scheduleA').value;
        var base_url = "<?php echo base_url(); ?>";

        var allowedExtensions = /(\.docx)$/i;
        // var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        
        if(!allowedExtensions.exec(filename)){
            swal({
              title: "Failed!",
              text: "Please upload an .docx file.",
              icon: "warning",
            });
            document.getElementById('scheduleA').value = "";
            return false;
        }



        var data = new FormData();
        data.append('scheduleA', $('#scheduleA').prop('files')[0]);
        // append other variables to data if you want: data.append('field_name_x', field_value_x);
        $('#loadingModel').modal('show');
        $.ajax({
            type: 'POST',               
            processData: false, // important
            contentType: false, // important
            data: data,
            url: base_url + 'template/savescheduleafile',
            success: function(result){
                $('#loadingModel').modal('hide');
                var obj = JSON.parse(result);
                if(obj.code == 1) {

                var uploadedFilename = obj.filename;
                var html = '<iframe frameborder="0" width="100%" height="450px" src="https://view.officeapps.live.com/op/embed.aspx?src=' +
                        base_url + 'assets/temp-schedule-a/' +
                        uploadedFilename + '"></iframe>';

                document.getElementById('displayUploadedScheduleA').innerHTML = html;
                document.getElementById('uploadedFilename').value = uploadedFilename;

                } else if (obj.code == 0){
                    swal({
                      title: "Failed!",
                      text: obj.msg,
                      icon: "warning",
                    });
                } else {
                    swal({
                      title: "Failed!",
                      text: "Exception Occured!!!",
                      icon: "warning",
                    });
                }
            }
        }); 
    });  
</script>