<?php
/**
* @package RSForm! Pro
* @copyright (C) 2007-2014 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');
$mainframe = JFactory::getApplication();

?>

<table width="100%" class="table table-bordered adminlist" id="dirSubmissionsTable">
	<thead>
		<tr>
			<th></th>
			<th align="center" class="center">
				<label class="checkbox inline" for="dirviewablecheck"><b><?php echo JText::_('RSFP_SUBM_DIR_LISTING'); ?></b> <input type="checkbox" id="dirviewablecheck" onclick="rsfp_SelectAll('dirviewable')" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" /> </label>
			</th>
			<th align="center" class="center">
				<label class="checkbox inline" for="dirsearchablecheck"><b><?php echo JText::_('RSFP_SUBM_DIR_SEARCHABLE'); ?></b><input type="checkbox" id="dirsearchablecheck" onclick="rsfp_SelectAll('dirsearchable')" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" /> </label>
			</th>
			<th align="center" class="center">
				<label class="checkbox inline" for="direditablecheck"><b><?php echo JText::_('RSFP_SUBM_DIR_EDITABLE'); ?></b><input type="checkbox" id="direditablecheck" onclick="rsfp_SelectAll('direditable')" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" /> </label>
			</th>
			<th align="center" class="center">
				<label class="checkbox inline" for="dirindetailscheck"><b><?php echo JText::_('RSFP_SUBM_DIR_IN_DETAILS'); ?></b><input type="checkbox" id="dirindetailscheck" onclick="rsfp_SelectAll('dirindetails')" onchange="rsfp_autogenerate();" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" /> </label>
			</th>
			<th align="center" class="center">
				<label class="checkbox inline" for="dirincsvcheck"><b><?php echo JText::_('RSFP_SUBM_DIR_IN_CSV'); ?></b><input type="checkbox" id="dirincsvcheck" onclick="rsfp_SelectAll('dirincsv')" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" /> </label>
			</th>
		</tr>
	</thead>
	<?php
	foreach ($this->fields as $field) {
	$mainframe->triggerEvent('rsfp_on_b_ManageDirectoriesDecideEditable', array(&$field));

	?>
	<tr>
		<td width="15%" nowrap="nowrap" align="right">
			<?php if ($field->componentId < 0) { ?>
				<?php echo JText::sprintf('RSFP_DIRECTORY_SUBMISSION_HEADER', $field->FieldName); ?>
			<?php } else { ?>
				<?php echo $field->FieldName; ?>
			<?php } ?>
			<input type="hidden" name="dirorder[]" value="<?php echo $field->ordering; ?>" />
			<input type="hidden" name="dircid[]" value="<?php echo $field->FieldId; ?>" />
		</td>
		<td align="center" class="center">
			<input type="checkbox" name="dirviewable[]" <?php echo $field->viewable ? 'checked="checked"' : ''; ?> value="<?php echo $field->FieldId; ?>" />
		</td>
		<td align="center" class="center">
			<input type="checkbox" name="dirsearchable[]" <?php echo $field->searchable ? 'checked="checked"' : ''; ?> value="<?php echo $field->FieldId; ?>" />
		</td>
		<td align="center" class="center">
			<?php
			if ($field->allowEdit)
			{ ?>
			<input type="checkbox" name="direditable[]" <?php echo $field->editable ? 'checked="checked"' : ''; ?> value="<?php echo $field->FieldId; ?>" />
			<?php } ?>
		</td>
		<td align="center" class="center">
			<input type="checkbox" name="dirindetails[]" onchange="rsfp_autogenerate();" <?php echo $field->indetails ? 'checked="checked"' : ''; ?> value="<?php echo $field->FieldId; ?>" />
		</td>
		<td align="center" class="center">
			<input type="checkbox" name="dirincsv[]" <?php echo $field->incsv ? 'checked="checked"' : ''; ?> value="<?php echo $field->FieldId; ?>" />
		</td>
	</tr>
	<?php } ?>
</table>