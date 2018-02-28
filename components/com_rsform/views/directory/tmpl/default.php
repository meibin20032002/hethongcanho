<?php
/**
* @package RSForm! Pro
* @copyright (C) 2007-2014 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');
$listOrder	= $this->escape($this->filter_order);
$listDirn	= $this->escape($this->filter_order_Dir); 
JHtml::_('behavior.tooltip'); ?>

<?php if (!RSFormProHelper::isJ('3.0')) { ?>
<style type="text/css">
table.category th { text-align:center !important; }
</style>
<?php } ?>

<?php if ($this->params->get('show_page_heading', 1)) { ?>
<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php } ?>

<form action="<?php echo $this->escape(JURI::getInstance()); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
	<?php if ($this->hasSearchFields || $this->directory->enablecsv) { ?>
	<div class="well well-small">
		<?php if ($this->hasSearchFields) { ?>
		<?php echo JText::_('RSFP_SEARCH'); ?> <input type="text" id="rsfilter" name="filter_search" value="<?php echo $this->escape($this->filter_search); ?>" onchange="directorySubmit();" /> 
		<button type="button" class="btn btn-primary button" onclick="directorySubmit();"><?php echo JText::_('RSFP_GO'); ?></button> 
		<button type="button" class="btn button" onclick="directoryReset();"><?php echo JText::_('RSFP_RESET'); ?></button>
		<?php } ?>
		<?php if ($this->directory->enablecsv) { ?>
		<button onclick="directoryDownloadCSV();" type="button" class="btn button pull-right"><?php echo JText::_('RSFP_SUBM_DIR_DOWNLOAD_CSV'); ?></button>
		<div class="clearfix"></div>
		<?php } ?>
	</div>
	<?php } ?>
	
	<div class="clearfix"></div>
	
	<?php 
		$directoryLayout = $this->loadTemplate('layout');
		eval($this->directory->ListScript);
		echo $directoryLayout;
	?>
	
	<div style="text-align: center;">
		<div class="pagination"><?php echo $this->pagination->getPagesLinks(); ?></div>
		<?php echo $this->pagination->getPagesCounter(); ?>
	</div>

	<input type="hidden" name="option" value="com_rsform" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="directory" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
</form>

<script type="text/javascript">
function directorySubmit(task) {
	var form = document.adminForm;
	
	if (typeof task != 'undefined') {
		form.task.value = task;
	} else {
		form.task.value = '';
	}
	form.submit();
}

function directoryReset() {
	var form = document.adminForm;
	form.filter_search.value = '';
	directorySubmit();
}

Joomla.tableOrdering = function(order, dir, task, form) {
	if (typeof(form) === 'undefined') {
		form = document.getElementById('adminForm');
	}

	form.filter_order.value = order;
	form.filter_order_Dir.value = dir;
	form.task.value = task;
	Joomla.submitform(task, form);
}

<?php if ($this->directory->enablecsv) { ?>
function directoryDownloadCSV() {
	var selected = false;
	var cids = document.getElementsByName('cid[]');
	for (var i=0; i<cids.length; i++) {
		if (cids[i].checked) {
			selected = true;
			break;
		}
	}
	
	if (!selected) {
		alert('<?php echo JText::_('RSFP_SUBM_DIR_PLEASE_SELECT_AT_LEAST_ONE', true); ?>');
		return;
	}
	
	directorySubmit('download');
}
<?php } ?>
</script>