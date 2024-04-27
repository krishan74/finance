<button type="button" class="mr-4 btn btn-primary dropdown-toggle" data-toggle="dropdown">
  Roles
</button>
<div class="dropdown-menu">
<?php 
$roles = $this->session->UserRole;
foreach($roles as $key => $value) {
	echo '<a class="dropdown-item" href="#">' . $value . '</a>';
}
?>
</div>

<span class="mr-4">Welcome "<?php echo $this->session->UserName; ?>"</span>
<a href="<?php echo base_url(); ?>login/signout"><button type="button" class="btn btn-warning mr-4">Sign Out</button></a>