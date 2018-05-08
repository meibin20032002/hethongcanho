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
// Get input cookie object
$inputCookie  = JFactory::getApplication()->input->cookie;

// Get cookie data
$value        = $inputCookie->get($name = 'myCookie', $defaultValue = null);

// Check that cookie exists
$cookieExists = ($value !== null);

// Set cookie data
$inputCookie->set($name = 'myCookie', $value = '123', $expire = 0);

// Remove cookie
$inputCookie->set('myCookie', null, time() - 1);
?>
<?php 
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
    
    			<!-- BRICK : search -->
                <div class="col-md-5 bitem">
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
    				<?php echo $this->filters['filter_category_id']->input;?>
    			</div>
                
                <div class="col-md-3 col-xs-6 bitem">
    				<?php echo $this->filters['filter_price']->input;?>
    			</div>
                <div class="col-md-3 col-xs-6 bitem">
    				<?php echo $this->filters['filter_acreage']->input;?>
    			</div>
                <div class="col-md-3 col-xs-6 bitem">
    				<?php echo $this->filters['filter_direction']->input;?>
    			</div>
                <div class="col-md-3 col-xs-6 bitem">
    				<?php echo $this->filters['filter_alley']->input;?>
    			</div>
                <!--div class="col-md-3 bitem">
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
                            <a onclick="display('list');" class="list active glyphicon glyphicon-th-list" title="Dạng danh sách"></a>
                            <a onclick="display('grid');" href="#" class="grid glyphicon glyphicon-th-large" title="Dạng lưới"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- BRICK : grid -->
		<?php echo $this->loadTemplate('list'); ?>
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
        <div class="clearfix"></div>
    </form>
</div>
<script type="text/javascript">
function display(view) {
	if (view == 'list') {
	   jQuery('.boxList').show();
       jQuery('.boxGrid').hide();
       
       jQuery('.view-layout .list').addClass('active');
       jQuery('.view-layout .grid').removeClass('active');
       jQuery.cookie('display', 'list');
    }else{
       jQuery('.boxGrid').show();
       jQuery('.boxList').hide();
       jQuery('.view-layout .list').removeClass('active');
       jQuery('.view-layout .grid').addClass('active');
	   jQuery.cookie('display', 'grid');
	}
}
jQuery( document ).ready(function($) { 
    view = $.cookie('display');
    if (view) {
    	display(view);
    } else {
    	display('list');
    }    

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