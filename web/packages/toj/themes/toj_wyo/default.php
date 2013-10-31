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
        <span id="pageBackgroundImage">
            <span class="backStretch" data-background="<?php echo $backgroundImage; ?>"></span>
        </span>

        <div id="cL2">
            <?php Loader::packageElement('partials/primary_navigation', 'toj', array('c' => $c)); ?>

            <div id="cL3">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="cBodyContent">

                            <!-- actual page content -->
                            <div class="whiteContainer">
                                <?php Loader::packageElement('partials/landing_page_header', 'toj'); ?>
                                <div class="row">
                                    <div class="containerSidebar col-sm-3">
                                        <?php
                                        $bt = BlockType::getByHandle('autonav');
                                        $bt->controller->orderBy                = 'display_asc';
                                        $bt->controller->displayPages 			= 'second_level';
                                        $bt->controller->displaySubPages 		= 'none';
                                        $bt->controller->displaySubPageLevels 	= 'enough';
                                        $bt->render('templates/sidebar');

                                        $a = new Area('Sidebar Content'); $a->display($c);
                                        ?>
                                    </div>
                                    <div class="col-sm-9">
                                        <?php $a = new Area('Page Content'); $a->display($c); ?>
                                    </div>
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