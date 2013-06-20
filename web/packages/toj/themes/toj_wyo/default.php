<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>

    <!-- ****************************** HEY YOU! *******************************
        Enjoy checking out what's under the hood? You're probably a nerd, and we
        love nerds... so we should talk. http://focus-43.com
    ************************************************************************ -->

    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>
    <?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
    <?php Loader::packageElement('modernizr', 'toj'); ?>
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

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>