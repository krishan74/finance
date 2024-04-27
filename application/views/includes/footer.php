</body>
</html>
<script>
$( document ).ready(function() {
  
	$(document).on('touchstart click', '#resetYourPassword', function(event){
		$('#resetYourPasswordModal').modal('show');
	});

	$(document).on('touchstart click', '#changeYourPasswordBtn', function(event){
		
		var oldPassword = document.getElementById('oldPassword').value;
		var newPassword = document.getElementById('newPassword').value;
		var confirmPassword = document.getElementById('confirmPassword').value;

		if(oldPassword == "" || newPassword == "" || confirmPassword == "") {
            swal({
              title: "Error Occured!",
              text: "All Fields are Mandatory!",
              icon: "warning",
            });
            return false;			
		}

		if(newPassword != confirmPassword) {
            swal({
              title: "Error Occured!",
              text: "New Password and Confirm Password doesn't match!",
              icon: "warning",
            });
            return false;			
		}

        var form = document.getElementById("changePasswordForm");
        var formData = new FormData(form);

		$.ajax({
	        url: "<?php echo base_url(); ?>" + "user/changepassword",
	        data: formData,
	        type: 'POST',
	        contentType: false, 
	        processData: false, 
	        success : function(data){

                var obj = JSON.parse(data);

                if(obj.code == 1) {
                    swal({
                      title: "Success!",
                      text: obj.msg,
                      icon: "success",
                    }); 

                    setTimeout(function(){ 
                    	window.location.href = '<?php echo base_url() ?>' + 'login/signout'; 
                    }, 3000);
  
                } else {
                    swal({
                      title: "Failed!",
                      text: obj.msg,
                      icon: "warning",
                    });
                }
	        }
	    });             
	});
}); 
</script>

<script>
function changeProfilePicture() {
    $('#profilePicture').trigger('click');
}

function changeImageInput() {
    var filename = document.getElementById('profilePicture').value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    
    if(!allowedExtensions.exec(filename)){
        swal({
          title: "Failed!",
          text: "Please upload an image file.",
          icon: "warning",
        });
        document.getElementById('profilePicture').value = "";
        return false;
    }

    var form = document.getElementById("profilePictureForm");
    var formData = new FormData(form);

    $.ajax({
          url: "<?php echo base_url(); ?>" + "user/changeprofilepicture",
          data: formData,
          type: 'POST',
          contentType: false,
          cache: false,
          processData:false,
          success : function(data){
            var obj = JSON.parse(data);
            if(obj.code == 1) {
              location.reload();
            } else {
                swal({
                  title: "Failed!",
                  text: "Failed to Change Image",
                  icon: "warning",
                });
            }
          }
      });

}
</script>