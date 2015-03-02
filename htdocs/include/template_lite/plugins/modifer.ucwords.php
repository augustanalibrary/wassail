<?PHP
  /**
   * template_lite string padding modifier plugin
   *
   * Type:    modifier
   * Name:    ucwords
   * Purpose: To uppercase the first character of each word.  This is a wrapper
   *          for the php function "ucwords"
   *          See: http://www.php.net/ucwords for function documentation
   *
   * Input:
   *          - string: input text
   * Author: Dylan Anderson
   */

function tpl_modifier_ucwords($string)
{
  return ucwords($string);
}

?>
  