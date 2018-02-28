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
class JFormFieldAjax extends JFormField
{
	/**
	* Groups cache.
	*
	* @var array
	*/
	protected static $_groups;

	/**
	* Extension name.
	*
	* @var string
	*/
	protected static $extension = 'bds';

	/**
	* The initialised state of the document object.
	*
	* @var boolean
	*/
	protected static $initialised;

	/**
	* The form field type.
	*
	* @var string
	*/
	public $type = 'ajax';

	/**
	* Build the configuration for the ajax plugin.
	*
	* @access	protected
	*
	* @return	array	List of the parameters
	*/
	protected function getConfig()
	{
		$config = array();

		// the wrapper is the div recieving the ajax response
		$wrapper = $this->getAttribute('wrapper', "ajax_" . rand(1111111111, 8888888888));


		$config['wrapper'] = $wrapper;

		// Sequence of values
		$config['values'] = $this->getValues();


		// Default plugin
		$plugin = 'field';


		if ($ajaxContext = $this->getAttribute('ajaxContext'))
			$plugin = 'legacy';


		if ($layout = $this->getAttribute('layout'))
			$plugin = 'layout';


		switch($plugin)
		{
			case 'layout':
				$config['extension'] = $this->getAttribute('extension', self::$extension);
				$config['view'] = $this->getAttribute('view');
				$config['layout'] = $this->getAttribute('layout');
				$config['format'] = $this->getAttribute('format', 'HTML');
				break;

			case 'field':

				$config['groups'] = BdsHelperForm::getElementGroups($this->element);
				$config['model'] = $this->getAttribute('model');
				$config['name'] = $this->getAttribute('name');

				if ($submit = $this->getAttribute('submit'))
					if (in_array(strtolower($submit), array('yes', 'true')))
					$config['submit'] = true;

				// Set filter form control
				if (substr($this->name, 0, 7) == 'filter[')
					$config['formControl'] = 'filter';

				break;


			case 'legacy':
				$config['ajaxContext'] = $ajaxContext;
				break;
		}


		$config['plugin'] = $plugin;

		return $config;
	}

	/**
	* Get a list of groups from the sub nodes.
	*
	* @access	protected
	*
	* @return	array	List of the groups
	*/
	protected function getGroups()
	{
		if (!self::$_groups)
		{
			self::$_groups = array();

			$model = $this->getModel();
			$valueKey = '';
			foreach ($this->element->children() as $option)
			{
				// Only get <chain /> elements.
				if ($option->getName() != 'group')
					continue;

				$group = new stdClass();
				$group->name = (string) $option['name'];
				$valueKey .= '_' . $group->name;


				$group->filterKey = $group->name;

				// Init some vars from the relation
				$relation = $model->getRelation($group->name);
				$group->model = $relation->foreignModelClass;


				$labelKey = (string) $option['labelKey'];
				if ($labelKey || isset($option['on']))
				{
					// Label field. If not specified, find automaticaly the full underscore namespaced field name
					$group->on = (isset($option['on'])?(string) $option['on']:$valueKey . '_' . $labelKey);
				}
				else
				{
					$group->on = $group->name;
				}

				$group->valueKey = $valueKey;

				$model = $this->getModel($group->model);

				self::$_groups[] = $group;
			}
		}

		return self::$_groups;
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
		if (!self::$initialised)
		{
			// Include jQuery
			JHtml::_('jquery.framework');

			$base = JURI::base(false);
			$base = substr($base, 0, strpos($base, 'administrator/'));

			// Load the assets files in the media folder of Joomla!
			JHtml::script('com_' . self::$extension . '/ajax.js', false, true);
			JHtml::stylesheet('com_' . self::$extension . '/ajax.css', array(), true);

			// Load the fork assets
			$forkMediaBase = $base . '/administrator/components/com_' . self::$extension . '/fork/media/';
			$forkMediaFiles = JPATH_ADMINISTRATOR . '/components/com_' . self::$extension . '/fork/media/';
			if (file_exists($forkMediaFiles . 'js/ajax.js'))
				JHtml::script($forkMediaBase . 'js/ajax.js');

			if (file_exists($forkMediaFiles . 'css/ajax.css'))
				JHtml::stylesheet($forkMediaBase . 'css/ajax.css');

			self::$initialised = true;
		}


		$config = $this->getConfig();



		$ajaxGroups = array();
		if (isset($config['groups']))
			$ajaxGroups = $config['groups'];

		$wrapper = $config['wrapper'];

		$html = "";
		if (count($ajaxGroups))
		{
			// Create a wrapper div for every expected ajax cascad field. Uses a decremental level suffix
			for ($i = count($ajaxGroups) ; $i > 0 ; $i--)
				$html .= '<div id="' . $wrapper . '_' . $i . '"></div>';
		}

		// Last wrapper (without level suffix)
		$html .= '<div id="' . $wrapper . '"></div>';


		$html .= '<input type="hidden"'
			.	' id="' . $this->id . '"'
			.	' name="' . $this->id . '"'
			.	' value="' . ($this->value == 0?'':$this->value) . '"'
			.	'/>';


		$jsFct = 'ckAjax';

		switch($config['plugin'])
		{
			case 'field':
				$jsFct = 'ckAjaxField';
				break;

			case 'legacy':
				$jsFct = 'ckAjaxLegacy';
				break;

			case 'layout':
				$jsFct = 'ckAjaxLayout';
				break;

		}

		$script = $jsFct . '("' . $wrapper. '", ' . json_encode($config) . ');';

		JFactory::getDocument()->addScriptDeclaration($script);

		return $html;
	}

	/**
	* Method to get a namespaced model.
	*
	* @access	protected
	* @param	string	$model	The model. If not specified, read from the attributes.
	*
	* @return	JModel	The model.
	*/
	protected function getModel($model = null)
	{
		if (!$model)
			$model = $this->getAttribute('model');

		return BdsHelper::componentModel($model);
	}

	/**
	* Load all values from a model, including relations.
	*
	* @access	protected
	*
	* @return	array	Array of values
	*/
	protected function getValues()
	{
		if (!$this->value)
			return array();

		$model = $this->getModel();
		$values = array($this->value);

		// Prepare the list groups
		$groups = $this->getGroups();
		if (empty($groups))
			return $values;

		$relations = array();
		foreach($groups as $group)
			$relations[] = preg_replace('/^filter_/', '', $group->name);


		// Include the joins in the SQL query BEFORE to get the items
		$model->prepareQueryRelations(implode('.', $relations), true);

		$model->addWhere('a.id = ' . $this->value);

		$items = $model->getItems();
		if (!count($items))
			return $values;

		$item = $items[0];

		foreach($groups as $group)
		{
			$valueKey = $group->valueKey;
			$values[] = $item->$valueKey;
		}

		return array_reverse($values);
	}


}



