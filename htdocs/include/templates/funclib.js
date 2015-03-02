$(document).ready(function(){

		    /* Set up the clicking for the info button */
		   $("#info").click(function(){
				      if($("#legend").css("display") == 'none')
					$("#legend").show('fast');
				      else
					$("#legend").hide('fast');
				      return false;
				    });
});

$(function(){
    $('img').Tooltip({
      delay:0

	  });
  });

