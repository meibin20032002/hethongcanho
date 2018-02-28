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

defined('LI_PREFIX') or define("LI_PREFIX", '<span class="msg-prefix">• </span>');


/**
* Helper HTML
*
* @package	Bds
* @subpackage	Validator
*/
class BdsHelperHtmlValidator
{
	/**
	* Attach the form.
	*
	* @access	public static
	* @param	string	$suffix	Suffix for special forms.
	*
	* @return	void
	*/
	public static function attachForm($suffix = '_chzn')
	{
		$script = '(function($){'
		.	'$(document).ready(function () {'
		.	'$("#adminForm").validationEngine(\'attach\',{prettySelect:true,useSuffix:"' . $suffix . '"});'
		.	'});'
		.	'})(jQuery);';

		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($script);
	}

	/**
	* Get the JSON object rule for the validator.
	*
	* @access	public static
	* @param	JFormField	$field	Form field.
	* @param	JFormRule	$rule	The validator rule.
	*
	* @return	string	JSON string.
	*/
	public static function getJsonRule($field, $rule)
	{
		if ($rule->regexJs)
			$regex = $rule->regexJs;
		else
		{
			//reformate Regex for javascript
			$regex = $rule->regex;
			$regex = preg_replace("/\\\\/", "\\", $regex);

			$regex = preg_replace("/\\\\s/", " ", $regex);
			$regex = preg_replace("/\\\\d/", "[0-9]", $regex);
		}

		$values = array(
			"#regex" => '/' . $regex . '/' . $rule->modifiers
		);

		if ($msgIncorrect = $field->getAttribute('msg-incorrect'))
			$values["alertText"] = LI_PREFIX . JText::_($msgIncorrect);
		else
			$values["alertText"] = LI_PREFIX . JText::_('BDS_FORMVALIDATOR_INCORRECT_VALUE');

		$json = self::jsonFromArray($values);

		return "{" . LN . $json . LN . "}";
	}

	/**
	* Transform a recursive associative array in JSON string.
	*
	* @access	public static
	* @param	array	$values	Associative array only (can be recursive).
	*
	* @return	string	JSON string.
	*/
	public static function jsonFromArray($values)
	{
		$entries = array();
		foreach($values as $key => $value)
		{
			$q = "'";

			if (is_array($value))
			{
				// ** Recursivity **
				$value = "{" . LN . self::jsonFromArray($value) . LN . "}";
				$q = "";
			}
			else if (substr($key, 0, 1) == '#')
			{
				//Do not require quotes
				$key = substr($key, 1);
				$q = "";
			}

			$entries[] = '"'. $key. '" : '. $q. $value. $q;
		}

		return implode(',' .LN, $entries);
	}

	/**
	* Instance the language script for the validator, and the default validation
	* rules.
	*
	* @access	public static
	*
	* @return	void
	*/
	public static function loadLanguageScript()
	{
		$script = '(function($){' .
				'jQuery.fn.validationEngineLanguage = function(){' .
				'};' .
				'jQuery.validationEngineLanguage = {' .
				'newLang: function(){' .
				'jQuery.validationEngineLanguage.allRules = {' .LN;

		$baseRules = array();

		$baseRules["required"] = array(
			"regex"	=> "none",
			"alertText" => LI_PREFIX . addslashes(JText::_("BDS_FORMVALIDATOR_THIS_FIELD_IS_REQUIRED")),
			"alertTextCheckboxMultiple" => LI_PREFIX . addslashes(JText::_("BDS_FORMVALIDATOR_PLEASE_SELECT_AN_OPTION")),
			"alertTextCheckboxe" => LI_PREFIX . addslashes(JText::_("BDS_FORMVALIDATOR_THIS_CHECKBOX_IS_REQUIRED")),
			"alertTextDateRange" => LI_PREFIX . addslashes(JText::_("BDS_FORMVALIDATOR_BOTH_DATE_RANGE_FIELDS_ARE_REQUIRED"))

		);

		// Default handlers

		$baseRules["numeric"] = array(
			"#regex"	=> '/^[\-\+]?\d+$/',
			"alertText" => LI_PREFIX . addslashes(JText::_("BDS_FORMVALIDATOR_THIS_IS_NOT_A_VALID_INTEGER")),
		);

		$baseRules["integer"] = array(
			"#regex"	=> '/^[\-\+]?\d+$/',
			"alertText" => LI_PREFIX . addslashes(JText::_("BDS_FORMVALIDATOR_THIS_IS_NOT_A_VALID_INTEGER")),
		);


		$baseRules["username"] = array(
			"#regex"	=> '/![\<|\>|\"|\'|\%|\;|\(|\)|\&]/i',
			"alertText" => LI_PREFIX . addslashes(JText::_("BDS_FORMVALIDATOR_THIS_IS_NOT_A_VALID_USERNAME")),
		);


		$baseRules["password"] = array(
			"#regex"	=> '/^\S[\S ]{2,98}\S$/',
			"alertText" => LI_PREFIX . addslashes(JText::_("BDS_FORMVALIDATOR_THIS_IS_NOT_A_VALID_PASSWORD")),
		);

		$baseRules["email"] = array(
			"#regex"	=> '/^[a-zA-Z0-9._-]+(\+[a-zA-Z0-9._-]+)*@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/',
			"alertText" => LI_PREFIX . addslashes(JText::_("BDS_FORMVALIDATOR_THIS_IS_NOT_A_VALID_EMAIL")),
		);



		/* TODO : You can add some rules here
		 * These rules are executed ONLY in client side (javascript)
		 * If you want both JS and PHP validation, create a rule file
		 */

		$script .= self::jsonFromArray($baseRules);

		$script .= LN. '};}};' .
				'jQuery.validationEngineLanguage.newLang();' .
				'})(jQuery);';


		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($script);
	}

