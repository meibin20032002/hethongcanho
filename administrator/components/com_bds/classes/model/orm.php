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
* ORM Class for Bds.
*
* @package	Bds
* @subpackage	Class
*/
class BdsClassModelOrm
{
	/**
	* Database.
	*
	* @var JDatabase
	*/
	protected $_db;

	/**
	* Model where ORM applies.
	*
	* @var JModel
	*/
	protected $model;

	/**
	* Constructor.
	*
	* @access	public
	* @param	JModel	$model	Model where ORM applies.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function __construct($model)
	{
		$this->model = $model;
		$this->_db = JFactory::getDbo();
	}

	/**
	* Filter access (publish + author + accesslevel).
	*
	* @access	public
	* @param	string	$tableField	namespace table.
	* @param	array	$config	Access Filter configuration.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function access($tableField, $config)
	{
		$wherePublished = $allowAuthor = $whereAccess = null;


		$acl = BdsHelper::getActions();

		// ACCESS - View Level Access
		if (isset($config['access']))
		{
			$keyAccess = $config['access'];

			$accessNamespace = $tableField . '.' . $keyAccess;
			$accessFieldAlias = static::tableFieldAlias($accessNamespace);

			$this->select($accessNamespace);

			$whereAccess = '1';
			if (!$this->model->canAdmin())
			{
			    $groups	= implode(',', JFactory::getUser()->getAuthorisedViewLevels());
				$whereAccess = $accessFieldAlias . ' IN ('.$groups.')';
			}
		}


		// AUTHOR - Allow the author in some cases
		if (isset($config['author']))
		{
			$keyAuthor = $config['author'];

			$authorNamespace = $tableField . '.' . $keyAuthor;
			$authorFieldAlias = static::tableFieldAlias($authorNamespace);

			$this->select($authorNamespace);

			$allowAuthor = '0';
			// Allow the author to see its own unpublished/archived/trashed items
			if ($acl->get('core.edit.own') || $acl->get('core.view.own') || $acl->get('core.delete.own'))
			{
				$allowAuthor = $authorFieldAlias . ' = ' . (int)JFactory::getUser()->get('id');
			}

			// Do not apply filter
			if ($allowAuthor == '0')
				$allowAuthor = null;
		}


		if (isset($config['publish']))
		{
			$keyPublished = $config['publish'];

			$publishedNamespace = $tableField . '.' . $keyPublished;
			$publishedFieldAlias = static::tableFieldAlias($publishedNamespace);

			$this->select($publishedNamespace);


			$wherePublished = '(' . $publishedFieldAlias . ' = 1 OR ' . $publishedFieldAlias . ' IS NULL)'; //Published or undefined state

			// Allow some users to access (core.edit.state)
			if ($acl->get('core.edit.state'))
				$wherePublished = '1'; //Do not filter

			// FILTER - Published state
			$published = $this->model->getState('filter.' . $keyPublished);

			// Only apply filter on current table. And only if ACL permits.
			if (($tableField == 'a') && (is_numeric($published)) && $acl->get('core.edit.state'))
			{
				// Limit to publish state when filter is applied
				$wherePublished = $publishedFieldAlias . ' = ' . (int)$published;

				// Very important : Does not apply the author condition when filter is defined
				$allowAuthor = '0';
			}

			// Do not apply filter
			if ($wherePublished == '1')
				$wherePublished = null;
		}

		// Build the condition using a SQL composer
		$where = $this->sqlWhereConditions(array(

			// Restrictions
			$whereAccess,
			$wherePublished
		), array(

			// Permissions
			$allowAuthor
		));

		if ($where)
			$this->model->addWhere($where);
	}

	/**
	* Set the context on the model.
	*
	* @access	public
	* @param	string	$config	Context name.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function context($config)
	{
		$this->model->setState('context', (string)$config);
	}

	/**
	* Filter directive.
	*
	* @access	public
	* @param	string	$name	Unique filter name.
	* @param	array	$config	Filter configuration.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function filter($name, $config)
	{
		$type = 'string';
		if (isset($config['type']))
			$type = $config['type'];

		if (in_array($type, array('enum')))
			$type = 'string';

		// Not allowed
		if (!in_array($type, array('fk', 'multi', 'pivot', 'string', 'range', 'period')))
			return;

		$fct = 'filter' . ucfirst($type);
		$this->$fct($name, $config);
	}

	/**
	* Filter on a Foreign Key.
	*
	* @access	public
	* @param	string	$name	Unique filter name.
	* @param	array	$config	Foreign Key Filter configuration.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function filterFk($name, $config)
	{
		$stateName = 'filter.' . $name;

		// Force a value
		if (isset($config['value']))
			$this->model->setState($stateName, $config['value']);


		$value = $this->model->getState($stateName, null);
		if (($value === null) || ($value === ''))
			return;

		if (is_array($value))
			return $this->filterMulti($name, $config);

		// Cast to int
		$value = (int)$value;

		if (isset($config['namespace']))
		{
			$namespace = $config['namespace'];
			// Join the requiremnts
			$this->select($namespace);

			$fieldAlias = static::tableFieldAlias($namespace);
		}
		else
			$fieldAlias = static::tableFieldAlias($name);

		$this->model->addWhere($fieldAlias . ' = ' . $value);
	}

	/**
	* Filter with multiple values.
	*
	* @access	public
	* @param	string	$name	Unique filter name.
	* @param	array	$config	Multiple Filter configuration.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function filterMulti($name, $config)
	{
		// Force a value
		if (isset($config['value']))
			$this->model->setState('filter.' . $name, $config['value']);

		$namespace = null;
		if (isset($config['namespace']))
			$namespace = $config['namespace'];

		$logic = null;
		if (isset($config['logic']))
			$logic = $config['logic'];


		$format = 'fk';
		if (isset($config['format']))
			$format = $config['format'];


		$values = array();
		if ($vals = $this->model->getState('filter.' . $name))
		{
			// Remove empty values
			if (is_array($vals))
				foreach($vals as $val)
					if (!empty($val))
						$values[] = $val;
		}

		if (empty($values))
			return;

		// JOIN the requirements
		if ($namespace)
			$this->join($namespace);

		if (isset($config['namespace']))
			$fieldAlias = static::tableFieldAlias($config['namespace']);
		else
			$fieldAlias = static::tableFieldAlias($name);

		$ids = array();
		switch($format)
		{
			case 'int':
			case 'fk':

				// Cast values
				foreach($values as $val)
					$ids[] = (int)$val;

				break;

			case 'cmd':
			case 'varchar':
			case 'enum':
				// Cast values
				foreach($values as $val)
					$ids[] = $this->_db->quote($val);

				break;
		}


		if (!count($ids))
			return;


		switch($logic)
		{
			// Exclude
			case 'NOT':
				$this->model->addWhere($fieldAlias . " NOT IN (" . implode(',', $ids) . ")");
				break;

			// Restrict
			default:
				$this->model->addWhere($fieldAlias . " IN (" . implode(',', $ids) . ")");
				break;
		}
	}

	/**
	* Filter over a period of time, using period strings.
	*
	* @access	public
	* @param	string	$name	Unique filter name.
	* @param	array	$config	Period Filter configuration.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function filterPeriod($name, $config)
	{
		if (array_key_exists('namespace', $config))
		{
			$namespace = $config['namespace'];

			// Join the requiremnts
			$this->select($namespace);

			$fieldAlias = static::tableFieldAlias($namespace);
		}
		else
			$fieldAlias = static::tableFieldAlias($name);

		// PERIOD
		$statePeriod = 'filter.' . $name;
		if (array_key_exists('value', $config))
			$this->model->setState($statePeriod, $config['value']);

		$value = $this->model->getState($statePeriod);

		// Search for null dates.
		if ($value == 'null')
		{
			$this->model->addWhere($fieldAlias . " IS NULL ");
			return;
		}

		// Search for defined dates.
		if ($value == 'defined')
		{
			$this->model->addWhere($fieldAlias . " <> NULL ");
			return;
		}


		// END
		$stateEnd = 'filter.' . $name . '.range';
		if (array_key_exists('range', $config))
			$this->model->setState($stateEnd, $config['range']);

		$valueRange = $this->model->getState($stateEnd);


		// Time cannot be null.
		$this->model->addWhere($fieldAlias . " IS NOT NULL ");


		// Use a shared function to transform period string to datetime bounds
		$range = $this->getPeriodRange($value, $valueRange);

		// Apply the STARTING time filter.
		if ($range['from'])
			$this->model->addWhere($fieldAlias . " >= " . $this->_db->quote($range['from']));

		// Apply the ENDING time filter.
		if ($range['to'])
			$this->model->addWhere($fieldAlias . " < " . $this->_db->quote($range['to']));
	}

	/**
	* Filter with a Xref value trough a pivot table (N:m).
	*
	* @access	public
	* @param	string	$name	Unique filter name.
	* @param	array	$config	Pivot Filter configuration.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function filterPivot($name, $config)
	{
		// Force a value
		if (isset($config['value']))
			$this->model->setState('filter.' . $name, $config['value']);

		$relationName = $name;
		if (isset($config['relation']))
			$relationName =  $config['relation'];

		$stateName = 'filter.' . $name;

		// Logic of the filter (AND|OR|NOT)
		if (isset($config['logic']))
		{
			$logic = $config['logic'];

			if (in_array($logic, array('AND', 'OR', 'NOT')))
				$this->model->setState($stateName . '.logic', $logic);
		}


		$stateName = 'filter.' . $relationName;

		if($values = $this->model->getState($stateName))
		{
			if (is_array($values))
			{
				$relation = $this->model->getRelation($relationName);

				// @logic Determines the behaviour of the filter
				$logic = strtoupper($this->model->getState($stateName . '.logic', 'AND'));
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

							$conditions[] = 'x.' . $relation->foreignKey . ' = ' . (int)$value;
						}

						if (count($conditions))
						{
							// Search for all related items matching the filter values
							$sql = $this->sqlBelongsOf($relation, $conditions);

							if ($logic == 'OR')
								// SQL Restriction list from the related items founds
								$this->model->addWhere("a.id IN (" . $sql . ")");
							else if ($logic == 'NOT')
								// SQL Exclusion of the related items founds.
								$this->model->addWhere("a.id NOT IN (" . $sql . ")");
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
							$sql = $this->sqlBelongsOf($relation, array('x.' . $relation->foreignKey . ' = ' . (int)$value));

							// Restrict SQL list from the related items founds
							$this->model->addWhere("a.id IN (" . $sql . ")");
						}

						break;
				}
			}
		}
	}

	/**
	* Filter with a range of values.
	*
	* @access	public
	* @param	string	$name	Unique filter name.
	* @param	array	$config	Pivot Filter configuration.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function filterRange($name, $config)
	{
		// FROM
		$stateNameFrom = 'filter.' . $name . '_from';
		if (isset($config['from']))
			$this->model->setState($stateNameFrom, $config['from']);

		$valueFrom = $this->model->getState($stateNameFrom);


		// TO
		$stateNameTo = 'filter.' . $name . '_to';
		if (isset($config['to']))
			$this->model->setState($stateNameTo, $config['to']);

		$valueTo = $this->model->getState($stateNameTo);


		// Not allowed
		if (is_array($valueFrom) || is_array($valueTo))
			return;

		if (empty($valueFrom) && empty($valueTo))
			return;

		if (isset($config['namespace']))
		{
			$namespace = $config['namespace'];

			// Join the requiremnts
			$this->select($namespace);

			$fieldAlias = static::tableFieldAlias($namespace);
		}
		else
			$fieldAlias = static::tableFieldAlias($name);


		if (!empty($valueFrom))
		{
			$valueFrom = $this->_db->quote($valueFrom);
			$this->model->addWhere($fieldAlias . ' >= ' . $valueFrom);
		}


		if (!empty($valueTo))
		{
			$valueTo = $this->_db->quote($valueTo);
			$this->model->addWhere($fieldAlias . ' <= ' . $valueTo);
		}
	}

	/**
	* Filter with a string value.
	*
	* @access	public
	* @param	string	$name	Unique filter name.
	* @param	array	$config	Filter configuration.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function filterString($name, $config)
	{
		$stateName = 'filter.' . $name;

		// Force a value
		if (isset($config['value']))
			$this->model->setState($stateName, $config['value']);

		$default = null;
		if (isset($config['default']))
			$default = $config['default'];

		$value = $this->model->getState($stateName, $default);

		// Not allowed
		if (is_array($value))
			return;

		if ($value == "")
			return;

		if (isset($config['namespace']))
		{
			$namespace = $config['namespace'];

			// Join the requiremnts
			$this->select($namespace);

			$fieldAlias = static::tableFieldAlias($namespace);
		}
		else
			$fieldAlias = static::tableFieldAlias($name);

		$value = $this->_db->quote($value);

		$this->model->addWhere($fieldAlias . ' = ' . $value);
	}

	/**
	* Get an ORM object.
	*
	* @access	public static
	* @param	JModel	$model	Model where ORM applies.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public static function getInstance($model)
	{
		return new BdsClassModelOrm($model);
	}

	/**
	* Get a model from a namespaced model name.
	*
	* @access	public static
	* @param	string	$modelName	Namespaced model. First part is the component name.
	*
	*
	* @since	Cook 3.1
	*
	* @return	JModel	Model.
	*/
	public static function getModel($modelName)
	{
		// Per default
		$extension = 'Bds';

		$parts = explode('.', $modelName);
		if (count($parts) > 1)
		{
			$extension = $parts[0];
			$modelName = $parts[1];
		}

		$model = CkJModel::getInstance($modelName, ucfirst($extension) . 'Model');

		return $model;
	}

