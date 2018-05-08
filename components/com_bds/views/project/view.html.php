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
* HTML View class for the Bds component
*
* @package	Bds
* @subpackage	Project
*/
class BdsViewProject extends BdsClassView
{
	/**
	* List of the reachables layouts. Fill this array in every view file.
	*
	* @var array
	*/
	protected $layouts = array('project');

	/**
	* Execute and display a template : Project
	*
	* @access	protected
	* @param	string	$tpl	The name of the template file to parse; automatically searches through the template paths.
	*
	*
	* @since	11.1
	*
	* @return	mixed	A string if successful, otherwise a JError object.
	*/
	protected function displayProject($tpl = null)
	{
		// Initialiase variables.
		$this->model	= $model	= $this->getModel();
		$this->state	= $state	= $this->get('State');
		$this->params 	= $state->get('params');
		$state->set('context', 'layout.project');
		$this->item		= $item		= $this->get('Item');
		$this->canDo	= $canDo	= BdsHelper::getActions($model->getId());
		$lists = array();
		$this->lists = &$lists;

		// Define the title
		$this->_prepareDocument(JText::_('BDS_LAYOUT_PROJECT'), $this->item, 'title');

		$user		= JFactory::getUser();
		$isNew		= ($model->getId() == 0);

		//Check ACL before opening the view (prevent from direct access)
		if (!$model->canAccess($item))
			$model->setError(JText::_('JERROR_ALERTNOAUTHOR'));

		// Check for errors.
		if (count($errors = $model->getErrors()))
		{
			JError::raiseError(500, implode(BR, array_unique($errors)));
			return false;
		}
		//Toolbar

		// Save & Close
		if (($isNew && $model->canCreate()) || (!$isNew && $item->params->get('access-edit')))
			JToolBarHelper::save('project.save', "BDS_JTOOLBAR_SAVE_CLOSE");
		// Save
		if (($isNew && $model->canCreate()) || (!$isNew && $item->params->get('access-edit')))
			JToolBarHelper::apply('project.apply', "BDS_JTOOLBAR_SAVE");
		// Cancel
		JToolBarHelper::cancel('project.cancel', "BDS_JTOOLBAR_CANCEL");
		// Publish
		if (!$isNew && $model->canEditState($item) && ($item->published != 1))
			JToolBarHelper::publish('projects.publish', "BDS_JTOOLBAR_PUBLISH");
		// Unpublish
		if (!$isNew && $model->canEditState($item) && ($item->published != 0))
			JToolBarHelper::unpublish('projects.unpublish', "BDS_JTOOLBAR_UNPUBLISH");
		// Trash
		if (!$isNew && $model->canEditState($item) && ($item->published != -2))
			JToolBarHelper::trash('projects.trash', "BDS_JTOOLBAR_TRASH", false);
		// Archive
		if (!$isNew && $model->canEditState($item) && ($item->published != 2))
			JToolBarHelper::custom('projects.archive', 'archive', 'archive',  "BDS_JTOOLBAR_ARCHIVE", false);

		$this->toolbar = JToolbar::getInstance();
        
        $model_types = CkJModel::getInstance('Categories', 'BdsModel');
        $model_types->addWhere('a.sub_category = 0');
		$model_types->addGroupOrder("a.title");
        $types = $model_types->getItems();
        
        $products = array(); 
        foreach($types as $row){
            $product = array();
            $model = CkJModel::getInstance('products', 'BdsModel');
            $model->addWhere('a.project_id ='. $item->id);
            $model->addWhere('a.types ='. $row->id);
    		$model->setState('context', 'layout.default');
            $product = $model->getItems();
            
            if($product){
                $products[] = array(
                    'title' => $row->title,
                    'alias' => $row->alias,                    
                    'count' => count($product),
                    'product' => $product
                );
            }
        }        
        $this->products = $products;
	}
}



