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

	<form action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
		<?php // Iterate through the form fieldsets and display each one. ?>
		<?php foreach ($this->form->getFieldsets() as $fieldset): ?>
			<?php $fields = $this->form->getFieldset($fieldset->name);?>
			<?php if (count($fields)):?>
				<div class="row">
				<?php // Iterate through the fields in the set and display them. ?>
				<?php foreach ($fields as $field) : ?>
					<?php // If the field is hidden, just display the input. ?>
					<?php if ($field->hidden): ?>
						<?php echo $field->input;?>
					<?php else:?>
                        <?php if ($field->type != 'Spacer') : ?>
                        <div class="col-md-6">                    
    						<div class="control-group">
                                <div class="control-label">
									<?php echo $field->label; ?>
								</div>
                                
    							<div class="controls">
    								<?php echo $field->input;?>
    							</div>
    						</div>
                        </div> 
                        <?php endif;?>                           
					<?php endif;?>
				<?php endforeach;?>
				</div>
			<?php endif;?>
		<?php endforeach;?>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary bt-skb validate"><?php echo JText::_('JREGISTER');?></button>
				<a class="cancel" href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>"><?php echo JText::_('JCANCEL');?></a>
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="registration.register" />
			</div>
		</div>
		<?php echo JHtml::_('form.token');?>
        <br />
	</form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>	
</div>	