	/**
	* Transform period string to SQL datetime bounds.
	*
	* @access	protected
	* @param	string	$period	Period string. Can be : today|now|null|defined or period string ex: +1day
	* @param	string	$range	Range string. Can be : period string ex: +1day
	*
	*
	* @since	Cook 3.1
	*
	* @return	array	Containing FROM and TO is a SQL format.
	*/
	protected function getPeriodRange($period, $range = null)
	{
		// Get UTC for now.
		$dNow = new JDate;
		$dFrom = clone $dNow;

		// Define the starting time.
		switch($period)
		{

			case 'now':
				// 1 hour back per default.
				$dFrom->modify('-1 hour');
				$dTo = clone $dNow;
				break;

			case 'today':
				//Align on the days bounds

				// Ranges that need to align with local 'days' need special treatment.
				$app	= JFactory::getApplication();
				$offset	= $app->getCfg('offset');

				// Reset the start time to be the beginning of today, local time.
				$dFrom	= new JDate('now', $offset);
				$dFrom->setTime(0, 0, 0);

				// Now change the timezone back to UTC.
				$tz = new DateTimeZone('GMT');
				$dFrom->setTimezone($tz);

				// End of the day
				$dTo = clone $dFrom;
				$dTo->modify('+1day');
				break;

			default:
				$dFrom->modify($period);
				$dTo = clone $dFrom;
			break;
		}


		//Define the ending time.
		switch($range)
		{
			case null: break;

			default:

				$dTo = clone $dFrom;
				$dTo->modify($range);
			break;
		}


		return array(
			'from' => ($dFrom?$dFrom->toSql():null),
			'to' => ($dTo?$dTo->toSql():null)
		);
	}

