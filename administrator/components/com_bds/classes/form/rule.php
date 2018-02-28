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

if (!class_exists('JFormRule'))
	jimport('joomla.form.formrule');


/**
* Form validator rule for Bds.
*
* @package	Bds
* @subpackage	Form
*/
class BdsClassFormRule extends JFormRule
{
	/**
	* Proxy to access protected methods.
	*
	* @access	public
	* @param	string	$var	The name of the property.
	*
	* @return	mixed	The value of the property. Null if not in the list.
	*/
	public function __get($var)
	{
		if (in_array($var, array('regex', 'regexJs', 'modifiers', 'handler')) && isset($this->$var))
		return $this->$var;
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
		/* 	TODO : Fill the associative array below, or create a JSON string manually
		* 	Note : $this->regex must be null
		*/

		$values = array();

		$json = BdsHelperHtmlValidator::jsonFromArray($values);
		return "{" . LN . $json . LN . "}";
	}

	/**
	* Method to test all common rules (Required, Unique, Unique Groups).
	*
	* @access	public static
	* @param	JXMLElement	&$element	The JXMLElement object representing the <field /> tag for the form field object.
	* @param	mixed	$value	The form field value to validate.
	* @param	string	$group	The field name group control value. This acts as as an array container for the field.
	* @param	JRegistry	&$input	An optional JRegistry object with the entire data set to validate against the entire form.
	* @param	object	&$form	The form object for which the field is being tested.
	*
	*
	* @since	Cook V2.0
	*
	* @return	boolean	True if the value is valid, false otherwise.
	*/
	public static function testDefaults(&$element, $value, $group = null, &$input = null, &$form = null)
	{
		$idKey = 'id';

		// If the field is empty and not required, the field is valid.
		$required = ((string) $element['required'] == 'true' || (string) $element['required'] == 'required');
		if ($required && (($value === '') || ($value === null))) // Allow zero value
		{
			return false;
		}

		$fieldName = (string)$element['name'];
		$unique = (string)$element['unique'];


		$uniqueGroups = array();
		foreach($element->children() as $child)
		{
			if ($child->getName() != 'unique')
				continue;

			if (!isset($child['alias']) || !isset($child['fields']))
				continue;

			$uniqueGroups[(string)$child['alias']] = (string)$child['fields'];
		}

		// Initialize some vars for database query
		if ($unique || count($uniqueGroups))
		{
			$jinput = JFactory::getApplication()->input;

			$parts = explode(".", $form->getName());
			$extension = preg_replace("/com_/", "", $parts[0]);
			$table = JTable::getInstance($parts[1], $extension . 'Table', array());

			// Get the database object and a new query object.
			$db = JFactory::getDBO();
			$id =  $jinput->get('cid', 0, 'array');
			if (count($id))
				$id = $id[0];

			if (in_array($jinput->get('task'), array('save2copy')))
				$id = 0;
		}

		// Check if we should test for uniqueness.
		if ($unique)
		{
			$query = $db->getQuery(true);

			// Build the query.
			$query->select('COUNT(*)');
			$query->from($table->getTableName());
			$query->where($db->quoteName($fieldName) . ' = ' . $db->quote($value));
			$query->where($db->quoteName($idKey) . '<>' . (int)$id);

			// Set and query the database.
			$db->setQuery($query);
			$duplicate = (bool) $db->loadResult();

			// Check for a database error.
			if ($db->getErrorNum())
			{
				JError::raiseWarning(500, $db->getErrorMsg());
				return false;
			}

			if ($duplicate)
			{
				JError::raiseWarning(1201, JText::sprintf("BDS_MODEL_DUPLICATE_ENTRY_FOR", JText::_($element['label'])));
				return false;
			}
		}


		// Check unicity between a group of values
		if (!empty($uniqueGroups))
		{
			$fieldLabels = array();
			foreach($uniqueGroups as $alias => $uniqueGroup)
			{

				$uniqueGroup = explode(',', $uniqueGroup);

				foreach($form->getFieldSet() as $field)
				{
					$fName = $field->getAttribute('name');

					if (in_array($fName, $uniqueGroup) && (!isset($fieldLabels[$fName])))
						$fieldLabels[$fName] = JText::_($field->getAttribute('label'));

				}

				$values = array();
				$missingValues = array();

				// Check if the primary keys are contained in the post request ($input)
				foreach($uniqueGroup as $key)
				{
					$val = $input->get($key);
					// Means that a value need to be read from the current object
					if ($val === null)
						$missingValues[] = $key;

					// Map the submited item
					$values[$key] = $val;
				}

				// If some primary key values are required AND missing in the request
				if ($id && !empty($missingValues))
				{
					// Get the sql value
					$query = $db->getQuery(true);

					// Build the query for completing the missing values
					$query->from($table->getTableName());

					// Select only the interresting missing fields
					foreach($missingValues as $key)
						$query->select($db->quoteName($key));

					$query->where($db->quoteName($idKey) . ' = ' . (int)$id);

					$db->setQuery($query);
					$item = $db->loadObject();

					// Fill complete submission with input override (simulate complete record)
					foreach($item as $key => $value)
						$values[$key] = $value;

				}

				$query = $db->getQuery(true);

				// Build the query.
				$query->select('COUNT(*)');
				$query->from($table->getTableName());

				// Sum all primary keys
				foreach($values as $key => $value)
					$query->where($db->quoteName($key) . ' = ' . $db->quote($value));


				// Exclude this item (when editing)
				if ($id)
					$query->where($db->quoteName($idKey) . '<>' . (int)$id);

				// Set and query the database.
				$db->setQuery($query);
				$duplicate = (bool) $db->loadResult();

				// Check for a database error.
				if ($db->getErrorNum())
				{
					JError::raiseWarning(500, $db->getErrorMsg());
					return false;
				}

				if ($duplicate)
				{
					JError::raiseWarning(1201, JText::sprintf("BDS_MODEL_DUPLICATE_ENTRY_FOR", implode (', ', $fieldLabels)));
					return false;
				}
			}
		}

		return true;
	}


}



