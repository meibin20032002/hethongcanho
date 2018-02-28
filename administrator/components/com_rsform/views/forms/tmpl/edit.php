<?php
/**
 * @package RSForm! Pro
 * @copyright (C) 2007-2014 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');
?>

	<form action="index.php?option=com_rsform&amp;task=forms.edit&amp;formId=<?php echo $this->form->FormId; ?>" method="post" name="adminForm" id="adminForm">

		<span><?php echo $this->lists['Languages']; ?></span>
		<span><?php echo JText::sprintf('RSFP_YOU_ARE_EDITING_IN', $this->lang, RSFormProHelper::translateIcon()); ?></span>

		<div id="rsform_container">
			<div id="state" style="display: none;"><img src="components/com_rsform/assets/images/load.gif" alt="<?php echo JText::_('RSFP_PROCESSING'); ?>" /><?php echo JText::_('RSFP_PROCESSING'); ?></div>

			<ul id="rsform_maintabs">
				<li><a href="javascript: void(0);" id="components" class="btn"><span class="rsficon rsficon-grid"></span><span class="inner-text"><?php echo JText::_('RSFP_COMPONENTS_TAB_TITLE'); ?></span></a></li>
				<li><a href="javascript: void(0);" id="properties" class="btn"><span class="rsficon rsficon-cogs"></span><span class="inner-text"><?php echo JText::_('RSFP_PROPERTIES_TAB_TITLE'); ?></span></a></li>
			</ul>
			<div id="rsform_tab1">
				<div id="rsform_fixed">
					<div id="rsform_textboxdiv" class="rsform_hide">
						<ul class="rsform_secondarytabs">
							<li><a href="javascript: void(0);" id="rsfptab0" class="active"><?php echo JText::_('RSFP_COMPONENTS_GENERAL_TAB'); ?></a></li>
							<li><a href="javascript: void(0);" id="rsfptab1"><?php echo JText::_('RSFP_COMPONENTS_VALIDATIONS_TAB'); ?></a></li>
							<li><a href="javascript: void(0);" id="rsfptab2"><?php echo JText::_('RSFP_COMPONENTS_ATRIBUTES_TAB'); ?></a></li>
						</ul>

						<div id="rsform_secondarytabcontent">
							<div id="rsfptabcontent0"></div>
							<div id="rsfptabcontent1"></div>
							<div id="rsfptabcontent2"></div>
						</div>
						<a href="javascript: void(0);" class="rsform_close btn btn-mini"><span class="icon-delete"></span></a>
					</div>
				</div>

				<?php echo $this->loadTemplate('components'); ?>
			</div>

			<div id="rsform_tab2">
				<ul class="rsform_leftnav" id="rsform_secondleftnav">
					<li class="rsform_navtitle"><?php echo JText::_('RSFP_DESIGN_TAB'); ?></li>
					<li><a href="javascript: void(0);" id="formlayout"><span class="rsficon rsficon-list-alt"></span><span class="inner-text"><?php echo JText::_('RSFP_FORM_LAYOUT'); ?></span></a></li>
					<li><a href="javascript: void(0);" id="formtheme"><span class="rsficon rsficon-image"></span><span class="inner-text"><?php echo JText::_('RSFP_FORM_THEME'); ?></span></a></li>
					<li><a href="javascript: void(0);" id="cssandjavascript"><span class="rsficon rsficon-file-code-o"></span><span class="inner-text"><?php echo JText::_('RSFP_CSS_JS'); ?></span></a></li>
					<?php $this->triggerEvent('rsfp_bk_onAfterShowFormDesignTabsTab'); ?>
					<li class="rsform_navtitle"><?php echo JText::_('RSFP_FORM_TAB'); ?></li>
					<li><a href="javascript: void(0);" id="editform"><span class="rsficon rsficon-info-circle"></span><span class="inner-text"><?php echo JText::_('RSFP_FORM_EDIT'); ?></span></a></li>
					<li><a href="javascript: void(0);" id="editformattributes"><span class="rsficon rsficon-grain"></span><span class="inner-text"><?php echo JText::_('RSFP_FORM_EDIT_ATTRIBUTES'); ?></span></a></li>
					<li><a href="javascript: void(0);" id="metatags"><span class="rsficon rsficon-earth"></span><span class="inner-text"><?php echo JText::_('RSFP_FORM_META_TAGS'); ?></span></a></li>
					<?php $this->triggerEvent('rsfp_bk_onAfterShowFormFormTabsTab'); ?>
					<li class="rsform_navtitle"><?php echo JText::_('RSFP_EMAILS_TAB'); ?></li>
					<li><a href="javascript: void(0);" id="useremails"><span class="rsficon rsficon-envelope-o"></span><span class="inner-text"><?php echo JText::_('RSFP_USER_EMAILS'); ?></span></a></li>
					<li><a href="javascript: void(0);" id="adminemails"><span class="rsficon rsficon-envelope"></span><span class="inner-text"><?php echo JText::_('RSFP_ADMIN_EMAILS'); ?></span></a></li>
					<li><a href="javascript: void(0);" id="emails"><span class="rsficon rsficon-envelope-square"></span><span class="inner-text"><?php echo JText::_('RSFP_FORM_EMAILS'); ?></span></a></li>
					<?php $this->triggerEvent('rsfp_bk_onAfterShowFormEmailsTabsTab'); ?>
					<li class="rsform_navtitle"><?php echo JText::_('RSFP_SCRIPTS_TAB'); ?></li>
					<li><a href="javascript: void(0);" id="scripts"><span class="rsficon rsficon-code"></span><span class="inner-text"><?php echo JText::_('RSFP_FORM_SCRIPTS'); ?></span></a></li>
					<li><a href="javascript: void(0);" id="emailscripts"><span class="rsficon rsficon-file-code-o"></span><span class="inner-text"><?php echo JText::_('RSFP_EMAIL_SCRIPTS'); ?></span></a></li>
					<?php $this->triggerEvent('rsfp_bk_onAfterShowFormScriptsTabsTab'); ?>
					<li class="rsform_navtitle"><?php echo JText::_('RSFP_EXTRAS_TAB'); ?></li>
					<li><a href="javascript: void(0);" id="mappings"><span class="rsficon rsficon-database"></span><span class="inner-text"><?php echo JText::_('RSFP_FORM_MAPPINGS'); ?></span></a></li>
					<li><a href="javascript: void(0);" id="conditions"><span class="rsficon rsficon-rotate"></span><span class="inner-text"><?php echo JText::_('RSFP_CONDITIONAL_FIELDS'); ?></span></a></li>
					<li><a href="javascript: void(0);" id="postscript"><span class="rsficon rsficon-envelope"></span><span class="inner-text"><?php echo JText::_('RSFP_POST_TO_LOCATION'); ?></span></a></li>
					<li><a href="javascript: void(0);" id="calculations"><span class="rsficon rsficon-calculator"></span><span class="inner-text"><?php echo JText::_('RSFP_CALCULATIONS'); ?></span></a></li>
					<?php $this->triggerEvent('rsfp_bk_onAfterShowFormEditTabsTab'); ?>
				</ul>

				<div id="propertiescontent">
					<div id="formlayoutdiv">
						<?php echo $this->loadTemplate('layout'); ?>
					</div><!-- formlayout -->
					<div id="formthemediv">
						<?php echo $this->loadTemplate('theme'); ?>
					</div><!-- formthemediv -->
					<div id="cssandjavascriptdiv">
						<?php echo $this->loadTemplate('cssjs'); ?>
					</div><!-- cssandjavascript -->
					<?php $this->triggerEvent('rsfp_bk_onAfterShowFormDesignTabs'); ?>
					<div id="editformdiv">
						<?php echo $this->loadTemplate('form'); ?>
					</div><!-- editform -->
					<div id="editformattributesdiv">
						<?php echo $this->loadTemplate('formattr'); ?>
					</div><!-- editformattributes -->
					<div id="metatagsdiv">
						<?php echo $this->loadTemplate('meta'); ?>
					</div><!-- metatags -->
					<?php $this->triggerEvent('rsfp_bk_onAfterShowFormFormTabs'); ?>
					<div id="useremailsdiv">
						<?php echo $this->loadTemplate('user'); ?>
					</div><!-- useremails -->
					<div id="adminemailsdiv">
						<?php echo $this->loadTemplate('admin'); ?>
					</div><!-- adminemails -->
					<div id="emailsdiv">
						<?php echo $this->loadTemplate('emails'); ?>
					</div><!-- emails -->
					<?php $this->triggerEvent('rsfp_bk_onAfterShowFormEmailsTabs'); ?>
					<div id="scriptsdiv">
						<?php echo $this->loadTemplate('scripts'); ?>
					</div><!-- scripts -->
					<div id="emailscriptsdiv">
						<?php echo $this->loadTemplate('emailscripts'); ?>
					</div><!-- emailscripts -->
					<?php $this->triggerEvent('rsfp_bk_onAfterShowFormScriptsTabs'); ?>
					<div id="mappingsdiv">
						<?php echo $this->loadTemplate('mappings'); ?>
					</div><!-- mappings -->
					<div id="conditionsdiv">
						<?php echo $this->loadTemplate('conditions'); ?>
					</div>
					<div id="postscriptdiv">
						<?php echo $this->loadTemplate('post'); ?>
					</div><!-- postscriptdiv -->
					<div id="calculationsdiv">
						<?php echo $this->loadTemplate('calculations'); ?>
					</div><!-- calculationsdiv -->
					<?php $this->triggerEvent('rsfp_bk_onAfterShowFormEditTabs'); ?>
				</div>
			</div>
			<div class="rsform_clear_both"></div>
		</div>

		<input type="hidden" name="tabposition" id="tabposition" value="0" />
		<input type="hidden" name="tab" id="ptab" value="0" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="formId" id="formId" value="<?php echo $this->form->FormId; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="option" value="com_rsform" />
		<input type="hidden" name="Lang" value="<?php echo $this->form->Lang; ?>" />
		<?php if (JFactory::getApplication()->input->getCmd('tmpl') == 'component') { ?>
			<input type="hidden" name="tmpl" value="component" />
		<?php } ?>
	</form>

	<script type="text/javascript">
		RSFormPro.$(document).ready(function(){
			RSFormPro.$('#rsform_tab2').formTabs(<?php echo $this->tab; ?>);
			RSFormPro.$('#rsform_textboxdiv').formTabs(0);
			<?php if (!$this->tabposition) { ?>
			RSFormPro.$("#rsform_tab1").show();
			RSFormPro.$("#rsform_tab2").hide();
			RSFormPro.$("#properties").removeClass('btn-primary');
			RSFormPro.$("#components").addClass('btn-primary');
			<?php } else { ?>
			RSFormPro.$("#rsform_tab2").show();
			RSFormPro.$("#rsform_tab1").hide();
			RSFormPro.$("#properties").addClass('btn-primary');
			RSFormPro.$("#components").removeClass('btn-primary');
			<?php } ?>
		});

		RSFormPro.$.formTabs = {
			tabTitles: {},
			tabContents: {},

			build: function (startindex) {
				this.each(function (index, el) {
					var tid = RSFormPro.$(el).attr('id');
					RSFormPro.$.formTabs.grabElements(el,tid);
					RSFormPro.$.formTabs.makeTitlesClickable(tid);
					RSFormPro.$.formTabs.setAllContentsInactive(tid);
					RSFormPro.$.formTabs.setTitleActive(startindex,tid);
					RSFormPro.$.formTabs.setContentActive(startindex,tid);
				});
			},

			grabElements: function(el,tid) {
				var children = RSFormPro.$(el).children();
				children.each(function(index, child) {
					if (index == 0)
						RSFormPro.$.formTabs.tabTitles[tid] = RSFormPro.$(child).find('a');
					else if (index == 1)
						RSFormPro.$.formTabs.tabContents[tid] = RSFormPro.$(child).children();
				});
			},

			setAllTitlesInactive: function (tid) {
				this.tabTitles[tid].each(function(index, title) {
					RSFormPro.$(title).removeClass('active');
				});
			},

			setTitleActive: function (index,tid) {
				index = parseInt(index);
				if (tid == 'rsform_tab2') document.getElementById('ptab').value = index;
				RSFormPro.$(this.tabTitles[tid][index]).addClass('active');
			},

			setAllContentsInactive: function (tid) {
				this.tabContents[tid].each(function(index, content) {
					RSFormPro.$(content).hide();
				});
			},

			setContentActive: function (index,tid) {
				index = parseInt(index);
				RSFormPro.$(this.tabContents[tid][index]).show();
			},

			makeTitlesClickable: function (tid) {
				this.tabTitles[tid].each(function(index, title) {
					RSFormPro.$(title).click(function () {
						RSFormPro.$.formTabs.setAllTitlesInactive(tid);
						RSFormPro.$.formTabs.setTitleActive(index,tid);

						RSFormPro.$.formTabs.setAllContentsInactive(tid);
						RSFormPro.$.formTabs.setContentActive(index,tid);
					});
				});
			}
		}

		RSFormPro.$.fn.extend({
			formTabs: RSFormPro.$.formTabs.build
		});

		Joomla.submitbutton = function(pressbutton)
		{
			var form = document.adminForm;

			if (pressbutton == 'forms.cancel')
			{
				Joomla.submitform(pressbutton);
				return;
			}
			else if (pressbutton == 'forms.preview')
			{
				window.open('<?php echo JURI::root(); ?>index.php?option=com_rsform&view=rsform&formId=<?php echo $this->form->FormId; ?>');
				return;
			}
			else if (pressbutton == 'components.copy' || pressbutton == 'components.duplicate')
			{
				if (form.boxchecked.value == 0)
				{
					alert('<?php echo addslashes(JText::sprintf('RSFP_PLEASE_MAKE_SELECTION_TO', JText::_('RSFP_COPY'))); ?>');
					return;
				}
				Joomla.submitform(pressbutton);
			}
			else if (pressbutton == 'components.remove' || pressbutton == 'components.publish' || pressbutton == 'components.unpublish' || pressbutton == 'components.save')
			{
				Joomla.submitform(pressbutton);
			}
			else
			{
				if (pressbutton == 'forms.apply' || pressbutton == 'forms.save') {
					if (!validateEmailFields()) {
						return false;
					}
				}
				
				// do field validation
				if (document.getElementById('FormName').value == '') {
					alert('<?php echo JText::_('RSFP_SPECIFY_FORM_NAME', true);?>');
				} else {
					if (RSFormPro.$('#properties').hasClass('btn-primary')) {
						document.getElementById('tabposition').value = 1;
					}
					Joomla.submitform(pressbutton);
				}
			}
		};
		
		function validateEmailFields() {
			var fields = [
				'UserEmailFrom', 'UserEmailTo', 'UserEmailReplyTo', 'UserEmailCC', 'UserEmailBCC',
				'AdminEmailFrom', 'AdminEmailTo', 'AdminEmailReplyTo', 'AdminEmailCC', 'AdminEmailBCC'
			];
			
			var result = true;
			var fieldName, field, fieldValue, values, value, match;
			var pattern = /{.*?}/g;
			
			for (var i = 0; i < fields.length; i++) {
				// Grab field name from array
				fieldName 	= fields[i];
				field 		= document.getElementById(fieldName);
				// Grab value
				fieldValue 	= field.value;
				
				RSFormPro.$(field).removeClass('rs_error_field');
				
				// Something's been typed in
				if (fieldValue.length > 0) {
					// Check for multiple values
					values = fieldValue.split(',');
					
					for (var v = 0; v < values.length; v++) {
						value = values[v].replace(/^\s+|\s+$/gm,'');
						
						// Has placeholder
						hasPlaceholder = value.indexOf('{') > -1 && value.indexOf('}') > -1;
						
						// Defaults to false, the code below will actually check the placeholder
						wrongPlaceholder = false;
						
						// Let's take into account multiple placeholders
						if (hasPlaceholder) {
							do {
								match = pattern.exec(value);
								if (match && typeof match[0] != 'undefined') {
									// Wrong placeholder
									if (RSFormPro.Placeholders.indexOf(match[0]) == -1) {
										wrongPlaceholder = true;
									}
								}
							} while (match);
						}
						
						// Not an email
						notAnEmail = !hasPlaceholder && value.indexOf('@') == -1;
						
						if (wrongPlaceholder || notAnEmail) {
							// Switch to the correct tab only on the first error
							if (result == true) {
								if (fieldName.indexOf('User') > -1) {
									RSFormPro.$('#useremails').click();
								} else {
									RSFormPro.$('#adminemails').click();
								}
							}
							RSFormPro.$(field).addClass('rs_error_field');
							result = false;
						}
					}
				}
			}
			
			return result;
		}

		function listItemTask(cb, task)
		{
			if (task == 'orderdown' || task == 'orderup')
			{
				var table = RSFormPro.$('#componentPreview');
				currentRow = RSFormPro.$(document.getElementById(cb)).parent().parent();
				if (task == 'orderdown')
				{
					try { currentRow.insertAfter(currentRow.next()); }
					catch (dnd_e) { }
				}
				if (task == 'orderup')
				{
					try { currentRow.insertBefore(currentRow.prev()); }
					catch (dnd_e) { }
				}

				tidyOrder(true);
				return;
			}

			stateLoading();

			xml=buildXmlHttp();
			var url = 'index.php?option=com_rsform&task=' + task + '&format=raw&randomTime=' + Math.random();

			xml.open("POST", url, true);

			params = new Array();
			params.push('i=' + cb);
			params.push('componentId=' + document.getElementById(cb).value);
			params.push('formId=<?php echo $this->form->FormId; ?>');
			params = params.join('&');

			//Send the proper header information along with the request
			xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xml.setRequestHeader("Content-length", params.length);
			xml.setRequestHeader("Connection", "close");

			switch (task) {
				case 'components.unpublish':
				case 'components.publish':
					var theId = 'publish' + cb;
					break;

				case 'components.unsetrequired':
				case 'components.setrequired':
					var theId = 'required' + cb;
					break;
			}

			xml.send(params);
			xml.onreadystatechange=function()
			{
				if(xml.readyState==4)
				{
					var cell = document.getElementById(theId);
					RSFormPro.$(cell).html(xml.responseText);

					stateDone();

					if (document.getElementById('FormLayoutAutogenerate1').checked==true)
						generateLayout(<?php echo $this->form->FormId; ?>, false);
				}
			}
		}

		function orderMapping(mp, task)
		{
			if (task == 'orderdown' || task == 'orderup')
			{
				var table = RSFormPro.$('#mappingTable');
				currentRow = RSFormPro.$(document.getElementById(mp)).parent().parent();
				if (task == 'orderdown')
				{
					try { currentRow.insertAfter(currentRow.next()); }
					catch (dnd_e) { }
				}
				if (task == 'orderup')
				{
					try { currentRow.insertBefore(currentRow.prev()); }
					catch (dnd_e) { }
				}

				tidyOrderMp(true);
				return;
			}
		}

		function saveorder(num, task)
		{
			tidyOrder(true);
		}

		function returnQuickFields()
		{
			var quickfields = new Array();

			<?php foreach ($this->quickfields as $quickfield) { ?>
			quickfields.push('<?php echo $quickfield['name']; ?>');
			<?php } ?>

			return quickfields;
		}

		function enableAttachFile(value)
		{
			if (value == 1)
			{
				document.getElementById('rsform_select_file').style.display = '';
				document.getElementById('UserEmailAttachFile').disabled = false;
			}
			else
			{
				document.getElementById('rsform_select_file').style.display = 'none';
				document.getElementById('UserEmailAttachFile').disabled = true;
			}
		}

		function enableEmailMode(type, value)
		{
			var opener = type == 'User' ? 'UserEmailText' : 'AdminEmailText';
			var id = type == 'User' ? 'rsform_edit_user_email' : 'rsform_edit_admin_email';
			// HTML
			if (value == 1)
			{
				document.getElementById(id).setAttribute('onclick', "openRSModal('index.php?option=com_rsform&task=richtext.show&opener=" + opener + "&formId=<?php echo $this->form->FormId; ?>&tmpl=component')");
			}
			// Text
			else
			{
				document.getElementById(id).setAttribute('onclick', "openRSModal('index.php?option=com_rsform&task=richtext.show&opener=" + opener + "&formId=<?php echo $this->form->FormId; ?>&tmpl=component&noEditor=1')");
			}
		}

		function enableThankyou(value)
		{
			if (value == 1)
			{
				document.getElementById('ShowContinue0').disabled = false;
				document.getElementById('ShowContinue1').disabled = false;

				document.getElementById('showContinueContainer').style.display = 'table-row';
				document.getElementById('systemMessageContainer').style.display = 'none';

				if (document.getElementById('ScrollToThankYou0').checked) {
					document.getElementById('ThankYouMessagePopUp0').disabled = false;
					document.getElementById('ThankYouMessagePopUp1').disabled = false;
					document.getElementById('thankyouMessagePopupContainer').style.display = 'table-row';
				}
			}
			else
			{
				document.getElementById('ShowContinue0').disabled = true;
				document.getElementById('ShowContinue1').disabled = true;
				document.getElementById('ThankYouMessagePopUp0').disabled = true;
				document.getElementById('ThankYouMessagePopUp1').disabled = true;

				document.getElementById('showContinueContainer').style.display = 'none';
				document.getElementById('systemMessageContainer').style.display = 'table-row';
				
				document.getElementById('thankyouMessagePopupContainer').style.display = 'none';
			}
		}
		
		function enableThankyouPopup(value)
		{
			if (value == 0)
			{
				if (document.getElementById('ShowThankyou1').checked) {
					document.getElementById('ThankYouMessagePopUp0').disabled = false;
					document.getElementById('ThankYouMessagePopUp1').disabled = false;
					document.getElementById('thankyouMessagePopupContainer').style.display = 'table-row';
				}
			}
			else
			{
				if (document.getElementById('ShowThankyou1').checked) {
					document.getElementById('ThankYouMessagePopUp0').disabled = true;
					document.getElementById('ThankYouMessagePopUp1').disabled = true;

					document.getElementById('thankyouMessagePopupContainer').style.display = 'none';
				}
			}
		}

		function RStranslateText(thetext)
		{
			if (thetext == 'extra')
				return '<?php echo JText::_('RSFP_COMP_FIELD_VALIDATIONEXTRA', true); ?>';
			else if (thetext == 'regex')
				return '<?php echo JText::_('RSFP_COMP_FIELD_VALIDATIONEXTRAREGEX', true); ?>';
			else if (thetext == 'sameas')
				return '<?php echo JText::_('RSFP_COMP_FIELD_VALIDATIONEXTRASAMEAS', true); ?>';
		}

		toggleQuickAdd();
		<?php
		if (in_array($this->form->FormLayoutName, $this->layouts['html5Layouts']) || $this->form->FormLayoutName == 'responsive') { ?>
		jQuery('#formtheme').hide();
		<?php } ?>
	</script>

<?php
//keep session alive while editing
JHTML::_('behavior.keepalive');
?>