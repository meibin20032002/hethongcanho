<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V3.1.9   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		
* @package		BDS
* @subpackage	Products
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
* Bds Item Model
*
* @package	Bds
* @subpackage	Classes
*/
class BdsModelProduct extends BdsClassModelItem
{
	/**
	* View list alias
	*
	* @var string
	*/
	protected $view_item = 'product';

	/**
	* View list alias
	*
	* @var string
	*/
	protected $view_list = 'products';

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
		parent::__construct();
	}

	/**
	* Method to delete item(s).
	*
	* @access	public
	* @param	array	&$pks	Ids of the items to delete.
	*
	* @return	boolean	True on success.
	*/
	public function delete(&$pks)
	{
		if (!count( $pks ))
			return true;


		if (!parent::delete($pks))
			return false;



		return true;
	}

	/**
	* Method to get the layout (including default).
	*
	* @access	public
	*
	* @return	string	The layout alias.
	*/
	public function getLayout()
	{
		$jinput = JFactory::getApplication()->input;
		return $jinput->get('layout', 'product', 'STRING');
	}

	/**
	* A public method to get a set of ordering conditions.
	*
	* @access	public
	* @param	object	$table	A record object.
	*
	*
	* @since	1.6
	*
	* @return	mixed	An array of conditions or a string to add to add to ordering queries.
	*/
	public function getReorderConditions($table)
	{
		$conditions = array('`category_id` = '.(int) $table->category_id);
		return $conditions;
	}

	/**
	* Returns a Table object, always creating it.
	*
	* @access	public
	* @param	string	$type	The table type to instantiate.
	* @param	string	$prefix	A prefix for the table class name. Optional.
	* @param	array	$config	Configuration array for model. Optional.
	*
	*
	* @since	1.6
	*
	* @return	JTable	A database object
	*/
	public function getTable($type = 'product', $prefix = 'BdsTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	* Method to increment hits (check session and layout)
	*
	* @access	public
	* @param	array	$layouts	List of authorized layouts for hitting the object.
	*
	*
	* @since	11.1
	*
	* @return	boolean	Null if skipped. True when incremented. False if error.
	*/
	public function hit($layouts = null)
	{
		return parent::hit(array());
	}

	/**
	* Method to get the data that should be injected in the form.
	*
	* @access	protected
	*
	* @return	mixed	The data for the form.
	*/
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_bds.edit.product.data', array());

		if (empty($data)) {
			//Default values shown in the form for new item creation
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('product.id') == 0)
			{
				$jinput = JFactory::getApplication()->input;

				$data->id = 0;
				$data->title = null;
				$data->alias = null;
				$data->category_id = $jinput->get('filter_category_id', $this->getState('filter.category_id'), 'INT');
				$data->project_id = $jinput->get('filter_project_id', $this->getState('filter.project_id'), 'INT');
				$data->types = $jinput->get('filter_types', $this->getState('filter.types'), 'STRING');
				$data->who = $jinput->get('filter_who', $this->getState('filter.who'), 'STRING');
				$data->main_location = $jinput->get('filter_main_location', $this->getState('filter.main_location'), 'INT');
                $data->sub_location = $jinput->get('filter_sub_location', $this->getState('filter.sub_location'), 'INT');
				$data->gallery = null;
				$data->price = null;
				$data->bedrooms = $jinput->get('filter_bedrooms', $this->getState('filter.bedrooms'), 'STRING');
				$data->description = null;
				$data->address = null;
				$data->acreage = null;
				$data->behind = null;
                $data->alley = null;
				$data->direction = $jinput->get('filter_direction', $this->getState('filter.direction'), 'STRING');
				$data->legal_documents = $jinput->get('filter_legal_documents', $this->getState('filter.legal_documents'), 'STRING');
				$data->characteristics = $jinput->get('filter_characteristics', $this->getState('filter.characteristics'), 'STRING');
				$data->shipping_payment = null;
				$data->contact_number = null;
				$data->contact_name = null;
				$data->contact_email = null;
				$data->contact_address = null;
				$data->ordering = null;
				$data->published = null;
                $data->hits = null;
				$data->created_by = $jinput->get('filter_created_by', $this->getState('filter.created_by'), 'INT');
				$data->modified_by = $jinput->get('filter_modified_by', $this->getState('filter.modified_by'), 'INT');
				$data->creation_date = null;
				$data->modification_date = null;

			}
            if($data->gallery){
				$data->gallery =  json_decode($data->gallery);
			}
		}
		return $data;
	}

	/**
	* Method to auto-populate the model state.
	* 
	* This method should only be called once per instantiation and is designed to
	* be called on the first call to the getState() method unless the model
	* configuration flag to ignore the request is set.
	* 
	* Note. Calling getState in this method will result in recursion.
	*
	* @access	protected
	*
	*
	* @since	11.1
	*
	* @return	void
	*/
	protected function populateState()
	{
		$app = JFactory::getApplication();
		$session = JFactory::getSession();
		$acl = BdsHelper::getActions();



		parent::populateState();

		//Only show the published items
		if (!$acl->get('core.admin') && !$acl->get('core.edit.state'))
			$this->setState('filter.published', 1);
	}

	/**
	* Preparation of the item query.
	*
	* @access	protected
	* @param	object	&$query	returns a filled query object.
	* @param	integer	$pk	The primary id key of the product
	*
	* @return	void
	*/
	protected function prepareQuery(&$query, $pk)
	{
		//FROM : Main table
		$query->from('#__bds_products AS a');

		// Primary Key is always required
		$this->addSelect('a.id');


		switch($this->getState('context', 'all'))
		{
			case 'layout.product':

				$this->orm->select(array(
					'acreage',
					'address',
					'alias',
					'bedrooms',
					'behind',
					'category_id',
					'category_id.title',
					'characteristics',
					'contact_address',
					'contact_email',
					'contact_name',
					'contact_number',
					'created_by',
					'created_by.name',
					'creation_date',
					'description',
					'direction',
					'gallery',
                    'hits',
					'legal_documents',
					'main_location',
					'main_location.title',
                    'sub_location',
					'sub_location.title',
					'modification_date',
					'modified_by',
					'modified_by.name',
					'ordering',
					'price',
                    'alley',
                    'project_id',
					'project_id.title',
					'shipping_payment',
					'title',
					'types',
					'who'
				));

				// Item search : Based on Primary Key
				$query->where('a.id = ' . (int) $pk);
				break;

			case 'all':
				//SELECT : raw complete query without joins
				$this->addSelect('a.*');

				// Disable the pagination
				$this->setState('list.limit', null);
				$this->setState('list.start', null);

				// Item search : Based on Primary Key
				$query->where('a.id = ' . (int) $pk);
				break;
		}

		$this->orm->select(array(
			'category_id',
			'created_by',
			'published'
		));

		$this->orm->access('a', array(
			'publish' => 'published',
			'author' => 'created_by'
		));

		// ORDERING
		$orderCol = $this->getState('list.ordering');
		$orderDir = $this->getState('list.direction', 'ASC');

		if ($orderCol)
			$this->addOrder($orderCol . ' ' . $orderDir);



		// Apply all SQL directives to the query
		$this->applySqlStates($query);
	}

	/**
	* Prepare and sanitise the table prior to saving.
	*
	* @access	protected
	* @param	JTable	$table	A JTable object.
	*
	*
	* @since	1.6
	*
	* @return	void
	*/
	protected function prepareTable($table)
	{
		$date = JFactory::getDate();


		if (empty($table->id))
		{
			//Defines automatically the author of this element
			$table->created_by = JFactory::getUser()->get('id');

			//Creation date
			if (empty($table->creation_date))
				$table->creation_date =  JFactory::getDate()->toSql();

			// Set ordering to the last item if not set
			$conditions = $this->getReorderConditions($table);
			$conditions = (count($conditions)?implode(" AND ", $conditions):'');
			$table->ordering = $table->getNextOrder($conditions);
		}
		else
		{
			//Defines automatically the editor of this element
			$table->modified_by = JFactory::getUser()->get('id');

			//Modification date
			$table->modification_date = JFactory::getDate()->toSql();
		}
		//Alias
		if (empty($table->alias))
			$table->alias = JApplication::stringURLSafe($table->title);
	}

	/**
	* Save an item.
	*
	* @access	public
	* @param	array	$data	The post values.
	*
	* @return	boolean	True on success.
	*/
	public function save($data)
	{
		$data1 = JRequest::getVar('jform');
        $data['gallery'] = json_encode($data['gallery']);
        $data['price'] = str_replace(',', '', $data1['price']);
        $data['acreage'] = str_replace(',', '', $data1['acreage']);
        $data['alley'] = str_replace(',', '', $data1['alley']);
        
        //Convert from a non-SQL formated date (creation_date)
		$data['creation_date'] = BdsHelperDates::getSqlDate($data['creation_date'], array('Y-m-d H:i'), true, 'USER_UTC');

		//Convert from a non-SQL formated date (modification_date)
		$data['modification_date'] = BdsHelperDates::getSqlDate($data['modification_date'], array('Y-m-d H:i'), true, 'USER_UTC');
		//Some security checks
		$acl = BdsHelper::getActions();

		//Secure the author key if not allowed to change
		if (isset($data['created_by']) && !$acl->get('core.edit'))
			unset($data['created_by']);

		//Secure the published tag if not allowed to change
		if (isset($data['published']) && !$acl->get('core.edit.state'))
			unset($data['published']);

		if (parent::save($data)) {
			return true;
		}
		return false;


	}


}



