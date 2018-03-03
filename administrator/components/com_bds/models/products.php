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
* Bds List Model
*
* @package	Bds
* @subpackage	Classes
*/
class BdsModelProducts extends BdsClassModelList
{
	/**
	* Default item layout.
	*
	* @var array
	*/
	public $itemDefaultLayout = 'product';

	/**
	* The URL view item variable.
	*
	* @var string
	*/
	protected $view_item = 'product';

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
		//Define the sortables fields (in lists)
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'a.ordering', 'ordering',
				'ordering', 'a.ordering',

			);
		}

		//Define the filterable fields
		$this->set('filter_vars', array(
			'published' => 'varchar',
			'sortTable' => 'cmd',
			'directionTable' => 'cmd',
			'limit' => 'cmd',
			'category_id' => 'cmd',
			'types' => 'varchar',
			'location_id' => 'cmd',
			'who' => 'varchar',
			'bedrooms' => 'varchar',
			'direction' => 'varchar',
			'legal_documents' => 'varchar',
			'characteristics' => 'varchar'
				));

		//Define the searchable fields
		$this->set('search_vars', array(
			'search' => 'string'
				));


		parent::__construct($config);

		$this->hasOne('category_id', // name
			'categories', // foreignModelClass
			'category_id', // localKey
			'id' // foreignKey
		);

		$this->hasOne('project_id', // name
			'projects', // foreignModelClass
			'project_id', // localKey
			'id' // foreignKey
		);

		$this->hasOne('location_id', // name
			'locations', // foreignModelClass
			'location_id', // localKey
			'id' // foreignKey
		);

		$this->hasOne('created_by', // name
			'.users', // foreignModelClass
			'created_by', // localKey
			'id' // foreignKey
		);

		$this->hasOne('modified_by', // name
			'.users', // foreignModelClass
			'modified_by', // localKey
			'id' // foreignKey
		);
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
		return $jinput->get('layout', 'default', 'STRING');
	}

	/**
	* Method to get a store id based on model configuration state.
	* 
	* This is necessary because the model is used by the component and different
	* modules that might need different sets of data or differen ordering
	* requirements.
	*
	* @access	protected
	* @param	string	$id	A prefix for the store id.
	*
	*
	* @since	1.6
	*
	* @return	void
	*/
	protected function getStoreId($id = '')
	{
		// Compile the store id.

		$id	.= ':'.$this->getState('sortTable');
		$id	.= ':'.$this->getState('directionTable');
		$id	.= ':'.$this->getState('limit');
		$id	.= ':'.$this->getState('search.search');
		$id	.= ':'.$this->getState('filter.category_id');
        $id	.= ':'.$this->getState('filter.project_id');
		$id	.= ':'.$this->getState('filter.types');
		$id	.= ':'.$this->getState('filter.location_id');
		$id	.= ':'.$this->getState('filter.who');
		$id	.= ':'.$this->getState('filter.bedrooms');
		$id	.= ':'.$this->getState('filter.direction');
		$id	.= ':'.$this->getState('filter.legal_documents');
		$id	.= ':'.$this->getState('filter.characteristics');
		return parent::getStoreId($id);
	}

	/**
	* Preparation of the list query.
	*
	* @access	protected
	* @param	object	&$query	returns a filled query object.
	*
	* @return	void
	*/
	protected function prepareQuery(&$query)
	{
		//FROM : Main table
		$query->from('#__bds_products AS a');

		// Primary Key is always required
		$this->addSelect('a.id');


		switch($this->getState('context', 'all'))
		{
			case 'layout.default':

				$this->orm->select(array(
					'acreage',
					'address',
					'alias',
					'bedrooms',
					'behind',
					'category_id',
					'category_id.title',
					'created_by',
					'created_by.name',
					'creation_date',
					'direction',
					'gallery',
                    'hits',
					'legal_documents',
					'location_id',
					'location_id.title',
					'ordering',
					'price',
                    'project_id',
					'project_id.title',
					'title',
					'types',
					'who'
				));
				break;

			case 'layout.modal':

				$this->orm->select(array(
					'title'
				));
				break;

			case 'all':
				//SELECT : raw complete query without joins
				$this->addSelect('a.*');

				// Disable the pagination
				$this->setState('list.limit', null);
				$this->setState('list.start', null);
				break;
		}

		// SELECT required fields for all profiles
		$this->orm->select(array(
			'category_id',
			'created_by',
			'published'
		));

		// ACCESS : Restricts accesses over the local table
		$this->orm->access('a', array(
			'publish' => 'published',
			'author' => 'created_by'
		));

		// SEARCH : Title + Alias + Address + Contact Number + Contact Name + Contact Address
		$this->orm->search('search', array(
			'on' => array(
				'title' => 'like',
				'alias' => 'like',
				'address' => 'like',
				'contact_number' => 'like',
				'contact_name' => 'like',
				'contact_address' => 'like'
			)
		));

		// FILTER : Category
		if($filter_category_id = $this->getState('filter.category_id'))
		{
			if ($filter_category_id > 0){
				$this->addWhere("a.category_id = " . (int)$filter_category_id);
			}
		}
        
        // FILTER : Project
		if($filter_project_id = $this->getState('filter.project_id'))
		{
			if ($filter_project_id > 0){
				$this->addWhere("a.project_id = " . (int)$filter_project_id);
			}
		}

		// FILTER : Type
		if($filter_types = $this->getState('filter.types'))
		{
			if ($filter_types !== null){
				$this->addWhere("a.types = " . $this->_db->Quote($filter_types));
			}
		}

		// FILTER : Location
		if($filter_location_id = $this->getState('filter.location_id'))
		{
			if ($filter_location_id > 0){
				$this->addWhere("a.location_id = " . (int)$filter_location_id);
			}
		}

		// FILTER : Who
		if($filter_who = $this->getState('filter.who'))
		{
			if ($filter_who !== null){
				$this->addWhere("a.who = " . $this->_db->Quote($filter_who));
			}
		}

		// FILTER : Bedrooms
		if($filter_bedrooms = $this->getState('filter.bedrooms'))
		{
			if ($filter_bedrooms !== null){
				$this->addWhere("a.bedrooms = " . $this->_db->Quote($filter_bedrooms));
			}
		}

		// FILTER : Direction
		if($filter_direction = $this->getState('filter.direction'))
		{
			if ($filter_direction !== null){
				$this->addWhere("a.direction = " . $this->_db->Quote($filter_direction));
			}
		}

		// FILTER : Legal documents
		if($filter_legal_documents = $this->getState('filter.legal_documents'))
		{
			if ($filter_legal_documents !== null){
				$this->addWhere("a.legal_documents = " . $this->_db->Quote($filter_legal_documents));
			}
		}

		// FILTER : Characteristics
		if($filter_characteristics = $this->getState('filter.characteristics'))
		{
			if ($filter_characteristics !== null){
				$this->addWhere("a.characteristics = " . $this->_db->Quote($filter_characteristics));
			}
		}

		// ORDERING
		$orderCol = $this->getState('list.ordering', 'title');
		$orderDir = $this->getState('list.direction', 'ASC');

		if ($orderCol)
			$this->orm->order(array($orderCol => $orderDir));


		// Apply all SQL directives to the query
		$this->applySqlStates($query);
	}


}



