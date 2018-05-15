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
$sub_location = $this->state->get('filter.sub_location');

$location_name = 'Toàn Quốc';
$id = '';
if($sub_location)
    $id = $sub_location;
elseif($main_location){
    $id = $main_location;
}

if($id){
    $model_main_location = CkJModel::getInstance('location', 'BdsModel');
    $item_main = $model_main_location->getItem($main_location);
    $main_location_name = $item_main->title;
    
    $model_location = CkJModel::getInstance('location', 'BdsModel');
    $item = $model_location->getItem($id);
    $location_name = $item->title;
}

$classDown = 'main';
if($id) $classDown = 'sub';
$active = '<i class="fa fa-check right" aria-hidden="true"></i>';

//
$type_id = $this->state->get('filter.type_id');

$type_name = 'Chọn Loại Dự Án';
if($type_id){
    $model_type = CkJModel::getInstance('type', 'BdsModel');
    $item = $model_type->getItem($type_id);
    $type_name = $item->title;
}

//
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
    			<div class="col-md-3 bitem">
                    <div class="dropdown location">     
                        <input class="main_id" type="hidden" name="filter_main_location" value="<?php echo $main_location?>" />
                        <input class="sub_id" type="hidden" name="filter_sub_location" value="<?php echo $sub_location?>" />
                                   
            			<div class="input-select <?php echo $classDown?>">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <span class="title"><?php echo $location_name?></span>
                            <i class="fa fa-angle-down right" aria-hidden="true"></i>
                        </div>
                        <ul class="main_list">
                            <li class="allR" data-id="">Toàn Quốc</li>
                            <?php foreach($this->filter_main_location as $row):?>
                            <li class="ma" data-id="<?php echo $row->id?>"><?php echo $row->title?> <i class="fa fa-angle-right right" aria-hidden="true"></i></li>
                            <?php endforeach;?>
                        </ul>
                        <ul class="sub_list">
                            <li class="back"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;<strong><?php echo $main_location_name?></strong></li></li>
                            <li class="all">Tất cả <?php if(!$sub_location) echo $active?></li>                            
                            <?php foreach($this->filter_sub_location as $row):?>
                            <li class="su" data-id="<?php echo $row->id?>"><?php echo $row->title?><?php if($sub_location == $row->id) echo $active?></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
    			</div>         
                                
    			<div class="col-md-4 bitem">
                    <div class="dropdown types">     
                        <input class="main_id" type="hidden" name="filter_type_id" value="<?php echo $type_id?>" />
                                   
            			<div class="input-select main">
                            <i class="fa fa-university" aria-hidden="true"></i>
                            <span class="title"><?php echo $type_name?></span>
                            <i class="fa fa-angle-down right" aria-hidden="true"></i>
                        </div>
                        <ul class="main_list" <?php if(JRequest::getVar('show')) echo 'style="display: block;"'?>>
                            <li class="all" data-id="">Chọn Loại Dự Án <?php if(!$type_id) echo $active?></li>
                            <?php foreach($this->filter_type_id as $row):?>
                            <li class="ma" data-id="<?php echo $row->id?>"><?php echo $row->title?> <?php if($type_id == $row->id) echo $active?></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
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

    $("#sortTable").change(function() {
		var order = $('#sortTable option:selected').val();    
        if(order == 'price') $('#order_Dir').val('asc');
        else $('#order_Dir').val('desc');                
	})	
    
    $(".location .main").live('click', function() {
    	$(".location .main_list").slideToggle('fast');
    });
    
    $(".location .sub").live('click', function() {
    	$(".location .sub_list").slideToggle('fast');
    });
    
    $('.location ul li.ma').on('click', function() {
        $('.overlayUpload').show();
        var id = $(this).data('id');
        var text = $(this).text();
        $('.location .main_id').val(id);
        $('.location .sub_id').val('');
        
        $.ajax({
            url : 'index.php?option=com_bds&task=locations.subLocations&<?php echo JSession::getFormToken()?>=1',
            data : {id : id},
            type: "POST",
            dataType: 'json',
            success: function(data){
                var sub = '<li class="back"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;<strong>'+text+'</strong></li>';
                sub += '<li class="all">Tất cả <i class="fa fa-check right" aria-hidden="true"></i></li>';
                $.each(data, function(key, val){
		    		sub+= '<li class="su" data-id="'+ val.id +'">'+ val.title +'</li>';
		    	});
                $('.location .sub_list').html(sub);
                $('.location .input-select .title').text(text);
                
                $('.location .input-select').removeClass('main');
                $('.location .input-select').addClass('sub');
                
                $('.location .main_list').hide();
                $('.location .sub_list').show();                
                $('.overlayUpload').hide();
            }
        });
    });
    
    $('.location .back').live('click', function() {
        $('.location .main_list').show();
        $('.location .sub_list').hide();
    });
    
    $('.location .all').live('click', function() {
        $('.location .sub_list').hide();
        $('.location .sub_id').val('');
        $('#adminForm').submit();   
    });
    
    $('.location .allR').live('click', function() {
        var text = $(this).text();
        $('.location .main_id').val('');
        $('.location .sub_id').val('');
        $('.location .input-select').removeClass('sub');
        $('.location .input-select').addClass('main');
        
        $('.location .input-select .title').text(text);
        $('.location .main_list').hide();
        $('#adminForm').submit();        
    });
    
    $('.location .su').live('click', function() {
        var id = $(this).data('id');
        var text = $(this).text();
        
        $('.location .sub_id').val(id);        
        $('.location .input-select .title').text(text);
        $('.location .sub_list').hide();
        $('#adminForm').submit();        
    });
    
    $(document).click(function(event) { 
        if(!$(event.target).closest('.location').length) {
            $('.location .main_list').hide();
            $('.location .sub_list').hide();
        }        
    });
    
    //
    $(".types .main").live('click', function() {
    	$(".types .main_list").slideToggle('fast');
    });
    $('.types .all').live('click', function() {
        $('.types .main_list').hide();
        $('.types .main_id').val('');
        $('#adminForm').submit();   
    });
    $('.types .ma').live('click', function() {
        var id = $(this).data('id');
        var text = $(this).text();
        
        $('.types .main_id').val(id);        
        $('.types .input-select .title').text(text);
        $('.types .main_list').hide();
        $('#adminForm').submit();        
    });
    
    $(document).click(function(event) { 
        if(!$(event.target).closest('.types').length) {
            $('.types .main_list').hide();
        }        
    });
})
</script>	