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

JFormHelper::loadFieldClass('groupedlist');

/**
* Form field for Bds.
*
* @package	Bds
* @subpackage	Form
*/
class JFormFieldModel extends JFormFieldGroupedList
{
	/**
	* Foreign Key Filter. 
	*
	* @var string
	*/
	public $filterKey;

	/**
	* Foreign Key Filter Value. 
	*
	* @var string
	*/
	public $filterValue;

	/**
	* The form field type.
	*
	* @var string
	*/
	public $type = 'model';

	/**
	* Method to get the groups for the grouped list.
	*
	* @access	protected
	*
	* @return	array	The grouped options.
	*/
	protected function getGroups()
	{
		// Joomla does not allow Nested groups... so we create empty groups for the purpose
		// ... But nested groups are tricky with chosen (see the docs at www.j-cook.pro)
		// the proposed solution here is wrapping an empty disabled option.
		if ($usesChosen = true) // Change the value here
			$emptyDisabledGroup = array(array('value' => null, 'text' => '&nbsp;', 'disable' => true));
		else
			$emptyDisabledGroup = array();


		$listKey = $this->getAttribute('listKey', 'id');
		$labelKey = $this->getAttribute('labelKey', 'title');
		$indentString = $this->getAttribute('groupIndentString', ' . ');

		$listGroups = BdsHelperForm::getElementGroups($this->element);


		// Return a sinple list if no group is specified
		if (empty($listGroups))
			return array($this->getOptions());

		$groupValue = array();
		foreach($listGroups as $listGroup)
			$groupValue[$listGroup->alias] = null;


		$label = null;
		$groups = array();

		// Add the placeholder
		$nullLabel = $this->getAttribute('nullLabel');
		if ($nullLabel)
			$groups[] = array('' => JText::_($nullLabel));

		$items = BdsHelperForm::getItems($this);

		if (!empty($items))
		foreach($items as $item)
		{

			if ($deep = count($listGroups))
			{
				if (count($listGroups) > 1)
				for($i = 1 ; $i < $deep ; $i++)
				{
					$listGroup = $listGroups[$i];
					$on = $listGroup->alias;

					if (isset($item->$on) && $item->$on != $groupValue[$on])
					{
						$label = str_repeat($indentString, $deep - $i - 1) . $item->$on;
						$groups[$label] = $emptyDisabledGroup;


						$groupValue[$on] = $item->$on;
					}
				}

				$listGroup = $listGroups[0];
				$on = $listGroup->alias;

				if (isset($item->$on) && $item->$on != $groupValue[$on])
				{

					$label = str_repeat($indentString, $deep - 1) . $item->$on;
					$groups[$label] = array();
					$groupValue[$on] = $item->$on;
				}
			}

			// Integer alone are marked
			if (is_numeric($label))
				$label .= ' ';

			if (isset($item->$listKey))
			{
				$val = BdsHelper::parseValue($item, $labelKey);
				if ($val !== null)
					$groups[$label][$item->$listKey] = str_repeat($indentString, $deep) . $val;
			}
		}

		reset($groups);
		return $groups;
	}

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
		$submit = $this->getAttribute('submit');
		if (in_array($submit, array(true, 'true')))
		{
			$this->onchange = 'this.form.submit();';
		}

		return parent::getInput();
	}

	/**
	* Method to get the field options.
	*
	* @access	protected
	*
	*
	* @since	11.1
	*
	* @return	array	The field option objects.
	*/
	protected function getOptions()
	{
		$options = array();

		// Get the value
		$listKey = $this->getAttribute('listKey', 'id');
		$labelKey = $this->getAttribute('labelKey', 'text');
		$nullLabel = $this->getAttribute('nullLabel');

		$options = array();
		if ($nullLabel)
			$options[''] = JText::_($nullLabel);


		$items = BdsHelperForm::getItems($this);

		if (!empty($items))
		foreach ($items as $item)
			$options[$item->$listKey] = BdsHelper::parseValue($item, $labelKey);

		return $options;
	}

	/**
	* Method to prepare the Model before to get the items.
	*
	* @access	public
	* @param	JModel	&$model	The model sent by the parent.
	*
	* @return	void
	*/
	public function prepareModel(&$model)
	{
		// Prepare the list groups
		$groups = BdsHelperForm::getElementGroups($this->element);

		if (!empty($groups))
		{
			$relations = array();
			foreach($groups as $group)
			{
				$dir = 'ASC';
				if (isset($group->dir))
					$dir = strtoupper($group->dir);

				$relations[$group->on] = $dir;
			}

			$model->orm(array(
				'groupOrder' => $relations
			));
		}

		// Filter the results on a parent FK value
		$filterKey = $this->getAttribute('filterKey', $this->filterKey);
		$filterValue = $this->getAttribute('filterValue', $this->filterValue);

		if ($filterKey && $filterValue)
		{
			$model->orm(array(
				'filter' => array(
					$filterKey => array(
						'value' => $filterValue
					)
				)
			));
		}
	}


}



