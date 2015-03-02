$(document).ready(function(){
		    /* Tabs */
		    $("#tabs ul li a").click(function(){
					       $("#tabs ul li").removeClass('active');
					       $(this).parent().addClass('active');
					       var target = $(this).attr('id').substring(4);
					       $(".panel").addClass('hidden');
					       $("#panel-"+target).removeClass('hidden');
					       $(this).blur();
				       });

		    /* "Next" & "Previous" links */
		    $(".next").click(function(){
				       $("#tabs ul li.active").next().children('a').click();
				     });
		    $(".previous").click(function(){
					   $("#tabs ul li.active").prev().children('a').click();
					 });

		    /* "Type" panel */
		    $("#panel-type > div").click(function(e){
						   if($("input[@name='type']:checked").val() == 'single' &&
						      $(this).children('input:first').val() == 'multiple' &&
						      $("#correct").val().length > 0)
						     {
						       var changeConfirm = confirm("Changing the question format from 'single' to 'multiple' will remove any 'correct' status an answer may have.\n\nClick 'OK' to continue.");
						       if(changeConfirm)
						       {
							 $(this).children('input:first').attr('checked',true);
							 setupCorrectness();
							 summarizeType();
							 summarizeAnswers();
						       }
						     }
						   else
						   {
						     $(this).children('input:first').attr('checked',true);
						     summarizeType();
						     summarizeAnswers();
						   }
						 });
		    
		    /* Note: the Text portion is updated by listenForEditorChanges.  That function is set as an event listener
		       in the tinyMCE.init() call in header.popup.tpl
		    */

		    /* Category panel */
		    $("#categories").change(function(){
					      if($("#categories option:selected").length > 1)
						$("#categories option:first").attr({selected:false});
					      summarizeCategories()
						});

		    /* Tags panel */
		    $("#tags").keyup(summarizeTags).change(summarizeTags);

		    /* "Answer" panel */
		    $("#tab-answers").click(setupCorrectness);

		    $("#add-answer").click(function(){
					     if($("#new-answer-text").val().length == 0)
					       alert('Please enter some answer text.');
					     else
					     {
					       addAnswer($("#new-answer-text").val());
					       $('#new-answer-text').val('');
					     }
					     summarizeAnswers();
					   });
		    $("#likert").change(function(){
					  var likertVal = $(this).val();
					  if(likertVal != -1)
					  {
					    for(var answer_key in likert[likertVal])
					    {
					      addAnswer(likert[likertVal][answer_key]);
					    }
					    $(this).val(-1);
					  }
					  summarizeAnswers();
					});
		    $("#common_answers").change(function(){
						  addAnswer($("#common_answers option:selected").text());
						  $(this).val(-1);
						  summarizeAnswers();
						});
			$("#qualitative-opt-out").change(function(){
				if($('option:selected',$(this)).val() != -1)
				{
					$("#qualitative-opt-out-text").val($('option:selected',$(this)).text());
					$(this).val(-1);
					summarizeAnswers();
				}
			});
			$("#qualitative-opt-out-text").keyup(summarizeAnswers).blur(summarizeAnswers);

		    $(".answer-delete").click(function(){
			      /* If this is the last element in the list, remove the list */
						if($(this).parent().parent().children('li').length == 1)
						    $(this).parent().parent().remove();
						/* Otherwise, just remove the element */
						else
						    $(this).parent().remove();

						summarizeAnswers()
					      });
		       
		    $(".status").click(function(){
					 if($(this).hasClass('incorrect'))
					 {
					   $("#correct").val($(this).next('input.answer_ids[]').val());
					   $("img.correct").attr('src','include/templates/images/check-grey.png').removeClass('correct').addClass('incorrect');
					   $(this).attr({src:'include/templates/images/check.png',className:'correct clickable'});
					 }
					 else
					 {
					    $("#correct").val('');
					    $(this).attr({src:'include/templates/images/check-grey.png',className:'incorrect clickable'});
					 }
					 summarizeAnswers();
				       });

		    /* If anything is done to change the list of answers, make it sortable again */
		    $("#tab-answers,#add-answer,#likert,.answer-delete,.status,#common_answers").click(function(){
									    $("#answer-list").sortable({
									      cancel:['input'],
										  stop:summarizeAnswers
										  }
									      );
									  });


		    /* Summary panel */
		    summarizeType();
		    summarizeText();
		    summarizeCategories();
		    summarizeTags();
		    summarizeAnswers();
		    setupCorrectness();
		    

		    /* Links in the various error messages */
		    $(".no-type-fix").click(function(){
					      $("#tab-type").click();
					    });
		    $(".no-text-fix").click(function(){
					      $("#tab-text").click();
					    });
		    $(".no-answer-fix").click(function(){
						$("#tab-answers").click();
					      });

		    $("#cancel").click(function(){
					 window.close();
					 return false;
				       });
		    

		    /* Stop a bug in the tooltip library from squawking */
		    $('div').Tooltip();

		    
		    /* TESTING */
		    //$("#tab-summary").click();
		  });


/*****
 * Function: listenForEditorChanges()
 * Purpose: To listen for all events fired by tinyMCE.  Whenever a keyup,blur,click, or change event
 * is fired by tinyMCE, summarizeText() is called.  This has the effect of duplicating what is visible in the editor,
 * in the summary field
 */
function listenForEditorChanges(e)
{
  if(e.type == 'keyup' || e.type == 'blur' || e.type == 'click' || e.type == 'change')
    summarizeText();
}

