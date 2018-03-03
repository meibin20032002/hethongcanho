<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V3.1.9   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		
* @package		BDS
* @subpackage	Products
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
$filter_who = $this->state->get('filter.who');
?>
<br />
<div class="grid-products">
    <form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm">
    	
        <div class="toolSearch">
            <div class="row">
    
    			<!-- BRICK : search -->
                <div class="col-md-6 bitem">
                    <?php echo $this->filters['search_search']->input;?>
                </div>    
    
    			<!-- BRICK : filters -->
    			<div class="col-md-2 bitem">
    				<?php echo $this->filters['filter_location_id']->input;?>
    			</div>
    
    			<div class="col-md-4 bitem">
    				<?php echo $this->filters['filter_category_id']->input;?>
    			</div>
                
    			<div class="col-md-2 bitem">
    				<?php echo $this->filters['filter_types']->input;?>
    			</div>
                
                <div class="col-md-2 bitem">
    				<?php echo $this->filters['filter_bedrooms']->input;?>
    			</div>
                <div class="col-md-4 bitem">
    				<?php echo $this->filters['filter_direction']->input;?>
    			</div>
                <div class="col-md-4 bitem">
    				<?php echo $this->filters['filter_legal_documents']->input;?>
    			</div>
    			<div class="clearfix"></div>

            </div>
        </div>  
        
        <div class="menuTab">
            <div class="row">
                <div class="menu col-md-8">
                    <a class="<?php if(!$filter_who) echo 'active'?>" href="<?php echo(JRoute::_("index.php?option=com_bds&view=products&Itemid=101")); ?>">
                        <div class="nav-title"><span>Tất cả</span></div>
                    </a>
                    <?php $who = BdsHelperEnum::_('products_who');?>
                    <?php foreach($who as $item):?>
                    <a class="<?php if($filter_who == $item['value']) echo 'active'?>" href="<?php echo(JRoute::_("index.php?option=com_bds&view=products&Itemid=101&filter_who=".$item['value'])); ?>">
                        <div class="nav-title"><span><?php echo $item['text']?></span></div>
                    </a>
                    <?php endforeach;?>
                    <?php ?>
                </div>
                <div class="sortby col-md-4">
                    <div class="row">
                        <div class="dropdown col-xs-8">
                            <?php echo $this->filters['sortTable']->input;?>
                        </div>
                        <div class="view-layout col-xs-4">
                            <button class="list active glyphicon glyphicon-th-list" title="Dạng danh sách"></button>
                            <button class="gird glyphicon glyphicon-th-large" title="Dạng lưới"></button>
                        </div>
                    </div>
                </div>
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
    					'view' => $jinput->get('view', 'products'),
    					'layout' => $jinput->get('layout', 'default'),
    					'boxchecked' => '0',
    					'filter_order' => $this->escape($this->state->get('list.ordering')),
    					'filter_order_Dir' => $this->escape($this->state->get('list.direction'))
    				)));
    	?>
    </form>
</div>