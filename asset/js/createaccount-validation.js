//username

$(document).ready(function() {
	$('#usernameLoading').hide();
	$('#username').keyup(function(){
	  $('#usernameLoading').show();
      $.post("inc/check-user-name.php", {
        user_name: $('#username').val()
      }, function(response){
        $('#usernameResult').fadeOut();
        setTimeout("finishAjax('usernameResult', '"+escape(response)+"')", 400);
      });
    	return false;
	});
});

function finishAjax(id, response) {
  $('#usernameLoading').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
} //finishAjax
 
//email id
  $(document).ready(function() {
	$('#emailLoading').hide();
	$('#checkEmail').keyup(function(){
	  $('#emailLoading').show();
      $.post("inc/check-email-id.php", {
        email: $('#checkEmail').val()
      }, function(response){
        $('#emailResult').fadeOut();
        setTimeout("finishAjaxEmail('emailResult', '"+escape(response)+"')", 400);
      });
    	return false;
	});
});

function finishAjaxEmail(id, response) {
  $('#emailLoading').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
} //finishAjax
 

//password
  $(document).ready(function() {
	$('#PasswordLoading').hide();
	$('#checkPassword').keyup(function(){
	  $('#PasswordLoading').show();
      $.post("inc/check-password.php", {
        password: $('#checkPassword').val()
      }, function(response){
        $('#PasswordResult').fadeOut();
        setTimeout("finishAjaxPassword('PasswordResult', '"+escape(response)+"')", 400);
      });
    	return false;
	});
});

function finishAjaxPassword(id, response) {
  $('#PasswordLoading').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
} //finishAjax
 




//show password
function show() {
  var a = document.getElementById("checkPassword");
  var b = document.getElementById("EYE");
  if (a.type == "password") {
    a.type = "text";
    b.src = "images/img/waw4z.png";
  } else {
    a.type = "password";
    b.src = "images/img/Oyk1g.png";
  }
}       
     