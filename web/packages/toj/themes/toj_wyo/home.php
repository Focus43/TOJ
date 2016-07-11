<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
<?php Loader::packageElement('theme/head_tag_inner', 'toj'); ?>
<?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
</head>

<body class="<?php echo $bodyClass; ?>">

    <div id="sidebarLeft" class="sidebars" data-load="<?php echo TOJ_TOOLS_URL; ?>sidebar_left">
        <?php if( Page::getCurrentPage()->isEditMode() ){
            Loader::packageElement('partials/sidebar_left', 'toj', array('c' => $c));
        }else{ ?>
            <div class="working"><i class="fa fa-refresh fa-spin"></i></div>
        <?php } ?>
    </div>

    <div id="sidebarRight" class="sidebars" data-load="<?php echo TOJ_TOOLS_URL; ?>sidebar_right">
        <?php if( Page::getCurrentPage()->isEditMode() ){
            Loader::packageElement('partials/sidebar_right', 'toj', array('c' => $c));
        }else{ ?>
            <div class="working"><i class="fa fa-refresh fa-spin"></i></div>
        <?php } ?>
    </div>

    <div id="cL1">
        <span id="pageBackgroundImage">
            <span class="backStretch" data-background="<?php echo $backgroundImage; ?>"></span>
        </span>

        <div id="cL2">
            <?php Loader::packageElement('theme/primary_navigation', 'toj', array('c' => $c)); ?>

            <!-- parallax launcher! -->
            <a id="launchParallax" class="hidden-sm hidden-xs" onclick="ExploreJackson.open();">
                <img class="img-responsive" src="<?php echo TOJ_IMAGES_URL; ?>explore_jackson.png" />
            </a>

            <div id="cL3">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="cL4">

                            <!-- actual page content -->
                            <div id="tagLine" class="hidden-xs row">
                                <div class="col-sm-12">
                                    <h1>Town Of Jackson, Wyoming
                                        <small><?php echo Page::getCurrentPage()->getCollectionDescription(); ?></small>
                                        <img class="img-responsive pull-left" src="<?php echo TOJ_IMAGES_URL; ?>toj_logo.png" />
                                    </h1>
                                </div>
                            </div>


                            <div id="homeSearch" class="row">
                                <div class="col-sm-12">
                                    <div class="inner">
                                        <form method="get" action="<?php echo $this->url('search'); ?>">
                                            <input name="query" type="text" class="form-control input-lg" placeholder="Site Search" />
                                            <i class="fa fa-search"></i>
                                            <button type="submit" class="btn btn-info btn-lg">Search</button>
                                            <input name="search_paths[]" type="hidden" value="">
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="introLinks">
                                <?php for($i = 1; $i <= 8; $i++):
                                    echo '<div class="element">';
                                    $loopedArea = new Area("Home Buttons $i");
                                    $loopedArea->setBlockLimit(1);
                                    $loopedArea->setCustomTemplate('button_link', 'templates/toj_homepage_buttons.php');
                                    $loopedArea->display($c);
                                    echo '</div>';
                                endfor; ?>
                            </div>

                            <?php Loader::packageElement('partials/recent_news', 'toj'); ?>

                            <a id="green-init" href="<?php echo $this->url('/services/environmental-initiatives'); ?>">
                                <span><i class="fa fa-leaf"></i> Energy and Carbon Emissions Initiatives</span>
                                <p>The Town of Jackson strives to save energy and cut carbon emissions wherever possible. Learn more about our solar panels, alternative fuel vehicles, electronic charging stations and other initiatives here.</p>
                            </a>

                            <div id="slide-facts">
                                <a href="http://townofjackson.com/government/slide-facts/">
                                    <img src="<?php echo TOJ_IMAGES_URL; ?>JHSlideFactsLogo_black.png" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php Loader::packageElement('theme/footer', 'toj', array('c' => $c)); ?>
        </div>
    </div>

<?php Loader::packageElement('theme/site_settings', 'toj'); ?>
<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>