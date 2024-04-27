<?php 
$profilePicPath = FCPATH . 'assets/profile-picture/';

if(empty($this->session->profilePic)) {
    $userProfilePicture = 'default.jpg';
} elseif(!file_exists($profilePicPath . $this->session->profilePic)) {
    $userProfilePicture = 'default.jpg';
} else {
    $userProfilePicture = $this->session->profilePic;  
}
?>

<style>
.btn-password {
	width: 80px;	
}

/* Spinner */

.loader,
.loader:after {
  border-radius: 50%;
  width: 10em;
  height: 10em;
}
.loader {
  margin: 60px auto;
  font-size: 10px;
  position: relative;
  text-indent: -9999em;
  border-top: 1.1em solid rgba(255, 255, 255, 0.2);
  border-right: 1.1em solid rgba(255, 255, 255, 0.2);
  border-bottom: 1.1em solid rgba(255, 255, 255, 0.2);
  border-left: 1.1em solid #ffffff;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation: load8 1.1s infinite linear;
  animation: load8 1.1s infinite linear;
}
@-webkit-keyframes load8 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes load8 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

#loadingModel .modal-dialog {
  position: relative;
  margin-top: 0;
  width:100%;
  height:100%;
  background-color: transparent!important;

}

#loadingModel .modal-content {
  background-color: transparent!important;
  margin-top: 0;
  border: none;
  height:133px;
  width:133px;
  position:absolute;
  top: calc(50% - 166px);
  left: calc(50% - 66px); 
}

</style>
<?php $roles = $this->session->UserRole; ?>
    
<img title="Change Profile Picture" onclick="changeProfilePicture()" class="navImage" src="<?php echo base_url(); ?>assets/profile-picture/<?php echo $userProfilePicture; ?>" style="cursor: pointer">
<?php 
$attributes = array('id' => 'profilePictureForm');
echo form_open('user/changeprofilepicture', $attributes);
?>
<input onchange="changeImageInput()" type="file" id="profilePicture" name="profilePicture" style="display:none">
</form>
<h3>
  <?php 
  if(strlen($this->session->name) > 15) {
    echo trim(substr($this->session->name, 0, 15)) . "...";
  } else {
    echo $this->session->name;
  }
  ?>
</h3>

<!-- Pankaj Code -->
<div class="toggleButtonDiv"><!--pankaj did this! -->
  <a href="#"></a><button type="button" class="btn btn-primary toggleButtonDivIn"data-toggle="collapse" data-target="#dasboardNavigationBar"><i class="fas fa-align-justify"></i></button>
  <a href="<?php echo base_url(); ?>login/signout"><button type="button" title="Sign Out" class="btn btn-warning ml-2"><i class="fas fa-sign-out-alt"></i></button></a>
</div>
<!-- Pankaj Code -->
<nav id="dasboardNavigationBar" class="navbar-collapse collapse">
	<ul>
		<a href="<?php echo base_url(); ?>dashboard"><li><i class="fa fa-universal-access" aria-hidden="true"></i>&nbsp;Dashboard</li></a>

    <?php if (in_array("VetterAccess", $roles) || in_array("ContractAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>
    <a href="<?php echo base_url(); ?>template/completequeue"><li><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;Final Contracts</li></a>
    <?php } ?>

    <?php if (in_array("VetterAccess", $roles) || in_array("ContractAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>
    <a href="<?php echo base_url(); ?>template/alltaskqueue"><li><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;All Task Queue</li></a>
    <?php } ?>

    <?php if (in_array("SigningQueueAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>
    <a href="<?php echo base_url(); ?>template/signingqueue"><li><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;Signing Queue</li></a>
    <?php } ?>

    <?php if (in_array("ProgramLeadAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>
    <a href="<?php echo base_url(); ?>template/programleadqueue"><li title="Program Leads Queue"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;Program Lead</li></a>
    <?php } ?>    

    <?php if (in_array("VetterAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>
    <a href="<?php echo base_url(); ?>template/vetterqueue"><li><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;Vetter Queue</li></a>
    <?php } ?>    


    <?php if (in_array("ContractAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>
    <a href="<?php echo base_url(); ?>template/creatorqueue"><li><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;Creator Queue</li></a>
    <?php } ?>    


    <?php if (in_array("VetterAccess", $roles) || in_array("ContractAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>

    <a href="<?php echo base_url(); ?>template/draft"><li><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;My Draft</li></a>

    <a href="<?php echo base_url(); ?>client/manage"><li><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;Manage Clients</li></a>

    <a href="<?php echo base_url(); ?>signingauthority/manage"><li><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;Manage Signatory</li></a>

		<a href="<?php echo base_url(); ?>template/create"><li><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbs<a href="<?php echo base_url(); ?>template/create"><li><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Create Contract</li></a>&nbsp;Create Contract</li></a>
   
    <a href="<?php echo base_url(); ?>contract/summary"><li><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbs<a href="<?php echo base_url(); ?>contract/summary"><li><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Contract Summary</li></a>&nbsp;Contract Summary</li></a>


    <?php } if(in_array("UserAccess", $roles) || in_array("SuperAdmin", $roles)) { ?>

    <a href="<?php echo base_url(); ?>user/manage"><li><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;Manage Users</li></a>

    <?php } ?>

		<li id="resetYourPassword"><i class="fa fa-unlock" aria-hidden="true"></i>&nbsp;Change Password</li>

		<a href="<?php echo base_url(); ?>login/signout"><li><i class="fas fa-sign-out-alt"></i>&nbsp;Sign Out</li></a>
	</ul>
</nav>

<!-- The Modal -->
<div class="modal" id="loadingModel">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row text-left">
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <div class="loader">Loading...</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal" id="resetYourPasswordModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Change Your Password</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div id="resetYourPasswordModal" class="modal-body">
        <div class="row text-left">
        	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        		<form id="changePasswordForm">
        		<label>Old Password</label>
        		<input type="password" name="oldPassword" id="oldPassword" class="form-control">
        		<label class="mt-4">New Password</label>
        		<input type="password" name="newPassword" id="newPassword" class="form-control">
        		<label class="mt-4">Confirm Password</label>
        		<input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
        		</form>
        	</div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      	<button type="button" id="changeYourPasswordBtn" class="btn btn-warning btn-password">Change</button>
        <button type="button" class="btn btn-danger btn-password" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>