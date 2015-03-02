<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-05-05 09:06:58 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<p>
	Updating properties for <?php echo $this->_vars['id_count']; ?>
 response(s)
</p>
<br />
<?php if ($this->_vars['success']): ?>
	<div class = "success">
		Properties updated.  Close this popup and reload the main window to see the changes.
	</div>
<?php endif; ?>
<form method = "post" action = "">
	<table>
		<thead>
			<tr>
				<th></th>
				<th>Existing</th>
				<th>New</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th style = "text-align:right">
					Template:
				</th>
				<td>
					<?php echo $this->_vars['template_name']; ?>

				</td>
				<td>
					<select name = "template_id">
						<?php if (count((array)$this->_vars['all_templates'])): foreach ((array)$this->_vars['all_templates'] as $this->_vars['index'] => $this->_vars['Template']): ?>
							<option value = "<?php echo $this->_vars['Template']['id']; ?>
" <?php if ($this->_vars['Template']['id'] == $this->_vars['template_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_vars['Template']['name']; ?>
</option>
						<?php endforeach; endif; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan = "3">
					<div class="notice">
						<small>
							Changing the template could result in <strong>lost or incomplete data</strong>.  To ensure this doesn't happen, only change the template to one with identical questions.
						</small>
					</div>
				</td>
			</tr>
			<tr>
				<th style = "text-align:right">
					Course:
				</th>
				<td>
					<?php echo $this->_vars['course_name']; ?>

				</td>
				<td>
					<select name = "course_id">
						<?php if (count((array)$this->_vars['all_courses'])): foreach ((array)$this->_vars['all_courses'] as $this->_vars['index'] => $this->_vars['Course']): ?>
							<option value = "<?php echo $this->_vars['Course']['id']; ?>
" <?php if ($this->_vars['Course']['id'] == $this->_vars['course_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_vars['Course']['name']; ?>
</option>
						<?php endforeach; endif; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th style = "text-align:right">
					Term:
				</th>
				<td>
					<?php echo $this->_vars['term']; ?>

				</td>
				<td>
					<select name = "term_id">
						<?php if (count((array)$this->_vars['all_terms'])): foreach ((array)$this->_vars['all_terms'] as $this->_vars['index'] => $this->_vars['term_name']): ?>
							<option value = "<?php echo $this->_vars['index']; ?>
" <?php if ($this->_vars['index'] == $this->_vars['term_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_vars['term_name']; ?>
</option>
						<?php endforeach; endif; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th style = "text-align:right">
					Type:
				</th>
				<td>
					<?php echo $this->_vars['type']; ?>

				</td>
				<td>
					<select name = "type_id">
						<?php if (count((array)$this->_vars['all_types'])): foreach ((array)$this->_vars['all_types'] as $this->_vars['index'] => $this->_vars['type_name']): ?>
							<option value = "<?php echo $this->_vars['index']; ?>
" <?php if ($this->_vars['index'] == $this->_vars['type_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_vars['type_name']; ?>
</option>
						<?php endforeach; endif; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th style = "text-align:right">
					Year:
				</th>
				<td>
					<?php echo $this->_vars['year']; ?>

				</td>
				<td>
					<select name = "year">
						<?php if (count((array)$this->_vars['years'])): foreach ((array)$this->_vars['years'] as $this->_vars['index'] => $this->_vars['curr_year']): ?>
							<option value = "<?php echo $this->_vars['curr_year']; ?>
" <?php if ($this->_vars['curr_year'] == $this->_vars['year']): ?>selected="selected"<?php endif; ?>><?php echo $this->_vars['curr_year']; ?>
</option>
						<?php endforeach; endif; ?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<input type = "submit" class = "submit" name = "submit" value = "Update properties" />
	<input type = "reset" class = "submit" name = "cancel" value = "Cancel" onclick = "window.close()" />
</form>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>