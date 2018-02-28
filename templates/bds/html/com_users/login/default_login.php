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
<div class="login-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="login<?php echo $this->pageclass_sfx; ?>">
                	<?php if ($this->params->get('show_page_heading')) : ?>
                	<div class="login-header">
                		<h1>
                			<?php echo $this->escape($this->params->get('page_heading')); ?>
                		</h1>
                	</div>
                	<?php endif; ?>
                
                	<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="form-validate">
                
                		<fieldset>
                			<?php foreach ($this->form->getFieldset('credentials') as $field) : ?>
                				<?php if (!$field->hidden) : ?>
                					<div class="control-group showicon">  						
                						<div class="controls">
                							<?php echo $field->input; ?>
                						</div>
                					</div>
                				<?php endif; ?>
                			<?php endforeach; ?>
                
                			<?php if ($this->tfa): ?>
                				<div class="control-group">
                					<div class="controls">
                						<?php echo $this->form->getField('secretkey')->input; ?>
                					</div>
                				</div>
                			<?php endif; ?>
                
                			<div class="row list-group">
                				<div class="col-md-6">
                					<button type="submit" class="btn btn-primary bt-skb">
                						<?php echo JText::_('JLOGIN'); ?>
                					</button>
                				</div>
                                <div class="col-md-6">
                                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
                            			<?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a> 
                                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
                            			<?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a>         			                                                      
                                </div>                                                
                			</div>
                
                			<?php if ($this->params->get('login_redirect_url')) : ?>
                				<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
                			<?php else : ?>
                				<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_menuitem', $this->form->getValue('return'))); ?>" />
                			<?php endif; ?>
                			<?php echo JHtml::_('form.token'); ?>
                		</fieldset>
                	</form>
                    
                    <div class="stacked">                    
                        <?php 
            				$document	= JFactory::getDocument();
            				$renderer	= $document->loadRenderer('modules');
            				$options	= array('style' => 'xhtml');
            				$position	= 'social';
            				echo $renderer->render($position, $options, null);
            			?>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>

    </div>	
</div>	
