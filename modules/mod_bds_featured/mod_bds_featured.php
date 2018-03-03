<?php
defined('_JEXEC') or die('Restricted access');
$app  = JFactory::getApplication();
$doc  = JFactory::getDocument();
require_once __DIR__ . '/helper.php';

$list            = modBDSFeaturedHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

require(JModuleHelper::getLayoutPath('mod_bds_featured',$params->get('layout', 'default')));	
?>		