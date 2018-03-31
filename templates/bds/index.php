<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');
$lang     = $app->input->getCmd('lang', '');
$config   = JFactory::getConfig();

$menu = $app->getMenu();
$doc->addStyleSheet($this->baseurl . '/templates/system/css/system.css');
//unset($this->_scripts[$this->baseurl .'/media/jui/js/jquery.min.js']);
//Pages
$app = JFactory::getApplication();
$menu = $app->getMenu()->getActive();
$pageclass   = "";

if (is_object($menu))
    $pageclass = $menu->params->get('pageclass_sfx');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes"/>
	<meta name="HandheldFriendly" content="true" />
	<meta name="apple-mobile-web-app-capable" content="YES" />
    <?php echo $params->get('after_head') ?>
    <jdoc:include type="head" />
    
    <link href="templates/<?php echo $this->template ?>/css/jquery-ui.css" rel="stylesheet" />
    <link href="templates/<?php echo $this->template ?>/css/bootstrap.min.css" rel="stylesheet" />
    <link href="templates/<?php echo $this->template ?>/assets/mlpushmenu/css/mlpushmenu.css" rel="stylesheet"/>
    <link href="templates/<?php echo $this->template ?>/css/font-awesome.min.css" rel="stylesheet" />
    <link href="templates/<?php echo $this->template ?>/css/montserrat-webfont.css" rel="stylesheet" />
    <link href="templates/<?php echo $this->template ?>/css/owl.carousel.css" rel="stylesheet" />
	<link href="templates/<?php echo $this->template ?>/css/screen.css" rel="stylesheet" />
    <link href="templates/<?php echo $this->template ?>/css/responsive.css" rel="stylesheet" />
    
    <script src="templates/<?php echo $this->template ?>/js/jquery-ui.js" type="text/javascript"></script>
    <script src="templates/<?php echo $this->template ?>/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="templates/<?php echo $this->template ?>/js/jquery.number.min.js" type="text/javascript"></script>  
    <script src="templates/<?php echo $this->template ?>/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="templates/<?php echo $this->template ?>/assets/mlpushmenu/js/modernizr.custom.js" type="text/javascript"></script>
    <script src="templates/<?php echo $this->template ?>/assets/mlpushmenu/js/classie.js" type="text/javascript"></script>
    <script src="templates/<?php echo $this->template ?>/assets/mlpushmenu/js/mlpushmenu.js" type="text/javascript"></script> 
    <script src="templates/<?php echo $this->template ?>/js/owl.carousel.min.js" type="text/javascript"></script>
    <script src="templates/<?php echo $this->template ?>/js/start.js" type="text/javascript"></script>
    <?php echo $params->get('before_head') ?>
</head>

<body class="<?php echo $pageclass?>">
    <?php echo $params->get('after_body') ?>
    
    <div class="fixed">
        <div class="container main-container">  
            <h1 class="logo">
                <a href="<?php echo JUri::base()?>" title="PresalesNow">
                    <img src="<?php echo $params->get('logo') ?>" alt="PresalesNow"/>
                </a>
            </h1>
            <div id="mainmenu">
                <jdoc:include type="modules" name="mainmenu" style="none" />
            </div>                                  
        </div>
    </div>
                            
    <div class="mp-container">
        <!-- Wrap everything with this .mp-container -->
        <div class="mp-pusher" id="mp-pusher">
            <!-- mp-menu -->
            <jdoc:include type="modules" name="mobile-menu" style="none" />
            <!-- /mp-menu -->
            <div class="scroller">
                <!-- This is for emulating position fixed of the nav -->
                <div class="scroller-inner">                    
                    <!-- Body -->
				    <div class="body">
                        <!-- Put all stuffs in this div. -->
                        <header id="header">
                            <div class="desktop">
                                <div class="container main-container">  
                                    <h1 class="logo">
                                        <a href="<?php echo JUri::base()?>" title="PresalesNow">
                                            <img src="<?php echo $params->get('logo') ?>" alt="PresalesNow"/>
                                        </a>
                                    </h1>
                                    <div id="mainmenu">
                                        <jdoc:include type="modules" name="mainmenu" style="none" />
                                    </div>                              
                                    
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle" id="trigger">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>    
                                </div>
                            </div>
                        </header>
                        
                        <div id="slide">
                            <jdoc:include type="modules" name="banner" style="none" />   
                        </div>
                        
                        <?php if($option!='com_users'):?>
                        <div class="container main-container"> 
                            <div class="main-content">  
                            <?php endif;?>
                                <jdoc:include type="modules" name="content-top" style="none" />                                       
                                <jdoc:include type="message" />                                                              
                                <jdoc:include type="component" />
                                <jdoc:include type="modules" name="content-bottom" style="none" />   
                            <?php if($option!='com_users'):?>
                            </div>       
                        </div>               
                        <?php endif;?>                                                                                   
    
                        <?php if($this->countModules('bottom')):?>
                        <div class="container main-container"> 
                            <jdoc:include type="modules" name="bottom" style="none" />
                        </div>
                        <?php endif;?>
                        
                    </div>
    
    				<!-- Footer -->
    				<div class="footer" role="contentinfo">
                        <div class="container main-container">
                            <div class="row infor">
                                <jdoc:include type="modules" name="footer" style="footer" />
                            </div>
                            <div class="copyright">
                                <jdoc:include type="modules" name="copyright" style="none" />
                            </div>
                        </div>          
                    </div>

                </div>
                <!--scroller-inner-->
            </div>
            <!--scroller-->
        </div>
        <!--mp-pusher-->
    </div>
    <!--mp-container-->

    <script>
        new mlPushMenu(document.getElementById('mp-menu'), document.getElementById('trigger'));
    </script>
    <div class="overlayUpload"><span class="loading"></span></div>
    <?php echo $params->get('before_body') ?>
</body>
</html>
