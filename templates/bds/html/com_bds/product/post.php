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
});
       
var arrImageUpload = {};
function handleFileSelect(evt) {

	var files = evt.target.files; // FileList object

	// Loop through the FileList and render image files as thumbnails.
	for (var i = 0, f; f = files[i]; i++) {
		if(i >= 6){
			createPopup('You’ve exceeded the maximum files for each policy. <br />Do reach us if you require further assistance. ');
			break;
		}

		var count = jQuery('#listImg li').length;
		var reader = new FileReader();

		// Closure to capture the file information.
		reader.onload = (function(theFile) {
			return function(e) {

				jQuery('.overlayUpload').show();
				var count = jQuery('#listImg li').length;
				if(count >= 6){
					createPopup('You’ve exceeded the maximum files for each policy. <br />Do reach us if you require further assistance. ');
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