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

defined('DS') or define("DS", DIRECTORY_SEPARATOR);


/**
* Script file of Bds component
*
* @package	Bds
* @subpackage	Installer
*/
class com_bdsInstallerScript
{
	/**
	* Called on installation
	*
	* @access	public
	* @param	JAdapterInstance	$adapter	Installer Component Adapter.
	*
	*
	* @since	1.6
	*
	* @return	void
	*/
	public function install(JAdapterInstance $adapter)
	{
		$adapter->getParent()->setRedirectURL('index.php?option=com_bds');


	}

	/**
	* Method to install the embedded third extensions.
	*
	* @access	private
	* @param	JAdapterInstance	$adapter	Installer Component Adapter.
	*
	*
	* @since	Cook 2.6
	*
	* @return	void
	*/
	private function installExtensions(JAdapterInstance $adapter)
	{
		$dir = $adapter->getParent()->getPath('source') . '/extensions';

		$installResults = array();

		jimport('joomla.filesystem.folder');
		$folders = JFolder::folders($dir);

		foreach($folders as $folder)
		{
			$source = $dir . '/' . $folder;
		    $installer = new JInstaller;
		    $installResults[] = $installer->install($source);
		}
	}

	/**
	* Called after any type of action.
	*
	* @access	public
	* @param	string	$type	Type.
	* @param	JAdapterInstance	$adapter	Installer Component Adapter.
	*
	*
	* @since	1.6
	*
	* @return	void
	*/
	public function postflight($type, JAdapterInstance $adapter)
	{
		switch($type)
		{
			case 'install':
				$txtAction = JText::_('Installing');

				//Install all extensions contained in 'extensions' directory
				$this->installExtensions($adapter);
				break;

			case 'update':
				$txtAction = JText::_('Updating');

				//Install all extensions contained in 'extensions' directory
				$this->installExtensions($adapter);
				break;

			case 'uninstall':
				$txtAction = JText::_('Uninstalling');

				//Install all extensions contained in 'extensions' directory
				$this->uninstallExtensions($adapter);
				break;

		}

		$app = JFactory::getApplication();
		$txtComponent = JText::_('COM_BDS');
		$app->enqueueMessage(JText::sprintf('%s %s was successfull.', $txtAction, $txtComponent));
	}

	/**
	* Called before any type of action
	*
	* @access	public
	* @param	string	$type	Type.
	* @param	JAdapterInstance	$adapter	Installer Component Adapter.
	*
	*
	* @since	1.6
	*
	* @return	void
	*/
	public function preflight($type, JAdapterInstance $adapter)
	{

	}

	/**
	* Called on uninstallation
	*
	* @access	public
	* @param	JAdapterInstance	$adapter	Installer Component Adapter.
	*
	*
	* @since	1.6
	*
	* @return	void
	*/
	public function uninstall(JAdapterInstance $adapter)
	{
		// We run postflight also after uninstalling
		self::postflight('uninstall', $adapter);

	}

	/**
	* Method to uninstall the embedded third extensions.
	*
	* @access	private
	* @param	JAdapterInstance	$adapter	Installer Component Adapter.
	*
	*
	* @since	Cook 2.6
	*
	* @return	void
	*/
	private function uninstallExtensions(JAdapterInstance $adapter)
	{

	}

	/**
	* Called on update
	*
	* @access	public
	* @param	JAdapterInstance	$adapter	Installer Component Adapter.
	*
	*
	* @since	1.6
	*
	* @return	void
	*/
	public function update(JAdapterInstance $adapter)
	{
		$adapter->getParent()->setRedirectURL('index.php?option=com_bds');
	}


}



