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
* Bds Projects Controller
*
* @package	Bds
* @subpackage	Projects
*/
class BdsControllerProjects extends BdsClassControllerList
{
	/**
	* The context for storing internal data, e.g. record.
	*
	* @var string
	*/
	protected $context = 'projects';

	/**
	* The URL view item variable.
	*
	* @var string
	*/
	protected $view_item = 'project';

	/**
	* The URL view list variable.
	*
	* @var string
	*/
	protected $view_list = 'projects';

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
			case 'project.publish':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.projects.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'project.unpublish':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.projects.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'project.trash':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.projects.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'project.archive':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.projects.default'
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



