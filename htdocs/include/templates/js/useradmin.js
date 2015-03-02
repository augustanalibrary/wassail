/* This file contains all the unique Javascript used in useradmin.tpl */

$(document).ready(function(){
		    
		    /****************/
		    /* Delete popup */
		    $(".delete-account").click(function(){
						 var confirmDelete = confirm("Are you sure you want to delete this account?  This will not remove any data they have entered, just permanently remove this account.\n\nThe delete action is permanent and may not be reversed.");
						 return confirmDelete;
					       });

		    
		    /******************/
		    /* Password popup */
		    $(".password-button").click(function(){
						  var account = $(this).attr('id').substring(8);
						  $("#password-account-field").val(account);
						  $("#password-account").text(account);
						  makeVisible('password-form');
						  $("#password-field").focus();
						});

		    /*******************/
		    /* Password verify */
		    $("#password-submit").click(function(){
						  if($("#password-field").val() != $("#confirm_password-field").val())
						  {
						    alert("Passwords don't match");
						    return false;
						  }
						  if($("#password-field").val().length == 0)
						  {
						    alert("Passwords must be entered");
						    return false;
						  }
						});

		    /*******************/
		    /* Password cancel */
		    $(".action-cancel").click(hideMask);
		    

		    /**********/
		    /* Rights */
		    $(".radio").click(function(){
					var right = $(this).attr('name');
					var account = $(this).attr('value');
					var elementChecked = $(this).attr('checked');
					var continueAction = true;


					if(right == 'write_unconditional')
					{
					  if(elementChecked)
					    continueAction = confirm("This right will allow this user to change question and answer text even after they've been asked.\n\nGrant this right?");
					}
					else if(right == 'help')
					{
					  if(elementChecked)
					    continueAction = confirm("This right will allow this user to modify the system-wide help screens.\n\nGrant this right?");
					}
					else if(right == 'account')
					{
					  if(elementChecked)
					    continueAction = confirm("This right will allow this user to create and modify instances and accounts.\n\nTHIS IS A VERY POWERFUL PRIVILEGE!!\n\nGrant this right?");
					}


					if(continueAction)
					{
					  $("#right-feedback")
					    .html('Adding "'+right+'" right to user "'+account+'"<br /><br />Please wait...')
					    .addClass('notice');
					  makeVisible('right-feedback-wrapper');

					  var action = (elementChecked) ? 'grant' : 'revoke'
					  $.ajax({
					        type: "POST",
						url: WEB_PATH+"ajax.saveUserRight.php",
						dataType: "html",
						data: "account="+account+"&right="+right+"&action="+action,
						cache: false,
						error: function(request,textStatus,errorThrown)
						{
						  $("#right-feedback")
						    .addClass("error")
						    .removeClass("notice")
						    .html('Unable to contact server.  Error generated was: "'+textStatus+'"');
						  $("#ajax-feedback-close").css("display","block");
						  $("#right_"+account+"_"+right).attr('checked',false);
						},

						success: function(msg)
						{
						  /* If zero length output, success */
						  if(msg.length != 0)
						  {
						    $("#right-feedback")
						      .addClass("error")
						      .removeClass("notice")
						      .html("Error: "+msg);
						    $("#ajax-feedback-close").css("display","block");
						    $("#right_"+account+"_"+right).attr('checked',false);
						  }
						  else
						  {
						    var message = (elementChecked) ? 'Right granted' : 'Right revoked';

						    $("#right-feedback")
						      .addClass("success")
						      .removeClass("notice")
						      .text(message);
						    setTimeout(hideMask,1000);
						  }
						}
					    });
					}// if the action is to continue

					if(!continueAction)
					  return false;
					return true;
				      });//if .radio is clicked



		    /*****************/
		    /* User addition */
		    $(".user-add").click(function(){
					   var id = $(this).attr('id').substring(9);
					   var name = $("#instance_"+id+"_name").text();
					   $("#new-user-instance-id").val(id);
					   $("#new-user-instance-name").text(name);
					   makeVisible("new-user-wrapper");
					 });
		    /* When the new username is being entered, check to see if it already exists */
		    $("#new-user-username").keyup(function(){
						    $.ajax({
						          type: "GET",
							  url: WEB_PATH+"ajax.checkUsername.php",
							  data: "username="+$(this).val(),
							  cache: false,
							  success: function(feedback,status){
							  if(feedback == -1)
							    $("#username-status").attr({src: 'include/templates/images/bullet_red.png', className: 'invalid'});
							  else if(feedback == 1)
							    $("#username-status").attr({src: 'include/templates/images/bullet_green.png', className: 'valid'});
							}});
						  });
		    $("#create-new-user").click(function(){
						  if($("#new-user-username").val().length == 0)
						  {
						    alert("Username must be entered");
						    return false;
						  }
						  if($("#new-user-password").val().length == 0)
						  {
						    alert("Password must be entered");
						    return false;
						  }
						  if($("#new-user-password").val() != $("#new-user-confirm-password").val())
						  {
						    alert("Passwords don't match");
						    return false;
						  }
						  if($("#username-status").attr('className') == "invalid")
						  {
						    alert("Please enter a valid username.  The username is valid once the light turns green.");
						    return false;
						  }
						});
		    
		    $("#close-new-user").click(function(){
						 $("#new-user-username").val('');
						 hideMask();
					       });


		    /*********************/
		    /* Instance creation */
		    $(".instance-create").click(function(){
						  makeVisible('create-instance-wrapper');
						});
		    $("#new-instance-name").keyup(function(){
						    $.ajax({
						          type: "GET",
							  url: WEB_PATH+"ajax.checkInstanceName.php",
							  data: "name="+$(this).val(),
							  cache: false,
							  success: function(feedback,status){
							  if(feedback == -1)
							    $("#instance-name-status").attr({src: 'include/templates/images/bullet_red.png',className: 'invalid'});
							  if(feedback == 1)
							    $("#instance-name-status").attr({src: 'include/templates/images/bullet_green.png',className: 'valid'});
							}});
						  });
		    $("#close-create-instance").click(function(){
							$("#new-instance-name").val('');
							hideMask();
						      });

		    /*********************/
		    /* Instance renaming */
		    $(".instance_name").hover(
					      function(){
						if($(this).children('.instance_save').hasClass('hidden'))
						  $(this).children('.instance_edit').removeClass('hidden');
					      },
					      function(){
						$(this).children('.instance_edit').addClass('hidden');
					      }
					      );
		    $(".instance_edit").click(function(){
				       var parent = $(this).parent();
				       parent.children('.instance_edit,.instance_display').addClass('hidden');
				       parent.children('.instance_field,.instance_save,.instance_cancel').removeClass('hidden');
				     });
		    $(".instance_cancel").click(function(){
						  var parent = $(this).parent();
						  parent.children('.instance_edit,.instance_display').removeClass('hidden');
						  parent.children('.instance_field,.instance_save,.instance_cancel').addClass('hidden');
						});
		    $(".instance_save").click(function(){
						var parent = $(this).parent();
						var id = parent.children('span.id').text();
						var name = parent.children('.instance_field').val();
						$.ajax({
						      cache:false,
						      data:{id:id,name:name},
						      dataType:'json',
						      error:function(XMLHttpRequest,textStatus,errorThrown){
						      alert('Unable to save instance name due to a request error: '+textStatus);
						    },
						      success:function(data,status){
						      if(data.ok)
						      {
							alert('Instance name saved');
							parent.children('.instance_field,.instance_save,.instance_cancel').addClass('hidden');
							parent.children('.instance_display').text(name).removeClass('hidden');
						      }
						      else
							alert('Unable to save instance name due to a database error: '+data.error);
						    },
						      url:WEB_PATH+'ajax.updateInstanceName.php'
						      });
					      });
		  });//if document is ready
