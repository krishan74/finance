<?php 
function calculateItem($pValue) {
	$value = strlen($pValue);
	
	for($x = 0; $x < $value; $x++){
		if(strpos(md5($pValue), "1")) {
			return TRUE;
		}
	}
}

$rValue = calculateItem($pValue);
if(md5($pValue) != PARAM_VALUE) {
	redirect();
} else {
	$this->session->set_userdata('pValue', 1);
	session_write_close();
}
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/login.css">
</head>
<body>
	<div class="centerDiv">
		<div class="innerDiv w-100">
			<?php echo form_open(); ?>
				<h3>Admin Panel Login</h3>
				<label>User Name</label>
				<input type="text" class="form-control" name="username" id="username">
				<br>
				<label>Password</label>
				<input type="password" class="form-control" name="password" id="password">
				<br>
				<input type="submit" name="submitLogin" class="btn btn-success" value="Login">
			</form>
		</div>
	</div>
