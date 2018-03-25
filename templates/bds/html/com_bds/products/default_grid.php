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
	'domId' => 'grid-products',
	'listOrder' => $listOrder,
	'listDirn' => $listDirn,
	'formId' => 'adminForm',
	'ctrl' => 'products',
	'proceedSaveOrderButton' => true,
));
?>

<div class="clearfix"></div>
<div class="boxGrid row">
    <?php foreach($this->items as $item):
        $gallery =  json_decode($item->gallery, true);
    ?>
    <div class="girdView col-md-3 col-sm-4 col-xs-6">
        <a href="<?php echo JRoute::_('index.php?option=com_bds&view=product&layout=product&id='.$item->id)?>">
            <?php if($item->hot):?>
            <div class="ctRibbonAd">HOT</div>   
            <?php endif?>             
            
            <div class="imageBox">
                <img src="<?php echo $gallery['gallery0']['image']?>" alt="<?php echo $item->title?>"/> 
                <div class="count-image"><?php echo count($gallery)?></div>
            </div>
            
            <div class="infoBox">
                <h4 class="title"><?php echo $item->title?></h4>        
                <div class="price"><i class="fa fa-tag"></i><span class="lab">Giá: </span> <?php echo BdsHelper::currencyFormat($item->price) ?></div>
            </div>
            
            <div class="infoFoot">
                <div class="creation_date">
                    <?php echo JHtml::date($item->creation_date, 'd/m/Y H:i')?> 
                </div>
                
                <div class="iconAvatar">
                    <?php echo BdsHelper::iconAvatarWho($item)?>
                </div>
            </div> 
        </a>
    </div>  
    <?php endforeach;?>
</div>