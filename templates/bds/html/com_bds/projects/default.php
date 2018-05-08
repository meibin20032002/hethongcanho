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

	$document	= JFactory::getDocument();
	$renderer	= $document->loadRenderer('modules');
	$options	= array('style' => 'xhtml');
	$position	= 'products';
	echo $renderer->render($position, $options, null);
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
                <div class="col-md-5">
        			<!-- BRICK : search -->
        			<?php echo $this->filters['search_search']->input;?>
                </div>
    
    			<!-- BRICK : filters -->
    			<div id="main_location" class="col-md-4 bitem" <?php if($main_location) echo 'style="display: none;"'?>>
    				<?php echo $this->filters['filter_main_location']->input;?>
    			</div>             
                <div id="sub_location" class="col-md-4 bitem" <?php if(!$main_location) echo 'style="display: none;"'?>>
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
        $("#filter_sub_location_chzn .chzn-results").before('<div class="backAll"><i class="fa fa-arrow-left"></i> Back All</div>');
    }
    
    $('.backAll').on('click', function(){
        jQuery('.overlayUpload').show();
        jQuery.ajax({
            url : 'index.php?option=com_bds&task=locations.mainLocations&<?php echo JSession::getFormToken()?>=1',
            type: "POST",
            dataType: 'json',
            success: function(data){
                var sub = '<option value="" selected="selected">Chọn Toàn quốc</option>';
                $.each(data, function(key, val){
		    		sub+= '<option value="'+ val.id +'">'+ val.title +'</option>';
		    	});
                $('#filter_main_location').html(sub);
                
                var sub = '<li class="active-result" data-option-array-index="0">Chọn Toàn quốc</li>';
                var i = 1;
                $.each(data, function(key, val){
		    		sub+= '<li class="active-result" data-option-array-index="'+ i +'">'+ val.title +'</li>';
                    i++;
		    	});
                $('#filter_main_location_chzn .chzn-results').html(sub);
                
                $('#filter_main_location_chzn').addClass('chzn-container-active chzn-with-drop');                
                $('#sub_location').hide();
                $('#main_location').show();
                jQuery('.overlayUpload').hide();
            }
        });
    });

    
    $('#filter_main_location').on('change', function() {
        jQuery('.overlayUpload').show();
        var id = jQuery(this).val();
        jQuery.ajax({
            url : 'index.php?option=com_bds&task=locations.subLocations&<?php echo JSession::getFormToken()?>=1',
            data : {id : id},
            type: "POST",
            dataType: 'json',
            success: function(data){
                $(".backAll").remove();
                $("#filter_sub_location_chzn .chzn-results").before('<div class="backAll"><i class="fa fa-arrow-left"></i> Back All</div>');
                
                var sub = '<option value="" selected="selected">Chọn Quận/Huyện</option>';
                $.each(data, function(key, val){
		    		sub+= '<option value="'+ val.id +'">'+ val.title +'</option>';
		    	});
                $('#filter_sub_location').html(sub);
                $('#filter_sub_location').trigger("chosen:updated");                
                
                var sub = '<li class="active-result" data-option-array-index="0">Chọn Quận/Huyện</li>';
                var i = 1;
                $.each(data, function(key, val){
		    		sub+= '<li class="active-result" data-option-array-index="'+ i +'">'+ val.title +'</li>';
                    i++;
		    	});
                $('#filter_sub_location_chzn .chzn-results').html(sub);
                
                $('#filter_sub_location_chzn').addClass('chzn-container-active chzn-with-drop');                
                $('#sub_location').show();
                $('#main_location').hide();
                jQuery('.overlayUpload').hide();
            }
        });
    });
})
</script>	