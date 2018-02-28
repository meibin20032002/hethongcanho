<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V3.1.9   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		
* @package		BDS
* @subpackage	BDS
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

jimport('joomla.application.component.view');


/**
* HTML View class for the Bds component
*
* @package	Bds
* @subpackage	Class
*/
class BdsClassView extends CkJView
{
	/**
	* List of the reachables layouts. Fill this array in every view file.
	*
	* @var array
	*/
	protected $layouts = array();

	/**
	* Call the parent display function. Trick for forking overrides.
	*
	* @access	protected
	* @param	string	$tpl	Template.
	*
	*
	* @since	Cook 2.0
	*
	* @return	void
	*/
	protected function _parentDisplay($tpl)
	{
		parent::display($tpl);
	}

	/**
	* Prepares the document.
	*
	* @access	protected
	* @param	string	$title	Defines the page title.
	* @param	object	$object	Item object.
	* @param	string	$keyTitle	Name of the field containing the title
	*
	*
	* @since	Cook 2.6.5
	*
	* @return	void
	*/
	protected function _prepareDocument($title = null, $object = null, $keyTitle = null)
	{
		$menu		= JFactory::getApplication()->getMenu()->getActive();

		$objectTitle = null;
		if ($object)
		{
			if (property_exists($object, $keyTitle) && !empty($object->$keyTitle))
				$objectTitle = $object->$keyTitle;
		}

		// Can reuse the item title to use in the page title
		if ($itemTitle = $this->params->get('item_title', $objectTitle))
			$title = ($title?$title . ' - ':'') . $itemTitle;

		$this->params->set('page_heading', $this->getPageHeading($title));

		// Set the page title
		$this->document->setTitle($this->getBrowserTitle($title));
	}

	/**
	* Manage a template override in the fork directory
	*
	* @access	protected
	*
	*
	* @since	Cook 2.0
	*
	* @return	void
	*/
	protected function addForkTemplatePath()
	{
		$this->addTemplatePath(JPATH_BDS . '/fork/views/' . $this->getName() . '/tmpl');
	}

	/**
	* Shared function before to load the layout.
	*
	* @access	public
	* @param	string	$tpl	Template name.
	*
	*
	* @since	Cook 2.7
	*
	* @return	void
	*/
	public function display($tpl = null)
	{
		$layout = $this->getLayout();
		if (!in_array($layout, $this->layouts))
		{
			JError::raiseError(0, $layout . ' : ' . JText::_('JERROR_LAYOUT_PAGE_NOT_FOUND'));

			// Set the first layout found as default
			if (count($this->layouts))
				$layout = $this->layouts[0];
		}

		$fct = "display" . ucfirst($layout);

		$this->addForkTemplatePath();
		$this->$fct($tpl);

		parent::display($tpl);
	}

	/**
	* Get the title to display in the browser page.
	*
	* @access	protected
	* @param	string	$title	Title.
	*
	*
	* @since	Cook 3.0.1
	*
	* @return	void
	*/
	protected function getBrowserTitle($title = null)
	{
		$title = $this->params->get('title_item', $this->params->get('title', $title));

		$menu = JFactory::getApplication()->getMenu()->getActive();

		if (empty($title) && $menu)
			$browserTitle = $menu->params->get('page_title', $menu->title);
		else
			$browserTitle = $title;

		return $browserTitle;
	}

	/**
	* Get the title to display in the page heading.
	*
	* @access	protected
	* @param	string	$title	Title.
	*
	*
	* @since	Cook 3.0.1
	*
	* @return	void
	*/
	protected function getPageHeading($title = null)
	{
		$title = $this->params->get('title_item', $this->params->get('title', $title));

		$menu = JFactory::getApplication()->getMenu()->getActive();

		if (empty($title) && $menu)
			$pageHeading = $menu->params->get('page_heading', $menu->title);
		else
			$pageHeading = $title;

		return $pageHeading;
	}

	/**
	* Renders the fieldset form.
	*
	* @access	public
	* @param	array	$fieldset	Fielset. array of fields.
	*
	*
	* @since	Cook 2.6.6
	*
	* @return	string	Rendered fields.
	*/
	public function renderFieldset($fieldset)
	{
		// Uses a layout
		return JLayoutHelper::render('form.fieldset', array(
			'fieldset' => $fieldset
		));
	}

	/**
	* Renders the error stack and returns the results as a string
	*
	* @access	public static
	* @param	string	$format	Possible output formats : HTML, TEXT, null (return array).
	*
	*
	* @since	Cook 2.0
	*
	* @return	mixed	Rendered messages. Or array if format is null.
	*/
	public static function renderMessages($format = 'HTML')
	{
		// Initialize the variables
		$msgList = array();
		$rawMessages = array();

		// Get the message queue
		$messages = JFactory::getApplication()->getMessageQueue();

		// Build the sorted message list
		if (is_array($messages) && !empty($messages))
		{
			foreach ($messages as $msg)
			{
				if (isset($msg['type']) && isset($msg['message']))
				{
					$msgList[$msg['type']][] = $msg['message'];

					//Prepare raw
					if ($format == 'TEXT')
						$rawMessages[] = strtoupper($msg['type']) . ': ' . $msg['message'];
				}
			}
		}

		// Return the sorted array
		if ($format == null)
			return $msgList;

		// When stack list is empty, does not return anything
		if (!count($msgList))
			return '';


		// Use a layout
		if ($format == 'HTML')
		{

			return JLayoutHelper::render('joomla.system.message', array(
				'msgList' => $msgList,
				'name' => null,
				'params' => array(),
				'content' => null
			));
		}


		// Output the messages in a raw text format (for alert boxes)
		if ($format == 'TEXT')
			return implode("\n", $rawMessages );
	}

	/**
	* Renders the toolbar.
	*
	* @access	public
	* @param	array	$items	List of items. Used in few cases
	*
	*
	* @since	Cook 2.6.2
	*
	* @return	string	Rendered toolbar.
	*/
	public function renderToolbar($items = null)
	{
		$render = true;

		$app = JFactory::getApplication();
		if ($app->isAdmin())
		{
			//Toolbar is handled by the administrator template
			$render = false;
	
			//Need to render it in case of modal view, or template less
			if ($app->input->get('tmpl') == 'component')
				$render = true;
		}

		if (!$render)
			return '';

		$html = JDom::_('html.toolbar', array(
			"bar" => JToolBar::getInstance('toolbar'),
			'list' => $items
		));

		return $html;
	}


}



