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
$gallery =  json_decode($this->item->gallery);
?>
<h1><?php echo $this->item->title ?></h1>
<p class="title"><?php echo $this->item->address?></p>



<fieldset class="fieldsfly fly-horizontal">

	<div class="control-group field-title">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_TITLE" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => 'title',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-_category_id_title">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_CATEGORY" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => '_category_id_title',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-types">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_TYPES" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.enum', array(
				'dataKey' => 'types',
				'dataObject' => $this->item,
				'labelKey' => 'text',
				'list' => BdsHelperEnum::_('products_types'),
				'listKey' => 'value'
			));?>
		</div>
    </div>
	<div class="control-group field-who">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_WHO" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.enum', array(
				'dataKey' => 'who',
				'dataObject' => $this->item,
				'labelKey' => 'text',
				'list' => BdsHelperEnum::_('products_who'),
				'listKey' => 'value'
			));?>
		</div>
    </div>
	<div class="control-group field-_main_location_title">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_MAIN_LOCATION" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => '_main_location_title',
				'dataObject' => $this->item
			));?>
		</div>
    </div>

	<div class="control-group field-price">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_PRICE" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.int', array(
				'dataKey' => 'price',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-bedrooms">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_BEDROOMS" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.enum', array(
				'dataKey' => 'bedrooms',
				'dataObject' => $this->item,
				'labelKey' => 'text',
				'list' => BdsHelperEnum::_('products_bedrooms'),
				'listKey' => 'value'
			));?>
		</div>
    </div>
	<div class="control-group field-description">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_DESCRIPTION" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => 'description',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-address">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_ADDRESS" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => 'address',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-acreage">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_ACREAGE" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.int', array(
				'dataKey' => 'acreage',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-behind">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_BEHIND" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.int', array(
				'dataKey' => 'behind',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-direction">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_DIRECTION" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.enum', array(
				'dataKey' => 'direction',
				'dataObject' => $this->item,
				'labelKey' => 'text',
				'list' => BdsHelperEnum::_('products_direction'),
				'listKey' => 'value'
			));?>
		</div>
    </div>
	<div class="control-group field-legal_documents">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_LEGAL_DOCUMENTS" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.enum', array(
				'dataKey' => 'legal_documents',
				'dataObject' => $this->item,
				'labelKey' => 'text',
				'list' => BdsHelperEnum::_('products_legal_documents'),
				'listKey' => 'value'
			));?>
		</div>
    </div>
	<div class="control-group field-characteristics">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_CHARACTERISTICS" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.enum', array(
				'dataKey' => 'characteristics',
				'dataObject' => $this->item,
				'labelKey' => 'text',
				'list' => BdsHelperEnum::_('products_characteristics'),
				'listKey' => 'value'
			));?>
		</div>
    </div>
	<div class="control-group field-shipping_payment">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_SHIPPING_PAYMENT" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => 'shipping_payment',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-contact_number">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_CONTACT_NUMBER" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => 'contact_number',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-contact_name">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_CONTACT_NAME" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => 'contact_name',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-contact_email">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_CONTACT_EMAIL" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => 'contact_email',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-contact_address">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_CONTACT_ADDRESS" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => 'contact_address',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-ordering">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_ORDERING" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.int', array(
				'dataKey' => 'ordering',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-published">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_PUBLISHED" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.publish', array(
				'dataKey' => 'published',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-_created_by_name">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_CREATED_BY" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => '_created_by_name',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-_modified_by_name">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_MODIFIED_BY" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => '_modified_by_name',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-creation_date">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_CREATION_DATE" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.datetime', array(
				'dataKey' => 'creation_date',
				'dataObject' => $this->item,
				'dateFormat' => 'Y-m-d H:i'
			));?>
		</div>
    </div>
	<div class="control-group field-modification_date">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_MODIFICATION_DATE" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.datetime', array(
				'dataKey' => 'modification_date',
				'dataObject' => $this->item,
				'dateFormat' => 'Y-m-d H:i'
			));?>
		</div>
    </div>
</fieldset>