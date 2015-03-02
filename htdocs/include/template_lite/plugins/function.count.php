<?php
  /**
   * template_lite count plugin
   *
   * Type:        function
   * Name:        count
   * Purpose:     Run the parameter through PHP's count() function
   * Parameters:  To use this function in a template, pass this function a "target" parameter
   */
function tpl_function_count($params,&$tpl)
{
  extract($params);
  return count($target);
}
?>