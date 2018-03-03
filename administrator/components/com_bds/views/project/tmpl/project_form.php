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
<div class="form-inline form-inline-header">

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

</div>

<div class="fieldsform form-horizontal">
<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('Content', true)); ?>
    <div class="row-fluid">
        <div class="span9">
            <div class="form-vertical">
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
             </div>
        </div>
        <div class="span3">
            <div class="form-vertical">
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

            </div>
        </div>
    </div>

	
    <?php echo JHtml::_('bootstrap.endTab'); ?>    
    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'address', 'Address & Price'); ?>

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
        
        <?php
    	// Hits
    	$field = $fieldSet['jform_hits'];
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


    <?php echo JHtml::_('bootstrap.endTab'); ?>    
    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'image', 'Images and Gallery'); ?>
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
    
    <?php echo JHtml::_('bootstrap.endTab'); ?>  
<?php echo JHtml::_('bootstrap.endTabSet'); ?>    
</div>