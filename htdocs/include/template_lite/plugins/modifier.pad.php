<?PHP
  /**
   * template_lite string padding modifier plugin
   *
   * Type:    modifier
   * Name:    pad
   * Purpose: To pad a string to a certain length.  This is a wrapper
   *          for the php function "str_pad"
   *          See: http://www.php.net/str_pad for function documentation
   *
   * Input:
   *          - string: input text
   *          - length: string length to pad to
   *          - pad_string: string to pad with
   *          - pad_type: type of padding to do
   *                      "left", "right", "both" map to STR_PAD_LEFT,
   *                      STR_PAD_RIGHT, and STR_PAD_BOTH respectively
   *
   * Author: Dylan Anderson
   */

function tpl_modifier_pad($string,$length,$pad_string = ' ',$pad_type='right')
{
  switch($pad_type)
  {
    case "left":
      $pad_type = STR_PAD_LEFT;
      break;
    case "both":
      $pad_type = STR_PAD_BOTH;
      break;
    default:
      $pad_type = STR_PAD_RIGHT;
      break;
  }
  return(str_pad($string,$length,$pad_string,$pad_type));
}

?>
  