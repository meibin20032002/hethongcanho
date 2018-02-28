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

jimport('joomla.application.component.modellist');


/**
* Bds List Model
*
* @package	Bds
* @subpackage	Classes
*/
class BdsClassModelList extends JModelList
{
	/**
	* Data array
	*
	* @var array
	*/
	protected $_data = null;

	/**
	* Pagination object
	*
	* @var object
	*/
	protected $_pagination = null;

	/**
	* Total
	*
	* @var integer
	*/
	protected $_total = null;

	/**
	* Context string for the model type.  This is used to handle uniqueness
	*
	* @var string
	*/
	protected $context = null;

	/**
	* Extension name.
	*
	* @var string
	*/
	protected static $extension = 'bds';

	/**
	* Filterable fields keys
	*
	* @var array
	*/
	protected $filter_vars = array();

	/**
	* Default item layout.
	*
	* @var array
	*/
	public $itemDefaultLayout;

	/**
	* ORM system
	*
	* @var ClassModelOrm
	*/
	protected $orm;

	/**
	* Model relations.
	*
	* @var array
	*/
	protected $relations = array();

	/**
	* Search entries
	*
	* @var array
	*/
	protected $search_vars = array();

	/**
	* Constructor
	*
	* @access	public
	* @param	array	$config	An optional associative array of configuration settings.
	*
	* @return	void
	*/
	public function __construct($config = array())
	{
		parent::__construct($config);

		// Load the ORM system
		$this->orm = BdsClassModelOrm::getInstance($this);

		$layout = $this->getLayout();
		$jinput = JFactory::getApplication()->input;
		$render = $jinput->get('render', null, 'CMD');

		$this->context = strtolower($this->option . '.' . $this->getName()
					. ($layout?'.' . $layout:'')
					. ($render?'.' . $render:'')
					);
	}

	/**
	* Method to exclude items from the list.
	*
	* @access	public
	* @param	array	$ids	IDs of the items to restricts
	*
	*
	* @since	Cook 3.0.9
	*
	* @return	void
	*/
	public function addExclude($ids)
	{
		// Merge all exclusions
		$exclude = $this->getState('query.exclude');
		if (is_array($exclude))
			$exclude = array_merge($exclude, $ids);
		else
			$exclude = $ids;

		$this->setState('query.exclude', $exclude);
	}

	/**
	* Method to store an EXTRA at the end of the SQL query. (LIMIT for example)
	*
	* @access	public
	* @param	string	$extra	
	*
	*
	* @deprecated	1
	*
	* @return	void
	*/
	public function addExtra($extra)
	{
		$this->addQuery('extra', $extra);
	}

	/**
	* Method to store a PRIORITARY ORDER for the SQL query. Used to group the
	* fields.
	* Deprecated : use addGroupOrder()
	*
	* @access	public
	* @param	string	$groupby	
	*
	* @return	void
	*/
	public function addGroupBy($groupby)
	{
		$this->addQuery('groupBy', $groupby);
	}

	/**
	* Method to store a PRIORITARY ORDER for the SQL query. Used to group the
	* fields per value.
	*
	* @access	public
	* @param	string	$groupOrder	
	*
	* @return	void
	*/
	public function addGroupOrder($groupOrder)
	{
		$this->addQuery('groupOrder', $this->sanitizeOrdering($groupOrder));
	}

	/**
	* Method to store a JOIN entry for the SQL query.
	*
	* @access	public
	* @param	string	$join	
	* @param	string	$type	
	*
	* @return	void
	*/
	public function addJoin($join, $type = 'left')
	{
		$join = preg_replace("/^((LEFT)?(RIGHT)?(INNER)?(OUTER)?\sJOIN)/", "", $join);
		$this->addQuery('join.' . strtolower($type), $join);
	}

	/**
	* Method to store an ORDER entry for the SQL query.
	*
	* @access	public
	* @param	string	$order	
	*
	* @return	void
	*/
	public function addOrder($order)
	{
		$this->addQuery('order', $this->sanitizeOrdering($order));
	}

	/**
	* Concat SQL parts in query. (Suggested by Cook Self Service)
	*
	* @access	public
	* @param	string	$type	SQL command.
	* @param	string	$queryElement	Command content.
	*
	* @return	void
	*/
	public function addQuery($type, $queryElement)
	{
		$queryElement = trim($queryElement);
		$queries = $this->getState('query.' . $type, array());
		if (!in_array($queryElement, $queries))
		{
			$queries[] = $queryElement;
			$this->setState('query.' . $type, $queries);
		}
	}

	/**
	* Method to restricted a list of items inside a list of possibles values.
	*
	* @access	public
	* @param	array	$ids	IDs of the items to restricts
	*
	*
	* @since	Cook 3.0.9
	*
	* @return	void
	*/
	public function addRestrict($ids)
	{
		// Intersects all restrictions
		$restrict = $this->getState('query.restrict');
		if (is_array($restrict))
			$restrict = array_intersect($restrict, $ids);
		else
			$restrict = $ids;

		$this->setState('query.restrict', $restrict);
	}

	/**
	* Method to concat a search entry.
	*
	* @access	public
	* @param	string	$instance	
	* @param	string	$namespace	
	* @param	string	$method	
	*
	* @return	void
	*/
	public function addSearch($instance, $namespace, $method)
	{
		$search = new stdClass();
		$search->method = $method;


		if (!isset($this->_searches[$instance]))
			$this->_searches[$instance] = array();

		$this->_searches[$instance][$namespace] = $search;
	}

	/**
	* Method to store a SELECT entry for the SQL query.
	*
	* @access	public
	* @param	string	$select	
	*
	* @return	void
	*/
	public function addSelect($select)
	{
		$this->addQuery('select', $select);
	}

	/**
	* Method to store a WHERE entry for the SQL query.
	*
	* @access	public
	* @param	string	$where	
	*
	* @return	void
	*/
	public function addWhere($where)
	{
		$this->addQuery('where', $where);
	}

	/**
	* Apply all SQL directives states to the query. This way you can set twice
	* the same statement without error, in case of numerous sql profiles and
	* complex statements.
	* Very important in case of doubled statement they must match exactly the
	* same.
	*
	* @access	protected
	* @param	object	$query	Joomla query object
	*
	*
	* @since	Cook 2.7
	*
	* @return	void
	*/
	protected function applySqlStates($query)
	{
		//Populate only uniques strings to the query

		// SELECT
		foreach($this->getState('query.select', array()) as $select)
			$query->select($select);

		// JOIN LEFT
		foreach($this->getState('query.join.left', array()) as $join)
			$query->join('LEFT', $join);

		// JOIN INNER
		foreach($this->getState('query.join.inner', array()) as $join)
			$query->join('INNER', $join);

		// JOIN OUTER
		foreach($this->getState('query.join.outer', array()) as $join)
			$query->join('OUTER', $join);

		// WHERE
		foreach($this->getState('query.where', array()) as $where)
			$query->where($where);

		// RESTRICT
		if (is_array($this->getState('query.restrict')))
		{
			$restrict = $this->getState('query.restrict');
			if (count($restrict))
				$query->where("a.id IN (" . implode(',', $restrict). ")");
			else
				$query->where("a.id = -1");  // Return nothing (restricted all)
		}

		// EXCLUDE
		if (is_array($this->getState('query.exclude')))
		{
			$exclude = $this->getState('query.exclude');
			if (count($exclude))
				$query->where("a.id NOT IN (" . implode(',', $exclude). ")");
		}

		// GROUP BY : Native SQL Group By
		foreach($this->getState('query.groupBy', array()) as $groupBy)
			$query->group($groupBy);

		// GROUP ORDER : Prioritary order for groups in lists
		foreach($this->getState('query.groupOrder', array()) as $groupOrder)
			$query->order($groupOrder);

		// ORDER
		foreach($this->getState('query.order', array()) as $order)
			$query->order($order);

		// Dump the query for debug
		if (defined('JDEBUG') && $this->getState('debug.query'))
			$this->queryDump($query);
	}

