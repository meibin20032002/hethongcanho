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
* @subpackage	Product
*/
class BdsViewProduct extends BdsClassView
{
	/**
	* List of the reachables layouts. Fill this array in every view file.
	*
	* @var array
	*/
	protected $layouts = array('product');

	/**
	* Execute and display a template : Product
	*
	* @access	protected
	* @param	string	$tpl	The name of the template file to parse; automatically searches through the template paths.
	*
	*
	* @since	11.1
	*
	* @return	mixed	A string if successful, otherwise a JError object.
	*/
	protected function displayProduct($tpl = null)
	{
		// Initialiase variables.
		$this->model	= $model	= $this->getModel();
		$this->state	= $state	= $this->get('State');
		$this->params 	= $state->get('params');
		$state->set('context', 'layout.product');
		$this->item		= $item		= $this->get('Item');

		$this->form		= $form		= $this->get('Form');
		$this->canDo	= $canDo	= BdsHelper::getActions($model->getId());
		$lists = array();
		$this->lists = &$lists;

		// Define the title
		$this->_prepareDocument(JText::_('BDS_LAYOUT_PRODUCT'), $this->item, 'title');

		$user		= JFactory::getUser();
		$isNew		= ($model->getId() == 0);

		//Check ACL before opening the form (prevent from direct access)
		if (!$model->canEdit($item, true))
			$model->setError(JText::_('JERROR_ALERTNOAUTHOR'));

		// Check for errors.
		if (count($errors = $model->getErrors()))
		{
			JError::raiseError(500, implode(BR, array_unique($errors)));
			return false;
		}
		//Toolbar
		JToolBarHelper::title(JText::_('BDS_LAYOUT_PRODUCT'), 'pencil-2');

		// Save & Close
		if (($isNew && $model->canCreate()) || (!$isNew && $item->params->get('access-edit')))
			JToolBarHelper::save('product.save', "BDS_JTOOLBAR_SAVE_CLOSE");
		// Save
		if (($isNew && $model->canCreate()) || (!$isNew && $item->params->get('access-edit')))
			JToolBarHelper::apply('product.apply', "BDS_JTOOLBAR_SAVE");
		// Save to Copy
		if (($isNew && $model->canCreate()) || (!$isNew && $item->params->get('access-edit')))
			JToolBarHelper::save2copy('product.save2copy', "BDS_JTOOLBAR_SAVE_TO_COPY");
		// Cancel
		JToolBarHelper::cancel('product.cancel', "BDS_JTOOLBAR_CANCEL");
		// Publish
		if (!$isNew && $model->canEditState($item) && ($item->published != 1))
			JToolBarHelper::publish('products.publish', "BDS_JTOOLBAR_PUBLISH");
		// Unpublish
		if (!$isNew && $model->canEditState($item) && ($item->published != 0))
			JToolBarHelper::unpublish('products.unpublish', "BDS_JTOOLBAR_UNPUBLISH");
		// Trash
		if (!$isNew && $model->canEditState($item) && ($item->published != -2))
			JToolBarHelper::trash('products.trash', "BDS_JTOOLBAR_TRASH", false);
		// Archive
		if (!$isNew && $model->canEditState($item) && ($item->published != 2))
			JToolBarHelper::custom('products.archive', 'archive', 'archive',  "BDS_JTOOLBAR_ARCHIVE", false);

        $model_types = CkJModel::getInstance('Categories', 'BdsModel');
        $model_types->addWhere('a.sub_category = 0');
		$model_types->addGroupOrder("a.title");
		$lists['fk']['types'] = $model_types->getItems();
        
        $types = ($item->types)?$item->types:1;
		$model_category_id = CkJModel::getInstance('Categories', 'BdsModel');
        $model_category_id->addWhere('a.sub_category = '.$types);
		$model_category_id->addGroupOrder("a.title");
		$lists['fk']['category_id'] = $model_category_id->getItems();
        
        $model_project_id = CkJModel::getInstance('Projects', 'BdsModel');
		$model_project_id->addGroupOrder("a.title");
		$lists['fk']['project_id'] = $model_project_id->getItems();
        
		$model_main_location = CkJModel::getInstance('Locations', 'BdsModel');
        $model_main_location->addWhere('a.sub_location = 0');
		$model_main_location->addGroupOrder("a.ordering");
		$lists['fk']['main_location'] = $model_main_location->getItems();
        
        $location_id = ($item->main_location)?$item->main_location:79;
        $model_sub_location = CkJModel::getInstance('Locations', 'BdsModel');
        $model_sub_location->addWhere('a.sub_location = '.$location_id);
		$model_sub_location->addGroupOrder("a.ordering");
		$lists['fk']['sub_location'] = $model_sub_location->getItems();

		$model_created_by = CkJModel::getInstance('ThirdUsers', 'BdsModel');
		$model_created_by->addGroupOrder("a.name");
		$lists['fk']['created_by'] = $model_created_by->getItems();

		$model_modified_by = CkJModel::getInstance('ThirdUsers', 'BdsModel');
		$model_modified_by->addGroupOrder("a.name");
		$lists['fk']['modified_by'] = $model_modified_by->getItems();

		//Ordering
		$orderModel = CkJModel::getInstance('Products', 'BdsModel');
		if (isset($item->category_id))
			$orderModel->addWhere("a.category_id = '" . $item->category_id . "'");
		$lists["ordering"] = $orderModel->getItems();
	}


}



