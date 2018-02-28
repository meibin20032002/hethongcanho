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
class JFormFieldCkeditor extends BdsClassFormField
{
	/**
	* The form field type.
	*
	* @var string
	*/
	public $type = 'ckeditor';

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

		$this->input = JDom::_('html.form.input.editor', array_merge(array(
				'dataKey' => $this->getOption('name'),
				'domClass' => $this->getOption('class'),
				'domId' => $this->id,
				'domName' => $this->name,
				'cols' => $this->getOption('cols'),
				'dataValue' => $this->value,
				'height' => $this->getOption('height'),
				'prefix' => $this->getOption('prefix'),
				'responsive' => $this->getOption('responsive'),
				'rows' => $this->getOption('rows'),
				'suffix' => $this->getOption('suffix'),
				'width' => $this->getOption('width')
			), $this->jdomOptions));

		return parent::getInput();
	}


}



