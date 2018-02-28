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
<?php
// Render the page title
echo JLayoutHelper::render('title', array(
	'params' => $this->params,
	'title' => null,
	'browserTitle' => null
)); ?>
<div class="form-subscribe">
    <div class="row">
        <form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm" class='form-validate' enctype='multipart/form-data'>
    
            <?php echo $this->loadTemplate('form'); ?>
            <div class="col-md-12">
                <button type="submit" onclick="return Joomla.submitform('product.apply');">SUBSCRIBE</button>
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