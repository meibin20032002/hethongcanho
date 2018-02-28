<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V3.1.9   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		
* @package		BDS
* @subpackage	BDS
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



/**
* Form field for Bds.
*
* @package	Bds
* @subpackage	Form
*/
class BdsClassFormFieldModal extends JFormField
{
	/**
	* The modal height in pixels
	*
	* @var integer
	*/
	protected $height = 450;

	/**
	* The modal width in pixels
	*
	* @var integer
	*/
	protected $width = 400;

	/**
	* Method to get the field input markup.
	*
	* @access	protected
	*
	*
	* @since	11.1
	*
	* @return	string	The field input markup.
	*/
	protected function getInput()
	{
		$dom = JDom::getInstance();
		$dom->set('extension', 'com_bds');


		$html =  JDom::_('html.form.input.select.modalpicker', array(
			'dataKey' => $this->id,
			'domName' => $this->name,
			'dataValue' => $this->value,
			'nullLabel' => $this->_nullLabel,
			'title' => $this->_title,

			'width' => $this->width,
			'height' => $this->height,

			'route' => array(
				'option' => $this->_option,
				'view' => $this->_view,
				'layout' => 'modal',
				'object' => $this->id

			),

			'tasks' => $this->getTasks(),

		));

		return $html;
	}

	/**
	* Method to extend the buttons in the picker.
	*
	* @access	protected
	*
	*
	* @since	Cook 2.5.8
	*
	* @return	array	An array of tasks
	*/
	protected function getTasks()
	{
		return array();

	}


}



