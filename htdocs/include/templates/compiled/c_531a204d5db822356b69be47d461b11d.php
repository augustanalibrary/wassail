<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-22 15:03:45 MDT */ ?>

<div id = "iconbar">
<?php if (! isset ( $this->_vars['hide_legend'] )): ?>
  <div id = "legend">
    <?php if ($this->_vars['icons']['add']): ?>
    <img src = "include/templates/images/add.png" alt = "Add"/> = <?php echo $this->_vars['icons']['add']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['save']): ?>
    <img src = "include/templates/images/disk.png" alt = "Save"/> = <?php echo $this->_vars['icons']['save']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['edit']): ?>
    <img src = "include/templates/images/pencil.png" alt = "Edit"/> = <?php echo $this->_vars['icons']['edit']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['delete']): ?>
    <img src = "include/templates/images/bin.png" alt = "Delete" /> = <?php echo $this->_vars['icons']['delete']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['show']): ?>
    <img src = "include/templates/images/eye.png" alt = "Show" /> = <?php echo $this->_vars['icons']['show']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['hide']): ?>
    <img src = "include/templates/images/eye-closed.png" alt = "Hide" /> = <?php echo $this->_vars['icons']['hide']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['filter']): ?>
    <img src = "include/templates/images/filter.png" alt = "Filter" /> = <?php echo $this->_vars['icons']['filter']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['stop']): ?>
    <img src = "include/templates/images/stop.png" alt = "Stop" /> = <?php echo $this->_vars['icons']['stop']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['user_add']): ?>
    <img src = "include/templates/images/user_add.png" alt = "Add user" /> = <?php echo $this->_vars['icons']['user_add']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['key']): ?>
    <img src = "include/templates/images/password.png" alt = "Password" /> = <?php echo $this->_vars['icons']['key']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['import_csv']): ?>
    <img src = "include/templates/images/page_white_go.png" alt = "Import CSV" /> = <?php echo $this->_vars['icons']['import_csv']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['export_csv']): ?>
    <img src = "include/templates/images/page_excel.png" alt = "Export" /> = <?php echo $this->_vars['icons']['export_csv']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['print']): ?>
    <img src = "include/templates/images/printer.png" alt = "Print" /> = <?php echo $this->_vars['icons']['print']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['copy']): ?>
    <img src = "include/templates/images/page_copy.png" alt = "Copy" /> = <?php echo $this->_vars['icons']['copy']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['webify']): ?>
    <img src = "include/templates/images/application_form_add.png" alt = "Make web form" /> = <?php echo $this->_vars['icons']['webify']; ?>

    <?php endif; ?>
	<?php if ($this->_vars['icons']['webify_edit']): ?>
    <img src = "include/templates/images/application_form_edit.png" alt = "Edit web form" /> = <?php echo $this->_vars['icons']['webify_edit']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['expand']): ?>
    <img src = "include/templates/images/arrow_out.png" alt = "Expand" /> = <?php echo $this->_vars['icons']['expand']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['icons']['shrink']): ?>
    <img src = "include/templates/images/arrow_in.png" alt = "Shrink" /> = <?php echo $this->_vars['icons']['shrink']; ?>

    <?php endif; ?>
	
	<?php if ($this->_vars['icons']['sort']): ?>
    <img src = "include/templates/images/arrow_up.png" alt = "Sort by column" /> = <?php echo $this->_vars['icons']['sort']; ?>

    <?php endif; ?>
	
	<?php if ($this->_vars['icons']['reorder']): ?>
    <img src = "include/templates/images/arrow-up-down.png" alt = "Reorder" /> = <?php echo $this->_vars['icons']['reorder']; ?>

    <?php endif; ?>
	
	<?php if ($this->_vars['icons']['correct']): ?>
    <img src = "include/templates/images/check-grey.png" alt = "Mark as correct" /> = <?php echo $this->_vars['icons']['correct']; ?>

    <?php endif; ?>
	
	<?php if ($this->_vars['icons']['correct_bar']): ?>
	<span style = "background-color:#DDAA33;padding:0 3px;"><?php echo $this->_vars['icons']['correct_bar']; ?>
</span>
	<?php endif; ?>

    <?php if ($this->_vars['icons']['switch']): ?>
        <img src = "include/templates/images/arrow-switch.png" alt = "Switch" /> = <?php echo $this->_vars['icons']['switch']; ?>

    <?php endif; ?>

  </div>
  <img src = "include/templates/images/information.png" alt = "Legend" title = "Click for icon legend" id = "info" />
<?php endif;  if (isset ( $this->_vars['show_print_icon'] )): ?>
  <img src = "include/templates/images/printer.png" alt = "Print" title = "Click to print screen" onclick = "window.print()" />
<?php endif;  if (! isset ( $this->_vars['hide_help'] )): ?>
  <img src = "include/templates/images/help.png" alt = "Help" title = "Click for Help" id = "help" />
 <?php endif; ?>
<script type = "text/javascript">
var page_script_name = '<?php echo $_SERVER['SCRIPT_NAME']; ?>
'.substring(WEB_PATH.length-1);
<?php echo '
$(\'#help\').click(function(){
		   window.open(WEB_PATH+\'help.php?from=\'+page_script_name,\'helpWindow\',\'width=870,height=600,resizable=yes,scrollbars=yes,toolbars=no,status=no\');
		 });
'; ?>

</script>
</div>

