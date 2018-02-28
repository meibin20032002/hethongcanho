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
    <h1><?php echo $this->item->title ?></h1>
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
        
        <br />
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Tin đăng (12)</a></li>
            <li><a data-toggle="tab" href="#menu1">Thông tin</a></li>
        </ul>
        
        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
            <div class="grid-products">
                <div class="box"> 
                    <a href="/hethongcanho/index.php?option=com_bds&amp;view=product&amp;layout=product&amp;id=1&amp;Itemid=101">
                        <div class="row">
                            <div class="ctRibbonAd">HOT</div>                
                            <div class="col-md-2">
                                <img src="/hethongcanho/images/product/001.jpg" alt="Bán 6 lô đất vàng sân bay Tân Sơn Nhất, P.4"> 
                                <div class="bghover"></div>
                            </div>
                            
                            <div class="col-md-10 info-des">
                                <h4 class="title">Bán 6 lô đất vàng sân bay Tân Sơn Nhất, P.4</h4>
                                <div class="price"><i class="fa fa-tag"></i><span class="lab">Giá: </span> 10.000.000 đ</div>
                                <div class="acreage"><i class="fa fa-home"></i><span class="lab">Diện tích: </span>41</div>
                                   
                                <div class="row info">
                                    <div class="col-xs-9 creation_date">
                                        12/02/2018 04:58 | Quận 1                    </div>
                                    <div class="col-xs-3 who">
                                        <div class="iconAvatar"><span class="nameAvatar">Kelvin</span><img class="imgAvatar" src="/hethongcanho/images/icon/no-avatar.png" alt="private"></div>                    </div>
                                </div>
                            </div> 
                        </div>  
                    </a>
                </div>
                <div class="box"> 
                    <a href="/hethongcanho/index.php?option=com_bds&amp;view=product&amp;layout=product&amp;id=1&amp;Itemid=101">
                        <div class="row">
                            <div class="ctRibbonAd">HOT</div>                
                            <div class="col-md-2">
                                <img src="/hethongcanho/images/product/001.jpg" alt="Bán 6 lô đất vàng sân bay Tân Sơn Nhất, P.4"> 
                                <div class="bghover"></div>
                            </div>
                            
                            <div class="col-md-10 info-des">
                                <h4 class="title">Bán 6 lô đất vàng sân bay Tân Sơn Nhất, P.4</h4>
                                <div class="price"><i class="fa fa-tag"></i><span class="lab">Giá: </span> 10.000.000 đ</div>
                                <div class="acreage"><i class="fa fa-home"></i><span class="lab">Diện tích: </span>41</div>
                                   
                                <div class="row info">
                                    <div class="col-xs-9 creation_date">
                                        12/02/2018 04:58 | Quận 1                    </div>
                                    <div class="col-xs-3 who">
                                        <div class="iconAvatar"><span class="nameAvatar">Kelvin</span><img class="imgAvatar" src="/hethongcanho/images/icon/no-avatar.png" alt="private"></div>                    </div>
                                </div>
                            </div> 
                        </div>  
                    </a>
                </div>
            </div>
          </div>
          <div id="menu1" class="tab-pane fade">
            <div class="address"><i class="fa fa-map-marker"></i> <?php echo $this->item->address ?></div>
            <div class="row">
                <div class="col-md-4">
                    <div class="price"><i class="fa fa-tag"></i> <span class="lab">Giá: </span> <?php echo $this->item->price_min?> - <?php echo $this->item->price_max?></div>
                </div>
                <div class="col-md-4">
                    <div class="handing_over"><i class="fa fa-calendar"></i> <span class="lab">Bàn giao: </span> <?php echo $this->item->handing_over?></div>
                </div>
                <div class="col-md-4">
                    <div class="investor"><i class="fa fa-users"></i> <span class="lab">Chủ đầu tư: </span> <?php echo $this->item->investor ?></div>
                </div>
            </div>
            
            <h3>Mô tả dự án</h3>
            <?php echo $this->item->description ?>
            
            <div>Loại dự án: <?php echo $this->item->total_area?></div>
            <div>Tổng diện tích: <?php echo $this->item->total_area?></div>
          </div>
          
          
</div>