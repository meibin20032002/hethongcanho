<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_related_items
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_bds/models', 'BDSModel');

use Joomla\Utilities\ArrayHelper;

class modBDSFeaturedHelper
{
	public static function getList(&$params)
	{
		// Get the dbo
		$db = JFactory::getDbo();
        $ids= implode(",", $params->get('products'));
        
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__bds_products');
		$query->order('id ASC');
        $query->where('id IN('.$ids.')');		
		
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();

		return $items;
	}
  
}
?>