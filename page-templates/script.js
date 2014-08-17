"use strict";

function toggleContent(id, fullText) {
	var content = document.getElementById(id);
	content.style.display == "block" ? content.style.display = "none" : content.style.display = "block";
}

//From w3schools for email validation
function validateRegister() {
	var x=document.forms["registerForm"]["username"].value;
  	var emailpattern = /([\w\-]+\@[\w\-]+\.[\w\-]+)/;
  	var errors = "";
  	if (!x.match(emailpattern)) {
  		 errors += "**Not a valid e-mail address**\n";
  	}
  	var y=document.forms["registerForm"]["first"].value;
  	var z=document.forms["registerForm"]["last"].value;
  	var namepatt = /^[a-zA-Z ]*$/;
  	if(!y.match(namepatt)) {
  		errors += "**Only letters and white space allowed in first name**\n";
  	}		
  	if(!z.match(namepatt)) {
  		errors += "**Only letters and white space allowed in last name**\n";
  	}
  	if(document.forms["registerForm"]["pwd"].value != document.forms["registerForm"]["pwd_confirm"].value) {
  		errors += "**Your passwords don't match**\n";
  	}
  	if(errors) {
  		alert("Please fix these error(s):\n" + errors);
  		return false;
  	}

}


function validateLogin() {
  var x=document.forms["loginform"]["username"].value;
  var emailpattern = /([\w\-]+\@[\w\-]+\.[\w\-]+)/;
  var message = "";
  if (!x.match(emailpattern)) {
    message += "**Not a valid e-mail address**\n";
  }
  if (document.forms["loginform"]["pwd"] > 0) {
    message += "**Password cannot be blank**";
  }
  if (message) {
    alert(message);
    return false;
  }
}

function toggleMenu() {
  var content = document.getElementById("userSideMenu");
  content.style.display == "block" ? content.style.display = "none" : content.style.display = "block";
}
//due to time constraints, I won't be implementing the calendar script. The idea of trying to use this over specifying a specific period time for auctions is unnecessary and overcomplicated. Also, I've already implemented an SQL query that uses hardcoded values for auction duration. 

$(document).ready(function() {
    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').on('keyup, change', function() {
    var $group = $(this).closest('.input-group'),
      $addon = $group.find('.input-group-addon'),
      $icon = $addon.find('span'),
      state = false;
            
      if (!$group.data('validate')) {
      state = $(this).val() ? true : false;
    }else if ($group.data('validate') == "email") {
      state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())
    }else if($group.data('validate') == 'phone') {
      state = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test($(this).val())
    }else if ($group.data('validate') == "length") {
      state = $(this).val().length >= $group.data('length') ? true : false;
    }else if ($group.data('validate') == "number") {
      state = !isNaN(parseFloat($(this).val())) && isFinite($(this).val());
    }

    if (state) {
        $addon.removeClass('danger');
        $addon.addClass('success');
        $icon.attr('class', 'glyphicon glyphicon-ok');
    }else{
        $addon.removeClass('success');
        $addon.addClass('danger');
        $icon.attr('class', 'glyphicon glyphicon-remove');
    }
  });
});