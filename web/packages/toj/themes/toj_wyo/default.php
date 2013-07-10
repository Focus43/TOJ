<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
<?php Loader::packageElement('partials/head_tag_inner', 'toj'); ?>
<?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
</head>

<body class="toj landing <?php echo $bodyClass; ?>">

    <div id="pageWrap" class="fullHeight">

        <!-- left column -->
        <div id="cLeft" data-load="<?php echo TOJ_TOOLS_URL; ?>sidebar_left">
            <!-- Loaded JIT via ajax -->
            <?php if( Page::getCurrentPage()->isEditMode() ){
                Loader::packageElement('partials/sidebar_left', 'toj', array('c' => $c));
            } ?>
        </div>

        <!-- main content -->
        <div id="cMiddle" class="fullHeight">
            <div id="biggieSmalls" class="backStretch hidden-phone" data-background="<?php echo $backgroundImage; ?>"></div>
            <?php Loader::packageElement('partials/primary_navigation', 'toj', array('c' => $c)); ?>
            <div id="cPrimary">
                <div id="cPrimaryInner">
                    <div class="container-fluid">
                        <?php Loader::packageElement('partials/landing_page_subheader', 'toj'); ?>
                        <div class="row-fluid">
                            <div class="span3">
                                <div class="well" style="padding:8px 0;">
                                    <?php
                                        $bt = BlockType::getByHandle('autonav');
                                        $bt->controller->orderBy 					= 'display_asc';
                                        $bt->controller->displayPages 				= 'second_level';
                                        $bt->controller->displaySubPages 			= 'none';
                                        $bt->controller->displaySubPageLevels 		= 'enough';
                                        $bt->render('templates/sidebar');
                                    ?>
                                </div>
                                <?php $a = new Area('Sidebar Content'); $a->display($c); ?>
                            </div>
                            <div class="span9">
                                <?php $a = new Area('Page Content'); $a->display($c); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php Loader::packageElement('partials/footer', 'toj', array('c' => $c)); ?>
        </div>

        <!-- right column -->
        <div id="cRight" data-load="<?php echo TOJ_TOOLS_URL; ?>sidebar_right">
            <!-- Loaded JIT via ajax -->
            <?php if( Page::getCurrentPage()->isEditMode() ){
                Loader::packageElement('partials/sidebar_right', 'toj', array('c' => $c));
            } ?>
        </div>
    </div>

<?php Loader::packageElement('partials/site_settings', 'toj'); ?>
<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>