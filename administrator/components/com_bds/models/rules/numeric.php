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
* Form validator rule for Bds.
*
* @package	Bds
* @subpackage	Form
*/
class JFormRuleNumeric extends BdsClassFormRule
{
	/**
	* Indicates that this class contains special methods (ie: get()).
	*
	* @var boolean
	*/
	public $extended = true;

	/**
	* Unique name for this rule.
	*
	* @var string
	*/
	protected $handler = 'numeric';

	/**
	* The regular expression to use in testing a form field value.
	*
	* @var string
	*/
	protected $regex = '^(\d|-)?(\d|,)*.?\d*$';

	/**
	* create the regex from the given field node.
	*
	* @access	protected
	* @param	JFormField	$field	The form field object.
	*
	* @return	string	The dynamic regex.
	*/
	protected function buildRegex($field)
	{
		// Default regex
		$regex = '^-?[0-9]+(\.[0-9]+)?$';

		if (is_object($field) && method_exists($field, 'getAttribute'))
			$numericFormat = $field->getAttribute('numericFormat');
		else if (isset($field['numericFormat']))
			$numericFormat = $field['numericFormat'];

		// numericFormat : precision,scale
		if ($numericFormat)
		{
			$parts = explode(',', $numericFormat);
			$precision = (int)$parts[0];

			$scale = 0;
			if (count($parts) >= 2)
				$scale = (int)$parts[1];

			// Integer part
			$length = max(0, ($precision - $scale));


			//Create regex from numeric format
			$regex = '^-?[0-9]{1,' . $length . '}(\.[0-9]{1,' . $scale . '})?$';
		}

		return $regex;
	}

	/**
	* Use this function to customize your own javascript rule.
	* $this->regex must be null if you want to customize here.
	*
	* @access	public
	* @param	JFormField	$field	The form field object.
	*
	* @return	string	A JSON string representing the javascript rules validation.
	*/
	public function getJsonRule($field)
	{
		//Create regex from numeric format
		$regex = $this->buildRegex($field);

		$values = array(
			"#regex" => 'new RegExp("' . $regex . '", \'i\')'
		);


		if ($msgIncorrect = $field->getAttribute('msg-incorrect'))
			$alertText = JText::_($msgIncorrect);

		else if ($numericFormat = $field->getAttribute('numericFormat'))
		{
			$parts = explode(',', $numericFormat);
			$precision = (int)$parts[0];

			$scale = 0;
			if (count($parts) >= 2)
				$scale = (int)$parts[1];

			// Integer part
			$length = max(0, ($precision - $scale));

			// Error message with the format description
			$alertText = JText::sprintf('BDS_ERROR_INCORRECT_FORMAT_EXPECTED_DIGITS_MAX_DECIMALS_MAX', $length, $scale);
		}
		else
			// Fallback default error message for all numeric types
			$alertText = JText::sprintf('BDS_ERROR_EXPECTED_NUMERIC_FORMAT');


		$values["alertText"] = LI_PREFIX . $alertText;


		$json = BdsHelperHtmlValidator::jsonFromArray($values);
		return "{" . LN . $json . LN . "}";
	}

	/**
	* Method to test the field.
	*
	* @access	public
	* @param	SimpleXMLElement	$element	The JXMLElement object representing the <field /> tag for the form field object.
	* @param	mixed	$value	The form field value to validate.
	* @param	string	$group	The field name group control value. This acts as as an array container for the field.
	* @param	JRegistry	$input	An optional JRegistry object with the entire data set to validate against the entire form.
	* @param	JForm	$form	The form object for which the field is being tested.
	*
	*
	* @since	11.1
	*
	* @return	boolean	True if the value is valid, false otherwise.
	*/
	public function test(SimpleXMLElement $element, $value, $group = null, JRegistry $input = null, JForm $form = null)
	{
		// Common test : Required, Unique
		if (!self::testDefaults($element, $value, $group, $input, $form))
			return false;

		// Dynamic regex
		$this->regex = $this->buildRegex($element);

		// Test the value against the regular expression.
		return parent::test($element, $value, $group, $input, $form);

		return true;
	}


}