	/**
	* Instance a javascript validator.
	*
	* @access	public static
	* @param	JFormField	$field	Form field.
	* @param	JFormRule	$rule	Validator rule.
	*
	* @return	void
	*/
	public static function loadScript($field, $rule)
	{
		if (!$rule->handler)
			return;

		if ($rule->regex){
			$jsRule = self::getJsonRule($field, $rule);
		}
		else
		{
			if (method_exists($rule, 'getJsonRule'))
				$jsRule = $rule->getJsonRule($field);
		}

		if (!$jsRule)
			return;

		$handler = $rule->handler;
		if ($ruleInstance = $field->getAttribute('ruleInstance'))
			$handler = $ruleInstance;

		$script = 'jQuery.validationEngineLanguage.allRules.' . $handler . ' = ' . $jsRule . ';';

		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($script);
	}

	/**
	* Render a prompt information to guide the user.
	*
	* @access	public static
	* @param	string	$id	The input id.
	* @param	string	$message	The message to display
	*
	* @return	void
	*/
	public static function loadScriptPromptInfo($id, $message)
	{
		$script = 'jQuery(document).ready(function(){' .
					'var el = jQuery("#' . $id . '");' .
					'el.validationEngine("showPrompt", "' . htmlentities($message) . '", "pass", false);' .
				'});';

		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($script);
	}

	/**
	* Instance js validators for a field.
	*
	* @access	public static
	* @param	JFormField	$field	Form field.
	*
	* @return	void
	*/
	public static function loadValidator($field)
	{
		//Show the prompt information
		if ($msgInfo = $field->getAttribute('msg-info'))
			self::loadScriptPromptInfo($field->id, JText::_($msgInfo));

		$class = $field->getAttribute('class');

		if (empty($class))
			return;

		$instanceIt = false;

		preg_match_all('/validate\[(.+)\]\s?/', $class, $matches);

		$validates = array();
		if (count($matches[1]))
			$validates = explode(",", $matches[1][0]);


		$required = $field->getAttribute('required');
		if (in_array('required', $validates))
			$required = true;


		if ($required != false)
			$instanceIt = true;

		$rules = array();
		if (isset($validates))
		foreach($validates as $ruleType)
		{
			preg_match_all("/custom\[([a-zA-Z0-9]+)(_.+)?\]/", $ruleType, $matchesCustom);

			if (count($matchesCustom[1]))
				$ruleType = $matchesCustom[1][0];

			if ($rule = JFormHelper::loadRuleType($ruleType))
			if (isset($rule->extended) && $rule->extended)
			{
				$rules[] = $rule;
				$instanceIt = true;
			}
		}

		if ($instanceIt)
			return self::renderValidator($field, $rules);
	}

	/**
	* Instance the validation javascript rules for a field.
	*
	* @access	public static
	* @param	JFormField	$field	Form field.
	* @param	JFormRule	$rules	The validator rule(s). Accept array
	*
	* @return	void
	*/
	public static function renderValidator($field, $rules = null)
	{
		if (is_array($rules) && (count($rules) > 0))
		{
			foreach($rules as $rule)
				self::loadScript($field, $rule);
		}
		else if (isset($rules->extended))
		{
			self::loadScript($field, $rules);
		}

	}


}



