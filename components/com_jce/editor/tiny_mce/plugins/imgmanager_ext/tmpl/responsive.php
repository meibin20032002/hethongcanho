<?php

/**
 * @copyright 	Copyright (c) 2009-2017 Ryan Demmer. All rights reserved
 * @license   	GNU/GPL 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses
 */
defined('_JEXEC') or die('RESTRICTED');
?>

<div class="uk-repeatable uk-placeholder uk-position-relative uk-margin-top-remove uk-margin-small-bottom">

  <div class="uk-form-row">
    <label for="responsive_media_query" class="uk-form-label uk-width-2-10"><?php echo WFText::_('WF_IMGMANAGER_EXT_LABEL_SOURCE', 'Source'); ?></label>
    <div class="uk-width-3-4 uk-form-controls uk-grid uk-grid-small">
      <div class="uk-width-4-6">
        <input type="text" name="responsive_source[]" class="uk-persistent-focus uk-active" />
      </div>
      <div class="uk-width-1-6 uk-form-icon uk-form-icon-flip">
        <input type="text" name="responsive_width_descriptor[]" pattern="[0-9]+" class="uk-text-center" />
        <i class="uk-icon-none">w</i>
      </div>
      <div class="uk-width-1-6 uk-form-icon uk-form-icon-flip">
        <input type="text" name="responsive_pixel_density[]" pattern="[0-9\.]+" class="uk-text-center" />
        <i class="uk-icon-none">x</i>
      </div>
    </div>
  </div>

  <!--div class="uk-form-row uk-width-9-10">
    <label for="responsive_source" class="uk-form-label uk-width-2-10"><?php echo WFText::_('WF_IMGMANAGER_EXT_LABEL_MEDIA_QUERY', 'Media'); ?></label>
    <div class="uk-grid uk-grid-small uk-width-8-10">
        <div class="uk-width-1-1 uk-form-controls">
          <input type="text" name="responsive_media_query[]" disabled="disabled" />
        </div>
    </div>
  </div-->

  <div class="uk-position-top-right uk-margin-small-top uk-margin-small-right">
    <button class="uk-button uk-button-link uk-repeatable-create uk-margin-small-top"><i class="uk-icon-plus"></i></button>
    <button class="uk-button uk-button-link uk-repeatable-delete uk-margin-small-top"><i class="uk-icon-trash"></i></button>
  </div>

</div>

<div class="uk-form-row">
  <label for="responsive_sizes" class="uk-form-label uk-width-2-10"><?php echo WFText::_('WF_IMGMANAGER_EXT_LABEL_SIZES', 'Sizes'); ?></label>
  <div class="uk-form-controls uk-width-8-10">
      <input type="text" id="responsive_sizes" />
  </div>
</div>
<!--div class="uk-form-row">
  <label for="responsive_picture" class="uk-form-label uk-width-2-10"><?php echo WFText::_('WF_IMGMANAGER_EXT_LABEL_PICTURE', 'Picture'); ?></label>
  <div class="uk-form-controls uk-width-8-10">
    <input type="checkbox" id="responsive_picture" />
  </div>
</div-->