	/**
	* Group directive.
	*
	* @access	public
	* @param	array	$config	Groups configuration.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function groupOrder($config)
	{
		foreach($config as $namespace => $dir)
		{
			if (!in_array($dir, array('ASC', 'DESC'), true))
				$dir = 'ASC';

			$fieldAlias = static::tableFieldAlias($namespace);

			// Requirements
			$this->select($namespace);

			$this->model->addQuery('groupOrder', $fieldAlias . ' ' . $dir);
		}
	}

	/**
	* Rule to filter the unique item.
	*
	* @access	public
	* @param	mixed	$config	array|string. Configuration of the filter.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function id($config)
	{
		$id = (int)$this->model->getState($this->model->getName() . '.id');

		// Over the primary key
		if (is_string($config) || is_integer($config))
		{
			$value = $config;

			// Get the primary key field name
			$field = $this->model->getNamePk();

			// Automatic value from the id state var
			$value = ($value == 'id'?$id:$value);

			if (!empty($value))
			{
				// Pk used for cache store ID
				$storeId = $value;

				// Filter on the Id key
				$this->model->addWhere('a.' . $field . ' = ' . (int)$value);
			}
		}

		// Custom filter
		else if (is_array($config) && count($config))
		{
			$storeId = array();
			foreach($config as $namespace => $value)
			{
				// Automatic values
				switch($value)
				{
					// Pick the ID from the state vars
					case 'id':
						$value = $id;
						break;

					// Pick the User ID from the application
					case 'user':
						$value = JFactory::getUser()->get('id');
						break;
				}

				// Joining requirements
				$this->join($namespace);

				// Can base the item selection on any namespaced field
				$fieldAlias = static::tableFieldAlias($namespace);

				// Create the cache store ID
				$storeId[] = $fieldAlias . ':' . $value;

				$value = $this->_db->quote($value);
				$this->model->addWhere($fieldAlias . ' = ' . $value);
			}

			$storeId = implode(',', $storeId);

		}

		if (isset($storeId) && !empty($storeId))
			$this->model->setState('id', $storeId);
	}

	/**
	* Join a required namespace.
	*
	* @access	public
	* @param	string	$namespace	Namespaced field.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function join($namespace)
	{
		$parts = explode('.', $namespace);
		$model = $this->model;

		// Optimization : Do not join anything on a root field
		if ($parts[0] == 'a')
			return;

		$currentNamespace = $parts[0];

		for ($depth = 0 ; $depth < count($parts) - 1 ; $depth++)
		{
			$field = $parts[$depth];
			$relation = $model->getRelation($field);

			// Not allowed
			if (!$relation || $relation->type != "hasOne")
				return;

			$localKey = $relation->localKey;
			if ($depth > 0)
			{
				$localKey = $currentNamespace . '.' . $localKey;
				$currentNamespace .= '.' . $field;

				// Select all nodes
				$this->select($localKey);
			}

			$localKey = static::tableFieldAlias($localKey);
			$fkTableAlias = '_' . str_replace('.', '_', $currentNamespace) . '_';


			$this->model->addJoin('`' . $relation->foreignTable . '` AS ' . $fkTableAlias
				. ' ON ' . $fkTableAlias . '.' . $relation->foreignKey . ' = ' . $localKey, 'LEFT');

			$partsModel = explode('.', $relation->foreignModelClass);
			$modelName = $partsModel[1];
			$extension = $partsModel[0];

			if (!empty($extension))
				$model = CkJModel::getInstance($modelName, ucfirst($extension) . 'Model');
		}
	}

	/**
	* Ordering directive.
	*
	* @access	public
	* @param	array	$config	Ordering configuration.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function order($config)
	{
		foreach($config as $namespace => $dir)
		{
			$dir = strtoupper($dir);

			if (!in_array($dir, array('ASC', 'DESC'), true))
				$dir = 'ASC';

			if (substr($namespace, 0, 1) == '_')
				$fieldAlias = $namespace; // Supports legacy ordering
			else
			{
				$fieldAlias = static::tableFieldAlias($namespace);

				// Requirements
				$this->join($namespace);
			}

			$this->model->addQuery('order', $fieldAlias . ' ' . $dir);
		}
	}

	/**
	* Pagination directive.
	*
	* @access	public
	* @param	array	$config	Pagination configuration.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function pagination($config)
	{
		if (array_key_exists('limit', $config))
			$this->model->setState('list.limit', $config['limit']);

		if (array_key_exists('start', $config))
			$this->model->setState('list.start', $config['start']);
	}

	/**
	* Developper function. Dump the query to the screen.
	*
	* @access	public static
	* @param	JDatabaseQuery	$query	Query to dump.
	* @param	boolean	$output	Print the query description to the standard output.
	*
	*
	* @since	Cook 3.1
	*
	* @return	array	Query description.
	*/
	public static function queryDump($query, $output = true)
	{
		$obj = new stdClass();

		// FROM
		if ($query->from && ($from = $query->from->getElements()))
			if (count($from))
				$obj->FROM = $from[0];



		// SELECT
		if (count($query->select))
		{
			$obj->SELECT = $query->select->getElements();
		}

		// JOIN
		$joins = array();
		if (count($query->join))
		{
			foreach($query->join as $join)
			{
				foreach($join->getElements() as $joinElement)
				{
					$joins[] = $joinElement;
				}
			}
			$obj->JOIN = $joins;
		}

		// WHERE
		$where = array();
		if ($query->where)
		{
			foreach($query->where->getElements() as $whereElement)
			{
				$where[] = $whereElement;
			}

			$obj->WHERE = $where;
		}


		// ORDER BY
		if (isset($query->order))
			$obj->ORDER_BY = $query->order->getElements();



		if ($output)
		{
			echo("<pre>"); print_r($obj); echo("</pre>");
			echo("<pre>"); print_r((string)$query); echo("</pre>");
		}

		return $obj;
	}

