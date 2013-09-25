<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
<?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
<?php Loader::packageElement('partials/head_tag_inner', 'toj'); ?>
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
                            <div class="span12">
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