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

            <div class="container-fluid">

                <div class="row-fluid hidden-phone">
                    <div class="span12">
                        <h1 class="centerize">Town Of Jackson, Wyoming<small>The Last Of The Wild, Wild West</small></h1>
                        <a id="launchParallax">
                            <img src="<?php echo TOJ_IMAGES_URL; ?>explore.svg" />
                        </a>
                    </div>
                </div>

                <div class="row-fluid hidden-phone">
                    <div class="span10 offset1">
                        <div id="homeSearch">
                            <i class="icon-search"></i>
                            <input type="text" class="search-query input-block-level" placeholder="Search" />
                            <button class="btn btn-info btn-large">Search</button>
                        </div>
                    </div>
                </div>

                <div id="introLinks" class="row-fluid">
                    <div class="span12">
                        <ul class="unstyled">
                            <?php for($i = 1; $i <= 8; $i++): ?>
                                <li><?php
                                    $loopedArea = new Area("Home Buttons $i");
                                    $loopedArea->setBlockLimit(1);
                                    $loopedArea->setCustomTemplate('button_link', 'templates/toj_homepage_buttons.php');
                                    $loopedArea->display($c);
                                    ?>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span10 offset1">
                        <?php $a = new Area('Homepage Content'); $a->display($c); ?>
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