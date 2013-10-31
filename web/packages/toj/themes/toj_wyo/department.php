<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
<?php Loader::packageElement('partials/head_tag_inner', 'toj'); ?>
<?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
</head>

<body class="toj landing agency-page <?php echo $bodyClass; ?>">

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
                            <div class="whiteContainer">
                                <?php Loader::packageElement('partials/landing_page_header', 'toj'); ?>
                                <div id="areaTop" class="row">
                                    <div class="col-sm-12">
                                        <?php $a = new Area('Top Area'); $a->setCustomTemplate('autonav', 'agency_subnav.php'); $a->display($c); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <?php $a = new Area('Left Content'); $a->display($c); ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <?php $a = new Area('Right Content'); $a->display($c); ?>
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