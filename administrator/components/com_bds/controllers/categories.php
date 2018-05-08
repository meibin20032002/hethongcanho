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

	/**
	* Method to publish an element.
	*
	* @access	public
	*
	* @return	void
	*/
	public function publish()
	{
		JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		$this->_result = $result = parent::publish();
		$model = $this->getModel();

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'default.publish':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.categories.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'default.unpublish':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.categories.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'default.trash':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.categories.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'default.archive':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.categories.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'category.publish':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.categories.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'category.unpublish':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.categories.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'category.trash':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.categories.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'category.archive':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.categories.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'modal.publish':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.categories.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'modal.unpublish':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.categories.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'modal.trash':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.categories.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'modal.archive':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.categories.default'
				), array(
					'cid[]' => null
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'stay'
				));
				break;
		}
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
        
        $html = '<option value="" selected="selected">Ch?n Lo?i b?t d?ng s?n</option>';
        if($list){
            foreach($list as $row){
                $html .= '<option value="'.$row->id.'">'.$row->title.'</option>';
            }
        }

		echo $html;
		exit();
	}
}