	/**
	* Method to get all local items matching a search over a pivot relation
	* (N:m).
	*
	* @access	protected
	* @param	object	$relation	Relation to the search
	* @param	array	$conditions	Match at least one of those SQL conditions. Use : <br/>`a` alias for the Foreign Table, <br/>`p` alias for the Pivot Table
	*
	*
	* @since	Cook 3.0.9
	*
	* @return	array	Item ids matching the search.
	*/
	protected function belongsOf($relation, $conditions)
	{
		if ($relation->type != 'belongsToMany')
			return null;

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Only works from the pivot table (alias: `p`)
		$query->select('p.' . $relation->pivotLocalKey);
		$query->from($relation->pivotTable . ' AS p');

		// Link the Foreign Table
		$query->join('LEFT', $db->qn($relation->foreignTable) . ' AS a '
			. ' ON a.' . $relation->foreignKey . ' = p.' . $relation->pivotForeignKey
		);

		// Concat all conditions with a 'OR' statement
		if (!empty($conditions))
		{
			$condition = '(' . implode(' OR ', $conditions) . ')';
			$query->where($condition);
		}

		$db->setQuery($query);
		$ids = $db->loadColumn();

		return $ids;
	}

	/**
	* Method to initialize a Many to Many relation.
	*
	* @access	protected
	* @param	string	$name	Relation name.
	* @param	string	$foreignModelClass	Foreign model. Use the name when null.
	* @param	string	$localKey	The local key.
	* @param	string	$foreignKey	The foreign key.
	* @param	string	$pivot	The pivot model name. Can recieve namespaced name or raw table name.
	* @param	string	$pivotLocalKey	The pivot local key.
	* @param	string	$pivotForeignKey	The pivot foreign key.
	* @param	array	$selectFields	The required fields to include in select.
	* @param	boolean	$raw	Uses a raw implementation. More optimized, but choose false for using the model features.
	*
	* @return	void
	*/
	protected function belongsToMany($name, $foreignModelClass = null, $localKey = null, $foreignKey = null, $pivot, $pivotLocalKey, $pivotForeignKey, $selectFields = array(), $raw = false)
	{
		$relation = $this->newRelation('belongsToMany', $name, $foreignModelClass, $selectFields);

		$relation->localKey = $localKey;
		$relation->foreignKey = $foreignKey;

		$extension = $relation->extension;
		if (substr($pivot, 0, 1) == '#')
		{
			$relation->pivotTable = $pivot;
		}
		else
		{
			$parts = explode('.', $pivot);
			if (count($parts) > 1)
			{
				$extension = ltrim($parts[0], 'com_');
				$pivot = $parts[1];
				$relation->pivotExtension = $extension;
			}

			$relation->pivotTable = '#__' . $extension . '_' . $pivot;
			$relation->pivotModel = $pivot;
		}

		$relation->pivotLocalKey = $pivotLocalKey;
		$relation->pivotForeignKey = $pivotForeignKey;
		$relation->pivotForeignPkey = 'id';

		$relation->raw = $raw;
	}

	/**
	* Method to build a SQL search string.
	*
	* @access	protected
	* @param	string	$instance	
	* @param	string	$searchText	
	* @param	string	$options	
	*
	* @return	string	The formated SQL string for the research.
	*/
	protected function buildSearch($instance, $searchText, $options = array('join' => 'AND', 'ignoredLength' => 0))
	{
		if (!isset($this->_searches[$instance]))
			return;

		$db= JFactory::getDBO();
		$tests = array();
		foreach($this->_searches[$instance] as $namespace => $search)
		{
			$test = "";
			switch($search->method)
			{
				case 'like':
					$test = $namespace . " LIKE " . $db->Quote("%%s%");
					break;

				case 'exact':
					$test = $namespace . " = " . $db->Quote("%s");
					break;

				case '':
					break;
			}

			if ($test)
				$tests[] = $test;
		}

		if (!count($tests))
			return "";

		$whereSearch = implode(" OR ", $tests);

		//SPLIT SEARCHED TEXT
		$searchesParts = array();

		foreach(explode(" ", $searchText) as $searchStr)
		{
			$searchStr = trim($searchStr);
			if ($searchStr == '')
				continue;

			if ((isset($options['ignoredLength'])) && (strlen($searchStr) <= $options['ignoredLength']))
				continue;

			if ($search->method == 'like')
				$searchStr = $db->escape($searchStr);


			$searchesParts[] = "(" . str_replace("%s", $searchStr, $whereSearch) . ")";
		}

		if (!count($searchesParts))
			return;

		if (isset($options['join']))
			$join = strtoupper($options['join']);
		else
			$join = "AND";

		$where = implode(" " . $join . " ", $searchesParts);

		return $where;
	}

	/**
	* Check if the user can access to the configuration.
	*
	* @access	public
	*
	* @return	boolean	True if allowed.
	*/
	public function canAdmin()
	{
		$acl = BdsHelper::getActions();

		if ($acl->get('core.admin'))
			return true;

		return false;
	}

	/**
	* Check if the user can create new items.
	*
	* @access	public
	*
	* @return	boolean	True if allowed.
	*/
	public function canCreate()
	{
		$acl = BdsHelper::getActions();
		
		if ($acl->get('core.create'))
			return true;
		
		return false;
	}

	/**
	* Method to test whether a user can delete items.
	*
	* @access	public
	*
	* @return	boolean	True if allowed.
	*/
	public function canDelete()
	{
		$acl = BdsHelper::getActions();
		
		if ($acl->get('core.delete'))
			return true;

		if ($acl->get('core.delete.own'))
			return true;
		
		return false;
	}

	/**
	* Check if the user can edit items.
	*
	* @access	public
	*
	* @return	boolean	True if allowed.
	*/
	public function canEdit()
	{
		$acl = BdsHelper::getActions();
		
		if ($acl->get('core.edit'))
			return true;

		if ($acl->get('core.edit.own'))
			return true;
		
		return false;
	}

	/**
	* Check if the user can edit the states (publish, default, ...).
	*
	* @access	public
	*
	* @return	boolean	True if allowed.
	*/
	public function canEditState()
	{
		$acl = BdsHelper::getActions();
		
		if ($acl->get('core.edit.state'))
			return true;
		
		return false;
	}

	/**
	* Check if allowed to process any acl task.
	*
	* @access	public
	*
	* @return	boolean	True if allowed.
	*/
	public function canSelect()
	{
		if ($this->canAdmin())
		return true;

		if ($this->canEdit())
		return true;

		if ($this->canDelete())
		return true;

		if ($this->canEditState())
		return true;

		if ($this->canEditState())
		return true;

		return false;
	}

	/**
	* Filter a FK value with multiple values.
	*
	* @access	protected
	* @param	string	$namespace	Namespace of the Foreign Keys chain
	*
	*
	* @since	Cook 3.0.10
	*
	* @return	void
	*/
	protected function filterMulti($namespace)
	{
		$parts = explode('.', $namespace);

		$ids = array();
		if ($values = $this->getState('filter.' . implode('_', $parts)))
		{
			if (is_array($values))
			{
				// Cast and Remove the first empty value
				foreach($values as $val)
					if (!empty($val))
						$ids[] = (int)$val;
			}
		}

		$this->prepareQueryJoin($namespace);

		if (count($ids))
			$this->addWhere($this->tableFieldAlias($namespace) . " IN (" . implode(',', $ids) . ")");
	}

