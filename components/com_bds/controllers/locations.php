<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V3.1.9   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		
* @package		BDS
* @subpackage	Locations
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
* Bds Locations Controller
*
* @package	Bds
* @subpackage	Locations
*/
class BdsControllerLocations extends BdsClassControllerList
{
	/**
	* The context for storing internal data, e.g. record.
	*
	* @var string
	*/
	protected $context = 'locations';

	/**
	* The URL view item variable.
	*
	* @var string
	*/
	protected $view_item = 'location';

	/**
	* The URL view list variable.
	*
	* @var string
	*/
	protected $view_list = 'locations';

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

    public function subLocations()
	{
        JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
        $main_location = JRequest::getInt('id');
        
        $model = CkJModel::getInstance('locations', 'BdsModel');
        if($main_location)
            $model->addWhere('a.sub_location = '.$main_location);
		$model->set('context', $model->get('context'));
		$list = $model->getItems();
        
        $html = '<option value="" selected="selected">Chọn Quận/Huyện</option>';
        if($list){
            foreach($list as $row){
                $html .= '<option value="'.$row->id.'">'.$row->title.'</option>';
            }
        }

		echo $html;
		exit();
	}
}



