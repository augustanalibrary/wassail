/*********
 * This file holds functionality that is used on multiple/all pages.  Any functionality unique to a page is usually stored
 * at the bottom of the template file for that page.
 */
window.feedback_window;

$(document).ready(function(){
    /* Set up the clicking for the info button */
    $("#info").toggle(
    	function(){
			$("#legend").show('fast'); 
		},
		function(){
			$("#legend").hide('fast'); 
		}
	);

   $("#header-hide").toggle(
     function()
     {
       $("#header-hide").text("Show header");
       $("#header").css({fontSize:"9pt",lineHeight:"2em",height:"2em",padding:"0px"});

     },
     function()
     {
       $("#header").css({fontSize:"2.7em",lineHeight:"115px",height:"115px",paddingLeft:"10px",paddingTop:"5px"});
       $("#header-hide").text("Hide header");
     }
     );

  });


/* Attach the tooltip() function to all <input> and <img> that have a 'title' attribute. */
$(function(){
    $('input,img,div,span').Tooltip(
			   {
			   delay:0,
			       track:true,
			       showURL:false
			       }
			   );
  }
);

function hideMask()
{
  $(".action").css("display","none");
  $("#mask").css("display","none");
}

function makeVisible(id)
{
  var offset = (window.pageYOffset) ? window.pageYOffset : document.body.scrollTop;
  offset += 100;


  $("#mask")
    .css("display","block");
  $("#"+id)
    .css("top",offset+"px")
    .css("display","block");
}
