<?php
/**
* @package RSForm! Pro
* @copyright (C) 2007-2015 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/fields/jquerycalendar.php';

class RSFormProFieldBootstrap3JqueryCalendar extends RSFormProFieldJqueryCalendar
{
	protected function setFieldOutput($input, $button, $container, $hidden, $layout) {
		if ($layout == 'FLAT') {
			return '<div class="row"><div class="col-md-12">'.$input.'</div>'.'<div class="col-md-12">'.$container.'</div>'.$hidden.'</div>';
		} else {
			return '<div class="row"><div class="col-md-6">'.$input.'</div>'.'<div class="col-md-6">'.$button.'</div>'.$container.$hidden.'</div>';
		}
	}
	
	// @desc All calendars should have a 'rsform-calendar-box' class for easy styling
	//		 Since the calendar is composed of multiple items, we need to differentiate the attributes through the $type parameter
	public function getAttributes($type='input') {
		$attr = parent::getAttributes();
		if (strlen($attr['class'])) {
			$attr['class'] .= ' ';
		}
		
		if ($type == 'input') {
			$attr['class'] .= 'rsform-calendar-box form-control';
			$layout	= $this->getProperty('CALENDARLAYOUT', 'FLAT');
			if ($layout == 'FLAT') {
				$attr['class'] .= ' txtCal';
			}
		} elseif ($type == 'button') {
			$attr['class'] .= 'btnCal rsform-calendar-button btn btn-default';
			if (!empty($attr['onclick'])) {
				$attr['onclick'] .= ' ';
			} else {
				$attr['onclick'] = '';
			}
			
			$attr['onclick'] .= "RSFormPro.jQueryCalendar.showCalendar('".$this->customId."');";
		}
		
		// Check for invalid here so that we can add 'rsform-error'
		if ($this->invalid) {
			$attr['class'] .= ' rsform-error';
		}
		
		return $attr;
	}
}