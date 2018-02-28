<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V3.1.9   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		
* @package		BDS
* @subpackage	Projects
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
class BdsModelProjects extends BdsClassModelList
{
	/**
	* Default item layout.
	*
	* @var array
	*/
	public $itemDefaultLayout = 'project';

	/**
	* The URL view item variable.
	*
	* @var string
	*/
	protected $view_item = 'project';

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
			'location_id' => 'cmd',
			'type_id' => 'cmd',
			'utility_id' => 'cmd',
			'handing_over' => 'date:Y-m-d'
				));

		//Define the searchable fields
		$this->set('search_vars', array(
			'search' => 'string'
				));


		parent::__construct($config);

		$this->hasOne('type_id', // name
			'types', // foreignModelClass
			'type_id', // localKey
			'id' // foreignKey
		);

		$this->hasOne('location_id', // name
			'locations', // foreignModelClass
			'location_id', // localKey
			'id' // foreignKey
		);

		$this->hasOne('utility_id', // name
			'utilities', // foreignModelClass
			'utility_id', // localKey
			'id' // foreignKey
		);

		$this->hasOne('modified_by', // name
			'.users', // foreignModelClass
			'modified_by', // localKey
			'id' // foreignKey
		);

		$this->hasOne('created_by', // name
			'.users', // foreignModelClass
			'created_by', // localKey
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
		$id	.= ':'.$this->getState('filter.location_id');
		$id	.= ':'.$this->getState('filter.type_id');
		$id	.= ':'.$this->getState('filter.utility_id');
		$id	.= ':'.$this->getState('filter.handing_over');
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
		$query->from('#__bds_projects AS a');

		// Primary Key is always required
		$this->addSelect('a.id');


		switch($this->getState('context', 'all'))
		{
			case 'layout.default':

				$this->orm->select(array(
					'address',
					'alias',
					'created_by',
					'created_by.name',
					'creation_date',
					'gallery',
					'handing_over',
					'location_id',
					'location_id.title',
					'ordering',
					'price_max',
					'price_min',
					'title'
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
			'created_by',
			'published'
		));

		// ACCESS : Restricts accesses over the local table
		$this->orm->access('a', array(
			'publish' => 'published',
			'author' => 'created_by'
		));

		// SEARCH : Title + Alias + Address + Investor
		$this->orm->search('search', array(
			'on' => array(
				'title' => 'like',
				'alias' => 'like',
				'address' => 'like',
				'investor' => 'like'
			)
		));

		// FILTER : Location
		if($filter_location_id = $this->getState('filter.location_id'))
		{
			if ($filter_location_id > 0){
				$this->addWhere("a.location_id = " . (int)$filter_location_id);
			}
		}

		// FILTER : Type
		if($filter_type_id = $this->getState('filter.type_id'))
		{
			if ($filter_type_id > 0){
				$this->addWhere("a.type_id = " . (int)$filter_type_id);
			}
		}

		// FILTER : Utility
		if($filter_utility_id = $this->getState('filter.utility_id'))
		{
			if ($filter_utility_id > 0){
				$this->addWhere("a.utility_id = " . (int)$filter_utility_id);
			}
		}

		// FILTER : Handing over
		if($filter_handing_over = $this->getState('filter.handing_over'))
		{
			if ($filter_handing_over !== null){
				$this->addWhere("a.handing_over = " . $this->_db->Quote($filter_handing_over));
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



