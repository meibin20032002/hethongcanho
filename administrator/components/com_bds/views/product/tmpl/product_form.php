<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V3.1.9   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		
* @package		BDS
* @subpackage	Products
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

<?php $fieldSet = $this->form->getFieldset('product.form');?>
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
            	// Hot
            	$field = $fieldSet['jform_hot'];
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
            	// Category
            	$field = $fieldSet['jform_category_id'];
            	$field->jdomOptions = array(
            		'list' => $this->lists['fk']['category_id']
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
            	// Project
            	$field = $fieldSet['jform_project_id'];
            	$field->jdomOptions = array(
            		'list' => $this->lists['fk']['project_id']
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
            	// Types
            	$field = $fieldSet['jform_types'];
            	$field->jdomOptions = array(
            		'list' => BdsHelperEnum::_('products_types')
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
            	// Who
            	$field = $fieldSet['jform_who'];
            	$field->jdomOptions = array(
            		'list' => BdsHelperEnum::_('products_who')
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
            	$field = $fieldSet['jform_main_location'];
            	$field->jdomOptions = array(
            		'list' => $this->lists['fk']['main_location']
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
            	$field = $fieldSet['jform_sub_location'];
            	$field->jdomOptions = array(
            		'list' => $this->lists['fk']['sub_location']
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
    	// Price
    	$field = $fieldSet['jform_price'];
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
    	// Bedrooms
    	$field = $fieldSet['jform_bedrooms'];
    	$field->jdomOptions = array(
    		'list' => BdsHelperEnum::_('products_bedrooms')
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
    	// Acreage
    	$field = $fieldSet['jform_acreage'];
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
    	// Behind
    	$field = $fieldSet['jform_behind'];
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
    	// Alley
    	$field = $fieldSet['jform_alley'];
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
    	// Direction
    	$field = $fieldSet['jform_direction'];
    	$field->jdomOptions = array(
    		'list' => BdsHelperEnum::_('products_direction')
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
    	// Legal documents
    	$field = $fieldSet['jform_legal_documents'];
    	$field->jdomOptions = array(
    		'list' => BdsHelperEnum::_('products_legal_documents')
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
    	// Characteristics
    	$field = $fieldSet['jform_characteristics'];
    	$field->jdomOptions = array(
    		'list' => BdsHelperEnum::_('products_characteristics')
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
    	// Shipping Payment
    	$field = $fieldSet['jform_shipping_payment'];
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
    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'contact', 'Contact'); ?>
    	<?php
    	// Contact Number
    	$field = $fieldSet['jform_contact_number'];
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
    	// Contact Name
    	$field = $fieldSet['jform_contact_name'];
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
    	// Contact Email
    	$field = $fieldSet['jform_contact_email'];
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
    	// Contact Address
    	$field = $fieldSet['jform_contact_address'];
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