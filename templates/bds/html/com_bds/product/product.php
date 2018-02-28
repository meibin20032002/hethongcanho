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
$gallery =  json_decode($this->item->gallery);
?>
<div class="product">
    <form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm" enctype='multipart/form-data'>
    	<div class="row">
            <div class="col-md-8">
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
                                <img src="<?php echo $item->image; ?>" alt="image" style="width:100%;"/>
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
                    
                    <div class="hidden-xs">
                        <span class="">Tin  Cá nhân  đăng hôm nay 11:30,
                            <a target="_blank" href="#" class="">được duyệt bởi Hải Dương</a>
                        </span>
                        <div class="img-thumbnail img-circle no-border">
                            <img alt="" src="images/icon/no-avatar.png" class="img-circle no-margin no-border"/>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <h4><?php echo $this->item->title ?></h4>
                <span class="price"><?php echo BdsHelper::currencyFormat($this->item->price) ?></span> - <?php echo $this->item->acreage?> m<sup>2</sup>
                
                <div class="desc">
                    <?php echo $this->item->description?>
                </div>
                
                <div class="col-md-6">
                    <div class="acreage"><i class="fa fa-home"></i><span class="lab">Diện tích: </span><?php echo $this->item->acreage?></div>
                </div>
                <div class="col-md-6">
                    <div class="direction"><i class="fa fa-map-marker"></i><span class="lab">Hướng cửa chính: </span><?php echo $this->item->direction?></div>
                </div>
                
                <br />
                <div class="note">
                    <i>Chúng tôi kiểm duyệt toàn bộ tin trước khi đăng để việc mua bán an toàn & hiệu quả hơn. Tuy nhiên, quá trình duyệt tin chỉ có thể hạn chế tối đa các trường hợp không trung thực. Hãy báo cho chúng tôi những tin xấu để chúng tôi có thể xác minh & xây dựng trang web mua bán an toàn nhất cho người Việt.</i>
                </div>
                
    		</div>
            
            
            <div class="col-md-4">
                <div class="media">
                    <div class="media-left media-middle">
                        <a href="#">
                            <div class="img-thumbnail img-circle">
                            <img src="images/icon/no-smaill-avatar.png" class="img-circle"/></div>
                        </a>           
                    </div>
                    <div class="media-body media-middle">
                        <div class="pf-fullname">
                            <a href="##ad_view">
                                <strong itemprop="name"><?php echo $this->item->contact_name?></strong>
                            </a>
                        </div>
                        <div class="pf-address">
                            <i class="fa fa-map-marker"></i> <?php echo $this->item->contact_address?>
                        </div>
                        <div class="pf-date">
                            Ngày tham gia: 06-09-2017
                        </div>
                    </div>
                </div>
                
                <a id="show_phone_bnt" class="btn btn-success btn-block">
                    <i class="fa fa-phone"></i><span> Nhấn để hiện số</span>
                </a>
                <h4 class="show-phone" style="display: none;text-align: center;">
                    <a href="tel:0902333146"><strong><?php echo $this->item->contact_number?></strong></a>
                </h4>
                
                <h6 class="text-left"><strong>MUA HÀNG AN TOÀN</strong></h6>
                <ul class="text-justify"><li><em>KHÔNG trả tiền trước khi nhận hàng.</em></li><li><em>Kiểm tra hàng cẩn thận, đặc biệt với hàng đắt tiền.</em></li><li><em>Hẹn gặp ở nơi công cộng.</em></li><li><em>Nếu bạn mua hàng hiệu, hãy gặp mặt tại cửa hàng để nhờ xác minh, tránh mua phải hàng giả.</em></li></ul>
                <p class="text-left"><em>Tìm hiểu thêm về <a href="#">an toàn mua bán</a>.</em></p>
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
</div>
<script>
jQuery( document ).ready(function($) {
    $( "#show_phone_bnt" ).click(function() {
        $( ".show-phone" ).show();
        $(this).hide();
    });
});

</script>