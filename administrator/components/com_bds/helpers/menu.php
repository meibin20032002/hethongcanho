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

defined('BDS_CPANEL_MAX_LENGTH') or define("BDS_CPANEL_MAX_LENGTH", null);
defined('BDS_CPANEL_ICON_SIZE') or define("BDS_CPANEL_ICON_SIZE", 48);
defined('BDS_CPANEL_BUTTON_WIDTH') or define("BDS_CPANEL_BUTTON_WIDTH", 100);
defined('BDS_CPANEL_BUTTON_HEIGHT') or define("BDS_CPANEL_BUTTON_HEIGHT", 100);


/**
* Menu Helper. Create the static menus.
*
* @package	Bds
*/
class BdsHelperMenu
{
	/**
	* Stores the menus in cache for optimization.
	*
	* @var array
	*/
	protected static $_cache = array();

	/**
	* Stores the XML menu file in cache for optimization.
	*
	* @var array
	*/
	protected static $_xml = array();

	/**
	* Prepare a menu before to instance and render it. Generally called by the
	* view.
	*
	* @access	public static
	* @param	string	$name	Name of the menu
	* @param	string	$view	Current view. Used for the 'active' state button.
	* @param	string	$layout	Current layout. Used for the 'active' state button.
	*
	* @return	array	Joomla! formated menu list.
	*/
	public static function addSubmenu($name = cpanel, $view, $layout)
	{
		$items = static::getMenuItems($name);

		// Construct the URL and Joomla format item
		$menu = array();
		foreach($items as $item)
		{
			// Menu link
			$extension = 'com_bds';
			if (!empty($item->extension))
				$extension = $item->extension;

			$url = 'index.php?option=' . $extension;
			if (!empty($item->view))
				$url .= '&view=' . $item->view;


			if (!empty($item->layout))
				$url .= '&layout=' . $item->layout;


			if (!empty($item->cid))
				$url .= '&id=' . $item->cid;


			// Is active
			$active = ($item->view == $view);
			if (!empty($item->layout))
				$active = $active && ($item->layout == $layout);

			// Reconstruct in the Joomla format
			$menu[] = array(JText::_($item->label), $url, $active, $item->icon);

		}

		return $menu;
	}

	/**
	* Get a menu from the XML file.
	*
	* @access	public static
	* @param	string	$name	Name of the menu
	*
	* @return	JXMLElement	XML file contents.
	*/
	public static function getMenuItems($name = cpanel)
	{
		// Check in cache
		if (isset($_cache[$name]))
			return $_cache[$name];

		// Read the XML configuration
		$xml = static::getXml();

		if (empty($xml))
			return array();

		$xmlParameters = array('type', 'label', 'description', 'icon', 'extension', 'view', 'layout', 'cid');

		$menu = array();
		// Reduce the xml to the requested menu
		foreach($xml->menu as $xmlMenu)
		{
			if ((string)$xmlMenu['name'] != $name)
				continue;

			// Sanitize into array of objects
			foreach($xmlMenu->children() as $child)
			{
				$item = new stdClass;
				foreach($xmlParameters as $param)
				{
					$item->$param = (string)$child[$param];
				}

				$menu[] = $item;
			}
		}

		// Stores in cache
		$_cache[$name] = $menu;

		return $menu;
	}

	/**
	* Load the menus from an XML file.
	*
	* @access	protected static
	*
	* @return	JXMLElement	XML file contents.
	*/
	protected static function getXml()
	{
		$client = 'admin';
		if (JFactory::getApplication()->isSite())
			$client = 'site';


		if (isset(self::$_xml[$client]))
			$xml = self::$_xml[$client];
		else
		{
			if ($client == 'admin')
				$xmlFileBase = JPATH_ADMIN_BDS;
			else
				$xmlFileBase = JPATH_SITE_BDS;

			$xmlFile = $xmlFileBase . '/menu.xml';
			if (file_exists($xmlFileBase . '/fork/menu.xml'))
				$xmlFile = $xmlFileBase . '/fork/menu.xml';


			if (!file_exists($xmlFile))
				return array();

			self::$_xml[$client] = JFactory::getXML($xmlFile);
		}


		$xml = self::$_xml[$client];


		return $xml;
	}

	/**
	* Render a control panel.
	*
	* @access	public static
	* @param	array	$list	Joomla! menu. Must respect the native format
	*
	* @return	string	HTML of the rendered control panel
	*/
	public static function renderCpanel($list)
	{
		if (empty($list))
			return;

		$html = '';
		$html .= '<div class="cpanel">';

		foreach($list as $item)
		{
			$html .= static::renderCpanelItem($item);
		}

		$html .= '</div>';

		return $html;
	}

	/**
	* Render a control panel button.
	*
	* @access	protected static
	* @param	array	$item	Description of the button. Must respect the Joomla! native format
	*
	* @return	string	HTML of the rendered button
	*/
	protected static function renderCpanelItem($item)
	{
		$maxLength = BDS_CPANEL_MAX_LENGTH;
		$iconSize = BDS_CPANEL_ICON_SIZE;
		$buttonWidth = BDS_CPANEL_BUTTON_WIDTH;
		$buttonHeight = BDS_CPANEL_BUTTON_HEIGHT;


		$html = '';

		$linkTitle = $title = JText::_($item[0]);
		if ($maxLength && (strlen($linkTitle) > $maxLength))
			$title = substr($linkTitle, 0, $maxLength - 1) . '...';


		$href = $item[1];


		//Image
		$imageClass = 'ico-' . $iconSize . '-' . (isset($item[3])?$item[3]:null);

		$html .= '<span'
		.	' class="' . $imageClass .'"'
		.	' style="width:' . $iconSize . 'px;height:' . $iconSize . 'px;background-repeat:no-repeat;background-position:center;display:inline-block;"'
		. 	' title="' . $title . '"'
		. '></span>';


		//Label
		$html .= "<span>". $title ."</span>";

		//Too keep icon in middle, and little bit up. Javascript could be better here
		$paddingTop = ($buttonHeight - $iconSize)/2 - ($buttonHeight/8);
		$paddingBottom = 0;

		$html = '<a'
			.	' href="' . $href . '"'
			. 	' style="width:' . (int)$buttonWidth . 'px;height:' . (int)($buttonHeight-$paddingTop) . 'px;padding-top:' . (int)$paddingTop .'px;padding-bottom:' . $paddingBottom . 'px;cursor:pointer;"'
			.	' title="' . JText::_($linkTitle) . '"'
			.	'>' . $html . '</a>';



		//Embed html in button
		$html = '<div class="button">' . $html . '</div>';


		//Embed html in left floating
		$html = '<div style="float:left;">' . $html . '</div>';

		return $html;
	}


}