	/**
	* Prepare a relation.
	* Stores the ORM description into a state var (relation.xxxx).
	* populateObjects() will then catch it and load the related items.
	*
	* @access	public
	* @param	string	$name	Relation name.
	* @param	array	$config	Relation sub-query configuration.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function relation($name, $config)
	{
		// Store the relation ORM configuration into states for further use (AFTER getting items)
		$this->model->setState('relation.' . $name, $config);
	}

	/**
	* Search directive.
	*
	* @access	public
	* @param	string	$name	Unique search name.
	* @param	array	$config	Search configuration.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function search($name, $config)
	{
		// Required param
		if (!isset($config['on']))
			return;

		$stateName = 'search.' . $name;
		// Force a value
		if (isset($config['value']))
			$this->model->setState($stateName, $config['value']);

		$value = $this->model->getState($stateName);

		// Empty value
		if ($value == '')
			return;

		$tests = array();

		// Each search field + method
		foreach($config['on'] as $namespace => $method)
		{
			// Init field alias. It can be a concatenated string
			if (!$fieldAlias = $this->sqlConcat($namespace))
				$fieldAlias = static::tableFieldAlias($namespace);

			if (empty($namespace))
				continue;

			// Join requirements
			$this->join($namespace);

			$splitWords = ($method != 'exact');

			if ($splitWords)
			{
				$logic = 'AND';
				switch($method)
				{
					// Search any term
					case 'like':
					case 'any':
						$logic = 'OR';
						break;

					// Search all term
					case 'all':
						$logic = 'AND';
						break;

				}

				$words = explode(' ', $value);
				$wheres = array();
				foreach ($words as $word)
				{
					if ((isset($config['ignoredLength'])) && (strlen($word) <= $config['ignoredLength']))
						continue;

					$wordRegex      = $this->_db->quote('%' . $this->_db->escape(strtolower($word), true) . '%', false);
					$wheres[]  = 'LOWER(' . $fieldAlias . ') LIKE ' . $wordRegex;
				}

				$tests[] = '(' . implode(" " . $logic . " ", $wheres) . ')';
			}
			else
			{
				$phraseRegex = $this->_db->quote('%' . $this->_db->escape(strtolower($value), true) . '%', false);
				$tests[] = 'LOWER(' . $fieldAlias . ') LIKE ' . $phraseRegex;
			}
		}


		if (!count($tests))
			return;

		$logic = 'OR';
		if (isset($config['logic']))
		{
			$log = strtoupper($config['logic']);
			if (in_array($log, array('AND', 'OR')))
				$logic = $log;
		}

		// Sum all searches from each field name
		$where = "(" . implode(' ' . $logic . ' ', $tests) . ")";

		$this->model->addWhere($where);
	}

	/**
	* Select directive.
	*
	* @access	public
	* @param	array|string	$config	List of desired fields and namespaces or field alone.
	* @param	string	$alias	Defines an alias for the requested field (when @config is a string).
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function select($config, $alias = null)
	{
		// config is an array
		if (is_array($config))
		{
			foreach($config as $index => $value)
			{
				// Simple SELECT
				if (is_numeric($index))
					$this->select($value);

				// SELECT with alias
				else
					$this->select($index, $value);
			}

			return;
		}

		// config is a coma separated string
		if (strpos($config, ','))
		{
			foreach(explode(',', $config) as $namespace)
				$this->select($namespace);
			return;
		}

		$namespace = $config;

		if (empty($namespace))
			return;

		// Concatenate fields
		if ($selectConcat = $this->sqlConcat($namespace))
		{
			// Alias is required for concatenation
			if (!$alias)
				return;
			// Instance the field in query with alias
			$this->model->addSelect($selectConcat . ' AS ' . $alias);

			return;
		}

		$parts = explode('.' ,$namespace);

		$isFk = (($parts[0] != 'a') && (count($parts) > 1));

		// Root field
		if (!$isFk)
		{
			// Instance the field in query
			$this->model->addSelect(static::tableFieldAlias($namespace) . ($alias?' AS ' . $alias:''));
		}

		// Foreign Key
		else
		{
			// Physical field name is always the last part
			$fieldname = $parts[count($parts)-1];
			$current = $parts[0];

			$parentTable = 'a';

			for($depth = 0 ; $depth < (count($parts)) ; $depth++)
			{
				$current = $parts[$depth];

				// Last
				if ($depth == (count($parts) - 1))
					break;

				$tableAlias = '_' . $current . '_';

				// Concat the table alias
				if ($parentTable == 'a')
					$parentTable = $tableAlias;
				else
					$parentTable .= $current . '_';
			}

			// Create the field var name for the model
			$fieldVar = '_' . str_replace('.', '_', $namespace);

			if (empty($alias))
				$alias = $this->_db->quoteName($fieldVar);

			// Instance the field in query with alias
			$this->model->addSelect($parentTable .'.'. $current . ' AS ' . $alias);

			// JOIN the requirements
			$this->join($namespace);
		}
	}

	/**
	* Add an ORM request.
	*
	* @access	public
	* @param	array	$description	ORM description.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function set($description)
	{
		if (empty($description))
			return;

		foreach($description as $directive => $config)
		{
			switch($directive)
			{
				case 'id':
				case 'context':
				case 'select':
				case 'groupOrder':
				case 'order':
				case 'pagination':
					$this->$directive($config);
					break;


				case 'access':
				case 'filter':
				case 'search':
				case 'relation':
				case 'version':
					foreach($config as $name => $options)
						$this->$directive($name, $options);
					break;
			}
		}
	}

	/**
	* Construct a SQL query filter, containings IDs of local table, belonging to
	* a cross-reference table (N:m).
	*
	* @access	protected
	* @param	string	$relation	Relation name.
	* @param	array	$conditions	Conditions to match on the cross-reference foreign table (N:m).
	*
	*
	* @since	Cook 3.1
	*
	* @return	string	SQL query returning local Id's.
	*/
	protected function sqlBelongsOf($relation, $conditions)
	{
		if ($relation->type != 'belongsToMany')
			return null;

		$query = $this->_db->getQuery(true);

		// Only works from the pivot table (alias: `p`)
		$query->select('p.' . $relation->pivotLocalKey);
		$query->from($relation->pivotTable . ' AS p');

		// Link the Foreign Table
		$query->join('LEFT', $this->_db->quoteName($relation->foreignTable) . ' AS x '
			. ' ON x.' . $relation->foreignKey . ' = p.' . $relation->pivotForeignKey
		);

		// Concat all conditions with a 'OR' statement
		if (!empty($conditions))
		{
			$condition = '(' . implode(' OR ', $conditions) . ')';
			$query->where($condition);
		}

		return (string)$query;
	}

