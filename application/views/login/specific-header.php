
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
				<button class="btn btn-info ml-2" type="button" onclick="reloadFunc()">Reset</button>
				<?php if(!empty(validation_errors()) || !empty($this->session->authentication_error)) { ?>
					<div id="dangerDiv" class="alert alert-danger" role="alert">
					<?php 
						echo validation_errors(); 
						echo $this->session->authentication_error;
						$this->session->unset_userdata('authentication_error');
					?>
					</div>
				<?php } ?>
			</form>
		</div>
	</div>
	<script>
	function reloadFunc() {
		var base_url = "<?php echo base_url() ?>";
		window.location.href = base_url;
	}
	</script>