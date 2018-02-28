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
* Bds Products Controller
*
* @package	Bds
* @subpackage	Products
*/
class BdsControllerProducts extends BdsClassControllerList
{
	/**
	* The context for storing internal data, e.g. record.
	*
	* @var string
	*/
	protected $context = 'products';

	/**
	* The URL view item variable.
	*
	* @var string
	*/
	protected $view_item = 'product';

	/**
	* The URL view list variable.
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
			case 'product.publish':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.products.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'product.unpublish':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.products.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'product.trash':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.products.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'product.archive':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.products.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'post.publish':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.products.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'post.unpublish':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.products.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'post.trash':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.products.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'post.archive':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.products.default'
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


}



