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

jimport('joomla.application.component.modeladmin');


/**
* Bds Item Model
*
* @package	Bds
* @subpackage	Classes
*/
class BdsClassModelItem extends JModelAdmin
{
	/**
	* Data array
	*
	* @var array
	*/
	protected $_data = null;

	/**
	* Item id
	*
	* @var integer
	*/
	public $_id = null;

	/**
	* Item by id.
	*
	* @var array
	*/
	protected $_item = null;

	/**
	* Item params
	*
	* @var array
	*/
	protected $_params = null;

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
	* List of all fields files indexes
	*
	* @var array
	*/
	protected $fileFields = array();

	/**
	* ORM system
	*
	* @var ClassModelOrm
	*/
	protected $orm;

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
	* 
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
		$queries = $this->getState('query.' . $type, array());
		if (!in_array($queryElement, $queries))
		{
			$queries[] = $queryElement;
			$this->setState('query.' . $type, $queries);
		}
	}

	/**
	* 
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

		//SELECT
		foreach($this->getState('query.select', array()) as $select)
			$query->select($select);

		//JOIN LEFT
		foreach($this->getState('query.join.left', array()) as $join)
			$query->join('LEFT', $join);

		//JOIN INNER
		foreach($this->getState('query.join.inner', array()) as $join)
			$query->join('INNER', $join);

		//JOIN OUTER
		foreach($this->getState('query.join.outer', array()) as $join)
			$query->join('OUTER', $join);

		//WHERE
		foreach($this->getState('query.where', array()) as $where)
			$query->where($where);

		// Dump the query for debug
		if (defined('JDEBUG') && $this->getState('debug.query'))
			$this->queryDump($query);
	}

	/**
	* Check if the user can access this item.
	*
	* @access	public
	* @param	object	$record	A record object.
	*
	* @return	boolean	True if allowed.
	*/
	public function canAccess($record)
	{
		if (!$this->canView($record))
			return false;


		return true;
	}

	/**
	* Check if the user is admin or manager.
	*
	* @access	public
	*
	* @return	boolean	True if user can admin all items.
	*/
	public function canAdmin()
	{
		$acl = BdsHelper::getActions();

		if ($acl->get('core.admin'))
			return true;

		return false;
	}

	/**
	* Method to check if the item is free of checkout.
	*
	* @access	public
	* @param	object	$record	A record object.
	*
	* @return	boolean	True if allowed. False if checkedout
	*/
	public function canCheck($record)
	{
		if ($this->isCheckedIn($record))
		{			
			$this->setError(JText::_("BDS_TASK_RESULT_THE_USER_CHECKING_OUT_DOES_NOT_MATCH_THE_USER_WHO_CHECKED_OUT_THE_ITEM"));
			return false;			
		}

		return true;
	}

	/**
	* Check if the user can create a new item.
	*
	* @access	public
	*
	* @return	boolean	True if allowed.
	*/
	public function canCreate()
	{
		//Facultative : Check Admin
		if ($this->canAdmin())
			return true;

		$acl = BdsHelper::getActions();

		//Authorizated to create
		if ($acl->get('core.create'))
			return true;

		return false;
	}

	/**
	* Method to test whether a record can be deleted.
	*
	* @access	public
	* @param	object	$record	A record object.
	*
	* @return	boolean	True if allowed to delete the record. Defaults to the permission for the component.
	*/
	public function canDelete($record)
	{
		//Check if already edited
		if ($this->isCheckedIn($record))
			return false;

		//Facultative : Check Admin
		if ($this->canAdmin())
			return true;

		$acl = BdsHelper::getActions();

		//Authorizated to delete
		if ($acl->get('core.delete'))
			if ($this->isAccessible($record)) //Facultative : Check accesslevel
				return true;

		//Author can delete
		if ($acl->get('core.delete.own'))
			if ($this->isAuthor($record))
				return true;

		return false;
	}

	/**
	* Check if the user can edit the item.
	*
	* @access	public
	* @param	object	$record	A record object.
	* @param	boolean	$testNew	Check canCreate() in case of new element.
	* @param	string	$pk	Primary key name.
	*
	* @return	boolean	True if allowed.
	*/
	public function canEdit($record, $testNew = true, $pk = 'id')
	{
		//Create instead of Edit if new item
		if($testNew && empty($record->$pk))
			return self::canCreate();
		
		//Check if already edited
		if (!$this->canCheck($record))
			return false;

		//Facultative : Check Admin
		if ($this->canAdmin())
			return true;

		$acl = BdsHelper::getActions();

		//Authorizated to edit
		if ($acl->get('core.edit'))
			if ($this->isAccessible($record)) //Facultative : Check accesslevel
				return true;

		//Author can edit
		if ($acl->get('core.edit.own'))
			if ($this->isAuthor($record))
				return true;

		return false;
	}

	/**
	* Check if the user can set default the item.
	*
	* @access	public
	* @param	object	$record	A record object.
	*
	* @return	boolean	True if allowed.
	*/
	public function canEditDefault($record)
	{
		//Uses the same ACL than edit state
		return $this->canEditState($record);
	}

	/**
	* Check if the user can edit he published state of this item.
	*
	* @access	public
	* @param	object	$record	A record object.
	*
	* @return	boolean	True if allowed.
	*/
	public function canEditState($record)
	{
		//Check if already edited
		if ($this->isCheckedIn($record))
			return false;

		//Facultative : Check Admin
		if ($this->canAdmin())
			return true;

		$acl = BdsHelper::getActions();

		//Authorizated to change publish state
		if (!$acl->get('core.edit.state'))
			return false;

		//Facultative : Check accesslevel
		if (!$this->isAccessible($record))
			return false;

		return true;
	}

	/**
	* Check if the user can view the item.
	*
	* @access	public
	* @param	object	$record	A record object.
	*
	* @return	boolean	True if allowed.
	*/
	public function canView($record)
	{
		//Check publish state
		if ($this->isVisible($record))
			return true;

		$acl = BdsHelper::getActions();

		//Not allowed to access to own item
		if (	!$acl->get('core.view.own')
			&& 	!$acl->get('core.edit.own')
			&& 	!$acl->get('core.delete.own')){
			return false;
		}

		//Author can view
		if ($this->isAuthor($record))
			return true;

		return false;
	}

	/**
	* Clean the cache
	*
	* @access	protected
	* @param	string	$group	The cache group.
	* @param	integer	$client_id	The ID of the client.
	*
	*
	* @since	12.2
	*
	* @return	void
	*/
	protected function cleanCache($group = null, $client_id = 0)
	{
		parent::cleanCache($group, $client_id);

		$pk = $this->getState($this->getName() . '.id');
		//Clean current item cache (Called when save succeed)
		$this->_item[$pk] = null;
	}

	/**
	* Delete the files assiciated to the items
	*
	* @access	public
	* @param	array	$pks	Ids of the items to delete the images
	* @param	array	$fileFields	Images indexes fields of the table where to find the images paths.
	*
	* @return	boolean	True on success
	*/
	public function deletefiles($pks, $fileFields)
	{
		if (!count($fileFields) || !count($pks))
			return;

		JArrayHelper::toInteger($pks);
		$db = JFactory::getDBO();

		$errors = false;
		$table = $this->getTable();

		// Quote the columns names
		$fieldsQuoted = array();
		foreach(array_keys($fileFields) as $fieldName)
			$fieldsQuoted[] = $db->quoteName($fieldName);


		//Get all indexes for all fields
		$query = "SELECT " . implode(", ", $fieldsQuoted)
			. " FROM " . $db->quoteName($table->getTableName())
			. ' WHERE id IN ( '.implode(', ', $pks) .' )';
		$db->setQuery($query);
		$files = $db->loadObjectList();

		$config	= JComponentHelper::getParams( 'com_bds' );

		foreach($fileFields as $fieldName => $op)
		{
			$directoryAlias = $this->view_list . '_' . $fieldName;
			$dir = $config->get('upload_dir_' . $directoryAlias, '[DIR_' . strtoupper($directoryAlias) . ']');

			foreach($files as $fileObj)
			{
				$imagePath = $fileObj->$fieldName;
				if (!preg_match("/\[.+\]/", $imagePath))
					$imagePath = $dir . '/' . $imagePath;
				if (!BdsHelperFile::removeFile($imagePath, $op))
					$errors = true;
			}
		}

		return !$errors;
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
			case 'main_location': return $tbl.$com. 'locations';
			case 'type_id': return $tbl.$com. 'types';
			case 'utility_id': return $tbl.$com. 'utilities';
			case 'sub_location': return $tbl.$com. 'locations';	
		}
	}

	/**
	* Returns the default item of a table.
	*
	* @access	public static
	* @param	string	$table	The table name.
	* @param	string	$defaultField	The field containing the default flag.
	* @param	string	$fieldValue	The field value to return. If null, return the full object.
	*
	*
	* @since	2.8.6
	*
	* @return	mixed ()	Can be stdClass in case of a full object, or mixed value depending of the requested value field.
	*/
	public static function getDefaultItem($table, $defaultField = 'default', $fieldValue = 'id')
	{
		$model = CkJModel::getInstance(ucfirst($table), 'BdsModel');
		$model->set('context', null);
		$model->addWhere('a.' . $defaultField . ' = 1');
		$defaultItems = $model->getItems();

		// Not found
		if (!count($defaultItems))
			return null;

		// Take first
		$defaultItem = $defaultItems[0];

		if (empty($fieldValue))
			return $defaultItem;

		return $defaultItem->$fieldValue;
	}

	/**
	* Method to get the form.
	*
	* @access	public
	* @param	array	$data	An optional array of data for the form to interrogate.
	* @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	* @param	string	$control	The name of the control group.
	*
	*
	* @since	11.1
	*
	* @return	JForm	A JForm object on success, false on failure
	*/
	public function getForm($data = array(), $loadData = true, $control = 'jform')
	{
		$form = $this->loadForm($this->context, $this->view_item, array('control' => $control,'load_data' => $loadData));
		if (empty($form))
			return false;

		$form->addRulePath(JPATH_ADMIN_BDS . '/models/rules');

		$id = $this->getState($this->getName() . '.id');
		$item = $this->_item[(int)$id];

		$this->populateParams($item);
		$this->populateObjects($item);

		return $form;
	}

	/**
	* Method to get the id.
	*
	* @access	public
	*
	*
	* @since	11.1
	*
	* @return	int	The item id. Null if no item loaded.
	*/
	public function getId()
	{
		if (isset($this->_item))
			return $this->getState($this->getName() . '.id');

		return 0;
	}

	/**
	* Method to get an item data.
	*
	* @access	public
	* @param	integer	$pk	The primary id key of the item
	*
	* @return	mixed	Item data object on success, false on failure.
	*/
	public function getItem($pk = null)
	{
		// Initialise variables.
		$pk = (!empty($pk)) ? $pk : (int) $this->getState($this->getName() . '.id');

		if ($this->_item === null) {
			$this->_item = array();
		}

		// Trick to be able to load an item with other conditions than Primary Key value
		if ($storeId = $this->getState('id'))
			$pk = $storeId;


		if (!isset($this->_item[$pk])) {

			try
			{
				if (empty($pk))
					$data = new stdClass();
				else
				{
					//Increment the hits if needed
					$this->hit();


					$db = $this->getDbo();
					$query = $db->getQuery(true);

					//Preparation of the query
					$this->prepareQuery($query, $pk);

					$db->setQuery($query);

					$data = $db->loadObject();

					if ($error = $db->getErrorMsg()) {
						throw new Exception($error);
					}
				}

				if (empty($data)) {
					$this->setError(JText::_('JGLOBAL_RESOURCE_NOT_FOUND'));
					return;
				}

				$this->populateParams($data);
				$this->populateObjects($data);

				$this->_item[$pk] = $data;

			}
			catch (JException $e)
			{
				if ($e->getCode() == 404) {
					// Need to go thru the error handler to allow Redirect to work.
					JError::raiseError(404, $e->getMessage());
				}
				else {
					$this->setError($e);
					$this->_item[$pk] = false;
				}
			}
		}

		return $this->_item[$pk];
	}

	/**
	* Method to get the layout.
	*
	* @access	public
	*
	* @return	string	The layout alias.
	*/
	public function getLayout()
	{
		$jinput = JFactory::getApplication()->input;
		return $jinput->get('layout', '', 'STRING');
	}

	/**
	* Returns the alias of the list model.
	*
	* @access	public
	*
	*
	* @since	Cook 2.0
	*
	* @return	void
	*/
	public function getNameList()
	{
		return $this->view_list;
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
	* Method to get a registered relation in list model.
	*
	* @access	public
	* @param	string	$name	Relation name. If null, returns all relations.
	*
	* @return	mixed	A relation object. Null if not found. All relation if name is null.
	*/
	public function getRelation($name = null)
	{
		$modelList = CkJModel::getInstance($this->getNameList(), 'BdsModel');
		if ($modelList)
			return $modelList->getRelation($name);


		return null;
	}

	/**
	* Get all the known relations of the model.
	*
	* @access	public
	*
	*
	* @since	3.1
	*
	* @return	arr	Set of relations maps objects.
	*/
	public function getRelations()
	{
		$modelList = CkJModel::getInstance($this->getNameList(), 'BdsModel');
		if ($modelList)
			return $modelList->getRelations();

		// Fallback when List model not found
		return array();
	}

	/**
	* A protected method to get a set of ordering conditions.
	*
	* @access	protected
	* @param	JTable	$table	A JTable object.
	*
	*
	* @since	12.2
	*
	* @return	mixed	An array of conditions or a string to add to add to ordering queries.
	*/
	protected function getReorderConditions($table)
	{
		return array();
	}

	/**
	* Method to increment hits when necessary (check session and layout)
	*
	* @access	public
	* @param	array	$layouts	List of authorized layouts for hitting the object
	*
	* @return	boolean	Null if skipped. True when incremented. False if error.
	*/
	public function hit($layouts = null)
	{
		//Not been overrided in this model (no hit function)
		if (!$layouts)
			return;

		$name = $this->getName();
		$context = $this->getState('context');

		//Search if this item is requested from an item layout
		$found = false;
		foreach($layouts as $layout)
			if ($context == ($name . '.' . $layout))
				$found = true;

		//This layout is not an item layout context
		if (!$found)
			return;

		//Search if the user already loaded this item.
		$id = $this->getState($name . '.id');

		$app = JFactory::getApplication();
		$hits = $app->getUserState($this->context . '.hits', array());


		//This item has already been seen during this session
		if (in_array($id, $hits))
			return;

		$hits[] = $id;

		//Increment the hits
		$table = $this->getTable();
		if (!$table->hit($id))
			return false;

		$app->setUserState($this->context . '.hits', $hits);

		return true;
	}

	/**
	* Method to cascad delete items.
	*
	* @access	public
	* @param	string	$key	The foreign key which relate to the cids.
	* @param	array	$cid	The deleted ids of foreign table.
	*
	* @return	boolean	True on success
	*/
	public function integrityDelete($key, $cid = array())
	{
		if (count( $cid ))
		{
			$db = $this->_db;
			$table = $this->getTable();
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );
			$query = 'SELECT id FROM ' . $db->quoteName($table->getTableName())
				. " WHERE `" . $key . "` IN ( " . $cids . " )";
			$db->setQuery($query);
			$list = $db->loadObjectList();

			$cidsDelete = array();
			if (count($list) > 0)
				foreach($list as $item)
					$cidsDelete[] = $item->id;

			//using the model, the integrities can be chained.
			return $this->delete($cidsDelete);

		}

		return true;
	}

	/**
	* Method to reset foreign keys.
	*
	* @access	public
	* @param	string	$key	The foreign key which relate to the cids.
	* @param	array	$cid	The deleted ids of foreign table.
	*
	* @return	boolean	True on success
	*/
	public function integrityReset($key, $cid = array())
	{
		if (count( $cid ))
		{
			$db = $this->_db;
			$table = $this->getTable();

			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );
			$query = 'UPDATE ' . $db->quoteName($table->getTableName())
				.	' SET ' . $db->quoteName($key) . ' = 0'
				. ' WHERE ' . $db->quoteName($key) . ' IN ( ' . $cids . ' )';
			$db->setQuery( $query );

			if(!$db->query()) {
				JError::raiseWarning(1100, $db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	/**
	* Restrict delete on cascade.
	*
	* @access	public
	* @param	string	$relation	Relation name (FK).
	* @param	array	&$pks	Primary Keys.
	* @param	string	$labelKey	Label Key for the attached children.
	* @param	string	$parentLabelKey	Parent Label Key.
	* @param	string	$editLink	Edit link template. The system will simply concat the ID value.
	*
	*
	* @since	3.1.2
	*
	* @return	void
	*/
	public function integrityRestrict($relation, &$pks, $labelKey, $parentLabelKey, $editLink)
	{
		if (!$relation = $this->getRelation($relation))
			return;

		$childSelect = array($labelKey);
		$childModel = $this->view_list;

		$allowedIds = array();
		foreach($pks as $id)
		{
			// Select all children of this item
			$children = BdsHelper::getData($childModel, array(
				'filter' => array(
					($relation->localKey) => array(
						'type' => 'fk',
						'value' => $id
					)
				),

				'select' => $childSelect
			));

			if (count($children))
			{
				$childText = array();
				foreach($children as $child)
				{
					// Build the edition link
					if ($editLink)
						$childText[] = '<a href="' . JRoute::_($editLink . '&cid[]=' . $child->id, false) . '">' . $child->$labelKey . '</a>';
					else
						$childText[] = $child->$labelKey;
				}

				$itemName = null;

				$model = BdsHelper::componentModel($relation->foreignModelClass, true);
				$model->setState('country.id', $id);

				// Select all children of this item
				if ($item = $model->getItem())
					$itemName = $item->$parentLabelKey;

				$msg = sprintf(JText::_('BDS_ERROR_IMPOSSIBLE_TO_DELETE_USED_IN'), ($itemName?$itemName:'item'), implode(', ', $childText));
				JError::raiseWarning( 100, $msg);
			}
			else
				$allowedIds[] = $id;
		}

		// Update the IDs
		$pks = $allowedIds;
	}

	/**
	* Method to check accesslevel.
	*
	* @access	public
	* @param	object	$record	A record object.
	* @param	string	$accessKey	The access level field name.
	*
	* @return	boolean	True if allowed.
	*/
	public function isAccessible($record, $accessKey = 'access')
	{
		//Accesslevels are not instancied
		if (!property_exists($record, $accessKey))
			return true;

		//User group affiliations permits to access		
		if (in_array($record->$accessKey, JFactory::getUser()->getAuthorisedViewLevels()))
			return true;

		return false;
	}

	/**
	* Method to check is the current user is the author (or can be the author).
	*
	* @access	public
	* @param	object	$record	A record object.
	* @param	string	$authorKey	The authoring field name.
	*
	* @return	boolean	True if allowed.
	*/
	public function isAuthor($record, $authorKey = 'created_by')
	{
		//Authoring is not used
		if (!property_exists($record, $authorKey))
			return true;

		//Author is not defined
		if (empty($record->$authorKey))
			return false;

		//Current user is author
		if ($record->$authorKey == JFactory::getUser()->get('id'))
			return true;

		return false;
	}

	/**
	* Method to check if item has already been opened.
	*
	* @access	public
	* @param	object	$record	A record object.
	* @param	string	$checkedKey	The check out field name.
	*
	* @return	boolean	True if allowed.
	*/
	public function isCheckedIn($record, $checkedKey = 'checked_out')
	{
		if (	property_exists($record, $checkedKey)
			&& 	!empty($record->$checkedKey)
			&& 	$record->$checkedKey != JFactory::getUser()->get('id')){
			return true;
		}

		return false;
	}

	/**
	* Method to check if then item can be seen, basing on publish state.
	*
	* @access	public
	* @param	object	$record	A record object.
	* @param	string	$publishKey	The publish state field name.
	*
	* @return	boolean	True if allowed.
	*/
	public function isPublished($record, $publishKey = 'published')
	{
		//Published states are not instancied
		if (!property_exists($record, $publishKey))
			return true;

		$acl = BdsHelper::getActions();

		//Who can change state can always see all.
		if ($acl->get('core.edit.state'))
			return true;

		//Published state is not defined
		if ($record->$publishKey === null)
			return true;

		//Published item
		if ($record->$publishKey == 1)
			return true;

		return false;
	}

	/**
	* Method to check the visibility of the item.
	*
	* @access	public
	* @param	object	$record	A record object.
	*
	* @return	boolean	True if allowed.
	*/
	public function isVisible($record)
	{
		if (!$this->isAccessible($record))
			return false;

		if (!$this->isPublished($record))
			return false;

		return true;
	}

	/**
	* Method to get a form object.
	*
	* @access	protected
	* @param	string	$name	The name of the form.
	* @param	string	$source	The form source. Can be XML string if file flag is set to false.
	* @param	array	$options	Optional array of options for the form creation.
	* @param	boolean	$clear	Optional argument to force load a new form.
	* @param	string	$xpath	An optional xpath to search for the fields.
	*
	*
	* @since	12.2
	*
	* @return	mixed	returnDesc.
	*/
	protected function loadForm($name, $source = null, $options = array(), $clear = false, $xpath = false)
	{
		// Handle the optional arguments.
		$options['control'] = JArrayHelper::getValue($options, 'control', false);

		// Create a signature hash.
		$hash = md5($source . serialize($options));

		// Check if we can use a previously loaded form.
		if (isset($this->_forms[$hash]) && !$clear)
		{
			return $this->_forms[$hash];
		}

		// Get the form.
		JForm::addFormPath(JPATH_BDS . '/models/forms');
		JForm::addFieldPath(JPATH_BDS . '/models/fields');

		try
		{
			$form = JForm::getInstance($name, $source, $options, false, $xpath);

			if (isset($options['load_data']) && $options['load_data'])
			{
				// Get the data for the form.
				$data = $this->loadFormData();
			}
			else
			{
				$data = array();
			}

			// Allow for additional modification of the form, and events to be triggered.
			// We pass the data because plugins may require it.
			$this->preprocessForm($form, $data);

			// Load the data into the form after the plugins have operated.
			$form->bind($data);

		}
		catch (Exception $e)
		{
			$this->setError($e->getMessage());
			return false;
		}

		// Store the form for later.
		$this->_forms[$hash] = $form;

		return $form;
	}

	/**
	* Method to load related items.
	*
	* @access	public
	* @param	string	$name	Relation name.
	* @param	array	&$item	Local item to populate.
	* @param	array	$orm	ORM description for sub query, or cascad loading.
	*
	*
	* @since	3.1
	*
	* @return	void
	*/
	public function loadRelation($name, &$item, $orm = array())
	{
		$relation = $this->getRelation($name);
		if (!$relation)
			return;


		$model = BdsClassModelOrm::getModel($relation->foreignModelClass);
		if (!$model)
			return;


		$localKey = $relation->localKey;
		$foreignKey = $relation->foreignKey;

		if (!isset($item->$localKey))
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



		$db = JFactory::getDbo();
		switch($relation->type)
		{
			// Many to Many
			case 'belongsToMany':

				$pivotTable = $relation->pivotTable;
				$pivotForeignKey = $relation->pivotForeignKey;
				$pivotLocalKey = $relation->pivotLocalKey;


				$model->addJoin($db->quoteName($pivotTable)
					. ' AS ' . $db->quoteName('pivot')
					. ' ON a.' . $foreignKey . ' = pivot.' . $pivotForeignKey, 'LEFT');


				$model->addSelect('pivot.' . $pivotLocalKey . ' AS _local');

				$model->addWhere('pivot.' . $pivotLocalKey . ' = ' . (int)$item->$localKey);

				break;



			// Many to One
			case 'hasMany':

				$model->addSelect('a.' . $foreignKey);

				$model->addWhere($db->quoteName($foreignKey) . ' = ' . (int)$item->$localKey);
				break;

		}


		// Get a mixed list
		$item->$name = $model->getItems();
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
		// Check the cascad chaining
		$parts = explode('.', $name);
		$chain = null;
		if (count($parts) > 1)
		{
			$name = $parts[0];
			array_shift($parts);
			$chain = implode('.', $parts);
		}

		$item = $this->getItem();


		$relation = $this->getRelation($name);
		if (!$relation)
			return;

		$localKey = $relation->localKey;
		$foreignKey = $relation->foreignKey;

		if (!isset($item->$localKey))
			return;

		$db = JFactory::getDbo();

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

		if (!$model)
			return;


		$model->setState('context', ''); // Empty select
		$model->setState('list.limit', null);
		$model->setState('list.start', null);


		switch($relation->type)
		{
			// Many to Many
			case 'belongsToMany':

				$pivotTable = $relation->pivotTable;
				$pivotForeignKey = $relation->pivotForeignKey;
				$pivotLocalKey = $relation->pivotLocalKey;


				$model->addJoin($db->quoteName($pivotTable)
					. ' AS ' . $db->quoteName('pivot')
					. ' ON a.' . $foreignKey . ' = pivot.' . $pivotForeignKey, 'LEFT');


				$model->addSelect('pivot.' . $pivotLocalKey . ' AS _local');

				$model->addWhere('pivot.' . $pivotLocalKey . ' = ' . (int)$item->$localKey);

				break;



			// Many to One
			case 'hasMany':

				$model->addSelect('a.' . $foreignKey);

				$model->addWhere($db->quoteName($foreignKey) . ' = ' . (int)$item->$localKey);
				break;

		}


		// Select the given fields
		foreach($relation->selectFields as $selectField)
		{
			$model->addSelect('a.' . $selectField);
		}

		// Get a mixed list
		$item->$name = $model->getItems();

		// Load the sub items
		if ($chain)
			$model->loadRelations($chain);

	}

	/**
	* Load a N:x relation list to objects array in the item.
	*
	* @access	public
	* @param	object	&$item	The item to populate.
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
	public function loadXref(&$item, $objectField, $xrefTable, $on, $key, $states = array(), $context = 'object.default')
	{
		$db = JFactory::getDbo();

		if ($this->getState('xref.' . $objectField))
		{
			$model = CkJModel::getInstance($xrefTable, 'bdsModel');

			// Prepare the fields to load, trough a context profile
			$model->setState('context', $context);

			// Filter on the origin
			$model->addWhere($db->quoteName($on) . '='. (int)$item->$key);

			// Cascad objects states
			// Apply the namespaced states to the relative base namespace
			if (count($states))
				foreach($states as $state)
				{
					if ($val = $this->getState('xref.' . $objectField . '.' . $state))
						$model->setState('xref.' . $state, $val);
				}

			// Set up the array in the item.
			$item->$objectField = $model->getItems();
		}
	}

	/**
	* Method to set default to the item.
	*
	* @access	public
	* @param	int	$id	Id of the item to become default.
	* @param	varchar	$field	Default field name.
	* @param	string	$where	Distinct the defaulting basing on this condition.
	*
	* @return	boolean	True on success. False if error.
	*/
	public function makeDefault($id, $field = 'default', $where = '')
	{
		$table = $this->getTable();

		if (!$table->load($id))
			return false;

		if (!$this->canEditDefault($table))
			return false;

		$pk = $table->getKeyName();

		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$query->update($db->quoteName($table->getTableName()));
		$query->set($db->quoteName($field) . ' = (' . $db->quoteName($pk) . ' = ' . (int)$id . ' )');

		if (trim($where) != '')
			$query->where($where);

		$db->setQuery($query);
		$db->query();

		return true;
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
	* ORM Predefined profile for ALL columns.
	*
	* @access	protected
	*
	*
	* @since	3.1
	*
	* @return	void
	*/
	protected function ormAll()
	{
		$this->orm(array(

			// SELECT all columns of the rrot table
			'select' => '*',

			// FILTER the result using Primary Key recieved from URL
			'id' => 'id'
		));
	}

	/**
	* Prepare some additional derivated objects.
	*
	* @access	public
	* @param	object	&$item	The object to populate.
	*
	* @return	void
	*/
	public function populateObjects(&$item)
	{
		// Populate related lists (N:m)
		if ($item)
		foreach($this->getRelations() as $name => $relation)
		{
			// Only N:m and N:1
			if (!in_array($relation->type, array('belongsToMany', 'hasMany')))
				continue;

			// Search for the ORM state vars
			if ($orm = $this->getState('relation.' . $name))
				$this->loadRelation($name, $item, $orm);
		}
	}

	/**
	* Prepare some additional important values.
	*
	* @access	public
	* @param	object	&$item	The object to populate.
	*
	* @return	void
	*/
	public function populateParams(&$item)
	{
		if (!$item)
			return;

		$item->params = new JObject();

		if ($this->canView($item))
			$item->params->set('access-view', true);

		if ($this->canEdit($item))
			$item->params->set('access-edit', true);

		if ($this->canDelete($item))
			$item->params->set('access-delete', true);

	}

	/**
	* Method to auto-populate the model state.
	*
	* @access	protected
	*
	* @return	void
	*/
	protected function populateState()
	{
		// Load id from array from the request.
		$jinput = JFactory::getApplication()->input;

		//1. First read the state var
		//2. Then read from Request
		//3. Finally search if cid is an array var (in request)
		$id = $this->state->get($this->getName() . '.id',
			$jinput->get('id',
				$jinput->get('cid', null, 'ARRAY')
				, 'ARRAY'));

		if (is_array($id))
			$id = $id[0];

		//assure compatibility when cid is received instead of id
		$jinput->set('id', $id);

		parent::populateState();

		if (defined('JDEBUG'))
			$_SESSION["Bds"]["Model"][$this->getName()]["State"] = $this->state;

	}

	/**
	* Register the ORM rules into model state SQL statements.
	*
	* @access	protected
	*
	*
	* @since	3.1
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
			else
			{
				// (Per default) FILTER the result using Primary Key recieved from URL
				$this->orm(array(
					'id' => 'id'
				));
			}
		}
	}

	/**
	* Convert the received datas from the input before to send to the model.
	*
	* @access	public
	* @param	array	&$data	Theinput array.
	*
	* @return	void
	*/
	public function prepareData(&$data)
	{

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
	* Method to allow derived classes to preprocess the form.
	*
	* @access	protected
	* @param	JForm	$form	A JForm object.
	* @param	mixed	$data	The data expected for the form.
	* @param	string	$group	The name of the plugin group to import (defaults to "content").
	*
	*
	* @since	12.2
	*
	* @return	void
	*/
	protected function preprocessForm(JForm $form, $data, $group = 'content')
	{
		$baseFolder = JPATH_BDS . '/fork/models/forms';
		$formFile = $baseFolder .'/'. $this->view_item .'.xml';
		if (file_exists($formFile))
		{
			$xml = simplexml_load_file($formFile);
			$form->load($xml, true);
		}

		parent::preprocessForm($form, $data, $group);
	}

	/**
	* Proxy. Dump the query to the screen.
	*
	* @access	public
	* @param	JDatabaseQuery	$query	Query to dump.
	* @param	boolean	$output	Print the query description to the standard output.
	*
	*
	* @since	3.1
	*
	* @return	array	Query description.
	*/
	public function queryDump($query, $output = true)
	{
		return BdsClassModelOrm::queryDump($query, $output);
	}

	/**
	* Method to save the form data.
	*
	* @access	public
	* @param	array	$data	The form data..
	*
	*
	* @since	12.2
	*
	* @return	boolean	True on success, False on error.
	*/
	public function save($data)
	{
		// Sync the model relations
		if ($result = parent::save($data))
		{
			$data  = JFactory::getApplication()->input->get('jform', array(), 'array');

			$relations = $this->getRelation();

			if ($relations)
			foreach($relations as $name => $relation)
			{
				if (!isset($data[$name]))
					continue;

				$this->syncRelation($name, $data[$name]);
			}
		}

		return $result;
	}

	/**
	* Saves the manually set order of records.
	*
	* @access	public
	* @param	array	$pks	An array of primary key ids.
	* @param	integer	$order	+1 or -1
	* @param	string	$where	The stringified condifions for ordering.
	*
	*
	* @since	12.2
	*
	* @return	boolean	True on success.
	*/
	public function saveorder($pks = null, $order = null, $where = null)
	{
		$table = $this->getTable();
		$conditions = array();

		if (empty($pks))
		{
			return JError::raiseWarning(500, JText::_($this->text_prefix . '_ERROR_NO_ITEMS_SELECTED'));
		}

		// Update ordering values
		foreach ($pks as $i => $pk)
		{
			$table->load((int) $pk);

			// Access checks.
			if (!$this->canEdit($table))
			{
				// Prune items that you can't change.
				unset($pks[$i]);
				JLog::add(JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'), JLog::WARNING, 'jerror');
			}

			elseif (isset($order[$i]) && $table->ordering != $order[$i])
			{
		
				$table->ordering = $order[$i];

				if (!$table->store())
				{
					$this->setError($table->getError());
					return false;
				}

				if ($where)
					$condition = array($where);
				else
					$condition = $this->getReorderConditions($table);


				$found = false;

				foreach ($conditions as $cond)
				{
					if ($cond[1] == $condition)
					{
						$found = true;
						break;
					}
				}

				if (!$found)
				{
					$key = $table->getKeyName();
					$conditions[] = array($table->$key, $condition);
				}
			}
		}

		// Execute reorder for each category.
		foreach ($conditions as $cond)
		{
			$table->load($cond[0]);
			$table->reorder($cond[1]);
		}

		// Clear the component's cache
		$this->cleanCache();

		return true;
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
		return $this->state->set($property, $value);
	}

	/**
	* Method to upgrade relations.
	*
	* @access	public
	* @param	string	$name	Relation name.
	* @param	array	$values	List of cross-reference values.
	*
	* @return	void
	*/
	public function syncRelation($name, $values)
	{
		if (!isset($values) || !is_array($values))
			return;

		// Init some vars
		$relation = $this->getRelation($name);
		$item = $this->getItem();
		$this->loadRelations($name);

		$db = $this->getDbo();
		$raw = $relation->raw;
		$ext = self::$extension;
		if (isset($relation->pivotExtension))
			$ext = ucfirst($relation->pivotExtension);

		if (empty($values[0]))
			array_shift($values);

		// Security : Sanitize array (against injections)
		$cur_values = $values;
		$values = array();
		foreach($cur_values as $foo => $v)
			$values[] = (int)$v;


		if ($relation->type == 'belongsToMany')
			$foreignKey = $relation->pivotForeignPkey;
		else
			$foreignKey = $relation->foreignPkey;

		$indexValues = array();
		$removeValues = array();
		foreach($item->$name as $related)
		{
			$val = $related->$foreignKey;

			// Intersection already present do nothing
			if (in_array($val, $values))
				$indexValues[] = $val;

			// Array of values to remove
			else
				$removeValues[] = $val;
		}

		//substract the known indexes
		$addValues = array_diff($values, $indexValues);

		switch($relation->type)
		{
			// Many to many
			case 'belongsToMany':


				// Procees with RAW database access
				if ($raw)
				{
					// ADD directly in Database
					foreach ($addValues as $value)
					{
						$query = $db->getQuery(true);
						$query->insert($relation->pivotTable);
						$query->set($relation->pivotLocalKey . ' = ' . (int)$this->getId());

						$query->set($relation->pivotForeignKey . ' = ' . (int)$value);

						$db->setQuery($query);
						$db->query();
					}

					// REMOVE directly in Database
					$query = $db->getQuery(true);
					$query->delete($relation->pivotTable);
					$query->where($relation->pivotLocalKey . ' = ' . (int)$this->getId());

					if (count($values))
						$query->where($relation->pivotForeignKey . ' NOT IN(' . implode(', ', $values). ')');

					$db->setQuery($query);
					$db->query();
				}



				// Reuse the model features
				else
				{


					$modelPivot = JModelLegacy::getInstance($relation->pivotModel, $relation->extension . 'Model');
					$model = JModelLegacy::getInstance($modelPivot->getNameItem(), $relation->extension . 'Model');


					// ADD with Model
					foreach ($addValues as $value)
					{
						$data = array();

						// Create new
						$model->setState($model->getName().'.id', 0);

						$model->save(array(
							$relation->pivotLocalKey => (int)$this->getId(),
							$relation->pivotForeignKey => (int)$value
						));
					}


					// REMOVE with Model

					// Load all pivot primary keys
					$modelPivot->addWhere($db->quoteName($relation->pivotLocalKey) . ' = ' . (int)$this->getId());

					if (count($values))
						$modelPivot->addWhere($db->quoteName($relation->pivotForeignKey) . ' NOT IN (' . implode(', ', $values) . ')');

					// Retreive pk Ids from the pivot table
					$relatedToDelete = $modelPivot->getItems();
					$deletePks = array();
					$pkField = $modelPivot->getNamePk();
					foreach($relatedToDelete as $related)
					{
						$deletePks[] = $related->$pkField;
					}

					$model->delete($deletePks);

				}



				break;


			case 'hasMany':

				// Raw DB
				if ($raw)
				{

					// UPDATE directly in Database
					foreach ($addValues as $value)
					{
						$query = $db->getQuery(true);
						$query->update($relation->foreignTable);
						$query->set($relation->foreignKey . ' = ' . (int)$this->getId());

						$query->where($relation->foreignPkey . ' = ' . (int)$value);

						$db->setQuery($query);
						$db->query();
					}


					// RESET directly in Databse
					$query = $db->getQuery(true);
					$query->update($relation->foreignTable);
					$query->set($relation->foreignKey . ' = null');

					$query->where($relation->foreignKey . ' = ' . (int)$this->getId());

					if (count($values))
						$query->where($relation->foreignPkey . ' NOT IN (' . implode(', ', $values) . ')');

					$db->setQuery($query);
					$db->query();
				}



				// Reuse the model features
				else
				{
					$modelForeign = JModelLegacy::getInstance($relation->model, $relation->extension . 'Model');
					$model = JModelLegacy::getInstance($modelForeign->getNameItem(), $relation->extension . 'Model');


					// UPDATE with Model
					foreach ($addValues as $value)
					{
						$data = array();

						// Create new
						$model->setState($model->getName().'.id', $value);

						$model->save(array(
							$relation->foreignKey => (int)$this->getId()
						));
					}

					// RESET with Model
					foreach ($removeValues as $value)
					{
						$data = array();

						// Create new
						$model->setState($model->getName().'.id', $value);

						$model->save(array(
							$relation->foreignKey => '0'
						));
					}
				}
				break;
		}
	}

	/**
	* Method to toggle a value, including integer values
	*
	* @access	public
	* @param	string	$fieldName	The field to increment.
	* @param	integer	$pk	The id of the item.
	* @param	integer	$max	Max possible values (modulo). Reset to 0 when the value is superior to max.
	*
	*
	* @since	Cook 2.7.1
	*
	* @return	boolean	True when changed. False if error.
	*/
	public function toggle($fieldName, $pk = null, $max = 1)
	{
		if ($pk)
			$this->setState($this->getName() . '.id', $pk);

		// To be sure that the request include this field
		$this->addSelect('a.' . $fieldName);

		// Get the item
		$item = $this->getItem();

		// Not found
		if (!$item->id)
			return false;

		//Calculate the new value
		$value = $item->$fieldName + 1;
		if ($value > $max)
			$value = 0;

		$result = $this->save(array(
			$fieldName => $value
		));


		if (!$result)
		{
			JError::raiseWarning(1106, JText::sprintf("BDS_MODEL_IMPOSSIBLE_TO_TOGGLE", $fieldName));
			return false;
		}

		return true;
	}

	/**
	* Method to validate the form data. 
	*  This override handle the inputs of files types, (Joomla issue when they
	* are required)
	*
	* @access	public
	* @param	object	$form	The form to validate against.
	* @param	array	$data	The data to validate.
	* @param	string	$group	The name of the field group to validate.
	*
	* @return	mixed	Array of filtered data if valid, false otherwise.
	*/
	public function validate($form, $data, $group = null)
	{
		//Get the posted files if this model is concerned by files submission
		// JOOMLA FIX : if missing fields in $_POST -> issue in partial update when required
		$currentData = $this->getItem();
		foreach($currentData as $fieldName => $value)
		{
			$field = $form->getField($fieldName, $group, $value);

			//Skip the ID data (and other fields not in the form)
			if (!$field)
				continue;

			//Missing in $_POST and required
			if (!in_array($fieldName, array_keys($data)) && $field->required)
				//Insert the current object value. (UPDATE)
				$data[$fieldName] = $currentData->$fieldName;
		}


		//JOOMLA FIX : Reformate some field types not handled properly
		foreach($form->getFieldset($group) as $field)
		{
			$value = null;
			if (isset($data[$field->fieldname]))
				$value = $data[$field->fieldname];
			else
			{
				// Set the default value when missing in POST
				$default = $field->getAttribute('default');
				if ($default !== null)
				{
					$data[$field->fieldname] = $value = $default;
				}
			}

			switch($field->type)
			{
				//JOOMLA FIX : Reformate the date/time format comming from the post
				case 'ckcalendar':

					if ($value && (string)$field->format)
					{
						// Validation treatement only for strings formats. Unix type always pass
						if (!is_numeric($value) && !BdsHelperDates::isNull((string)$value))
						{
							$time = BdsHelperDates::getSqlDate($value, array($field->format));

							if ($time === null){
								JError::raiseWarning(1203, JText::sprintf('BDS_VALIDATOR_WRONG_DATETIME_FORMAT_FOR_PLEASE_RETRY', $field->label));
								$valid = false;
							}
							else
								$data[$field->fieldname] = $time->toSql();
						}
					}


					break;


				//JOOMLA FIX : Apply a null value if the field is in the form
				case 'ckcheckbox':
					if (!$value)
						$data[$field->fieldname] = 0;
					break;
			}
		}


		// JOOMLA FIX : always missing file names in $_POST -> issue when required
		//Get the posted files if this model is concerned by files submission
		if (count($this->fileFields))
		{
			$fileInput = new JInput($_FILES);
			$files = $fileInput->get('jform', null, 'array');

			if (count($files['name']))
			foreach($files['name'] as $fieldName => $value)
			{
				//For required files, temporary insert the value comming from $_FILES
				if (!empty($value))
				{
					$field = $form->getField($fieldName, $group);
					if ($field->required)
						$data[$fieldName] = $value;
				}
			}
		}

		//Exec the native PHP validation (rules)
		$result = parent::validate($form, $data, $group);

		//check the result before to go further
		if ($result === false)
			return false;

		//ID key follower (in some case, ex : save2copy task)
		if (isset($data['id']))
			$result['id'] = $data['id'];

		return $result;
	}


}