	/**
	* Method to filter a list with a Pivot relation (N:m).
	*
	* @access	protected
	* @param	string	$relationName	Name of the model relation
	* @param	string	$stateName	Name of the values state. You can use any state var name for custom. <br/> By default, reads the value from the pivot filter state.
	*
	*
	* @since	Cook 3.0.9
	*
	* @return	void
	*/
	protected function filterPivot($relationName, $stateName = null)
	{
		if (!$stateName)
			$stateName = 'filter.' . $relationName;


		if($values = $this->getState($stateName))
		{
			if (is_array($values))
			{
				$relation = $this->getRelation($relationName);

				// @logic Determines the behaviour of the filter
				$logic = strtoupper($this->getState($stateName . '.logic', 'AND'));
				switch ($logic)
				{
					case 'NOT':
					case 'OR':
						// Matches "at least one" value
						$conditions = array();
						foreach($values as $value)
						{
							if (empty($value))
								continue;

							$conditions[] = 'a.' . $relation->foreignKey . ' = ' . (int)$value;
						}

						if (count($conditions))
						{
							// Search for all related items matching the filter values
							$ids = $this->belongsOf($relation, $conditions);

							if ($logic == 'OR')
								// SQL Restriction list from the related items founds
								$this->addRestrict($ids);
							else if ($logic == 'NOT')
								// SQL Exclusion of the related items founds.
								$this->addExclude($ids);
						}

						break;

					case 'AND':
					default:

						// Match ALL values
						foreach($values as $value)
						{
							if (empty($value))
								continue;


							// Search for all related items matching the filter values
							$ids = $this->belongsOf($relation, array('a.' . $relation->foreignKey . ' = ' . (int)$value));

							// Restrict SQL list from the related items founds
							$this->addRestrict($ids);


						}

						break;
				}

			}
		}

	}

	/**
	* Temporary function, before FoF implementation. Return the table Foreign Key
	* name of a field.
	*
	* @access	public static
	* @param	string	$fieldname	FK field name
	*
	*
	* @since	Cook 2.6.3
	*
	* @return	string	The table name. # is used as prefix to significate the component name table prefix.
	*/
	public static function fkTable($fieldname)
	{
		$tbl = '#__';
		$com = 'bds_';

		switch($fieldname)
		{
			case 'sub_category': return $tbl.$com. 'categories';
			case 'created_by': return $tbl. 'users';
			case 'modified_by': return $tbl. 'users';
			case 'category_id': return $tbl.$com. 'categories';
			case 'project_id': return $tbl.$com. 'projects';
			case 'location_id': return $tbl.$com. 'locations';
			case 'type_id': return $tbl.$com. 'types';
			case 'utility_id': return $tbl.$com. 'utilities';
			case 'sub_location': return $tbl.$com. 'locations';	
		}
	}

	/**
	* Method to get a customized form.
	*
	* @access	public
	* @param	string	$instance	The name of the form in XML file.
	* @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	* @param	string	$control	The name of the control group.
	*
	*
	* @since	Cook 2.0
	*
	* @return	JXMLElement	A Fieldset containing all the field parameters (XML node)
	*/
	public function getForm($instance = 'default.filters', $loadData = true, $control = null)
	{
		$model = CkJModel::getInstance($this->view_item, 'BdsModel');
		$form = $model->getForm(null, $loadData, $control);

		if (empty($form))
			return null;

		if ($loadData)
		{
			//Fill the form with the states vars (For filters)
			foreach ($this->filter_vars as $filterVar => $type)
			{
				switch($filterVar)
				{
					case 'sortTable':
						$fieldName = $filterVar;
						$stateVar = 'list.ordering';
						break;

					case 'directionTable':
						$fieldName = $filterVar;
						$stateVar = 'list.direction';
						break;

					case 'limit':
						$fieldName = $filterVar;
						$stateVar = 'list.limit';
						break;

					default:
						$fieldName = 'filter_' . $filterVar;
						$stateVar = 'filter.' . $filterVar;
						break;
				}
				$value = $this->getState($stateVar);

				$form->setValue($fieldName, '', $value);
			}

			//Fill the form with the states vars (For Searches)
			foreach ($this->search_vars as $searchVar => $type)
			{
				$value = $this->getState('search.' . $searchVar);
				$form->setValue('search_' . $searchVar, '', $value);
			}
		}

		$fieldSet = $form->getFieldset($instance);

		//Check ACL (access property)
		$allowedFields = array();
		foreach($fieldSet as $name => $field)
		{
			if ((method_exists($field, 'canView')) && !$field->canView())
				continue;

			$allowedFields[$name] = $field;
		}
		return $allowedFields;
	}

	/**
	* Method to get an array of data items. Override to catch the errors.
	*
	* @access	public
	*
	*
	* @since	11.1
	*
	* @return	array	Items objects.
	*/
	public function getItems()
	{
		try
		{
			$items = parent::getItems();
			$db = $this->getDbo();

			if ($error = $db->getErrorMsg())
			{
				if (!$this->canAdmin())
					$error = JText::_('BDS_ERROR_INVALID_QUERY');
				throw new Exception($error);
			}

			// Complete the Item shape with some flags
			$this->populateParams($items);

			// Create linked objects (N:m)
			$this->populateObjects($items);

		}
		catch (JException $e)
		{

		}
		return $items;
	}

	/**
	* Get the current layout. Abstract function to override.
	*
	* @access	public
	*
	*
	* @since	11.1
	*
	* @return	string	The default layout alias.
	*/
	public function getLayout()
	{
		$jinput = JFactory::getApplication()->input;
		return $jinput->get('layout', 'default', 'STRING');
	}

