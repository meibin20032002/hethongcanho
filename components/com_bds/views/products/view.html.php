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
* HTML View class for the Bds component
*
* @package	Bds
* @subpackage	Products
*/
class BdsViewProducts extends BdsClassView
{
	/**
	* List of the reachables layouts. Fill this array in every view file.
	*
	* @var array
	*/
	protected $layouts = array('default', 'modal');

	/**
	* Execute and display a template : Products
	*
	* @access	protected
	* @param	string	$tpl	The name of the template file to parse; automatically searches through the template paths.
	*
	*
	* @since	11.1
	*
	* @return	mixed	A string if successful, otherwise a JError object.
	*/
	protected function displayDefault($tpl = null)
	{
		$this->model		= $model	= $this->getModel();
		$this->state		= $state	= $this->get('State');
		$this->params 		= JComponentHelper::getParams('com_bds', true);
        $types = $state->get('filter.types');
        if($types){
            if($types == 0){
                $state->set('filter.types', 'mua-ban');  
            }          
        }else{
            $state->set('filter.types', 'mua-ban');
        }
                                    
		$state->set('context', 'layout.default');
		$this->items		= $items	= $this->get('Items');
		$this->canDo		= $canDo	= BdsHelper::getActions();
		$this->pagination	= $this->get('Pagination');
		$this->filters = $filters = $model->getForm('default.filters');
		$this->menu = BdsHelper::addSubmenu('products', 'default');
		$lists = array();
		$this->lists = &$lists;

		// Define the title
		$this->_prepareDocument(JText::_('BDS_LAYOUT_PRODUCTS'));

		

		//Filters
		// Location
		$modelmain_location = CkJModel::getInstance('locations', 'BdsModel');
        $modelmain_location->addWhere('a.sub_location=0');
		$modelmain_location->set('context', $model->get('context'));
		$filters['filter_main_location']->jdomOptions = array(
			'list' => $modelmain_location->getItems()
		);
        
        $main_location = $this->state->get('filter.main_location');
        $modelsub_location = CkJModel::getInstance('locations', 'BdsModel');
        if($main_location)
            $modelsub_location->addWhere('a.sub_location='.$main_location);
		$modelsub_location->set('context', $model->get('context'));
		$filters['filter_sub_location']->jdomOptions = array(
			'list' => $modelsub_location->getItems()
		);

		// Category
		$modelCategory_id = CkJModel::getInstance('categories', 'BdsModel');
		$modelCategory_id->set('context', $model->get('context'));
		$filters['filter_category_id']->jdomOptions = array(
			'list' => $modelCategory_id->getItems()
		);

		// Sort by
		$filters['sortTable']->jdomOptions = array(
			'list' => $this->getSortFields('default')
		);

		// Limit
		$filters['limit']->jdomOptions = array(
			'pagination' => $this->pagination
		);

		// Toolbar



		$this->toolbar = JToolbar::getInstance();
	}

	/**
	* Execute and display a template : Products
	*
	* @access	protected
	* @param	string	$tpl	The name of the template file to parse; automatically searches through the template paths.
	*
	*
	* @since	11.1
	*
	* @return	mixed	A string if successful, otherwise a JError object.
	*/
	protected function displayModal($tpl = null)
	{
		$this->model		= $model	= $this->getModel();
		$this->state		= $state	= $this->get('State');
		$this->params 		= JComponentHelper::getParams('com_bds', true);
		$state->set('context', 'layout.modal');
		$this->items		= $items	= $this->get('Items');
		$this->canDo		= $canDo	= BdsHelper::getActions();
		$this->pagination	= $this->get('Pagination');
		$this->filters = $filters = $model->getForm('modal.filters');
		$this->menu = BdsHelper::addSubmenu('products', 'modal');
		$lists = array();
		$this->lists = &$lists;

		// Define the title
		$this->_prepareDocument(JText::_('BDS_LAYOUT_PRODUCTS'));

		

		//Filters
		// Limit
		$filters['limit']->jdomOptions = array(
			'pagination' => $this->pagination
		);

		// Toolbar



		$this->toolbar = JToolbar::getInstance();
	}

	/**
	* Returns an array of fields the table can be sorted by.
	*
	* @access	protected
	* @param	string	$layout	The name of the called layout. Not used yet
	*
	*
	* @since	3.0
	*
	* @return	array	Array containing the field name to sort by as the key and display text as value.
	*/
	protected function getSortFields($layout = null)
	{
		return array(
			'price' => JText::_('BDS_FIELD_PRICE'),
			'' => JText::_('BDS_FIELD_ID')
		);
	}


}



