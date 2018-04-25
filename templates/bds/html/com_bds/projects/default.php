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
$main_location = $this->state->get('filter.main_location');
$main_location_name = '';
if($main_location){
    $model_location = CkJModel::getInstance('location', 'BdsModel');
    $item = $model_location->getItem($main_location);
    $main_location_name = $item->title;
}
?>
<br />
<div class="grid-products">
    <form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm">
    	<div class="toolSearch">
            <div class="sc-types">
                <?php 
            	$document	= JFactory::getDocument();
            	$renderer	= $document->loadRenderer('modules');
            	$options	= array('style' => 'none');
            	$position	= 'menu_category';
            	echo $renderer->render($position, $options, null);
                ?>
            </div>
            
            <div class="xsfilter">
                <div class="col-md-6">
        			<!-- BRICK : search -->
        			<?php echo $this->filters['search_search']->input;?>
                </div>
    
    			<!-- BRICK : filters -->
    			<div id="main_location" class="col-md-3 bitem" <?php if($main_location) echo 'style="display: none;"'?>>
    				<?php echo $this->filters['filter_main_location']->input;?>
    			</div>             
                <div id="sub_location" class="col-md-3 bitem" <?php if(!$main_location) echo 'style="display: none;"'?>>
    				<?php echo $this->filters['filter_sub_location']->input;?>
    			</div>
    			<div class="col-md-3 bitem">
    				<?php echo $this->filters['filter_type_id']->input;?>
    			</div>
                
                <div class="col-md-3 bitem">
    				<?php echo $this->filters['filter_price']->input;?>
    			</div>
                <div class="col-md-3 bitem">
    				<?php echo $this->filters['filter_acreage']->input;?>
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
    	<div class="clearfix"></div>
    
    
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
<script type="text/javascript">
jQuery( document ).ready(function($) { 
    var location_name = '<?php echo $main_location_name?>';
    $("#sortTable").change(function() {
		var order = $('#sortTable option:selected').val();    
        if(order == 'price') $('#order_Dir').val('asc');
        else $('#order_Dir').val('desc');                
	})	
    
    if(location_name){   
        $("#filter_sub_location_chzn .chzn-single").html('<span>'+location_name+'<span><div><b></b></div>');
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