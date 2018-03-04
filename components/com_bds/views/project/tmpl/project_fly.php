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



?>

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
	<div class="control-group field-alias">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_ALIAS" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => 'alias',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-gallery">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_GALLERY" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => 'gallery',
				'dataObject' => $this->item
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
    <div class="control-group field-_sub_location_title">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_SUB_LOCATION" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => '_sub_location_title',
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
	<div class="control-group field-price_min">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_PRICE_MIN" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.int', array(
				'dataKey' => 'price_min',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-price_max">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_PRICE_MAX" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.int', array(
				'dataKey' => 'price_max',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-handing_over">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_HANDING_OVER" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.datetime', array(
				'dataKey' => 'handing_over',
				'dataObject' => $this->item,
				'dateFormat' => 'Y-m-d'
			));?>
		</div>
    </div>
	<div class="control-group field-investor">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_INVESTOR" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => 'investor',
				'dataObject' => $this->item
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
	<div class="control-group field-_type_id_title">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_TYPE" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => '_type_id_title',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-total_area">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_TOTAL_AREA" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly.int', array(
				'dataKey' => 'total_area',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-_utility_id_title">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_UTILITY" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => '_utility_id_title',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-model_house">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_MODEL_HOUSE" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => 'model_house',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
	<div class="control-group field-construction_progress">
    	<div class="control-label">
			<label><?php echo JText::_( "BDS_FIELD_CONSTRUCTION_PROGRESS" ); ?></label>
		</div>
		
        <div class="controls">
			<?php echo JDom::_('html.fly', array(
				'dataKey' => 'construction_progress',
				'dataObject' => $this->item
			));?>
		</div>
    </div>
</fieldset>