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


// Some usefull constants
if(!defined('DS')) define('DS',DIRECTORY_SEPARATOR);
if(!defined('BR')) define("BR", "<br />");
if(!defined('LN')) define("LN", "\n");

// Main component aliases
if (!defined('COM_BDS')) define('COM_BDS', 'com_bds');
if (!defined('BDS_CLASS')) define('BDS_CLASS', 'Bds');

// Component paths constants
if (!defined('JPATH_ADMIN_BDS')) define('JPATH_ADMIN_BDS', JPATH_ADMINISTRATOR . '/components/' . COM_BDS);
if (!defined('JPATH_SITE_BDS')) define('JPATH_SITE_BDS', JPATH_SITE . '/components/' . COM_BDS);

$app = JFactory::getApplication();

// This constant is used for replacing JPATH_COMPONENT, in order to share code between components.
if (!defined('JPATH_BDS')) define('JPATH_BDS', ($app->isSite()?JPATH_SITE_BDS:JPATH_ADMIN_BDS));

// Load the component Dependencies
require_once(dirname(__FILE__) . '/helper.php');


jimport('joomla.version');
$version = new JVersion();

if (version_compare($version->RELEASE, '3.0', '<'))
	throw new JException('Joomla! 3.x is required.');

// Proxy alias class : CONTROLLER
if (!class_exists('CkJController')){ 	jimport('legacy.controller.legacy'); 	class CkJController extends JControllerLegacy{}}

// Proxy alias class : MODEL
if (!class_exists('CkJModel')){			jimport('legacy.model.legacy');			class CkJModel extends JModelLegacy{}}

// Proxy alias class : VIEW
if (!class_exists('CkJView')){	if (!class_exists('JViewLegacy', false))	jimport('legacy.view.legacy'); class CkJView extends JViewLegacy{}}

require_once(dirname(__FILE__) . '/../classes/loader.php');

BdsClassLoader::setup(false, false);
BdsClassLoader::discover('Bds', JPATH_ADMIN_BDS, false, true);

// Some helpers
BdsClassLoader::register('JToolBarHelper', JPATH_ADMINISTRATOR ."/includes/toolbar.php", true);

CkJController::addModelPath(JPATH_BDS . '/models', 'BdsModel');
// Register JDom
JLoader::register('JDom', JPATH_ADMIN_BDS . '/dom/dom.php', true);

//Instance JDom
if (!isset($app->dom))
{
	if (!class_exists('JDom'))
		jexit('JDom is required');

	JDom::getInstance();	
}