	/**
	* Build a CONCAT sql statement.
	*
	* @access	public
	* @param	string	$pattern	Pattern string. Field namespaces are embed in brackets.
	*
	*
	* @since	Cook 3.1.4
	*
	* @return	string	SQL statement
	*/
	public function sqlConcat($pattern)
	{
		if (!preg_match('/\{/', $pattern))
			return null;

		$matches = array();
		preg_match_all('/\{([a-z,A-Z,\.,_]+)\}/', $pattern, $matches);
		$concatPattern = preg_replace('/(\{[a-z,A-Z,\.,_]+\})/', '|', $pattern);

		if (!count($matches[0]))
			return '';

		$concat = array();

		$patterns = explode('|', $concatPattern);


		foreach($patterns as $p)
		{
			if ($p != '')
				$concat[] = $this->_db->quote($p);

			if (count($matches[1]))
			{
				// Extract the field namespace
				$fieldNamespace = array_shift($matches[1]);

				// JOIN the requirements
				$this->join($fieldNamespace);

				$fieldAlias = static::tableFieldAlias($fieldNamespace);
				$concat[] = ($fieldAlias);
			}
		}

		$select = 'CONCAT(' . implode(',', $concat) . ')';
		return $select;
	}

	/**
	*  Build the SQL Condition string. Optimize and clean the useless logic.
	* Structure : (RESTRICT && RESTRICT && RESTRICT) || ALLOW || ALLOW || ALLOW
	*
	* @access	protected
	* @param	array	$restricts	Restrictions conditions (AND).
	* @param	array	$allows	Permissions conditions (OR).
	*
	*
	* @since	Cook 3.1
	*
	* @return	string	SQL condition.
	*/
	protected function sqlWhereConditions($restricts, $allows)
	{
		$where = null;


		// RESTRICTIONS
		$restrictions = array();


		$isRestricted = false;
		foreach ($restricts as $restrict)
		{
			// No condition > Skip
			if (empty($restrict))
				continue;

			// (... AND 1) > Nop
			if ($restrict == '1')
				continue;


			// (... AND 0) > Always 0
			if ($restrict == '0')
				$isRestricted = true;


			$restrictions[] = $restrict;
		}


		if ($isRestricted)
			$where = '0';
		else
		{
			// Concat the restrictions conditions with AND
			$where = implode(' AND ', $restrictions);

			// Make sure all restrictions are grouped into one required condition
			if (count($restrictions))
				$where = '(' . $where . ')';

		}


		// No restrictions. No need to invoke the ALLOW statement.
		if (!$where)
			return;


		// ( ... OR 1) > Always true
		// To that point there is no restriction
		if (!$where || ($where == '1'))
			return;



		// ALLOW

		$allowing = array();
		foreach ($allows as $allow)
		{
			if (empty($allow))
				continue;

			// (... OR 0) > Ignore statement
			if ($allow != '0')
				$allowing[] = $allow;
		}


		if (count($allowing))
		{
			// Concat the restrictions conditions with OR
			$where = $where . ' OR ' . implode(' OR ', $allowing);

			// Make sure all statemeents are grouped into one condition
			$where = '(' . $where . ')';
		}


		return $where;
	}

