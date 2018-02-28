<?php
/**
* @package RSForm! Pro
* @copyright (C) 2007-2014 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class RsformControllerConfiguration extends RsformController
{
	function __construct()
	{
		parent::__construct();
		
		$this->registerTask('apply', 'save');
		
		$this->_db = JFactory::getDbo();
	}

	function edit()
	{
		JFactory::getApplication()->input->set('view', 	'configuration');
		JFactory::getApplication()->input->set('layout', 	'default');
		
		parent::display();
	}
	
	function cancel()
	{
		$this->setRedirect('index.php?option=com_rsform');
	}
	
	public function save()
	{
		$db 	= JFactory::getDbo();
		$config = JFactory::getApplication()->input->get('rsformConfig', array(), 'array');

		if ($config) {
			foreach ($config as $name => $value) {
				if ($name == 'global.register.code') {
					$value = trim($value);
				}
				$query = $db->getQuery(true)
					->update($db->qn('#__rsform_config'))
					->set($db->qn('SettingValue').' = '.$db->q($value))
					->where($db->qn('SettingName').' = '.$db->q($name));
				$db->setQuery($query)
					->execute();
			}
		}
		
		RSFormProHelper::readConfig(true);
		
		$task = $this->getTask();
		switch ($task)
		{
			case 'apply':
				$tabposition = JFactory::getApplication()->input->getInt('tabposition', 0);
				$link = 'index.php?option=com_rsform&task=configuration.edit&tabposition='.$tabposition;
			break;
			
			case 'save':
				$link = 'index.php?option=com_rsform';
			break;
		}
		
		$this->setRedirect($link, JText::_('RSFP_CONFIGURATION_SAVED'));
	}
}