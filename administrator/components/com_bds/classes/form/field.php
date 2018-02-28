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
class BdsClassFormField extends JFormField
{
	/**
	* The literal input HTML.
	*
	* @var string
	*/
	protected $input = null;

	/**
	* The form field dynamic options (JDom legacy).
	*
	* @var array
	*/
	public $jdomOptions = array();

	/**
	* Method to get extended properties of the field.
	*
	* @access	public
	* @param	string	$name	Name of the property.
	*
	* @return	mixed	Field property value.
	*/
	public function __get($name)
	{
		switch ($name)
		{
			case 'format':
			case 'position':
			case 'align':
			case 'responsive':
				return $this->element[$name];
				break;
		}
		return parent::__get($name);
	}

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
		return $this->input;
	}

	/**
	* Method to read an option parameter.
	*
	* @access	protected
	* @param	string	$name	The parameter name.
	* @param	string	$default	Default value.
	* @param	string	$type	Var type for this parameter.
	*
	* @return	mixed	Parameter value.
	*/
	protected function getOption($name, $default = null, $type = null)
	{
		if (!isset($this->element[$name]))
			return $default;

		$elemValue = $this->element[$name];

		switch($type)
		{
			case 'bool':
				$elemValue = (string)$elemValue;
				if (($elemValue == 'true') || ($elemValue == '1'))
					return true;

				if (($elemValue == 'false') || ($elemValue == '0'))
					return false;

				if (!empty($elemValue))
					return true;

				return false;
				break;

			case 'int':
				return (int)$elemValue;
				break;

			default:
				return (string)$elemValue;
				break;
		}
	}


}



