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
$user = JFactory::getUser();
?>
<div class="page-header">
	<h1>Đăng tin miễn phí</h1>
</div>
<div class="form-subscribe">
    <div class="row">
        <form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm" class='form-validate' enctype='multipart/form-data'>
    
            <?php echo $this->loadTemplate('form'); ?>
            <div class="col-md-12">
                <button type="submit" onclick="return Joomla.submitform('product.apply');">ĐĂNG NGAY</button>
            </div>
        
            <input type="hidden" name="jform[contact_number]" value="<?php echo $user->get('username')?>"/>
            <input type="hidden" name="jform[contact_name]" value="<?php echo $user->get('name')?>"/>
            <input type="hidden" name="jform[contact_email]" value="<?php echo $user->get('email')?>"/>
            <input type="hidden" name="jform[contact_address]" value="<?php echo $user->get('address1')?>"/>
        	<?php 
        		$jinput = JFactory::getApplication()->input;
        		echo JDom::_('html.form.footer', array(
        		'dataObject' => $this->item,
        		'values' => array(
        					'id' => $this->state->get('product.id')
        				)));
        	?>
        </form>
    </div>
</div>

<script>
jQuery(document).ready(function ($) {
    $('.uploadPhotoButton').bind('click',function(e){
		$(this).parent().find('input').click();
		return false;
	});
    
    $('#jform_price').number( true, 0);
    $('#jform_acreage').number( true, 0);
    $('#jform_behind').number( true, 0);
    $('#jform_alley').number( true, 0);
    
    
    $(".types .main").live('click', function() {
    	$(".types .main_list").slideToggle('fast');
    });
    
    $(".types .sub").live('click', function() {
    	$(".types .sub_list").slideToggle('fast');
    });
    
    $('.types ul li.ma').on('click', function() {
        $('.overlayUpload').show();
        var id = $(this).data('id');
        var text = $(this).text();
        $('.types .main_id').val(id);
        $('.types .sub_id').val('');
        
        $.ajax({
            url : 'index.php?option=com_bds&&task=categories.subCategory&<?php echo JSession::getFormToken()?>=1',
            data : {id : id},
            type: "POST",
            dataType: 'json',
            success: function(data){
                var sub = '<li class="back"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;<strong>'+text+'</strong></li>';
                sub += '<li class="all">Tất cả <i class="fa fa-angle-down right" aria-hidden="true"></i></li>';
                $.each(data, function(key, val){
		    		sub+= '<li class="su" data-id="'+ val.id +'">'+ val.title +'</li>';
		    	});
                $('.types .sub_list').html(sub);
                $('.types .input-select .title').text(text);
                
                $('.types .input-select').removeClass('main');
                $('.types .input-select').addClass('sub');
                
                $('.types .main_list').hide();
                $('.types .sub_list').show();                
                $('.overlayUpload').hide();
            }
        });
    });
    
    $('.types .back').live('click', function() {
        $('.types .main_list').show();
        $('.types .sub_list').hide();
    });
    
    $('.types .all').live('click', function() {
        $('.types .sub_id').val('');
        $('.types .sub_list').hide();
    });
    
    $('.types .allR').live('click', function() {
        var text = $(this).text();
        $('.types .main_id').val('');
        $('.types .sub_id').val('');
        $('.types .input-select').removeClass('sub');
        $('.types .input-select').addClass('main');
        
        $('.types .input-select .title').text(text);
        $('.types .main_list').hide();
    });
    
    $('.types .su').live('click', function() {
        var id = $(this).data('id');
        var text = $(this).text();
        
        $('.types .sub_id').val(id);        
        $('.types .input-select .title').text(text);
        $('.types .sub_list').hide();
    });
    
    $(document).click(function(event) { 
        if(!$(event.target).closest('.types').length) {
            $('.types .main_list').hide();
            $('.types .sub_list').hide();
        }        
    });
    
    //
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
                sub += '<li class="all">Tất cả <i class="fa fa-angle-down right" aria-hidden="true"></i></li>';
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
        $('.location .sub_id').val('');
        $('.location .sub_list').hide();
    });
    
    $('.location .allR').live('click', function() {
        var text = $(this).text();
        $('.location .main_id').val('');
        $('.location .sub_id').val('');
        $('.location .input-select').removeClass('sub');
        $('.location .input-select').addClass('main');
        
        $('.location .input-select .title').text(text);
        $('.location .main_list').hide();
    });
    
    $('.location .su').live('click', function() {
        var id = $(this).data('id');
        var text = $(this).text();
        
        $('.location .sub_id').val(id);        
        $('.location .input-select .title').text(text);
        $('.location .sub_list').hide();
    });
    
    $(document).click(function(event) { 
        if(!$(event.target).closest('.location').length) {
            $('.location .main_list').hide();
            $('.location .sub_list').hide();
        }        
    });
});
       
var arrImageUpload = {};
function handleFileSelect(evt) {

	var files = evt.target.files; // FileList object

	// Loop through the FileList and render image files as thumbnails.
	for (var i = 0, f; f = files[i]; i++) {
		if(i > 5){
			alert('Hình ảnh không quá 6 tấm');
            jQuery('.overlayUpload').hide();
			break;
		}

		var count = jQuery('#listImg li').length;
		var reader = new FileReader();

		// Closure to capture the file information.
		reader.onload = (function(theFile) {
			return function(e) {

				jQuery('.overlayUpload').show();
				var count = jQuery('#listImg li').length;
				if(count > 5){
					alert('Hình ảnh không quá 6 tấm');
                    jQuery('.overlayUpload').hide();
					return false;
				}

                //Set Data file
                var data = new FormData();
                data.append('file', theFile);

                //Load File
                jQuery.ajax({
    				url: 'index.php?option=com_bds&task=product.ajaxSave&<?php echo JSession::getFormToken()?>=1',
    				data: data,
    				type: "POST",
    				dataType:"json",
                    cache: false,
                    contentType: false,
                    processData: false,
    				success: function(data){
    					if(data.result == true){
    						// Render thumbnail.
        					var span = document.createElement('li');
        					var fileType = theFile.type;

    						span.className += " imgDoc";
    						span.innerHTML = ['<span class="deleteImg" data-value="'+count+'" data-name="'+data.name+'"></span><a class="imgUploadView" href="'+data.href+'"><img src="'+data.href+'" width="100%" height="100%" alt="'+data.name+'" /></a>'].join('');

        					document.getElementById('listImg').insertBefore(span, null);
    					}else{
    						createPopup(data.message);
    					}
								jQuery('.overlayUpload').hide();
    				},
    				error: function(err){
    					createPopup('ERROR');
    				}
    			});

				arrImageUpload[count] = e.target.result;
				count++;
			};
		})(f);

		// Read in the image file as a data URL.
		reader.readAsDataURL(f);
    }
}

jQuery(document).on('click', '.deleteImg', function(){
    var $this = jQuery(this);
    var key = $this.attr('data-value');
    var name = $this.attr('data-name');
    
    if(name){
        jQuery('.overlayUpload').show();
        jQuery.ajax({
            url : 'index.php?option=com_bds&task=product.ajaxDelete&<?php echo JSession::getFormToken()?>=1',
            data : {name : name},
            type: "POST",
            dataType: 'json',
            success: function(data){
                if(data.result == true){
                    $this.parent().remove();
                    delete arrImageUpload[key];
                }
				jQuery('.overlayUpload').hide();
            }
        });
    }else{
        $this.parent().remove();
        delete arrImageUpload[key];
    }
});
document.getElementById('files').addEventListener('change', handleFileSelect, false);
</script>