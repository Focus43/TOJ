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

<body class="toj <?php echo $bodyClass; ?>">
    
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
            <div id="homeScreen" class="backStretch" data-background="<?php echo $backgroundImage; ?>">
                <?php Loader::packageElement('partials/primary_navigation', 'toj', array('c' => $c)); ?>
                <div class="container-fluid">
                    <div class="row-fluid hidden-phone">
                        <div class="span12">
                            <h1 class="centerize">Town Of Jackson, Wyoming<small>The Last Of The Wild, Wild West</small></h1>
                            <a id="launchParallax"><img src="<?php echo TOJ_IMAGES_URL; ?>explore.svg" /></a>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span10 offset1">
                            <div id="homeSearch">
                                <i class="icon-search"></i>
                                <input type="text" class="search-query input-block-level" placeholder="Search &amp; Explore" />
                                <button class="btn btn-info btn-large">Search</button>
                            </div>
                        </div>
                    </div>
                    <div id="introLinks" class="row-fluid">
                        <div class="span12">
                            <ul class="unstyled">
                                <li><a><i class="icon-file-alt"></i> <span>Agendas &amp;<br />Minutes</span></a></li>
                                <li><a><i class="icon-calendar"></i> <span>Event<br />Calendar</span></a></li>
                                <li><a><i class="icon-road"></i> <span>Jackson<br />Police</span></a></li>
                                <li><a><i class="icon-warning-sign"></i> <span>Important<br />Alerts</span></a></li>
                                <li><a><i class="icon-bullhorn"></i> <span>Report An<br />Issue</span></a></li>
                                <li><a><i class="icon-facetime-video"></i> <span>Watch A<br />Meeting</span></a></li>
                                <li><a><i class="icon-money"></i> <span>Pay Bill<br />Or Ticket</span></a></li>
                                <li><a><i class="icon-copy"></i> <span>Permits &<br />Applications</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span10 offset1">
                            <div id="alertSection" class="well">
                                <span id="importantAlerts">News <span class="hidden-phone">&amp; Current Events</span></span>
                                <!--<ul class="unstyled clearfix hidden-phone">
                                    <li><span class="badge badge-important">0</span> Critical Alert(s)</li>
                                    <li><span class="badge badge-warning">1</span> Moderate Alert(s)</li>
                                    <li><span class="badge badge-success">4</span> General Announcements</li>
                                </ul>-->
                                <div id="alertRotation">
                                    <ol class="unstyled">
                                        <li><span class="label label-warning">May 29, 2013</span> Teton County Elects New Chair of the Sheriff's Department</li>
                                        <li><span class="label label-success">May 29, 2013</span> This is a second piece of news that would show up...</li>
                                        <li><span class="label label-info">May 29, 2013</span> And this is an example of a different color label for the date</li>
                                    </ol>
                                </div>
                                <h4 class="centerize">View More Recent News &nbsp;<i class="icon-arrow-right"></i></h4>
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