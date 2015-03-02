$(document).ready(function(){
		    /* Fade out success message */
		    $("#success-message").animate({
		      opacity:0},5000);

		    $("#add-course").click(function(){
					     makeVisible('add-course-wrapper');
					   });
		    $("#add-course-cancel").click(hideMask);


		    var nameValid = false;
		    var numberValid = false;

		    $("#new-number").keyup(function(){
					     if($(this).val().length > 0)
					       $.ajax({
						     type: "GET",
						     url: WEB_PATH+"ajax.checkCourse.php",
						     data: "type=number&number="+$(this).val(),
						     cache: false,
						     success: function(feedback,status){
						     if(feedback == 1)
						     {
						       $("#new-number-status").attr({src: 'include/templates/images/bullet_green.png',className: 'valid'});
						       if(nameValid)
							 $("#add-course-submit").css('visibility','visible');
						       numberValid = true;
						     }
						     else
						     {
						       $("#new-number-status").attr({src: 'include/templates/images/bullet_red.png',className: 'invalid'});
						       $("#add-course-submit").css('visibility','hidden');
						       numberValid = false;
						     }
						   }
						 });
					     else
					     {
					       $("#new-number-status").attr({src: 'include/templates/images/bullet_red.png',classname: 'invalid'});
					       $("#add-course-submit").css('visibility','hidden');
					       numberValid = false;
					     }
					   });

		    $("#new-name").keyup(function(){
					   if($(this).val().length > 0)
					     $.ajax({
					           type: "GET",
						   url: "ajax.checkCourse.php",
						   data: "type=name&name="+$(this).val(),
						   cache: false,
						   success: function(feedback,status){
						   if(feedback == 1)
						   {
						     $("#new-name-status").attr({src: 'include/templates/images/bullet_green.png',className: 'valid'});
						     nameValid = true;
						     if(numberValid)
						       $("#add-course-submit").css('visibility','visible');
						   }
						   else
						   {
						     $("#new-name-status").attr({src: 'include/templates/images/bullet_red.png',className: 'invalid'});
						     $("#add-course-submit").css('visibility','hidden');
						     nameValid = false;
						   }
						 }
					       });
					   else
					   {
					     $("#new-name-status").attr({src: 'include/templates/images/bullet_red.png',className: 'invalid'});
					     $("#add-course-submit").css('visibility','hidden');
					     nameValid = false;
					   }
					 });
});

/* Check the add form */
$("#add-form").submit(function(){
			var missingFields = false;

			if($("#new-number").val() == '')
			{
			  $("#new-number").addClass("input-highlight");
			  missingFields = 'Course number'
			}
			else
			  $("#new-number").removeClass("input-highlight");
			

			if($("#new-name").val() == '')
			{
			  $("#new-name").addClass("input-highlight");
			  missingFields = (missingFields.length > 0) ? missingFields + " and Course name" : "Course name";
			}
			else
			  $("#new-name").removeClass("input-highlight");

			if(missingFields)
			{
			  alert(missingFields + " must be entered");
			  return false;
			}
});


/* Set a hidden 'id' form variable if one of the submit buttons are clicked.  This is a fix for IE7 not submitting $_POST['edit'] if it's an image */
$(".edit-submitter").click(function(){
	$("#hidden-edit").val($(this).val());
	$("#hidden-edit").attr('name','edit');
});

$(".delete-submitter").click(function(e){
			       var confirmStatus = confirm('Are you sure you want to delete this course?\n\nThe delete action is permanent and may not be reversed.');
			       if(confirmStatus)
			       {
				 $("#hidden-delete").val($(this).val());
				 $("#hidden-delete").attr('name','delete');
			       }
			       else
			       {
				 e.stopPropagation();
				 e.preventDefault();
				 return false;
			       }
			     });