/**********
 * Functions: summarize*()
 * Purpose: To update the summary panel with the appropriate information
 * This logic is put in functions to reduce duplication of code, as these functions
 * need to be called on page load and when anything is changed
 *
 * summarizeButtons() is unique in that it makes the forms submission possible if typeOK, textOK, and answersOK are
 * all true, and impossible if any of them are false.
 */

var typeOK = false;
var textOK = false;
var answersOK = false;
function summarizeType()
{
  /* Display the question type text if one is chosen, an error message if one is not */
  if($("input[@name=type]:checked").length == 0)
  {
    $("#summary-type").html('').prepend($("#type-error-holder > div").clone(true));
    typeOK = false;
  }
  else
  {
    $("#summary-type").html($("input[@name=type]:checked + div").html());
    typeOK = true;
  }

  summarizeButtons();
  $('div').Tooltip();
}

function summarizeText()
{
  /* If tinyMCE is loaded, get the text from there */
  if(tinyMCE.selectedInstance)
  {
    var editorContents = tinyMCE.selectedInstance.getHTML();

    if(editorContents.length > 0)
    {
      $("#summary-text").html(editorContents);
      textOK = true;
    }
    else
    {
      textOK = false;
      $("#summary-text").html('').prepend($("#text-error-holder > div").clone(true));
    }
  }
		    
  /* Otherwise, get the text from the original textarea */
  else if ($("#editor-area").html().length == 0)
  {

    $("#summary-text").html('').prepend($("#text-error-holder > div").clone(true));
    textOK = false;
  }
  else
  {
    textOK = true;
    $("#summary-text").html($("#editor-area").text());
  }

  summarizeButtons();
  $('div').Tooltip();
}

function summarizeCategories()
{
  $("#summary-categories").html('');
  $("#categories option:selected").each(function(){
					  $("#summary-categories").append($(this).text()).append('<br />');
					  // $("#summary-categories").html($("#summary-categories").html() + $(this).text() + '<br />');
					});
}

function summarizeTags()
{
	var tags = $("#tags").val();
	tags = tags.length ? tags.toLowerCase() : 'NONE';
  $("#summary-tags").text(tags);
}

function summarizeAnswers()
{
  $("#summary-answers").html('');

  if($("input[name=type]:checked").val() && $("input[name=type]:checked").val().search('qualitative') != -1)
  {
		var opt_out_text = $("#qualitative-opt-out-text").val();
		if(opt_out_text.length == 0)
		{
			$("#summary-answers").html("No opt out text provided.  Opt out checkbox will not be shown & question will become required.");
		}
		else
			$("#summary-answers").html('The default "Opt out" text of <em>'+$("#qualitative-opt-out-text").val()+'</em> is currently listed as an optional response to a written response.  Click on the ANSWERS tab to change or delete this.');
		
		$("#panel-answers-inside").addClass('hidden');
    	$("#panel-answers-qualitative-text").removeClass('hidden');
    	answersOK = true;
  }
  else
  {
    $("#panel-answers-inside").removeClass('hidden');
    $("#panel-answers-qualitative-text").addClass('hidden');

    if($("#answer-list li").length > 0)
    {
      $("#summary-answers").html('<ol type = "a"></ol>');
      $("#answer-list li").each(function(){
				  var answer_id = $(this).children('[@name="answer_ids[]"]').val();
				  
				  var endingCode = $(this).children('input.input-field').val() + '</li>';

				  if(answer_id == $("#correct").val())
				    $("#summary-answers ol").append('<li class = "summary-correct">' + endingCode);
				  else
				    $("#summary-answers ol").append('<li>' + endingCode);
				});
      answersOK = true;
    }
    else
    {
      $("#answer-error-holder > div").clone(true).prependTo("#summary-answers");
      answersOK = false;
    }
  }  
  $('div').Tooltip();
  summarizeButtons(); 
}
  
function summarizeButtons()
{
  if(typeOK && textOK && answersOK)
    $("#save").removeClass('hidden');
  else
    $("#save").addClass('hidden');
}


/**********
 * Function: addAnswer()
 *
 * This function is used to handle the addition of an answer to the form
 */

// This variable is used to keep track of the temporary id of the last added answer
var latestAddedAnswer = -1;
function addAnswer(answerText)
{
  /* Create the list if it doesn't exist.  Can't just throw this in the xhtml code as an empty list doesn't validate */
  if($('#answer-list').length == 0)
    $('#answer-list-wrapper').html('<ol type = "a" id="answer-list"></ol>');

  /* Create the element(s) */
  var selection = $("#answer-clone-original")
    .clone(true)
    .appendTo("#answer-list")
    .attr('id','');

  /* Update the answer text field */
  selection.children('input.input-field').val(answerText).attr('name','answers[]');

  /* Update the hidden id field */
  selection.children("input.answer-id").val(latestAddedAnswer--).attr('name','answer_ids[]');

  /* For some reason the Tooltip plugin causes a big fuss, calling Tooltip() again stops that fuss */
  $('input,img').Tooltip();

  setupCorrectness();
}

/*****
 * Function: setupCorrectness()
 * Purpose: To remove all correctness indicators & variables if the question type is 'multiple'
 *   
 */
function setupCorrectness()
{
  if($("input[@name=type]:checked").val() == 'multiple')
  {
    $("#correct").val('');
    $(".correct, .incorrect").attr({src:'include/templates/images/icon.filler.gif'}).removeClass('correct status clickable').addClass('incorrect');

    $(".summary-correct").removeClass('summary-correct');
  }
  else
  {
    $(".incorrect").attr({src:'include/templates/images/check-grey.png'}).addClass('status clickable');
  }
}