	/**
	* Method to get a JDatabaseQuery object for retrieving the data set from a
	* database.
	*
	* @access	public
	*
	*
	* @since	11.1
	*
	* @return	JDatabaseQuery	A JDatabaseQuery object to retrieve the data set.
	*/
	public function getListQuery()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$this->prepareQuery($query);
		return $query;
	}

	/**
	* Proxy to get the model.
	*
	* @access	public
	* @param	bool	$item	If true, return the item model
	*
	*
	* @since	1.6
	*
	* @return	JModel	Return the model.
	*/
	public function getModel($item = false)
	{
		if ($item)
			return CkJModel::getInstance($this->view_item, 'BdsModel');

		return parent::getModel();
	}

	/**
	* Get the model singular name.
	*
	* @access	public
	*
	*
	* @since	1.6
	*
	* @return	string	Return the model singular.
	*/
	public function getNameItem()
	{
		return $this->view_item;
	}

	/**
	* Get the model primary key name.
	*
	* @access	public
	*
	*
	* @since	2.7.3
	*
	* @return	string	Model primary key name.
	*/
	public function getNamePk()
	{
		return 'id';
	}

	/**
	* Read ORM configuration from XML Fiters file. Not available yet.
	*
	* @access	public
	*
	*
	* @since	Cook 3.1
	*
	* @return	array	ORM description.
	*/
	public function getOrmFilters()
	{

	}

	/**
	* Method to get a registered relation in list model.
	*
	* @access	public
	* @param	string	$name	Relation name. If null, returns all relations.
	*
	* @return	mixed	A relation object. Null if not found. All relation if name is null.
	*/
	public function getRelation($name = null)
	{
		if (!$name)
			// Return all relations
			return $this->relations;

		if (!isset($this->relations[$name]))
			return;

		return $this->relations[$name];
	}

	/**
	* Get all the known relations of the model.
	*
	* @access	public
	*
	*
	* @since	3.1
	*
	* @return	array	Set of relations maps objects.
	*/
	public function getRelations()
	{
		return $this->relations;
	}

	/**
	* Returns a routed URL for an item, or a list.
	*
	* @access	public
	* @param	integer	$cid	The item primary key value (ID).
	* @param	string	$layout	The layout name.
	*
	*
	* @since	Cook 3.1.4
	*
	* @return	string	Routed URL.
	*/
	public function getRoute($cid = null, $layout = null)
	{
		$url = 'index.php?option=com_bds';

		if ($cid)
		{
			// Item view
			$url .= '&view=' . $this->view_item;
			$url .= '&layout=' . ($layout?$layout:$this->itemDefaultLayout);
			$url .= '&cid=' . (int)$cid;
		}
		else
		{
			// List view
			$url .= '&view=' . $this->getName();
			$url .= '&layout=' . ($layout?$layout:'default');
		}

		return JRoute::_($url);
	}

	/**
	* Alternative to avoid userVar beeing updated for Ajax calls.
	*
	* @access	public
	* @param	string	$key	The key of the user state variable.
	* @param	string	$request	The name of the variable passed in a request.
	* @param	string	$default	The default value for the variable if not found. Optional.
	* @param	string	$type	Filter for the variable, for valid values see {@link JFilterInput::clean()}. Optional.
	* @param	string	$resetPage	If true, the limitstart in request is set to zero
	*
	* @return	void
	*/
	public function getUserStateFromRequest($key, $request, $default = null, $type = 'none', $resetPage = true)
	{
		$app = JFactory::getApplication();
		$jinput = JFactory::getApplication()->input;

		$old_state = $app->getUserState($key);
		$cur_state = (!is_null($old_state)) ? $old_state : $default;

		$new_state = $jinput->get($request, $cur_state, $type);


		//Only POST queries can apply changes on the states vars. Ajax queries or JSON requests are also excluded from storing states in session
		if (($jinput->getMethod() == 'POST')
			&& ($jinput->get('layout') != 'ajax')

			// Only the filters form from the current view (for blocking others models)
			&& ($jinput->get('view') == $this->getName())

			&& (!in_array($jinput->get('format'), array('ajax', 'json')))
		){
			// Whatever filtering permanent state changed, the pagination returns to the first page
			if ($resetPage && !empty($new_state) && ($cur_state != $new_state))
			{
				$this->setState('list.start', 0);
				$app->setUserState($this->context . '.list.start', 0);
			}

			// Save the new value only if it is set in this request.
			if ($new_state !== null)
				$app->setUserState($key, $new_state);
			else
				$new_state = $cur_state;
		}

		return $new_state;
	}

	/**
	* Method to initialize a Many to One relation.
	*
	* @access	protected
	* @param	string	$name	Relation name.
	* @param	string	$foreignModelClass	Foreign model. Use the name when null.
	* @param	string	$localKey	The local key.
	* @param	string	$foreignKey	The foreign key.
	* @param	array	$selectFields	The required fields to include in select.
	* @param	boolean	$raw	Uses a raw implementation. More optimized, but choose false for using the model features.
	*
	* @return	void
	*/
	protected function hasMany($name, $foreignModelClass = null, $localKey = null, $foreignKey = null, $selectFields = array(), $raw = false)
	{
		$relation = $this->newRelation('hasMany', $name, $foreignModelClass, $selectFields);

		$relation->localKey = $localKey;
		$relation->foreignKey = $foreignKey;
		$relation->foreignPkey = 'id';

		$relation->raw = $raw;
	}

	/**
	* Method to initialize a Foreign Key relation.
	*
	* @access	protected
	* @param	string	$name	Relation name.
	* @param	string	$foreignModelClass	Foreign model. Use the name when null.
	* @param	string	$localKey	The local key.
	* @param	string	$foreignKey	The foreign key.
	* @param	array	$selectFields	The required fields to include in select.
	* @param	boolean	$raw	Uses a raw implementation. More optimized, but choose false for using the model features.
	*
	* @return	void
	*/
	protected function hasOne($name, $foreignModelClass = null, $localKey = null, $foreignKey = null, $selectFields = array(), $raw = false)
	{
		$relation = $this->newRelation('hasOne', $name, $foreignModelClass, $selectFields);

		$relation->localKey = $localKey;
		$relation->foreignKey = $foreignKey;
		$relation->foreignPkey = 'id';

		$relation->raw = $raw;
	}

	/**
	* Method to load related items.
	*
	* @access	public
	* @param	string	$name	Relation name.
	* @param	array	&$items	Local items to populate.
	* @param	array	$orm	ORM description for sub query, or cascad loading.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function loadRelation($name, &$items, $orm = array())
	{
		if (empty($items))
			return;

		$relation = $this->getRelation($name);

		if (!$relation)
			return;

		$localKey = $relation->localKey;
		$foreignKey = $relation->foreignKey;


		$db = JFactory::getDbo();

		// Index all the items ID's
		$itemIds = array();
		foreach($items as $item)
			$itemIds[(int)$item->$localKey] = true;


		$model = BdsClassModelOrm::getModel($relation->foreignModelClass);
		if (!$model)
			return;

		// Empty context per default (for optimization)
		$context = '';
		if (array_key_exists('context', $orm))
			$context = $orm['context'];


		$model->setState('context', $context);

		// Apply the requested ORM
		// Recursive infinite sub requests
		if (!empty($orm))
			$model->orm($orm);


		$model->orm(array(

			// Disable the pagination
			'pagination' => array(
				'limit' => null,
				'start' => null
			)
		));

		$relType = 'array';
		switch($relation->type)
		{
			// Many to Many
			case 'belongsToMany':

				$pivotTable = $relation->pivotTable;
				$pivotForeignKey = $relation->pivotForeignKey;
				$pivotLocalKey = $relation->pivotLocalKey;


				$model->addJoin($db->qn($pivotTable)
					. ' AS ' . $db->qn('pivot')
					. ' ON a.' . $foreignKey . ' = pivot.' . $pivotForeignKey, 'LEFT');


				$model->addSelect('pivot.' . $pivotLocalKey . ' AS _local');


				// Filter mixing all parents to optimize the SQL queries
				$model->addWhere('pivot.' . $pivotLocalKey  . ' IN (' . implode(',', array_keys($itemIds)). ')');

				break;


			// Many to One
			case 'hasMany':

				$model->addSelect('a.' . $foreignKey);


				// Filter on the origin, mixing all parents to optimize the SQL queries
				$model->addWhere($db->qn($foreignKey) . ' IN (' . implode(',', array_keys($itemIds)). ')');

				break;

			// Foreign Key
			case 'hasOne':

				$relType = 'object';

				$model->addSelect('a.' . $foreignKey);

				// Filter on the origin, mixing all parents to optimize the SQL queries
				$model->addWhere($db->quoteName($foreignKey) . ' IN (' . implode(',', array_keys($itemIds)). ')');

				break;
		}


		// Get a mixed list
		$rows = $model->getItems();

		// Sort by $remoteValue
		$dico = array();
		foreach($rows as $row)
		{
			// N:M
			if (isset($row->_local))
			{
				$remoteValue = $row->_local;
				unset($row->_local);
			}

			// N:1
			else
			{
				$remoteValue = $row->$foreignKey;
			}

			if ($relType == 'array')
			{
				if (empty($dico[$remoteValue]))
					$dico[$remoteValue] = array();

				$dico[$remoteValue][] = $row;
			}
			else
				$dico[$remoteValue] = $row;
		}


		// Reassemble the lists in the correct parents
		foreach($items as $item)
		{
			$localValue = $item->$localKey;
			$item->$name = (isset($dico[$localValue])?$dico[$localValue]:(($relType == 'array')?array():null));
		}

		return $items;
	}

	/**
	* Method to load related items.
	*
	* @access	public
	* @param	string	$name	Relation name. Can be namespaced to load in cascad
	*
	* @return	void
	*/
	public function loadRelations($name)
	{
		// Cascad chaining
		$parts = explode('.', $name);
		$chain = null;
		if (count($parts) > 1)
		{
			$name = $parts[0];
			array_shift($parts);
			$chain = implode('.', $parts);
		}

		$items = $this->getItems();

		if (empty($items))
			return;


		$relation = $this->getRelation($name);

		if (!$relation)
			return;

		$localKey = $relation->localKey;
		$foreignKey = $relation->foreignKey;


		$db = JFactory::getDbo();

		$itemIds = array();
		foreach($items as $item)
		{
			$itemIds[(int)$item->$localKey] = true;
		}

		$modelName = $relation->foreignModelClass;
		$extension = 'Bds';
		$parts = explode('.', $modelName);
		if (count($parts) > 1)
		{
			$extension = $parts[0];
			$modelName = $parts[1];
		}


		$model = CkJModel::getInstance($modelName, ucfirst($extension) . 'Model');
		if (!$model)
			return;

		$model->setState('context', ''); // Empty select
		$model->setState('list.limit', null);
		$model->setState('list.start', null);

		$relType = 'array';

		switch($relation->type)
		{
			// Many to Many
			case 'belongsToMany':

				$pivotTable = $relation->pivotTable;
				$pivotForeignKey = $relation->pivotForeignKey;
				$pivotLocalKey = $relation->pivotLocalKey;


				$model->addJoin($db->qn($pivotTable)
					. ' AS ' . $db->qn('pivot')
					. ' ON a.' . $foreignKey . ' = pivot.' . $pivotForeignKey, 'LEFT');


				$model->addSelect('pivot.' . $pivotLocalKey . ' AS _local');


				// Filter mixing all parents to optimize the SQL queries
				$model->addWhere('pivot.' . $pivotLocalKey  . ' IN (' . implode(',', array_keys($itemIds)). ')');

				break;


			// Many to One
			case 'hasMany':

				$model->addSelect('a.' . $foreignKey);


				// Filter on the origin, mixing all parents to optimize the SQL queries
				$model->addWhere($db->qn($foreignKey) . ' IN (' . implode(',', array_keys($itemIds)). ')');

				break;

			// Foreign Key
			case 'hasOne':

				$relType = 'object';

				$model->addSelect('a.' . $foreignKey);

				// Filter on the origin, mixing all parents to optimize the SQL queries
				$model->addWhere($db->quoteName($foreignKey) . ' IN (' . implode(',', array_keys($itemIds)). ')');

				break;
		}


		// Select the given fields
		foreach($relation->selectFields as $selectField)
		{
			$model->addSelect('a.' . $selectField);
		}

		// Get a mixed list
		$rows = $model->getItems();

		// Load the sub items
		if ($chain)
			$model->loadRelations($chain);


		// Sort by $remoteValue
		$dico = array();
		foreach($rows as $row)
		{
			// N:M
			if (isset($row->_local))
			{
				$remoteValue = $row->_local;
				unset($row->_local);
			}

			// N:1
			else
			{
				$remoteValue = $row->$foreignKey;
			}

			if ($relType == 'array')
			{
				if (empty($dico[$remoteValue]))
					$dico[$remoteValue] = array();

				$dico[$remoteValue][] = $row;
			}
			else
				$dico[$remoteValue] = $row;
		}


		// Reassemble the lists in the correct parents
		foreach($items as $item)
		{
			$localValue = $item->$localKey;
			$item->$name = (isset($dico[$localValue])?$dico[$localValue]:(($relType == 'array')?array():null));
		}

		return $items;
	}

	/**
	* Load a N:x relation list to objects array in the item.
	*
	* @access	public
	* @param	object	&$items	The items to populate.
	* @param	string	$objectField	The item property name used for this list.
	* @param	string	$xrefTable	Cross Reference (Xref) table handling this link.
	* @param	string	$on	The FK fieldname from Xref pointing to the origin
	* @param	string	$key	The ID fieldname from Origin.
	* @param	array	$states	Cascad states followers, for recursive objects.
	* @param	string	$context	SQL predefined query
	*
	*
	* @since	Cook 2.6.3
	*
	* @return	void
	*/
	public function loadXref(&$items, $objectField, $xrefTable, $on, $key, $states = array(), $context = 'object.default')
	{
		$db = JFactory::getDbo();

		if ($this->getState('xref.' . $objectField) && count($items))
		{
			$itemIds = array();
			foreach($items as $item)
			{
				$itemIds[(int)$item->$key] = true;
			}

			$model = CkJModel::getInstance($xrefTable, 'BdsModel');

			// Prepare the fields to load, trough a context profile
			$model->setState('context', $context);

			// Be sure the 'on' field is in the query
			$model->addSelect('a.' . $on);

			// Filter on the origin, mixing all parents to optimize the SQL queries
			$model->addWhere($db->quoteName($on) . ' IN (' . implode(',', array_keys($itemIds)). ')');


			//Cascad objects states
			// Apply the namespaced states to the relative base namespace
			if (count($states))
			foreach($states as $state)
			{
				if ($val = $this->getState('xref.' . $objectField . '.' . $state))
					$model->setState('xref.' . $state, $val);
			}


			// Get a mixed list
			$rows = $model->getItems();

			// Sort by 'ON' field value
			$dico = array();
			foreach($rows as $row)
			{
				if (empty($dico[$row->$on]))
					$dico[$row->$on] = array();

				$dico[$row->$on][] = $row;

			}

			// Reassemble the lists in the correct parents
			foreach($items as $item)
			{
				$item->$objectField = $dico[$item->$key];
			}

		}
	}

	/**
	* Common method to prepare a new relation.
	*
	* @access	protected
	* @param	string	$type	Relation type.
	* @param	string	$name	Relation name.
	* @param	string	$foreignModelClass	Foreign model. Use the name when null.
	* @param	array	$selectFields	The required fields to include in select.
	*
	* @return	void
	*/
	protected function newRelation($type, $name, $foreignModelClass = null, $selectFields = array())
	{
		$relation = new stdClass();
		$extension = self::$extension;

		$relation->type = $type;

		if (!$foreignModelClass)
			$foreignModelClass = $name;

		$model = $foreignModelClass;
		$parts = explode('.', $foreignModelClass);
		if (count($parts) > 1)
		{
			$extension = $parts[0];
			$model = $parts[1];
		}

		$relation->extension = $extension;

		$relation->model = $model;

		$relation->name = $name;
		$relation->foreignModelClass = $extension . '.' . $model;
		$relation->foreignTable = '#__' . ($extension?strtolower($extension) . '_':'') . $relation->model;

		$relation->selectFields = $selectFields;

		// Index localy in the model
		$this->relations[$name] = $relation;

		return $relation;
	}

	/**
	* Request the ORM system.
	*
	* @access	public
	* @param	array	$description	Configuration or the ORM request
	*
	*
	* @since	Cook 3.0.10
	*
	* @return	void
	*/
	public function orm($description)
	{
		$this->orm->set($description);
	}

	/**
	* ORM Predefined profile for ALL columns and ALL rows.
	*
	* @access	protected
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	protected function ormAll()
	{
		$this->orm(array(
			'select' => '*',

			'pagination' => array(
				'limit' => null,
				'start' => null,
			)
		));
	}

	/**
	* Prepare some additional derivated objects.
	*
	* @access	public
	* @param	array	&$items	The objects to populate.
	*
	* @return	void
	*/
	public function populateObjects(&$items)
	{
		// Populate related lists (N:m)
		if (count($items))
		foreach($this->getRelations() as $name => $relation)
		{
			// Only N:m and N:1
			if (!in_array($relation->type, array('belongsToMany', 'hasMany')))
				continue;

			// Search for the ORM state vars
			if ($orm = $this->getState('relation.' . $name))
				$this->loadRelation($name, $items, $orm);
		}


	}

	/**
	* Prepare some additional important values.
	*
	* @access	public
	* @param	array	&$items	The objects to populate.
	*
	* @return	void
	*/
	public function populateParams(&$items)
	{
		if (!isset($items) || empty($items))
			return;

		$model = CkJModel::getInstance($this->view_item, 'BdsModel');
		foreach ($items as &$item)
		{
			// TODO : attribs
		//			$itemParams = new JRegistry;
		//			$itemParams->loadString((isset($item->attribs)?$item->attribs:$item->params));

			//$item->params = clone $this->getState('params');

			$item->params = new JObject();;

			if ($model)
			{
				if ($model->canView($item))
					$item->params->set('access-view', true);

				if ($model->canEdit($item))
					$item->params->set('access-edit', true);

				if ($model->canDelete($item))
					$item->params->set('access-delete', true);

				if ($model->isCheckedIn($item))
					$item->params->set('tag-checkedout', true);

				if (isset($item->published))
					$item->params->set('tag-published', $item->published);

				if (isset($item->default))
					$item->params->set('tag-default', $item->default);

			}
		}
	}

	/**
	* Method to auto-populate the model state.
	*
	* @access	protected
	* @param	string	$ordering	
	* @param	string	$direction	
	*
	* @return	void
	*/
	protected function populateState($ordering = null, $direction = null)
	{
		$jinput = JFactory::getApplication()->input;
		$layout = $jinput->get('layout', null, 'CMD');
		$render = $jinput->get('render', '', 'CMD');

		if ($layout == 'ajax')
		{
			$this->setState('context', 'ajax' . ($render?'.'.$render:''));
			$this->setState('list.limit', 0);
			$this->setState('list.start', 0);
		}


		$globalParams = JComponentHelper::getParams('com_bds', true);
		$this->setState('params', $globalParams);

		// If the context is set, assume that stateful lists are used.
		if ($this->context)
		{
			$app = JFactory::getApplication();

			// Handle legacy limitstart
			if ($jinput->get('limitstart') !== null)
				$jinput->set('start', $jinput->get('limitstart'));

		// FILTERS
			foreach($this->filter_vars as $var => $varType)
			{
				//1. Read the state var sent by the caller
				//2. Then read the Request in URL
				//3. Finally read the persistant value for THIS context
				$value = $this->state->get('filter.' . $var,
					$this->getUserStateFromRequest(
						$this->context . '.filter.' . $var,
						'filter_' . $var,
						null,
						$varType
					)
				);

				//Convert datetime entries back from a custom format
				if ($value && (preg_match("/^date:(.+)/", $varType, $matches)))
				{
					$date = BdsHelperDates::timeFromFormat($value, $matches[1]);
					if ($date)
					{
						jimport('joomla.utilities.date');
						$jdate = new JDate($date);
						$value = $jdate->toSql();
					}
					else
						continue;
				}
				$this->setState('filter.' . $var, $value);
			}

		// FILTERS : SEARCHES
			foreach($this->search_vars as $var => $varType)
			{
				//1. Read the state var sent by the caller
				//2. Then read the Request in URL
				//3. Finally read the persistant value for THIS context
				$value = $this->state->get('search.' . $var,
					$this->getUserStateFromRequest($this->context . '.search.' . $var,
						'search_' . $var,
						null,
						$varType
					)
				);

				$this->setState('search.' . $var, $value);
			}


		// PAGINATION : LIMIT
			//1. First read the state var sent by the caller
			//2. Then read the Request in URL
			//3. Then read the default limit value for THIS context
			//4. Finally read the list limit value from the Joomla configuration
			$limit = $this->state->get('list.limit',
				$app->getUserStateFromRequest($this->context . '.list.limit',
					'limit',
					$this->state->get('list.limit.default',
						$app->getCfg('list_limit')
					)
				)
			);

			$this->setState('list.limit', $limit);


		// PAGINATION : LIMIT START
			//1. First read the Request in URL
			//2. Then read the state var sent by the caller
			$value = $app->getUserStateFromRequest($this->context . '.start',
				'start',
				$this->state->get('list.start')
			);


			$limitstart = ($limit != 0 ? (floor($value / $limit) * $limit) : 0);
			$this->setState('list.start', $limitstart);


		// SORTING : ORDERING (Vocabulary confusion in Joomla. This is a SORTING. Ordering is an index value in the item.)
			//1. First read the Request in URL
			//2. Then read the default sorting value sent trough the args (called 'ordering')
			$value = $app->getUserStateFromRequest($this->context . '.list.ordering',
				'filter_order',
				$ordering
			);


			if (!in_array($value, $this->filter_fields))
			{
				$value = $ordering;
				$app->setUserState($this->context . '.ordercol', $value);
			}
			$this->setState('list.ordering', $value);


		// SORTING : DIRECTION
			//1. First read the Request in URL
			//2. Then read the default direction value sent trough the args.
			$value = $app->getUserStateFromRequest($this->context . '.orderdirn',
				'filter_order_Dir',
				$direction
			);

			if (!in_array(strtoupper($value), array('ASC', 'DESC', '')))
			{
				$value = $direction;
				$app->setUserState($this->context . '.orderdirn', $value);
			}
			$this->setState('list.direction', $value);
		}
		else
		{
			$this->setState('list.start', 0);
			$this->state->set('list.limit', 0);
		}

		if (defined('JDEBUG'))
			$_SESSION["Bds"]["Model"][$this->getName()]["State"] = $this->state;
	}

	/**
	* Register the ORM rules into model state SQL statements.
	*
	* @access	protected
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	protected function populateStatesOrm()
	{
		// Primary Key is always required
		$this->orm->select($this->getNamePk());

		// Load the SQL context profile (from ormXxxxYyyy() function)
		if ($context = $this->getState('context', 'all'))
		{
			$fctOrm = 'orm';
			foreach(explode('.', $context) as $part)
				$fctOrm .= ucfirst($part);


			// Call the predefined profile function
			if (method_exists($this, $fctOrm))
				$this->$fctOrm();
		}

		// Get the ORM description from the XML filters file
		$ormFilters = $this->getOrmFilters();

		// Request with ORM
		$this->orm($ormFilters);

		// Set the list ordering
		$orderCol = $this->getState('list.ordering');
		$orderDir = $this->getState('list.direction', 'ASC');


		if ($orderCol)
			$this->orm->order(array($orderCol => $orderDir));
	}

	/**
	* Method to easily filter the dates.
	*
	* @access	public
	* @param	string	$field	Field to apply the filter.
	* @param	string	$range	String to describe the starting time range, or predefined range. ex: [-4 day][-2 month][null][defined]
	* @param	string	$rangeEnd	String to describe the ending time range
	*
	* @return	void
	*/
	public function prepareFilterTime($field, $range, $rangeEnd = null)
	{
		$db = JFactory::getDbo();

		// Get UTC for now.
		$dNow = new JDate;
		$dBegin = clone $dNow;
		$dEnd = clone $dNow;

		// Define the starting time.
		switch($range)
		{
	
			case 'now':
				// 1 hour back per default.
				$dBegin->modify('-1 hour');
				break;
		
			case 'today':
				//Align on the days bounds
		
				// Ranges that need to align with local 'days' need special treatment.
				$app	= JFactory::getApplication();
				$offset	= $app->getCfg('offset');

				// Reset the start time to be the beginning of today, local time.
				$dBegin	= new JDate('now', $offset);
				$dBegin->setTime(0, 0, 0);

				// Now change the timezone back to UTC.
				$tz = new DateTimeZone('GMT');
				$dBegin->setTimezone($tz);
				break;
	
			default: 		
				$dBegin->modify($range);
			break;
		}


		//Define the ending time.
		switch($rangeEnd)
		{
			case null: break;

	
			default: 		
				$dEnd->modify($rangeEnd);
			break;
		}

		// Search for null dates.
		if ($range == 'null')
		{
			$this->addWhere($field . " IS NULL ");
			return;
		}

		// Search for defined dates.
		if ($range == 'defined')
		{
			$this->addWhere($field . " <> NULL ");
			return;
		}

		// Time cannot be null.
		$this->addWhere($field . " IS NOT NULL ");

		// Apply the STARTING time filter.
		$this->addWhere($field . " >= " . $db->quote($dBegin->toSql()));			

		// Apply the ENDING time filter.
		$this->addWhere($field . " < " . $db->quote($dEnd->toSql()));			
	}

	/**
	* Prepare the query for filtering accesses. Can be used on foreign keys.
	*
	* @access	protected
	* @param	varchar	$table	The table alias (_tablealias_).
	* @param	varchar	&$whereAccess	The returned SQL access filter. Set to true to activate it.
	* @param	varchar	&$wherePublished	The returned SQL published filter. Set to true to activate it.
	* @param	varchar	&$allowAuthor	The returned SQL to allow author to pass. Set to true to activate it.
	*
	* @return	void
	*/
	protected function prepareQueryAccess($table = 'a', &$whereAccess = null, &$wherePublished = null, &$allowAuthor = null)
	{
		$acl = BdsHelper::getActions();

		// Must be aliased ex : _tablename_
		if ($table != 'a')
			$table = '_' . trim($table, '_') . '_';


		// ACCESS - View Level Access
		if ($whereAccess)
		{
			// Select fields requirements
			if ($table != 'a')
				$this->addSelect($table . '.access AS `' . $table . 'access`');	

			$whereAccess = '1';
			if (!$this->canAdmin())
			{	
			    $groups	= implode(',', JFactory::getUser()->getAuthorisedViewLevels());
				$whereAccess = $table . '.access IN ('.$groups.')';
			}
		}

		// ACCESS - Author
		if ($allowAuthor)
		{
			// Select fields requirements
			if ($table != 'a')
				$this->addSelect($table . '.created_by AS `' . $table . 'created_by`');

			$allowAuthor = '0';
			//Allow the author to see its own unpublished/archived/trashed items
			if ($acl->get('core.edit.own') || $acl->get('core.view.own') || $acl->get('core.delete.own'))
				$allowAuthor = $table . '.created_by = ' . (int)JFactory::getUser()->get('id');
		
		}

		// ACCESS - Publish state
		if ($wherePublished)
		{
			// Select fields requirements
			if ($table != 'a')
				$this->addSelect($table . '.published AS `' . $table . 'published`');

			$wherePublished = '(' . $table . '.published = 1 OR ' . $table . '.published IS NULL)'; //Published or undefined state
			//Allow some users to access (core.edit.state)
			if ($acl->get('core.edit.state'))
				$wherePublished = '1'; //Do not filter

			// FILTER - Published state
			$published = $this->getState('filter.published');

			//Only apply filter on current table. Aand only if ACL permits.
			if (($table == 'a') && (is_numeric($published)) && $acl->get('core.edit.state'))
			{
				//Limit to publish state when filter is applied
				$wherePublished = $table . '.published = ' . (int)$published;
				//Does not apply the author condition when filter is defined
				$allowAuthor = '0';
			}
		}

		// Fallback values
		if (!$whereAccess)
			$whereAccess = '1';

		if (!$allowAuthor)
			$allowAuthor = '0';

		if (!$wherePublished)
			$wherePublished = '1';
	}

	/**
	* This feature is the blueprint of ORM-kind feature. It create the optimized
	* SQL query for mounting an object, including foreign links.
	*
	* @access	public
	* @param	array	$headers	The header structure. see:https://www.akeebabackup.com/documentation/fof/common-fields-for-all-types.html
	*
	*
	* @since	Cook 2.6.3
	*
	* @return	void
	*/
	public function prepareQueryHeaders($headers)
	{
		if (!count($headers))
			return;

		$db = JFactory::getDbo();

		foreach($headers as $namespace => $header)
		{
			// the namespace is used to localize the foreign key path
			$fieldAlias = $namespace = $header['name'];
			if (isset($header['namespace']))
				$namespace = $header['namespace'];

			$parts = explode('.' ,$namespace);
			$isFk = (count($parts) > 1);


			// Physical field name is always the last part
			$fieldname = $parts[count($parts)-1];
			$current = $parts[0];

			$parentTable = 'a';

			for($i = 0 ; $i < (count($parts)) ; $i++)
			{
				$isLast = ($i == (count($parts) - 1));
				$current = $parts[$i];

				// Select the field
				if ($isLast)
					break;

				$tableName = self::fkTable($current);
				$tableAlias = '_' . $current . '_';

				// Join the required tables
				$this->addJoin($db->qn($tableName)
					.	' AS ' . $tableAlias
					.	' ON ' . $tableAlias . '.id'
					.	' = ' . $parentTable . '.' . $current

					, 'LEFT');

				$parentTable = $tableAlias;
			}

			// Instance the field in query
			$this->addSelect($parentTable .'.'. $current . ' AS ' . $db->qn($fieldAlias));
		}
	}

	/**
	* Join the table behind the Foreign Key.
	*
	* @access	protected
	* @param	string	$namespace	Namespace of the Foreign Keys chain
	*
	*
	* @since	Cook 3.0.10
	*
	* @return	void
	*/
	protected function prepareQueryJoin($namespace)
	{
		$parts = explode('.', $namespace);
		$model = $this;
		$table = $this->getName();

		$tableAlias = 'a';
		foreach($parts as $field)
		{
			$relation = $model->getRelation($field);

			$this->addJoin('`' . $relation->foreignTable . '` AS _' . $field
				. '_ ON _' . $field . '_.' . $relation->foreignKey . ' = ' . $tableAlias . '.' . $field, 'LEFT');


			$tableAlias = '_' . $field . '_';

			$partsModel = explode('.', $relation->foreignModelClass);

			$model = CkJModel::getInstance($partsModel[1], ucfirst($partsModel[0]) . 'Model');
		}
	}

	/**
	* Method to prepare a query including relations.
	*
	* @access	public
	* @param	string	$name	Relation name. Can be namespaced to load in cascad
	* @param	boolean	$groupOrder	Instance a prioritary order for groups.
	*
	* @return	void
	*/
	public function prepareQueryRelations($name, $groupOrder = false)
	{
		if (empty($name))
			return;

		$db = JFactory::getDbo();

		$extension = self::$extension;

		// Nested relations
		$parts = explode('.', $name);


		// Initialize the base
		$parentTable = 'a';
		$fieldAliasBase = '';
		$model = $this;

		for($i = 0 ; $i < count($parts) ; $i++)
		{
			$name = $parts[$i];

			$relation = $model->getRelation($name);

			// Break whole process here (cannot cascad more)
			if (!$relation)
				return;

			// Only Foreign Key relation are handled here
			if ($relation->type != 'hasOne')
				return;

			$foreignTable = $relation->foreignTable;

			$fieldAliasBase .= '_' . $relation->localKey;


			// Join the required tables
			$this->addJoin($db->quoteName($foreignTable)
				.	' ON ' . $foreignTable . '.' . $relation->foreignKey
				.	' = ' . $parentTable . '.' . $relation->localKey

				, 'LEFT');

			// Select the foreign Pkey
			$this->addSelect($foreignTable .'.'. $relation->foreignPkey . ' AS ' . $db->quoteName($fieldAliasBase));


			$defaultField = null;

			// Instance every select field in query
			foreach($relation->selectFields as $selectField)
			{
				if (!$defaultField)
					$defaultField = $selectField;

				$fieldAlias = $fieldAliasBase . '_' . $selectField;
				$this->addSelect($foreignTable .'.'. $selectField . ' AS ' . $db->quoteName($fieldAlias));
			}


			// Instance a prioritary order, when the relations are used to group a list
			if ($groupOrder && $defaultField)
				$this->addGroupOrder($foreignTable .'.'. $defaultField . ' ASC');


			// Initialize for the next nested relation
			if ($i < (count($parts)))
			{
				$parentTable = $foreignTable;
				$model = CkJModel::getInstance($relation->model, ucfirst($relation->extension) . 'Model');
			}

		}
	}

	/**
	* Prepare the language translation of items for SQL query.
	*
	* @access	protected
	* @param	array	$fields	The fields you want to translate.
	* @param	array	$options	An array of configuration.
	*
	* @return	void
	*/
	protected function prepareQueryTranslate($fields, $options = array())
	{
		if (empty($fields))
			return;

		//Define an alias prefix when the selected field is abroad FK. (ie: _product_category_title, use : _product_category_)
		$fieldPrefix = '';
		if (isset($options['fieldPrefix']))
		{
			$fieldPrefix = $options['fieldPrefix'];
			$tableAlias = $fieldPrefix;
			$langTableAlias = '__lang' . $fieldPrefix;
		}
		else
		{
			$tableAlias = 'a';
			$langTableAlias = '__lang_';
		}

		//The alias used in query for temporary load the related language item (be careful unicity of table aliases)
		if (isset($options['langTableAlias']))
			$langTableAlias = $options['langTableAlias'];

		//The table name from witch are stored the languages strings
		$tableFrom = '#__' . ltrim($this->option, '_com') . '_' . $this->getName();
		if (isset($options['tableFrom']))
			$tableFrom = $options['tableFrom'];

		//Define the field on which the filter is working. Language tag (ie: en-GB).
		$keyLang = 'language';
		if (isset($options['keyLang']))
			$keyLang = $options['keyLang'];

		//Define the recursive field FK which relate to the original item
		$keyXref = 'xref';
		if (isset($options['keyXref']))
			$keyXref = $options['keyXref'];

		//Limit to the root elements when not the root table (a.)
		if (isset($options['tableFrom']))
			$this->addWhere("($tableAlias.$keyXref IS NULL || $tableAlias.$keyXref = 0)");

		//Apply the filter
		$stateValue = $this->getState('filter.language');
		if ($stateValue !== null)
		{
			// Join language table (recursive 1 level)
			$this->addJoin("`$tableFrom` AS `$langTableAlias` ON ($langTableAlias.$keyXref = $tableAlias.id AND $langTableAlias.$keyLang = "
					. $this->_db->Quote($stateValue)
					. ')' , 'LEFT');

			//Translatable fields
			foreach($fields as $key)
				$this->addSelect("(CASE WHEN ($langTableAlias.$key IS NOT NULL AND $langTableAlias.$key > 0) THEN $langTableAlias.$key ELSE $tableAlias.$key END) AS `$fieldPrefix$key`");
		}
	}

	/**
	* Proxy. Dump the query to the screen.
	*
	* @access	public
	* @param	JDatabaseQuery	$query	Query to dump.
	* @param	boolean	$output	Print the query description to the standard output.
	*
	*
	* @since	Cook 3.1
	*
	* @return	array	Query description.
	*/
	public function queryDump($query, $output = true)
	{
		return BdsClassModelOrm::queryDump($query, $output);
	}

	/**
	* Method to adjust the ordering of a row.
	*
	* @access	public
	* @param	array	$ids	The ID of the primary key to move.
	* @param	int	$inc	Delta increment, usually +1 or -1.
	*
	*
	* @since	11.1
	*
	* @return	boolean	True on success
	*/
	public function reorder($ids, $inc)
	{
		$model = $this->getModel(true);

		$table = $model->getTable();
		$table->load($ids[0]);

		if (!$table->move($inc))
			return false;

		$conditions = $model->getReorderConditions($table);
		$conditions = (count($conditions)?implode(" AND ", $conditions):'');
		$table->reorder($conditions);

		return true;
	}

	/**
	* Unify the orderdering statements syntax.
	*
	* @access	protected
	* @param	string	$order	SQL order statement
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	protected function sanitizeOrdering($order)
	{
		$parts = explode(' ', trim($order));

		$field = $parts[0];

		$dir = 'ASC'; // Per default
		if ((count($parts) > 1) && in_array($parts[1], array('ASC', 'DESC')))
			$dir = $parts[1];

		return $field . ' ' . $dir;
	}

	/**
	* Saves the manually set order of records.
	*
	* @access	public
	* @param	array	$pks	An array of primary key ids.
	* @param	array	$order	order values
	*
	*
	* @since	11.1
	*
	* @return	boolean	True on success
	*/
	public function saveorder($pks, $order)
	{
		$model = $this->getModel(true);
		$model->saveorder($pks, $order);
	}

	/**
	* Method to set model state variables. Update local vars.
	*
	* @access	public
	* @param	string	$property	The name of the property.
	* @param	mixed	$value	The value of the property to set or null.
	*
	*
	* @since	11.1
	*
	* @return	mixed	The previous value of the property or null if not set.
	*/
	public function setState($property, $value = null)
	{
		if ($property == 'context')
			$this->context = $value;
	
		return parent::setState($property, $value);
	}

	/**
	* Construct the field alias based on the table alias.
	*
	* @access	protected
	* @param	string	$namespace	Namespace of the Foreign Keys chain
	*
	*
	* @since	Cook 3.0.10
	*
	* @return	void
	*/
	protected function tableFieldAlias($namespace)
	{
		$parts = explode('.', $namespace);

		$table = 'a';

		foreach($parts as $part)
		{
			$alias = $table . '.' . $part;
			$table = '_' . $part . '_';
		}

		return $alias;
	}

	/**
	* Synchronize the N:M references Add/Remove.
	*
	* @access	public
	* @param	string	$field	Fk fieldname in the Xref table
	* @param	array	$values	Array of ID of the values for $field
	* @param	string	$on	Fk fieldname pointing the origin referral.
	* @param	integer	$id	ID value of the origin.
	*
	*
	* @since	Cook 2.6.3
	*
	* @return	boolean	True when success.
	*/
	public function updateXref($field, $values, $on, $id)
	{
		$db = JFactory::getDbo();

		$sqlValues = implode(',', $values);
		if (empty($sqlValues))
			$sqlValues = '0';


		// Get all current links in context
		$model = CkJModel::getInstance($this->getName(), 'BdsModel');
		$model->addWhere($db->quoteName($on) . '='. $id);

		$xref = $model->getItems();
		$refs = array();

		$isNm = true;
		if ($field == null)
		{
			$isNm = false;
			$field = 'id';
		}

		$delete = array();
		foreach($xref as $row)
		{
			$refs[] = $row->$field;
			if (!in_array($row->$field, $values))
			{
				//Delete row
				$delete[] = $row->id;
			}
		}

		$create = array();
		foreach($values as $val)
		{
			if (!in_array($val, $refs))
			{
				//Create new row
				$create[] = $val;
			}
		}

		$result = true;

		// In case on N:M, the links are physical rows
		if ($isNm)
		{
			//Apply delete
			$model = CkJModel::getInstance($this->view_item, 'BdsModel');
			if (count($delete))
				if (!$model->delete($delete))
					$result = false;


			// Create new entries
			$model = CkJModel::getInstance($this->view_item, 'BdsModel');
			if (count($create))
			foreach($create as $val)
			{
				if (!$model->save(array(
					'id' => 0, //New
					$on => $id,
					$field => $val
				)))
					$result = false;
			}
		}

		// In case of N:1, the links are FK from the opposite table
		else
		{

			if (count($delete))
			{
				$query = $db->getQuery(true);
				$query->update('#__bds_' . $this->getName())

					// Unlink it
					->set($db->quoteName($on) . '= NULL')

					// From the given list to delete
					->where($db->quoteName($field) . ' IN (' . implode(',', $delete). ')');

				$db->setQuery($query);


				if (!$db->query())
					$result = false;
			}

			if (count($create))
			{
				$query = $db->getQuery(true);
				$query->update('#__bds_' . $this->getName())

					// Link it
					->set($db->quoteName($on) . '='. (int)$id)

					// Facultative security : ONLY free items are linkables $on = (NULL or O)
					->where('(' . $db->quoteName($on) . ' IS NULL OR ' . $db->quoteName($on) . ' = 0 '. ')')

					// From the given list to create
					->where($db->quoteName($field) . ' IN (' . implode(',', $create). ')');

				$db->setQuery($query);

				if (!$db->query())
					$result = false;

			}
		}

		return $result;

	}


}