	/**
	* Get the alias of a namespaced field.
	*
	* @access	public static
	* @param	string	$namespace	Namespaced name.
	* @param	string	$sqlPath	Return SQL table base per default. Set to false to return the field alias name.
	*
	*
	* @since	Cook 3.1
	*
	* @return	string	Aliased field.
	*/
	public static function tableFieldAlias($namespace, $sqlPath = true)
	{
		$parts = explode('.', $namespace);

		$table = 'a';
		$alias = '';

		if (count($parts) && $parts[0] == '')
		{
			$table = '';
			$sqlPath = false;
			array_shift($parts);
		}

		foreach($parts as $part)
		{
			$alias = $table . ($sqlPath?'.':'') . $part;

			if ($part != 'a')
			{
				if ($table == 'a')
					$table = '_';

				$table .= $part . '_';
			}
		}

		return $alias;
	}

	/**
	* Get the table name of a namespaced foreign key.
	*
	* @access	protected
	* @param	string	$namespace	Namespaced foreign key.
	*
	*
	* @since	Cook 3.1
	*
	* @return	string	Table name of the last field FK.
	*/
	protected function tableName($namespace)
	{
		$parts = explode('.', $namespace);
		$model = $this->model;

		$extension = 'bds';
		$table = $model->getName();

		if ($parts[0] == 'a')
			array_shift($parts);

		$currentNamespace = $parts[0];

		for ($depth = 0 ; $depth < count($parts) ; $depth++)
		{
			if ($depth > 0)
				$model = CkJModel::getInstance($table, ucfirst($extension) . 'Model');


			$field = $parts[$depth];
			$relation = $model->getRelation($field);

			// Not a relation
			if (!$relation)
				break;

			// Not a Foreign Key
			if ($relation->type != "hasOne")
				break;

			$partsModel = explode('.', $relation->foreignModelClass);
			$extension = $partsModel[0];
			$table = $partsModel[1];
		}

		return '#__' . ($extension?$extension.'_':'') . $table;
	}

	/**
	* Content Versioning directive.
	*
	* @access	public
	* @param	string	$name	Unique search name.
	* @param	array	$config	Translation configuration.
	*
	*
	* @since	Cook 3.1
	*
	* @return	void
	*/
	public function version($name, $config)
	{

	}


}



