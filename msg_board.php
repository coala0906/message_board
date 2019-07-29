<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Message Board</title>
<script language="JavaScript" type="text/javascript" src="js/jquery.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.timer.js"></script>
<link href="css/style.css" rel="stylesheet" />
<script type="text/JavaScript">
function postData(){
    var name = $('#name').val();
    var email = $('#email').val();
	var website = $('#website').val();
	var message = $('#message').val();
	var captcha_code = $('#captcha_code').val();
	var dataString = 'name='+ name + '&email=' + email + '&website=' + website + '&message=' + message + '&captcha_code=' + captcha_code;  
    $.ajax({  
    	type: "POST",  
     	url: "post.php",  
    	data: dataString,   
     	success: function(data) {
      		console.log('OK: ' + data);
        },
     	error: function(jqXHR, textStatus, errorThrown) {
        	console.log('Error: ' + data);
     	}
  	});
	return true;
}
 
$(document).ready(function(){  
  $(".button").click(function() {	    
	 if(postData()){
			$('#messages').load("messages.php");
		 };	 
	 return false;
  });  
});
</script>
</head>
<body>
	<div id="stylized" class="myform">
		<form id="form" name="form" action="#" method="post">
			<h1>Post your message</h1>
			<p id="error">Please complete the form below</p>
			<label>Name</label> <input name="name" type="text" id="name" /> <label>Email</label>
			<input name="email" type="text" id="email" /> <label>Website<span
				class="small">yourwebsite.com</span>
			</label> <input name="website" type="text" id="website"
				value="http://" /> <label>Message (Character count: <span id="count">0</span>)
			</label>
			<textarea name="message" id="message"></textarea>
			<label>Security Code <span class="small">Click to refresh</span>
			</label> <a href="#" onclick="refreshCaptcha();"><span id="cap"></span>
			</a> <label>Re-type Security Code <span class="small">(case
					sensitive)</span>
			</label> <input name="captcha_code" type="text" id="captcha_code"
				size="10" maxlength="10" />
			<button type="submit" class="button">Submit</button>
			<div class="spacer"></div>
		</form>
	</div>
	<div style="float: left">
		<div id="messages" class="messages">
			<!-- posted messages display here -->
		</div>
	</div>
</body>
</html>