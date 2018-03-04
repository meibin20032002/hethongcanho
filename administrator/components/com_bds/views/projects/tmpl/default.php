<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V3.1.9   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		
* @package		BDS
* @subpackage	Projects
* @copyright	
* @author		 -  - 
* @license		
*
*             .oooO  Oooo.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


BdsHelper::headerDeclarations();
//Load the formvalidator scripts requirements.
JDom::_('html.toolbar');
?>

<form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm">
	<div class="row-fluid bds">
		<div id="sidebar" class="span2">
			<div class="sidebar-nav">

			<!-- BRICK : menu -->
			<?php echo JDom::_('html.menu.submenu', array(
				'list' => $this->menu
			)); ?>
			<div class = "nav-filters">
				<!-- BRICK : filters -->
				<?php echo $this->filters['filter_main_location']->input;?>
				<hr class="hr-condensed">
				<?php echo $this->filters['filter_type_id']->input;?>
				<hr class="hr-condensed">
				<?php echo $this->filters['filter_utility_id']->input;?>
				<hr class="hr-condensed">
				<?php echo $this->filters['filter_handing_over']->input;?>
			</div>

			</div>
		</div>
		<div id="contents" class="span10">
			<!-- BRICK : search -->
			<?php echo $this->filters['search_search']->input;?>
			<!-- BRICK : display -->
			<div class="pull-right">
				<?php echo $this->filters['sortTable']->input;?>
			</div>


			<div class="pull-right">
				<?php echo $this->filters['directionTable']->input;?>
			</div>


			<div class="pull-right">
				<?php echo $this->filters['limit']->input;?>
			</div>

			<div class="clearfix"></div>

			<!-- BRICK : grid -->
			<?php echo $this->loadTemplate('grid'); ?>

			<!-- BRICK : pagination -->
			<?php echo $this->pagination->getListFooter(); ?>
		</div>
	</div>


	<?php 
		$jinput = JFactory::getApplication()->input;
		echo JDom::_('html.form.footer', array(
		'values' => array(
					'view' => $jinput->get('view', 'projects'),
					'layout' => $jinput->get('layout', 'default'),
					'boxchecked' => '0',
					'filter_order' => $this->escape($this->state->get('list.ordering')),
					'filter_order_Dir' => $this->escape($this->state->get('list.direction'))
				)));
	?>
</form>