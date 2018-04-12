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
<div class="pbox">    
    <a class="plistView" href="<?php echo JRoute::_('index.php?option=com_bds&view=project&layout=project&id='.$item->id)?>"> 
        <div class="pimageBox col-xs-6">
            <div class="colBox0">
                <?php if(isset($gallery['gallery0']['image'])):?>
                <img src="<?php echo $gallery['gallery0']['image']?>" alt="<?php echo $item->title?>"/> 
                <?php endif;?>
            </div>
            <div class="colBox1">
                <div class="subBox0">
                    <?php if(isset($gallery['gallery1']['image'])):?>
                    <img src="<?php echo $gallery['gallery1']['image']?>" alt="<?php echo $item->title?>"/>
                    <?php endif;?> 
                </div>
                <div class="subBox1">
                    <?php if(isset($gallery['gallery2']['image'])):?>
                    <img src="<?php echo $gallery['gallery2']['image']?>" alt="<?php echo $item->title?>"/> 
                    <?php endif;?>
                </div>
            </div>
        </div>           
        
        <div class="col-xs-6">
            <h4 class="title"><?php echo $item->title?></h4>
            <div class="handing_over">
                Năm bàn giao: <?php echo JHtml::date($item->handing_over, 'Y') ?><br />
                Chủ đầu tư: <?php echo $item->investor ?>
            </div> 
            <?php if($item->_main_location_title):?>
            <div class="areaName"> 
                <?php if($item->_sub_location_title) echo $item->_sub_location_title.', ' ?>
                <?php echo $item->_main_location_title ?>
            </div>
            <?php endif;?> 
            <div class="pprice"><?php echo BdsHelper::currencyFormat($item->price_min) ?> - <?php echo BdsHelper::currencyFormat($item->price_max)?></div>
            
            <div class="countSale"><span><?php echo BdsHelper::countSale($item->id)?> người bán</span></div>  
        </div> 
    </a> 
</div>
<?php endforeach;?>