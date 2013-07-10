<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
<?php Loader::packageElement('partials/head_tag_inner', 'toj'); ?>
<?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
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
                    <div class="row-fluid hidden-phone">
                        <div class="span10 offset1">
                            <div id="homeSearch">
                                <i class="icon-search"></i>
                                <input type="text" class="search-query input-block-level" placeholder="Search" />
                                <button class="btn btn-info btn-large">Search</button>
                            </div>
                            <!--<script>
                                (function() {
                                    var cx = '011694434224589997737:sbj5ayzj2fe';
                                    var gcse = document.createElement('script');
                                    gcse.type = 'text/javascript';
                                    gcse.async = true;
                                    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
                                        '//www.google.com/cse/cse.js?cx=' + cx;
                                    var s = document.getElementsByTagName('script')[0];
                                    s.parentNode.insertBefore(gcse, s);
                                })();
                            </script>
                            <gcse:search></gcse:search>-->
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
                            <?php $a = new Area('Homepage Content'); $a->display($c); ?>
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