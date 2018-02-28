<?php
/**
* @package RSForm! Pro
* @copyright (C) 2007-2014 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access'); ?>

<div id="rsform_layout_msg" class="alert alert-info">
	<?php echo JText::_('RSFP_CALCULATION_INFO'); ?>
</div>
<br />
<table class="admintable">
	<tr>
		<td>
			<select name="rsfp_total_add" id="rsfp_total_add" size="1" style="margin-bottom:0px;">
				<?php echo JHtml::_('select.options',$this->totalFields); ?>
			</select>
		</td>
		<td> = </td>
		<td>
			<input type="text" name="rsfp_expression" id="rsfp_expression" size="100" class="rs_inp rs_80" value="" data-filter-type="include" data-filter="value" data-delimiter=" " data-placeholders="display" />
		</td>
		<td><button class="btn btn-primary" type="button" onclick="rsfp_add_calculation(<?php echo $this->form->FormId; ?>);"><?php echo JText::_('RSFP_SAVE_THIS_CALCULATION'); ?></button></td>
	</tr>
	<tr>
		<td colspan="4"><hr /></td>
	</tr>
	<tbody id="rsfp_calculations">
		<?php if (!empty($this->calculations)) { ?>
		<?php foreach ($this->calculations as $row) { ?>
		<tr id="calculationRow<?php echo $row->id; ?>">
			<td>
				<select name="calculations[<?php echo $row->id; ?>][total]" size="1" style="margin-bottom:0px;">
					<?php echo JHtml::_('select.options',$this->totalFields,'value','text',$row->total); ?>
				</select>
			</td>
			<td> = </td>
			<td colspan="2">
				<input type="text" name="calculations[<?php echo $row->id; ?>][expression]" id="calculations<?php echo $row->id; ?>expression" size="100" class="rs_inp rs_80" data-filter-type="include" data-filter="value" data-delimiter=" " data-placeholders="display" value="<?php echo $this->escape($row->expression); ?>" />
				<a href="javascript:void(0)" onclick="rsfp_remove_calculation(<?php echo $row->id; ?>);">
					<img src="<?php echo JURI::root(); ?>administrator/components/com_rsform/assets/images/close.png" alt="" />
				</a>
				<input type="hidden" name="calcid[]" value="<?php echo $row->id; ?>" />
				<input type="hidden" name="calorder[]" value="<?php echo $row->ordering; ?>" />
			</td>
		</tr>
		<?php } ?>
		<?php } ?>
	</tbody>
</table>