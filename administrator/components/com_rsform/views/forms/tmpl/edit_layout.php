<?php
/**
 * @package RSForm! Pro
 * @copyright (C) 2007-2014 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die('Restricted access');

JText::script('RSFP_SHOW_LEGACY_LAYOUTS');
JText::script('RSFP_HIDE_LEGACY_LAYOUTS');
?>
<script type="text/javascript">
	RSFormPro.$(document).ready(function() {
		RSFormPro.$('#rsform_show_legacy_btn').click(function(){
			RSFormPro.$('#rsform_legacy_layouts').toggle();

			if (RSFormPro.$('#rsform_legacy_layouts').is(':visible')) {
				RSFormPro.$(this).text(Joomla.JText._('RSFP_HIDE_LEGACY_LAYOUTS'));
			} else {
				RSFormPro.$(this).text(Joomla.JText._('RSFP_SHOW_LEGACY_LAYOUTS'));
			}
		});
		<?php if (!$this->hasLegacyLayout) { ?>
		RSFormPro.$('#rsform_legacy_layouts').hide();
		<?php } ?>
	});
</script>
<button class="btn btn-mini btn-warning" type="button" id="rsform_show_legacy_btn"><?php echo $this->hasLegacyLayout ? JText::_('RSFP_HIDE_LEGACY_LAYOUTS') : JText::_('RSFP_SHOW_LEGACY_LAYOUTS'); ?></button>
<fieldset id="rsform_legacy_layouts">
	<h3 class="rsfp-legend"><?php echo JText::_('RSFP_CLASSIC_LAYOUTS'); ?></h3>
	<?php foreach ($this->layouts['classicLayouts'] as $layout) { ?>
		<div class="rsform_layout_box">
			<label for="formLayout<?php echo ucfirst($layout); ?>" class="radio">
				<input type="radio" id="formLayout<?php echo ucfirst($layout); ?>" name="FormLayoutName" value="<?php echo $layout; ?>" onclick="saveLayoutName('<?php echo $this->form->FormId; ?>', this.value);" <?php if ($this->form->FormLayoutName == $layout) { ?>checked="checked"<?php } ?> /><?php echo JText::_('RSFP_LAYOUT_'.$layout);?><br/>
			</label>
			<img src="components/com_rsform/assets/images/layouts/<?php echo $layout; ?>.gif" width="175"/>
		</div>
	<?php } ?>
	<?php foreach ($this->layouts['xhtmlLayouts'] as $layout) { ?>
		<div class="rsform_layout_box">
			<label for="formLayout<?php echo ucfirst($layout); ?>" class="radio">
				<input type="radio" id="formLayout<?php echo ucfirst($layout); ?>" name="FormLayoutName" value="<?php echo $layout; ?>" onclick="saveLayoutName('<?php echo $this->form->FormId; ?>', this.value);" <?php if ($this->form->FormLayoutName == $layout) { ?>checked="checked"<?php } ?> /><?php echo JText::_('RSFP_LAYOUT_'.str_replace('-', '_', $layout));?><br/>
			</label>
			<img src="components/com_rsform/assets/images/layouts/<?php echo $layout; ?>.gif" width="175"/>
		</div>
	<?php } ?>
	<span class="rsform_clear_both"></span>
</fieldset>

<fieldset>
	<h3 class="rsfp-legend"><?php echo JText::_('RSFP_HTML5_LAYOUTS'); ?></h3>
	<?php foreach ($this->layouts['html5Layouts'] as $layout) { ?>
		<div class="rsform_layout_box">
			<label for="formLayout<?php echo ucfirst($layout); ?>" class="radio">
				<input type="radio" id="formLayout<?php echo ucfirst($layout); ?>" name="FormLayoutName" value="<?php echo $layout; ?>" onclick="saveLayoutName('<?php echo $this->form->FormId; ?>', this.value);" <?php if ($this->form->FormLayoutName == $layout) { ?>checked="checked"<?php } ?> /><?php echo JText::_('RSFP_LAYOUT_'.str_replace('-', '_', $layout));?><br/>
			</label>
			<img src="components/com_rsform/assets/images/layouts/<?php echo $layout; ?>.gif" width="175"/><br/>
		</div>
	<?php } ?>
	<span class="rsform_clear_both"></span>
</fieldset>

<fieldset>
	<h3 class="rsfp-legend"><?php echo JText::_('RSFP_FORM_HTML_LAYOUT_OPTIONS'); ?></h3>
	<span class="rsform_clear_both"></span>
	<table border="0">
		<tr>
			<td><label><?php echo JText::_('RSFP_LOAD_LAYOUT_FRAMEWORK'); ?></label></td>
			<td><?php echo $this->renderHTML('select.booleanlist', 'LoadFormLayoutFramework', '', $this->form->LoadFormLayoutFramework); ?></td>
		</tr>
		<tr>
			<td><label><?php echo JText::_('RSFP_AUTOGENERATE_LAYOUT');?></label></td>
			<td><?php echo $this->lists['FormLayoutAutogenerate']; ?></td>
		</tr>
	</table>
</fieldset>

<fieldset>
	<h3 class="rsfp-legend"><?php echo JText::_('RSFP_FORM_HTML_LAYOUT'); ?></h3>
	<button class="btn btn-warning" type="button" onclick="generateLayout('<?php echo $this->form->FormId; ?>', true);"><?php echo JText::_('RSFP_GENERATE_LAYOUT'); ?></button>
	<table width="100%">
		<tr>
			<td valign="top">
				<table width="98%" style="clear:both;">
					<tr>
						<td>
							<textarea rows="20" cols="75" style="width:100%;" class="codemirror-html" name="FormLayout" id="formLayout" <?php echo $this->form->FormLayoutAutogenerate ? 'readonly="readonly"' : '';?>><?php echo $this->escape($this->form->FormLayout); ?></textarea>
						</td>
					</tr>
				</table>
			</td>
			<td valign="top" width="1%" nowrap="nowrap">
				<button class="btn" type="button" onclick="toggleQuickAdd();"><?php echo JText::_('RSFP_TOGGLE_QUICKADD'); ?></button>
				<span class="rsform_clear_both"></span>
				<div id="QuickAdd1">
					<h3><?php echo JText::_('RSFP_QUICK_ADD');?></h3>
					<?php echo JText::_('RSFP_QUICK_ADD_DESC');?><br/><br/>
					<?php foreach($this->quickfields as $field) {
						echo RSFormProHelper::generateQuickAdd($field, 'generate');
					}?>
				</div>
			</td>
		</tr>
	</table>
</fieldset>