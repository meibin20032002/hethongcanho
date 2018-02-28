<?php
/**
* @package RSForm! Pro
* @copyright (C) 2007-2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php if ($showFormTitle) { ?>
<div class="componentheading">{global:formtitle}</div>
<?php } ?>
{error}
<?php foreach ($fieldsets as $page_num => $fields) { ?>
<!-- Do not remove this ID, it is used to identify the page so that the pagination script can work correctly -->
<table class="formTableLayout" border="0" id="rsform_{global:formid}_page_<?php echo $page_num; ?>">
<?php 
		$chunks = array_chunk($fields['visible'], 2);
		foreach ($chunks as $chunkFields) {
?>
	<tr>
<?php		foreach ($chunkFields as $i => $field) {
				// handle special hidden fields
				if ($this->getProperty($field['data'], 'LAYOUTHIDDEN', false)) {
					continue;
				}
				$fieldName = $this->getProperty($field['data'], 'NAME');
				
				// retrieve the componentTypeId
				$componentTypeId = $this->getComponentType($field['data']['componentId'], $formId);
				
				// detect if the field is a Captcha Field of any sort
				$captchaField = false;
				if (in_array($componentTypeId, RSFormProHelper::$captchaFields) && !empty($formOptions->RemoveCaptchaLogged)) {
					$captchaField = true;
				}
?>
		<td class="<?php echo ($i == 0 ? 'formTableLeft' : 'formTableRight');?>" valign="top">
		<?php if ($captchaField) { ?>
			{if {global:userid} == "0"}
		<?php } ?>
			<div class="formField rsform-block rsform-block-<?php echo JFilterOutput::stringURLSafe($fieldName);?>"><?php 
			if (!$field['pagebreak']) { ?>
				{<?php echo $fieldName; ?>:caption}<?php echo ($field['required'] ? '<strong class="formRequired">'.$requiredMarker.'</strong>' : '');?><br/>
				<?php } ?>{<?php echo $fieldName; ?>:body}<br/><?php 
			if (!$field['pagebreak']) { ?>
				{<?php echo $fieldName; ?>:validation}
				{<?php echo $fieldName; ?>:description}<br/>
			<?php } ?></div>
			<?php if ($captchaField) { ?>
				{/if}
			<?php } ?>
		</td>
<?php
			} ?>
	</tr>
<?php
		}
		
		if (!empty($fields['hidden'])) {
			foreach ($fields['hidden'] as $field) {
				$fieldName = $this->getProperty($field['data'], 'NAME'); ?>
	{<?php echo $fieldName; ?>:body} 
<?php
			}
		}
?>
</table>
<?php
}