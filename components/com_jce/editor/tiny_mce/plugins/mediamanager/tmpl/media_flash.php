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
<div class="media_option flash">
	<h4><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_OPTIONS'); ?></h4>

		<div class="uk-form-row">
			<label for="flash_quality" class="uk-form-label uk-width-1-5"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_QUALITY'); ?></label>
			<div class="uk-width-4-5">
				<div class="uk-form-controls uk-width-2-5">
					<select id="flash_quality">
						<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET'); ?></option>
						<option value="high"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_HIGH'); ?></option>
						<option value="low"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_LOW'); ?></option>
						<option value="autolow"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_AUTOLOW'); ?></option>
						<option value="autohigh"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_AUTOHIGH'); ?></option>
						<option value="best"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_BEST'); ?></option>
					</select>
				</div>

				<label for="flash_scale" class="uk-form-label uk-width-1-5"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_SCALE'); ?></label>
				<div class="uk-form-controls uk-width-2-5">
					<select id="flash_scale">
						<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET'); ?></option>
						<option value="showall"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_SHOWALL'); ?></option>
						<option value="noborder"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_NOBORDER'); ?></option>
						<option value="exactfit"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_EXACTFIT'); ?></option>
					</select>
				</div>
			</div>
		</div>

		<div class="uk-form-row">
			<label for="flash_wmode" class="uk-form-label uk-width-1-5"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_WMODE'); ?></label>
			<div class="uk-width-4-5">
				<div class="uk-form-controls uk-width-2-5">
					<select id="flash_wmode">
						<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET'); ?></option>
						<option value="window"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_WINDOW'); ?></option>
						<option value="opaque"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_OPAQUE'); ?></option>
						<option value="transparent" selected="selected"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_TRANSPARENT'); ?></option>
					</select>
				</div>

				<label for="flash_salign" class="uk-form-label uk-width-1-5"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_SALIGN'); ?></label>
				<div class="uk-form-controls uk-width-2-5">
					<select id="flash_salign">
						<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET'); ?></option>
						<option value="l"><?php echo WFText::_('WF_OPTION_LEFT'); ?></option>
						<option value="t"><?php echo WFText::_('WF_OPTION_TOP'); ?></option>
						<option value="r"><?php echo WFText::_('WF_OPTION_RIGHT'); ?>t</option>
						<option value="b"><?php echo WFText::_('WF_OPTION_BOTTOM'); ?></option>
						<option value="tl"><?php echo WFText::_('WF_OPTION_TOP_LEFT'); ?></option>
						<option value="tr"><?php echo WFText::_('WF_OPTION_TOP_RIGHT'); ?></option>
						<option value="bl"><?php echo WFText::_('WF_OPTION_BOTTOM_LEFT'); ?></option>
						<option value="br"><?php echo WFText::_('WF_OPTION_BOTTOM_RIGHT'); ?></option>
					</select>
				</div>
			</div>
		</div>

		<div class="uk-form-row">
			<input type="checkbox" id="flash_play"
						checked="checked" />
			<label for="flash_play" class="uk-margin-right"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_PLAY'); ?></label>

			<input type="checkbox" id="flash_loop"
						checked="checked" />
			<label for="flash_loop" class="uk-margin-right"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_LOOP'); ?></label>
			<input type="checkbox" class="checkbox" id="flash_menu"
						checked="checked" />
			<label for="flash_menu" class="uk-margin-right"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_MENU'); ?></label>
			<input type="checkbox" id="flash_swliveconnect" />
			<label for="flash_swliveconnect" class="uk-margin-right"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_LIVECONNECT'); ?></label>
			<input type="checkbox"
						id="flash_allowfullscreen" />
			<label for="flash_allowfullscreen"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_ALLOWFULLSCREEN'); ?></label>
		</div>

	<div class="uk-form-row">
			<label for="flash_base" class="uk-form-label uk-width-1-5"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_BASE'); ?></label>
			<div class="uk-form-controls uk-width-4-5">
				<input type="text" id="flash_base" />
			</div>
	</div>

	<div class="uk-form-row">
		<label for="flash_flashVars" class="uk-form-label uk-width-1-5"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_FLASHVARS'); ?></label>
		<div class="uk-form-controls uk-width-4-5">
			<textarea id="flash_flashvars" rows="3"></textarea>
		</div>
	</div>

	<p class="uk-text-small">Adobe and Flash are either registered trademarks or trademarks of Adobe Systems Incorporated in the United States and/or other countries.</p>
</div>
