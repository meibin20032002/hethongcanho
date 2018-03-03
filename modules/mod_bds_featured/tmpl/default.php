<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_related_items
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die; 
?> 
<?php if(count($list) > 1):?>
<div class="thumbsGallery">
    <h3><?php echo $module->title?></h3>
	<ul>
        <?php foreach($list as $row ):
            $gallery =  json_decode($row->gallery, true);
        ?>
        <li class="item">
			<a href="<?php echo JRoute::_('index.php?option=com_bds&view=product&layout=product&id='.$row->id)?>">
                <div class="imageBox">
                    <img src="<?php echo $gallery['gallery0']['image']?>" alt=""/>
                </div>
                <h4 class="titleBox"><?php echo $row->title?></h4>
                <div class="price"><?php echo BdsHelper::currencyFormat($row->price)?></div>
            </a>
		</li>
        <?php endforeach;?>       
	</ul>
</div>
<?php endif; ?>
<script>
jQuery( document ).ready(function($) {
	$(".thumbsGallery ul").owlCarousel({
    	items : 6,
        loop:true,
        autoplay:true,
        autoplayTimeout:1500,
        autoplayHoverPause:true,
      	nav: true,
        margin: 15,
        responsive:{
            0:{
                items:2,
                nav:true
            },
            600:{
                items:4,
                nav:true
            },
            1000:{
                items:6,
                nav:true
            }
        }
  	});
})
</script>