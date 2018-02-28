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

if (!class_exists('BdsHelper'))
	require_once(JPATH_ADMINISTRATOR . '/components/com_bds/helpers/loader.php');


/**
* Form field for Bds.
*
* @package	Bds
* @subpackage	Form
*/
class JFormFieldCksearch extends BdsClassFormField
{
	/**
	* The form field type.
	*
	* @var string
	*/
	public $type = 'cksearch';

	/**
	* Method to get the field input markup.
	*
	* @access	public
	*
	*
	* @since	11.1
	*
	* @return	string	The field input markup.
	*/
	public function getInput()
	{

		$this->input = JDom::_('html.form.input.search', array_merge(array(
				'dataKey' => $this->getOption('name'),
				'domClass' => $this->getOption('class'),
				'domId' => $this->id,
				'domName' => $this->name,
				'dataValue' => $this->value,
				'label' => JText::_($this->getOption('placeholder',  $this->getOption('label'))),
				'placeholder' => $this->getOption('placeholder'),
				'prefix' => $this->getOption('prefix'),
				'responsive' => $this->getOption('responsive'),
				'size' => $this->getOption('size'),
				'suffix' => $this->getOption('suffix')
			), $this->jdomOptions));

		return parent::getInput();
	}


}



