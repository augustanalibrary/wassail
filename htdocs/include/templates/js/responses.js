/* Load window for CSV import */
$("#csv-import").click(function(){
      window.open(WEB_PATH+"popup.csv_import.php",'importWindow','scrollbars=yes,toolbar=no,menubar=no,resizable=yes,width=500,height=500');
      });

/* Show/hide add response form */
$(document).ready(function(){
      $("#add-form-show").click(function(){
				  makeVisible('add-response');
				});
      $("#add-cancel").click(hideMask);
		  });

/* 'Add new response' form submission */
$("#add-submit").click(function(){
			 terms = document.getElementsByName("term");
			 for(i=0;i<terms.length;i++)
			 {
			   if(terms[i].checked == true)
			     var term = terms[i].value;
			 }

			 types = document.getElementsByName("type");
			 for(i=0;i<types.length;i++)
			 {
			   if(types[i].checked == true)
			     var type = types[i].value;
			 }
			 
			 var template_id = $("#add-template").val();
			 var course = $("#add-course").val();
			 var school_year = $("#add-school-year").val();


			 var url=WEB_PATH+"popup.edit_response.php?template="+template_id+"&course="+course+"&term="+term+"&type="+type+"&school_year="+school_year;
			 window.open(url,'editResponse','toolbars=no,scrollbars=yes,resizable=yes,width=800,height=750');
			 
			 hideMask();
		       });


/* Toggle class of moused-over rows */
$(".real-row").hover(function(){
			     $(this).addClass("hover")},
			   function(){
			     $(this).removeClass("hover")});

/* Load the sub table via AJAX */
var originalImgTag = '';
$(".real-row").click(function(e){
		       /* Don't act if the user has clicked the bin */
		       if($(e.target).hasClass('delete-responses'))
			 return false;
		       var id = $(this).attr('id').substring(3);
		       var childRow = $("#child-"+id);
		       /* set the value of the select in the popup, to this template */
		       $("#add-template").val(id);
		       if(childRow.parent().attr('class') == 'hidden'){
			 /* Hide all "child" rows */
			 $(".child").parent().addClass('hidden');
			 
			 /* show the "child" of the row that was clicked on */
			 childRow.parent().removeClass('hidden');
			 originalImgTag = childRow.html();
			 childRow.load(WEB_PATH+"ajax.responses.template_responses.php?id="+id);
		       }
		       else
		       {
			 childRow.empty();
			 childRow.append(originalImgTag);
			 childRow.parent().addClass('hidden');
		       }
      
		     });


$(".delete-responses").click(function(e){
			       if(!confirm('Are you sure you want to delete ALL the responses for this template?\n\nThe delete action is permanent and may not be reversed.'))
				 return false;

			       var id = $(this).attr('id').substring(7);
			       var clicked = e.target;
			       $.ajax({
				 type: "GET",
				     url: WEB_PATH+"ajax.deleteTemplateResponses.php",
				     data:"id="+id,
				     cache: false,
				     dataType: "json",
				     success: function(feedback){
				     if(feedback.success){
				       alert('Responses deleted');
				       $(clicked).parent().parent().remove();
				       $('child-'+id).parent().remove();
				     }},
				     error: function(XMLHTTPRequest,status,error){
				     alert('Error trying to delete all responses form template: '+error);
				   }});
			     });




/* Parses the DOM & adds listeners.  This can't be called at page load because the DOM changes due to AJAX */
function addAJAXListeners()
{
  $(".response_edit").click(function(){
			      var id = $(this).attr('id');
			      id = id.substring(14);
			      var url=WEB_PATH+"popup.edit_response.php?load="+id;
			      window.open(url,'editResponse','toolbars=no,scrollbars=yes,resizable=yes,width=800,height=750');
			    });
  $(".response_delete").click(function(){
				if(confirm('Are you sure you want to delete this response?\n\nThe delete action is permanent and may not be reversed.'))
				{
				  var id = $(this).attr('id').substring(16);
				  $.ajax({
				    type: "GET",
					url: WEB_PATH+"ajax.deleteResponse.php",
					data: "id="+id,
					cache: false,
					success: function(feedback){
					if(feedback == 1)
					  $("#response-"+id).remove();
					else
					  alert('Error deleting response: '+feedback);
				      },
					error: function(XMLHTTPRequest,status,error){
					alert('Error deleting response: '+error);
				      }
				    });
				}
	});
  $(".responses_print").click(function(){
  	var id = $(this).attr('id'),
  		id_components = id.split('_'),
  		url = WEB_PATH+"popup.print_responses.php?template_id="+id_components[1]+"&course_id="+id_components[2]+"&term_id="+id_components[3]+"&questionnaire_type_id="+id_components[4]+"&school_year="+id_components[5];

  	window.open(url,'printResponses','toolbars=no,scrollbars=yes,resizable=yes,width=800,height=750');  		
  });

  $(".edit_response_properties").click(function(){
  	var id = $(this).attr('id'),
  		ids = id.split('-'),
  		url = WEB_PATH+"popup.edit_response_properties.php?";

  	ids.shift();//remove the "edit_response_properties" element

  	for(var i in ids){
  		url = url + 'id[]='+ids[i]+'&';
  	}

  	window.open(url,'editResponseProperties','toolbars=no,scrollbars=yes,resizable=yes,width=800,height=250');
  });
}

/* Does the deleting of responses for a specific course/term/type/year combination.  Use a function rather than a jQuery declaration, because the element that is clicked to cause this function is loaded by AJAX */

function deleteResponses(clickedElement,template_id,course_id,term_id,type_id,year)
{
  $.ajax({
  cache:false,
      data:{template_id:template_id,course_id:course_id,term_id:term_id,type_id:type_id,year:year},
	type:"GET",
      url:WEB_PATH+"ajax.deleteCombinationResponses.php",
      dataType:'json',
      error:function(xmlhttprequest,textStatus,errorThrown)
      {
	alert('Unable to delete responses.  The error generated was: "'+textStatus+'"');
      },
      success:function(data,textStatus){
      if(!data.success)
	alert('Unable to delete responses.  The error returned was: "'+data.error+'"');
      else
      {
	alert('Responses deleted');
	$(clickedElement).parent().parent().remove();
      }}
    });   
}

function fadeNote(){
	$("#response-added-note").animate({
		  opacity:0},5000,function(){$(this).addClass('hidden').css('opacity',1);});
}
