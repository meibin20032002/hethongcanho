<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.beez3
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$app             = JFactory::getApplication();
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$msgList = $displayData['msgList'];
?>

    <?php if (is_array($msgList) && $msgList) : ?>
    <div class="modal fade custom" id="messageModal" role="dialog">
      <div class="modal-dialog"> 
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <?php foreach ($msgList as $type => $msgs) : ?>
            <?php if ($msgs) : ?>
            <dt class="<?php echo strtolower($type); ?>"><h2><?php echo JText::_($type); ?></h2></dt>
            <dd class="<?php echo strtolower($type); ?> message">
              <ul>
                <?php foreach ($msgs as $msg) : ?>
                <li><?php echo $msg; ?></li>
                <?php endforeach; ?>
              </ul>
            </dd>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
    jQuery(document).ready(function(e) {
        jQuery('#messageModal').appendTo("body") 
        jQuery('#messageModal').modal(); 
    });
    </script>
    <?php endif; ?>

