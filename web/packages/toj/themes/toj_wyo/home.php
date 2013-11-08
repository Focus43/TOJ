<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
<?php Loader::packageElement('theme/head_tag_inner', 'toj'); ?>
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
            <?php Loader::packageElement('theme/primary_navigation', 'toj', array('c' => $c)); ?>

            <!-- parallax launcher! -->
            <a id="launchParallax" class="hidden-sm hidden-xs" onclick="ExploreJackson.open();">
                <img class="img-responsive" src="<?php echo TOJ_IMAGES_URL; ?>explore_jackson.png" />
            </a>

            <div id="cL3">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="cL4">

                            <!-- actual page content -->
                            <div id="tagLine" class="hidden-xs row">
                                <div class="col-sm-12">
                                    <h1 style="position:relative;display:inline-block;margin:0 auto;text-align:left;left:65px;">
                                        Town Of Jackson, Wyoming
                                        <small><?php echo Page::getCurrentPage()->getCollectionDescription(); ?></small>
                                        <img class="img-responsive pull-left" style="width:120px;position:absolute;top:-22px;left:-130px;" src="<?php echo TOJ_IMAGES_URL; ?>toj_logo.png" />
                                    </h1>
                                </div>
                            </div>


                            <div id="homeSearch" class="row">
                                <div class="col-sm-12">
                                    <div class="inner">
                                        <input id="googleSearchInput" type="text" class="form-control input-lg" placeholder="Search (start typing)" />
                                        <i class="fa fa-search"></i>
                                        <button class="btn btn-info btn-lg">Search</button>

                                        <!-- google custom search -->
                                        <gcse:searchresults-only></gcse:searchresults-only>
                                    </div>
                                </div>
                            </div>

                            <div id="introLinks">
                                <?php for($i = 1; $i <= 8; $i++):
                                    echo '<div class="element">';
                                    $loopedArea = new Area("Home Buttons $i");
                                    $loopedArea->setBlockLimit(1);
                                    $loopedArea->setCustomTemplate('button_link', 'templates/toj_homepage_buttons.php');
                                    $loopedArea->display($c);
                                    echo '</div>';
                                endfor; ?>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <?php $a = new Area('Homepage Content'); $a->display($c); ?>
                                </div>
                            </div>
                            <!-- end page content -->

                        </div>
                    </div>
                </div>
            </div>

            <?php Loader::packageElement('theme/footer', 'toj', array('c' => $c)); ?>
        </div>
    </div>

<!-- google custom search loader -->
<script>
    (function() {
        var cx = '008919983407566295456:1bhycu9q2r8';
        var gcse = document.createElement('script');
        gcse.type = 'text/javascript';
        gcse.async = true;
        gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
            '//www.google.com/cse/cse.js?cx=' + cx;
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(gcse, s);
    })();

    // custom for TOJ; sans-jquery
    (function(){
        var _container, _googleApi, _timeOut;
        function typeDelay( _api, _keyEvent ){
            return setTimeout(function(){
                _api.execute( _keyEvent.target.value );
                _keyEvent.target.focus();
            }, 275);
        }
        document.getElementById('googleSearchInput').onkeyup = function( keyEvent ){
            keyEvent.target.focus();
            clearTimeout(_timeOut);
            _container = _container || document.querySelector('[id*=gcse]');
            _googleApi = _googleApi || google.search.cse.element.getElement('searchresults-only0');
            if( typeof(_googleApi) !== 'undefined' ){
                _container.style.display = 'block';
                _timeOut = typeDelay( _googleApi, keyEvent );
            }
        };
    })();
</script>
<?php Loader::packageElement('theme/site_settings', 'toj'); ?>
<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>