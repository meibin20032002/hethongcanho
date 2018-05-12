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

<?php $fieldSet = $this->form->getFieldset('post.form');?>
<fieldset class="fieldsform form-horizontal">
    <?php
	// Location
	$field = $fieldSet['jform_main_location'];
	?>
	<div class="col-md-6 <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
            <div class="dropdown location">     
                <input class="main_id" type="hidden" name="jform[main_location]" value="" />
                <input class="sub_id" type="hidden" name="jform[sub_location]" value="" />
                           
    			<div class="input-select main">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <span class="title">Toàn Quốc</span>
                    <i class="fa fa-angle-down right" aria-hidden="true"></i>
                </div>
                <ul class="main_list">
                    <li class="allR" data-id="">Toàn Quốc</li>
                    <?php foreach($this->lists['fk']['main_location'] as $row):?>
                    <li class="ma" data-id="<?php echo $row->id?>"><?php echo $row->title?> <i class="fa fa-angle-right right" aria-hidden="true"></i></li>
                    <?php endforeach;?>
                </ul>
                <ul class="sub_list"></ul>
            </div>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>
    
	<?php
	// Types
	$field = $fieldSet['jform_types'];
    $field->jdomOptions = array(
		'list' => $this->lists['fk']['types']
			);
	?>
	<div class="col-md-6 <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<div class="dropdown types">     
                <input class="main_id" type="hidden" name="jform[types]" value="1" />
                <input class="sub_id" type="hidden" name="jform[category_id]" value="" />
                           
    			<div class="input-select main">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <span class="title">Mua Bán </span>
                    <i class="fa fa-angle-down right" aria-hidden="true"></i>
                </div>
                <ul class="main_list">
                    <?php foreach($this->lists['fk']['types'] as $row):?>
                    <li class="ma" data-id="<?php echo $row->id?>"><?php echo $row->title?> <i class="fa fa-angle-right right" aria-hidden="true"></i></li>
                    <?php endforeach;?>
                </ul>
                <ul class="sub_list"></ul>
            </div>
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
	<div class="col-md-6 <?php echo 'field-' . $field->id . $field->responsive; ?>">
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
	<div class="col-md-6 <?php echo 'field-' . $field->id . $field->responsive; ?>">
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
	<div class="col-md-12 <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
    		<div class="imgListPolicy">
    			<ul id="listImg">
                    <?php 
                    $gallery = $this->model->listTemp();
                    if($gallery):
                    $patfile = '';
                    foreach($gallery as $row):
                    if (file_exists(JPATH_ROOT.DS.$row->upload)) {
                        $patfile = JUri::root().$row->upload;
                        ?>
        				<li>
                            <span class="deleteImg" data-value="1" data-name="<?php echo $row->key?>"></span>
        					<a class="imgUploadView" href="<?php echo JUri::root().$row->upload?>">
                                <img src="<?php echo $patfile?>" width="100%" height="100%" alt="<?php echo $row->upload?>"/>                    
                            </a>
                            <input type="hidden" name="jform[edit][]" value="<?php echo $row->upload?>"/>
        				</li>
    			         <?php
                        }
                    endforeach;
                    endif; 
                    ?>
                </ul>
    		</div>
            
            <div class="uploadButton">
				<a href="#" class="uploadPhotoButton">
                    <span style="position:relative; cursor:pointer"> 
                        <i class="fa fa-camera camera-add-image"></i>
                        <i class="fa fa-plus-circle plus-add-image"></i>
                    </span>
                </a>
				<input type="file" id="files" name="file[]" multiple="" accept=".doc, .docx, .xls, .xlsx, image/*, application/msword, application/msexcel, application/pdf"/>
			</div>
        </div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>

    <?php
	// Title
	$field = $fieldSet['jform_title'];
	?>
	<div class="col-md-6 <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>
    
     <?php
	// Price
	$field = $fieldSet['jform_price'];
	?>
	<div class="col-md-6 <?php echo 'field-' . $field->id . $field->responsive; ?>">
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
	<div class="col-md-12 <?php echo 'field-' . $field->id . $field->responsive; ?>">
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
	<div class="col-md-6 <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>


   	<?php
	// alley
	$field = $fieldSet['jform_alley'];
	?>
	<div class="col-md-6 <?php echo 'field-' . $field->id . $field->responsive; ?>">
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
	<div class="col-md-6 <?php echo 'field-' . $field->id . $field->responsive; ?>">
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
	<div class="col-md-6 <?php echo 'field-' . $field->id . $field->responsive; ?>">
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
	<div class="col-md-6 <?php echo 'field-' . $field->id . $field->responsive; ?>">
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
	<div class="col-md-6 <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(BdsHelperHtmlValidator::loadValidator($field)); ?>

</fieldset>