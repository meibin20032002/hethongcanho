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
$main_location = $this->state->get('filter.main_location');
$main_location_name = '';
if($main_location){
    $model_location = CkJModel::getInstance('location', 'BdsModel');
    $item = $model_location->getItem($main_location);
    $main_location_name = $item->title;
}
$filter_types = $this->state->get('filter.types');
?>
<br />
<div class="grid-products">
    <form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm">
    	
        <div class="toolSearch">
            <div class="sc-types">
                <?php $types = BdsHelperEnum::_('products_types');?>
                <?php foreach($types as $item):?>
                <a class="<?php if($filter_types == $item['value']) echo 'active'?>" href="<?php echo(JRoute::_("index.php?option=com_bds&view=products&Itemid=101&filter_types=".$item['value'])); ?>">
                    <div class="tab-title"><?php echo $item['text']?></div>
                </a>
                <?php endforeach;?>
            </div>
            
            <div class="row">
    
    			<!-- BRICK : search -->
                <div class="col-md-5 bitem">
                    <?php echo $this->filters['search_search']->input;?>
                </div>    
    
    			<!-- BRICK : filters -->
    			<div id="main_location" class="col-md-3 bitem" <?php if($main_location) echo 'style="display: none;"'?>>
    				<?php echo $this->filters['filter_main_location']->input;?>
    			</div>                
                <div id="sub_location" class="col-md-3 bitem" <?php if(!$main_location) echo 'style="display: none;"'?>>
    				<?php echo $this->filters['filter_sub_location']->input;?>
    			</div>    
    			<div class="col-md-4 bitem">
    				<?php echo $this->filters['filter_category_id']->input;?>
    			</div>
                
                <div class="col-md-3 bitem">
    				<?php echo $this->filters['filter_price']->input;?>
    			</div>
                <div class="col-md-3 bitem">
    				<?php echo $this->filters['filter_acreage']->input;?>
    			</div>
                <div class="col-md-3 bitem">
    				<?php echo $this->filters['filter_direction']->input;?>
    			</div>
                <!--div class="col-md-3 bitem">
    				<?php echo $this->filters['filter_bedrooms']->input;?>
    			</div>
                <div class="col-md-3 bitem">
    				<?php echo $this->filters['filter_legal_documents']->input;?>
    			</div-->
    			<div class="clearfix"></div>

            </div>
        </div>  
        
        <div class="menuTab">
            <div class="row">
                <div class="menu col-md-8">
                    <a class="<?php if(!$filter_who) echo 'active'?>" href="<?php echo(JRoute::_("index.php?option=com_bds&view=products&Itemid=101&filter_who=0")); ?>">
                        <div class="nav-title"><span>Tất cả</span></div>
                    </a>
                    <?php $who = BdsHelperEnum::_('products_who');?>
                    <?php foreach($who as $item):?>
                    <a class="<?php if($filter_who == $item['value']) echo 'active'?>" href="<?php echo(JRoute::_("index.php?option=com_bds&view=products&Itemid=101&filter_who=".$item['value'])); ?>">
                        <div class="nav-title"><span><?php echo $item['text']?></span></div>
                    </a>
                    <?php endforeach;?>
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
        <input type="hidden" name="filter_who" value="<?php echo $filter_who?>" />
        <input type="hidden" id="order_Dir" name="filter_order_Dir" value="<?php echo $this->state->get('list.direction')?>" />
    </form>
</div>
<script type="text/javascript">
jQuery( document ).ready(function($) { 
    var location_name = '<?php echo $main_location_name?>';
    $("#sortTable").change(function() {
		var order = $('#sortTable option:selected').val();    
        if(order == 'price') $('#order_Dir').val('asc');
        else $('#order_Dir').val('desc');                
	})	
    
    if(location_name){   
        $("#filter_sub_location_chzn .chzn-single").html('<span>Quận Huyện<span><div><b></b></div>');
        $("#filter_sub_location_chzn .chzn-results").before('<div class="backAll"><i class="fa fa-arrow-left"></i> '+location_name+'</div>');
    }
    
    $('.backAll').on('click', function(){
        $('#sub_location').hide();
        $('#main_location').show();
    });
    $("#filter_main_location_chzn .result-selected").live('click', function(){
        var selectName = $(this).text();
        if(selectName == location_name){
            $('#sub_location').show();
            $('#main_location').hide();
        }
    });
})
</script>		   