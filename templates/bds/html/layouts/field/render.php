<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_fields
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

if (!key_exists('field', $displayData))
{
	return;
}

$field = $displayData['field'];
$label = JText::_($field->label);
$value = $field->value;
$showLabel = $field->params->get('showlabel');

if ($value == '')
{
	return;
}
?>
<a href="<?php echo JUri::base().$field->rawvalue; ?>"><img src="<?php echo JUri::base().$field->rawvalue; ?>" alt="Thumbnail 2"/></a>