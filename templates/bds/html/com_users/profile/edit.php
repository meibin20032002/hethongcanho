<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');

// Load user_profile plugin language
$lang = JFactory::getLanguage();
$lang->load('plg_user_profile', JPATH_ADMINISTRATOR);

?>
<div class="login-bg" style="background-image: url('images/banners/bg.jpg');">	
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="login register<?php echo $this->pageclass_sfx; ?>">
                	<?php if ($this->params->get('show_page_heading')) : ?>
                	<div class="login-header">
                		<h1>
                			<?php echo $this->escape($this->params->get('page_heading')); ?>
                		</h1>
                	</div>
                	<?php endif; ?>

	<form id="member-profile" action="<?php echo JRoute::_('index.php?option=com_users&task=profile.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
	<?php // Iterate through the form fieldsets and display each one. ?>
	<?php foreach ($this->form->getFieldsets() as $group => $fieldset) : ?>
		<?php $fields = $this->form->getFieldset($group); ?>
		<?php if (count($fields)) : ?>
		<div class="row">
			<?php // Iterate through the fields in the set and display them. ?>
			<?php foreach ($fields as $field) : ?>
			<?php // If the field is hidden, just display the input. ?>
				<?php if ($field->hidden) : ?>
					<?php echo $field->input; ?>
				<?php else : ?>
                    <div class="col-md-6">   
    					<div class="control-group">
    						<div class="controls">
    							<?php if ($field->fieldname == 'password1') : ?>
    								<?php // Disables autocomplete ?> <input type="password" style="display:none">
    							<?php endif; ?>
    							<?php echo $field->input; ?>
    						</div>
    					</div>
                    </div> 
				<?php endif;?>
			<?php endforeach;?>
		</div>
		<?php endif;?>
	<?php endforeach;?>

	<?php if (count($this->twofactormethods) > 1) : ?>
		<fieldset>
			<legend><?php echo JText::_('COM_USERS_PROFILE_TWO_FACTOR_AUTH'); ?></legend>

			<div class="control-group">
				<div class="control-label">
					<label id="jform_twofactor_method-lbl" for="jform_twofactor_method" class="hasTooltip"
						   title="<?php echo '<strong>' . JText::_('COM_USERS_PROFILE_TWOFACTOR_LABEL') . '</strong><br />' . JText::_('COM_USERS_PROFILE_TWOFACTOR_DESC'); ?>">
						<?php echo JText::_('COM_USERS_PROFILE_TWOFACTOR_LABEL'); ?>
					</label>
				</div>
				<div class="controls">
					<?php echo JHtml::_('select.genericlist', $this->twofactormethods, 'jform[twofactor][method]', array('onchange' => 'Joomla.twoFactorMethodChange()'), 'value', 'text', $this->otpConfig->method, 'jform_twofactor_method', false); ?>
				</div>
			</div>
			<div id="com_users_twofactor_forms_container">
				<?php foreach($this->twofactorform as $form) : ?>
				<?php $style = $form['method'] == $this->otpConfig->method ? 'display: block' : 'display: none'; ?>
				<div id="com_users_twofactor_<?php echo $form['method']; ?>" style="<?php echo $style; ?>">
					<?php echo $form['form']; ?>
				</div>
				<?php endforeach; ?>
			</div>
		</fieldset>

		<fieldset>
			<legend>
				<?php echo JText::_('COM_USERS_PROFILE_OTEPS'); ?>
			</legend>
			<div class="alert alert-info">
				<?php echo JText::_('COM_USERS_PROFILE_OTEPS_DESC'); ?>
			</div>
			<?php if (empty($this->otpConfig->otep)) : ?>
			<div class="alert alert-warning">
				<?php echo JText::_('COM_USERS_PROFILE_OTEPS_WAIT_DESC'); ?>
			</div>
			<?php else : ?>
			<?php foreach ($this->otpConfig->otep as $otep) : ?>
			<span class="span3">
				<?php echo substr($otep, 0, 4); ?>-<?php echo substr($otep, 4, 4); ?>-<?php echo substr($otep, 8, 4); ?>-<?php echo substr($otep, 12, 4); ?>
			</span>
			<?php endforeach; ?>
			<div class="clearfix"></div>
			<?php endif; ?>
		</fieldset>
	<?php endif; ?>

		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary bt-skb validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>
				<a class="cancel" href="<?php echo JRoute::_('index.php?option=com_users&view=profile'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="profile.save" />
			</div>
		</div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>	
</div>	

