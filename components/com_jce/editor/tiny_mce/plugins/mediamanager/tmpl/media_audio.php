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

<div class="media_option audio">
        <h4><?php echo WFText::_('WF_MEDIAMANAGER_AUDIO_OPTIONS'); ?></h4>

        <div class="uk-form-row">
          <input type="checkbox" id="audio_autoplay" /></td>
          <label for="audio_autoplay" class="uk-margin-right"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_AUTOPLAY'); ?></label>
          <input type="checkbox" id="audio_controls" checked="checked" />
          <label for="audio_controls" class="uk-margin-right"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_CONTROLS'); ?></label>
          <input type="checkbox" id="audio_loop" />
          <label for="audio_loop" class="uk-margin-right"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_LOOP'); ?></label>
          <input type="checkbox" id="audio_audio" />
          <label for="audio_audio"><?php echo WFText::_('WF_MEDIAMANAGER_VIDEO_MUTE'); ?></label>
        </div>

        <div class="uk-form-row">
            <label for="audio_preload" class="uk-form-label uk-width-1-5"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_PRELOAD'); ?></label>
            <div class="uk-form-controls uk-width-1-5">
              <select id="audio_preload">
                    <option value=""><?php echo WFText::_('WF_OPTION_AUTO'); ?></option>
                    <option value="none"><?php echo WFText::_('WF_OPTION_NONE'); ?></option>
                    <option value="metadata"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_METADATA'); ?></option>
                </select>
            </div>
        </div>

        <div class="uk-form-row">
            <label for="audio_source" class="uk-form-label uk-width-1-5"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_SOURCE'); ?></label>
            <div class="uk-form-controls uk-width-4-5">
              <input type="text" name="audio_source[]" class="active" onclick="MediaManagerDialog.setSourceFocus(this);" />
            </div>
        </div>
        <div class="uk-form-row">
            <label for="audio_source" class="uk-form-label uk-width-1-5"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_SOURCE'); ?></label>
            <div class="uk-form-controls uk-width-4-5">
              <input type="text" name="audio_source[]" onclick="MediaManagerDialog.setSourceFocus(this);" />
            </div>
        </div>
        <div class="uk-form-row">
            <label for="audio_attributes" class="uk-form-label uk-width-1-5"><?php echo WFText::_('WF_LABEL_ATTRIBUTES'); ?></label>
            <div class="uk-width-4-5" id="audio_attributes">
                <div class="uk-form-row uk-repeatable">
                    <div class="uk-form-controls uk-grid uk-grid-small uk-width-9-10">
                            <label class="uk-form-label uk-width-1-10"><?php echo WFText::_('WF_LABEL_NAME'); ?></label>
                            <div class="uk-form-controls uk-width-4-10">
                                <input type="text" name="audio_attributes_name[]" />
                            </div>
                            <label class="uk-form-label uk-width-1-10"><?php echo WFText::_('WF_LABEL_VALUE'); ?></label>
                            <div class="uk-form-controls uk-width-4-10">
                                <input type="text" name="audio_attributes_value[]" />
                            </div>
                    </div>
                    <div class="uk-form-controls uk-width-1-10 uk-margin-small-left">
                            <button type="button" class="uk-button uk-button-link uk-repeatable-create"><i class="uk-icon-plus"></i></button>
                            <button type="button" class="uk-button uk-button-link uk-repeatable-delete"><i class="uk-icon-trash"></i></button>
                    </div>
                </div>
        </div>
        </div>
</div>
