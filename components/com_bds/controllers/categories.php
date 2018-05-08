<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V3.1.9   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		
* @package		BDS
* @subpackage	Categories
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
* Bds Categories Controller
*
* @package	Bds
* @subpackage	Categories
*/
class BdsControllerCategories extends BdsClassControllerList
{
	/**
	* The context for storing internal data, e.g. record.
	*
	* @var string
	*/
	protected $context = 'categories';

	/**
	* The URL view item variable.
	*
	* @var string
	*/
	protected $view_item = 'category';

	/**
	* The URL view list variable.
	*
	* @var string
	*/
	protected $view_list = 'categories';

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
		$app = JFactory::getApplication();

	}

	/**
	* Return the current layout.
	*
	* @access	protected
	* @param	bool	$default	If true, return the default layout.
	*
	* @return	string	Requested layout or default layout
	*/
	protected function getLayout($default = null)
	{
		if ($default)
			return 'default';

		$jinput = JFactory::getApplication()->input;
		return $jinput->get('layout', 'default', 'CMD');
	}

    public function subCategory()
	{
        JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
        $id = JRequest::getInt('id');
        
        $model = CkJModel::getInstance('categories', 'BdsModel');
        if($id)
            $model->addWhere('a.sub_category = '.$id);
		$model->set('context', $model->get('context'));
		$list = $model->getItems();
        
        $array = array();
        if($list){
            foreach($list as $row){
                $array[] = array(
                    'id' => $row->id,
                    'title' => $row->title,                                    
                );
            }
        }

		print_r(json_encode($array));
		exit();
	}
}



