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
$gallery =  json_decode($this->item->gallery);
?>
<div class="project">
    <h1>Thông tin dự án <?php echo $this->item->title ?></h1>
    <div class="address"><i class="fa fa-map-marker"></i> <?php echo $this->item->address ?></div>
        <?php if($gallery):?>
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators"> 
                <?php $i = 0;?>
                <?php foreach ($gallery as $item) :?>
                    <li data-target="#myCarousel" data-slide-to="<?php echo $i?>" class="<?php if($i == 0) echo 'active'?>"></li>
                    <?php $i++;?>
                <?php endforeach; ?>
            </ol>
        
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <?php $active = 'active';?>
                <?php foreach ($gallery as $item) :?>
                    <div class="item <?php echo $active?>">    
                        <img src="<?php echo $item->image; ?>" alt="image" style="width:100%; max-height: 450px;"/>
                    </div>
                    <?php $active = '';?>
                <?php endforeach; ?>
            </div>
        
            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <span class="sr-only">Next</span>
            </a>
            
        </div>
        <?php endif; ?>
        
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Tin đăng (<?php echo BdsHelper::countSale($this->item->id)?>)</a></li>
            <li><a data-toggle="tab" href="#menu1">Thông tin</a></li>
        </ul>
        
        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
            <div class="grid-products">
                <?php 
                $model = CkJModel::getInstance('products', 'BdsModel');
                $model->addWhere('a.project_id ='. $this->item->id);
        		$model->setState('context', 'layout.default');
       			$items = $model->getItems();
                ?>
                <ul class="boxList">
                    <?php foreach($items as $row):
                        $gallery =  json_decode($row->gallery, true);
                    ?>
                    <li class="listView">
                        <a href="<?php echo JRoute::_('index.php?option=com_bds&view=product&layout=product&id='.$row->id)?>">
                            <?php if($row->hot):?>
                            <div class="ctRibbonAd">HOT</div>   
                            <?php endif?>             
                            
                            <div class="imageBox">
                                <?php if($gallery['gallery0']['image']):?>
                                <img src="<?php echo $gallery['gallery0']['image']?>" alt="<?php echo $row->title?>"/> 
                                <div class="count-image"><?php echo count($gallery)?></div>
                                <?php endif;?>
                            </div>
                            
                            <div class="infoBox">
                                <h4 class="title"><?php echo $row->title?></h4>        
                                <div class="price"><i class="fa fa-tag"></i><span class="lab">Giá: </span> <?php echo BdsHelper::currencyFormat($row->price) ?></div>
                                <div class="acreage"> Diện tích: </span><?php echo BdsHelper::acreageFormat($row->acreage)?></div>
                            </div>
                        </a>
                        
                        <div class="infoFoot">
                            <div class="creation_date">
                                <?php echo JHtml::date($row->creation_date, 'd/m/Y H:i')?> 
                                <?php if($row->_main_location_title):?>
                                <span class="areaName"> | 
                                    <?php if($row->_sub_location_title) echo $row->_sub_location_title.', ' ?>
                                    <?php echo $row->_main_location_title ?>
                                </span>
                                <?php endif;?>
                            </div>
                            <div class="iconAvatar">
                                <span class="nameAvatar"><?php echo $row->_created_by_name ?></span>
                                <img class="imgAvatar" src="<?php echo BdsHelper::iconAvatar($row->created_by)?>" alt="private"/>
                            </div>
                        </div> 
                    </li>  
                    <?php endforeach;?>
                </ul>
            </div>
          </div>
          <div id="menu1" class="tab-pane fade">
            <div class="address"><i class="fa fa-map-marker"></i> <?php echo $this->item->address ?></div>
            <div class="iconInfor">
                <div class="col-md-4">
                    <div class="price"><i class="fa fa-tag"></i> <span class="lab">Giá: </span> <?php echo BdsHelper::currencyFormat($this->item->price_min)?> - <?php echo BdsHelper::currencyFormat($this->item->price_max)?></div>
                </div>
                <div class="col-md-4">
                    <div class="handing_over"><i class="fa fa-calendar"></i> <span class="lab">Bàn giao: </span> <?php echo $this->item->handing_over?></div>
                </div>
                <div class="col-md-4">
                    <div class="investor"><i class="fa fa-users"></i> <span class="lab">Chủ đầu tư: </span> <?php echo $this->item->investor ?></div>
                </div>
            </div>
            
            <h3 class="pi-title">Mô tả dự án</h3>
            <?php echo $this->item->description ?>
            
            <div>Loại dự án: <?php echo $this->item->total_area?></div>
            <div>Tổng diện tích: <?php echo $this->item->total_area?></div>
          </div>
    </div>   
</div>