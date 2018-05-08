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
<script src="../templates/bds/js/jquery.number.min.js" type="text/javascript"></script> 
<script language="javascript" type="text/javascript">
	//Secure the user navigation on the page, in order preserve datas.
	var holdForm = true;
	window.onbeforeunload = function closeIt(){	if (holdForm) return false;};
</script>

<form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm" class='form-validate' enctype='multipart/form-data'>
	<div class="row-fluid bds">
		<div id="contents" class="span12">
			<!-- BRICK : toolbar_sing -->
			<?php echo $this->renderToolbar();?>
			<!-- BRICK : form -->
			<?php echo $this->loadTemplate('form'); ?>
		</div>
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
    
    $('#jform_types').on('change', function() {
        jQuery('.overlayUpload').show();
        var id = jQuery(this).val();
        jQuery.ajax({
            url : 'index.php?option=com_bds&task=categories.subCategory&<?php echo JSession::getFormToken()?>=1',
            data : {id : id},
            type: "POST",
            dataType: 'html',
            success: function(data){
                $('#jform_category_id').html(data);
                $('#jform_category_id').trigger('liszt:updated');
                jQuery('.overlayUpload').hide();
            }
        });
    });
    
    $('#jform_main_location').on('change', function() {
        jQuery('.overlayUpload').show();
        var id = jQuery(this).val();
        jQuery.ajax({
            url : 'index.php?option=com_bds&task=locations.subLocations&<?php echo JSession::getFormToken()?>=1',
            data : {id : id},
            type: "POST",
            dataType: 'html',
            success: function(data){
                $('#jform_sub_location').html(data);
                $('#jform_sub_location').trigger('liszt:updated');
                jQuery('.overlayUpload').hide();
            }
        });
    });

});
</script>