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


JHtml::addIncludePath(JPATH_ADMIN_BDS.'/helpers/html');
JHtml::_('behavior.tooltip');
//JHtml::_('behavior.multiselect');

$model		= $this->model;
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$saveOrder	= $listOrder == 'a.ordering' && $listDirn != 'desc';
JDom::_('framework.sortablelist', array(
	'domId' => 'grid-projects',
	'listOrder' => $listOrder,
	'listDirn' => $listDirn,
	'formId' => 'adminForm',
	'ctrl' => 'projects',
	'proceedSaveOrderButton' => true,
));
?>

<div class="clearfix"></div>
<?php foreach($this->items as $item):
    $gallery =  json_decode($item->gallery, true);
?>
<div class="box">    
    <a href="<?php echo JRoute::_('index.php?option=com_bds&view=project&layout=project&id='.$item->id)?>"> 
        <div class="row">            
            <div class="col-md-2">
                <img src="<?php echo $gallery['gallery0']['image']?>" alt="<?php echo $item->title?>"/> 
            </div>
            
            <div class="col-md-10">
                <h4 class="title"><?php echo $item->title?></h4>
                <div class="handing_over"><?php echo $item->handing_over?></div>   
                <div class="price"><?php echo $item->price_min?> - <?php echo $item->price_max?></div>
                <div class="address"><?php echo $item->address?></div>   
            </div> 
        </div>
    </a>  
</div>
<?php endforeach;?>