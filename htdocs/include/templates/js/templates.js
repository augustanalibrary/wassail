$(document).ready(function(){
		    $("#add-template").click(function(){
					       makeVisible('add-template-wrapper');
					     });
		    $("#success-message").animate({opacity:0},5000);

		    $("#add-cancel").click(function(){
					     hideMask();
					     $("#new-template-name").removeClass("input-highlight");
					   });

		    /* Check the add form */
		    $("#add-submit").click(function(){
					     var missingFields = false;
					     
					     if($("#new-template-name").val() == '')
					     {
					       $("#new-template-name").addClass("input-highlight");		  
					       missingFields = true;
					     }
					     else
					       $("#new-template-name").removeClass("input-highlight");
					     
					     if(missingFields)
					     {
					       alert('Please enter a template name');
					       return false;
					     }
					   });
		  });



$(".question-show").click(function(){
      $(this).toggle();
      id = $(this).attr('id').substring(5);
      $("#hide-"+id).toggle();
      $("#questions-"+id)
	.load(WEB_PATH+"ajax.templateQuestions.php",{id:id})
	.removeClass('hidden');
});
$(".question-hide").click(function(){
      $(this).toggle();
      id = $(this).attr('id').substring(5);
      $("#show-"+id).toggle();
      $("#questions-"+id).addClass('hidden');
});

$(".save-icon").click(function(){$("#hidden-save").val($(this).val()).attr('name','save');});
$(".copy-icon").click(function(){$("#hidden-copy").val($(this).val()).attr('name','copy');});
$(".print-icon").click(function(){
			 window.open(WEB_PATH+'popup.create_template_printout.php?id='+$(this).attr('id').substring(6),'printout','width=600,height=200,scrollbars=yes,toolbar=no,resizable=yes,menubar=yes');
      });


$(".delete-icon").click(function(){
	var confirmResult = confirm('Are you sure you want to delete this template?\n\nOnly the template will be deleted - the questions will remain in the system.\n\nThe delete action is permanent and may not be reversed.');
	if(confirmResult)
	  $("#hidden-delete").val($(this).val()).attr('name','delete');
	else
	  return false;
      });
$(".form-icon").click(function(){
      window.open(WEB_PATH+'popup.add_web_form.php?id='+$(this).val(),'addForm',"width=830,height=700,scrollbars=yes,toolbars=no,resizable=yes");
      return false;
});
$(".form-edit-icon").click(function(){
	var value = $(this).val();
	
	$.ajax({
		data:{id:value},
		success:function(data){
			$("#web_form_list").html(data);
			makeVisible('web_form_list_wrapper');
			addEditFormListeners();
		},
		url:WEB_PATH+'ajax.web_form.php'
	});
	
	return false;
});
$("#edit-cancel").click(function(){
	hideMask();
});

$("#filter").bind("click",function(event){
		     $("#filter-title").toggleClass("hidden");
		     $("#filter-field-wrapper").toggleClass("hidden");

		     if($("#filter-title").css('display') != 'none')
		       $(".filter").parent().parent().removeClass('hidden');
		     else
		       $("#filter-field").focus();


		     /* Stop the <a> link from executing */
		     event.stopPropagation();
		     event.preventDefault();
		     return false;
		  });

$("#filter-field").bind("click",function(event){
			  event.stopPropagation();
			  event.preventDefault();
			  return false;
			});
$('#filter-field').keyup(function(){

			   var searchString = $('#filter-field').val();
			   if(searchString.length != 0)
			   {
			     var searchWords = searchString.split(' ');
			     
			     $(".filter").parent().parent().addClass('hidden');
			     $.each(searchWords,function(key,word){
				      $(".filter:contains('"+word+"')").each(function(i){
									       $(this).parent().parent().removeClass('hidden');
									     });
				    });
			   }
			   else
			     $(".filter").parent().parent().removeClass('hidden');
			 });

/* This function is called inline.  The function is defined here to be consistent with all other
 * files that have their JS defined at the end of the file
 */
function newWindow(id)
{
  window.open(WEB_PATH+'popup.edit_template_questions.php?id='+id,'templateWindow','width=800,height=400,resizable=yes,toolbars=no,status=no,scrollbars=yes');
}

function addEditFormListeners()
{
	$("#web_form_list").find('a').click(function(){
		var rel = $(this).attr('rel');
		
		window.open(WEB_PATH+'popup.edit_web_form.php?id='+rel,'addForm',"width=830,height=700,scrollbars=yes,toolbars=no,resizable=yes");
		
		hideMask();
		return false;
	});
}
