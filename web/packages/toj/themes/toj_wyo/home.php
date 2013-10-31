<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
<?php Loader::packageElement('partials/head_tag_inner', 'toj'); ?>
<?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
</head>

<body class="<?php echo $bodyClass; ?>">

    <div id="sidebarLeft" class="sidebars" data-load="<?php echo TOJ_TOOLS_URL; ?>sidebar_left">
        <?php if( Page::getCurrentPage()->isEditMode() ){
            Loader::packageElement('partials/sidebar_left', 'toj', array('c' => $c));
        } ?>
    </div>

    <div id="sidebarRight" class="sidebars" data-load="<?php echo TOJ_TOOLS_URL; ?>sidebar_right">
        <?php if( Page::getCurrentPage()->isEditMode() ){
            Loader::packageElement('partials/sidebar_right', 'toj', array('c' => $c));
        } ?>
    </div>

    <div id="cL1">
        <span id="pageBackgroundImage" class="backStretch" data-background="<?php echo $backgroundImage; ?>"></span>

        <div id="cL2">
            <?php Loader::packageElement('partials/primary_navigation', 'toj', array('c' => $c)); ?>

            <div id="cL3">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="cBodyContent">

                            <!-- actual page content -->
                            <div id="tagLine" class="row hidden-xs">
                                <div class="col-sm-12">
                                    <h1>Town Of Jackson, Wyoming<small>The Last Of The Wild, Wild West</small></h1>
                                    <!--<a id="launchParallax">
                                        <img src="<?php echo TOJ_IMAGES_URL; ?>explore.svg" />
                                    </a>-->
                                </div>
                            </div>

                            <div id="homeSearch" class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <div class="inner">
                                        <input type="text" class="form-control input-lg" placeholder="Search" />
                                        <i class="fa fa-search"></i>
                                        <button class="btn btn-info btn-lg">Search</button>
                                    </div>
                                </div>
                            </div>

                            <div id="introLinks">
                                <?php for($i = 1; $i <= 8; $i++):
                                    $loopedArea = new Area("Home Buttons $i");
                                    $loopedArea->setBlockLimit(1);
                                    $loopedArea->setCustomTemplate('button_link', 'templates/toj_homepage_buttons.php');
                                    $loopedArea->display($c);
                                endfor; ?>
                            </div>

                            <div class="row-fluid">
                                <div class="span10 offset1">
                                    <?php $a = new Area('Homepage Content'); $a->display($c); ?>
                                </div>
                            </div>
                            <!-- end page content -->

                        </div>
                    </div>
                </div>
            </div>

            <?php Loader::packageElement('partials/footer', 'toj', array('c' => $c)); ?>
        </div>
    </div>


<?php Loader::packageElement('partials/site_settings', 'toj'); ?>
<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>