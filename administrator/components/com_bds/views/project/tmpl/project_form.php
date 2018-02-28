<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V3.1.9   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		
* @package		BDS
* @subpackage	Projects
* @copyright	
* @author		 -  - 
* @license		
*
*             .oooO  Oooo.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


if (!$this->form)
	return;

$fieldSets = $this->form->getFieldsets();
?>

<?php $fieldSet = $this->form->getFieldset('project.form');?>
<fieldset class="fieldsform form-horizontal">

	<?php
	// Title
	$field = $fieldSet['jform_title'];
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Alias
	$field = $fieldSet['jform_alias'];
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Gallery
	$field = $fieldSet['jform_gallery'];
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Type
	$field = $fieldSet['jform_type_id'];
	$field->jdomOptions = array(
		'list' => $this->lists['fk']['type_id']
			);
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Location
	$field = $fieldSet['jform_location_id'];
	$field->jdomOptions = array(
		'list' => $this->lists['fk']['location_id']
			);
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Address
	$field = $fieldSet['jform_address'];
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Price Min
	$field = $fieldSet['jform_price_min'];
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Price Max
	$field = $fieldSet['jform_price_max'];
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Handing over
	$field = $fieldSet['jform_handing_over'];
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Investor
	$field = $fieldSet['jform_investor'];
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Description
	$field = $fieldSet['jform_description'];
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Total area
	$field = $fieldSet['jform_total_area'];
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Utility
	$field = $fieldSet['jform_utility_id'];
	$field->jdomOptions = array(
		'list' => $this->lists['fk']['utility_id']
			);
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Model house
	$field = $fieldSet['jform_model_house'];
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Construction progress
	$field = $fieldSet['jform_construction_progress'];
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Published
	$field = $fieldSet['jform_published'];
	?>
		<?php if (!method_exists($field, 'canView') || $field->canView()): ?>
		<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
			<div class="control-label">
				<?php echo $field->label; ?>
			</div>

		    <div class="controls">
				<?php echo $field->input; ?>
			</div>
		</div>
		<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>
		<?php endif; ?>



	<?php
	// Creation date
	$field = $fieldSet['jform_creation_date'];
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Modification date
	$field = $fieldSet['jform_modification_date'];
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>



	<?php
	// Created By
	$field = $fieldSet['jform_created_by'];
	$field->jdomOptions = array(
		'list' => $this->lists['fk']['created_by']
			);
	?>
		<?php if (!method_exists($field, 'canView') || $field->canView()): ?>
		<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
			<div class="control-label">
				<?php echo $field->label; ?>
			</div>

		    <div class="controls">
				<?php echo $field->input; ?>
			</div>
		</div>
		<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>
		<?php endif; ?>



	<?php
	// Modified by
	$field = $fieldSet['jform_modified_by'];
	$field->jdomOptions = array(
		'list' => $this->lists['fk']['modified_by']
			);
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>

</fieldset>