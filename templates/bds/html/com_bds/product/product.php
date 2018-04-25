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
$user = JFactory::getUser($this->item->created_by);
$document = JFactory::getDocument();
?>
<div class="product">
    <form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm" enctype='multipart/form-data'>
    	<div class="row">
            <div class="col-md-8 productDesc">
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
                        <?php foreach ($gallery as $item) :
                            if($item->image){
                                $document->setMetaData( 'og:image', JUri::root().htmlspecialchars($item->image));
                                $image = $item->image;
                            }else{
                                $image = 'images/no-image.jpg';
                            }
                        ?>
                            <div class="item <?php echo $active?>">    
                                <img src="<?php echo $image; ?>" alt="image" style="width:100%; max-height: 400px;"/>
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
                    
                    <div class="hidden-xs footer-slider">
                        <span class="create-date">Tin 
                            <?php 
                            $who = BdsHelperEnum::_('products_who');
                            if(isset($who[$this->item->who]['text'])) echo $who[$this->item->who]['text']?> đăng <?php echo JHtml::date($this->item->creation_date, 'd-m-Y H:i')?>,
                            <a target="_blank" href="#" class="">được duyệt bởi <?php echo $this->item->_modified_by_name ?></a>
                        </span>
                        <div class="img-thumbnail img-circle no-border">
                            <img alt="" src="<?php echo BdsHelper::iconAvatar($this->item->modified_by) ?>" class="img-circle no-margin no-border"/>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="shareNow">
                    <div class="row">                
                        <div class="col-xs-12">
                            <a class="icon google" href="#">google</a>
                            <a class="icon zalo" href="#">zalo</a>
                            <a class="icon facebook" href="#">facebook</a>                    
                        </div>
                    </div>
                </div>
                
                <h4><?php echo $this->item->title ?></h4>
                <span class="price"><?php echo BdsHelper::currencyFormat($this->item->price) ?></span> - <?php echo BdsHelper::acreageFormat($this->item->acreage)?>
                
                <div class="desc">
                    <?php echo $this->item->description?>
                </div>
                
                <div class="acrDirection">
                    <?php if($this->item->_project_id_title):?>
                    <div class="col-md-6">
                        <div class="xitem"><i class="fa fa-university"></i><span class="lab">Dự án: </span><?php echo $this->item->_project_id_title?></div>
                    </div>
                    <?php endif;?>
                    
                    <?php if($this->item->acreage):?>
                    <div class="col-md-6">
                        <div class="xitem"><i class="fa fa-home"></i><span class="lab">Diện tích: </span><?php echo BdsHelper::acreageFormat($this->item->acreage)?></div>
                    </div>
                    <?php endif;?>
                    
                    <?php if($this->item->direction):?>
                    <div class="col-md-6">
                        <div class="xitem"><i class="fa fa-compass"></i><span class="lab">Hướng cửa chính: </span><?php echo $this->item->direction?></div>
                    </div>
                    <?php endif;?>
                    
                    <?php if($this->item->legal_documents):?>
                    <div class="col-md-6">
                        <div class="xitem">
                            <i class="fa fa-file"></i>
                            <span class="lab">Giấy tờ pháp lý: </span>
                            <?php 
                            $documents = BdsHelperEnum::_('products_legal_documents');
                            echo $documents[$this->item->legal_documents]['text'];
                            ?>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
                <h5><strong>Địa chỉ BĐS </strong></h5>
                <div class="address"><i class="fa fa-map-marker"></i> <?php echo $this->item->address?></div>
               
                <br />
				<div> </div>
                <div class="note">
                    <i>Chúng tôi kiểm duyệt toàn bộ tin trước khi đăng để việc mua bán an toàn & hiệu quả hơn. Tuy nhiên, quá trình duyệt tin chỉ có thể hạn chế tối đa các trường hợp không trung thực. Hãy báo cho chúng tôi những tin xấu để chúng tôi có thể xác minh & xây dựng trang web mua bán an toàn nhất cho người Việt.</i>
                </div>
                <?php echo $this->loadTemplate('fly'); ?>
    		</div>
            
            
            <div class="col-md-4 seller">
                <div class="media">
                    <div class="media-left media-middle GniN">
                        <a href="#" class="Capee">
                            <div class="img-thumbnail img-circle thumbnails">
                            <img src="<?php echo BdsHelper::iconAvatar($this->item->created_by) ?>" class="img-circle"/></div>
                        </a>           
                    </div>
                    <div class="media-body media-middle">
                        <div class="pf-fullname">
                            <a href="#ad_view">
                                <strong itemprop="name"><?php echo $this->item->contact_name?></strong>
                            </a>
                        </div>
                        <div class="pf-address">
                            <i class="fa fa-map-marker"></i> <?php echo $this->item->contact_address?>
                        </div>
                        <div class="pf-date">
                            Ngày tham gia: <?php echo Jhtml::date($user->get('registerDate'), 'd-m-Y')?>
                        </div>
                    </div>
                </div>
                
                <a id="show_phone_bnt" class="btn btn-success btn-block">
                    <i class="fa fa-phone"></i><span> Nhấn để hiện số</span>
                </a>
                <h4 class="show-phone" style="display: none;text-align: center;">
                    <?php $phone = BdsHelper::getPhone($this->item->contact_number, $this->item->created_by)?>
                    <a href="tel:<?php echo $phone ?>"><strong><?php echo $phone?></strong></a>
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
    
    var current = '<?php echo JRoute::_('index.php?view=product&layout=product&option=com_bds&id='.$this->item->id, false, -1)?>';
            
    jQuery('.facebook').click(function() {        
        var href = 'https://www.facebook.com/sharer.php?u=';              
        return openWindow(href+current);
    });
    jQuery('.zalo').click(function() {        
        var href = 'https://id.zalo.me/account?continue=';              
        return openWindow(href+current);
    });
    jQuery('.google').click(function() {        
        var href = 'https://plus.google.com/up/?continue=';              
        return openWindow(href+current);
    });
    
    function openWindow(url) {
        var width = window.innerWidth * 0.66 ;
        // define the height in
        var height = width * window.innerHeight / window.innerWidth ;
        // Ratio the hight to the width as the user screen ratio
        window.open(url , 'newwindow', 'width=' + width + ', height=' + height + ', top=' + ((window.innerHeight - height) / 2) + ', left=' + ((window.innerWidth - width) / 2));
    }
});
</script>