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
<?php foreach($this->items as $item):
    $gallery =  json_decode($item->gallery, true);
?>
<div class="box"> 
    <a href="<?php echo JRoute::_('index.php?option=com_bds&view=product&layout=product&id='.$item->id)?>">
        <div class="row">
            <div class="ctRibbonAd">HOT</div>                
            <div class="col-md-2 col-sm-3 col-xs-5">
                <img src="<?php echo $gallery['gallery0']['image']?>" alt="<?php echo $item->title?>"/> 
                <div class="bghover"></div>
            </div>
            
            <div class="col-md-10 col-sm-9 col-xs-7 info-des">
                <h4 class="title"><?php echo $item->title?></h4>
 </a>
                <div class="price"><i class="fa fa-tag"></i><span class="lab">Giá: </span> <?php echo BdsHelper::currencyFormat($item->price) ?></div>
                <div class="acreage"> Diện tích: </span><?php echo $item->acreage?></div>
                   
                <div class="row info">
                    <div class="col-xs-9 creation_date">
                        <?php echo JHtml::date($item->creation_date, 'd/m/Y H:i')?> | <?php echo $item->_location_id_title ?>
                    </div>
                    <div class="col-xs-3 who">
                        <?php echo BdsHelper::iconAvatar($item)?>
                    </div>
                </div>
            </div> 
        </div>  
 
</div>
<?php endforeach;?>