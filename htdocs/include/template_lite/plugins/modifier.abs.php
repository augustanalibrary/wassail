<?PHP

/**
 * template_lite abs modifier plugin
 *
 * Type: modifier
 * Name: abs
 * Purpose: Wrapper for the PHP 'abs' function - returns the absolute value
 * of the passed parameter
 */
function tpl_modifier_abs($int)
{
  return abs($int);
}
?>