<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V3.1.9   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		
* @package		BDS
* @subpackage	Categories
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

<?php $fieldSet = $this->form->getFieldset('category.form');?>
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
            	// Sub Category
            	$field = $fieldSet['jform_sub_category'];
            	$field->jdomOptions = array(
            		'list' => $this->lists['fk']['sub_category']
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
    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'image', 'Image & Options'); ?>
    
    	<?php
    	// Image
    	$field = $fieldSet['jform_image'];
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
    <?php echo JHtml::_('bootstrap.endTab'); ?>  
<?php echo JHtml::_('bootstrap.endTabSet'); ?>    
</div>