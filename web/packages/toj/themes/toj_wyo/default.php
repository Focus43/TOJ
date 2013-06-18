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
                        <div class="row-fluid">
                            <div class="span12">
                                <ul id="breadcrumbs" class="unstyled clearfix">
                                    <li><a>Home</a></li>
                                    <li><a>Government</a></li>
                                    <li style="background:none;"><a>Agency Listing</a></li>
                                    <li class="hidden-phone" style="float:right;font-size:1.4em;padding-top:.4em;">
                                        <i class="icon-facebook-sign"></i><i class="icon-twitter-sign"></i><i class="icon-google-plus-sign"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12">
                                <h1>Government Agency Listings</h1>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span3">
                                <div class="well" style="padding:8px 0;">
                                    <ul class="nav nav-list">
                                        <li class="nav-header">Government</li>
                                        <li class="active"><a>Mayor &amp; Town Council</a></li>
                                        <li><a>Boards &amp; Committees</a></li>
                                        <li><a>Department Listings</a></li>
                                        <li><a>Development Regulations &amp; Comprehensive Plan</a></li>
                                        <li><a>Job Opportunities</a></li>
                                        <li><a>Meeting Minutes</a></li>
                                        <li><a>Meeting Agenda</a></li>
                                        <li><a>Municipal Court</a></li>
                                        <li><a>Municipal Code</a></li>
                                        <li><a>Open Bids &amp; RFPs</a></li>
                                        <li><a>Ordinances &amp; Resolutions</a></li>
                                    </ul>
                                </div>
                                <?php $a = new Area('Sidebar Content'); $a->display($c); ?>
                            </div>
                            <div class="span9">
                                <?php $a = new Area('Page Content'); $a->display($c); ?>
                                <?php/* for($i = 1; $i <= 26; $i++): ?>
                                    <h2>test</h2>
                                <?php endfor;*/ ?>
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