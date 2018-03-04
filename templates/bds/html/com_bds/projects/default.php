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
<br />
<div class="grid-products">
    <form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm">
    	<div class="toolSearch">
            <div class="row">
                <div class="col-md-6">
        			<!-- BRICK : search -->
        			<?php echo $this->filters['search_search']->input;?>
                </div>
    
    			<!-- BRICK : filters -->
    			<div class="col-md-3">
    				<?php echo $this->filters['filter_main_location']->input;?>
    			</div>
    
    			<div class="col-md-3">
    				<?php echo $this->filters['filter_type_id']->input;?>
    			</div>
    
    			<!--div class="col-md-3">
    				<?php //echo $this->filters['filter_handing_over']->input;?>
    			</div-->
    			<div class="clearfix"></div>
            </div>
        </div>

		<!-- BRICK : grid -->
		<?php echo $this->loadTemplate('grid'); ?>    

        <!-- BRICK : pagination -->
		<?php echo $this->pagination->getListFooter(); ?>
    	
    
    
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
</div>