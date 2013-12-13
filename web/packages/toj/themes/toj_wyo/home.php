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
        }else{ ?>
            <div class="working"><i class="fa fa-refresh fa-spin"></i></div>
        <?php } ?>
    </div>

    <div id="sidebarRight" class="sidebars" data-load="<?php echo TOJ_TOOLS_URL; ?>sidebar_right">
        <?php if( Page::getCurrentPage()->isEditMode() ){
            Loader::packageElement('partials/sidebar_right', 'toj', array('c' => $c));
        }else{ ?>
            <div class="working"><i class="fa fa-refresh fa-spin"></i></div>
        <?php } ?>
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
                                    <h1>Town Of Jackson, Wyoming
                                        <small><?php echo Page::getCurrentPage()->getCollectionDescription(); ?></small>
                                        <img class="img-responsive pull-left" src="<?php echo TOJ_IMAGES_URL; ?>toj_logo.png" />
                                    </h1>
                                </div>
                            </div>


                            <div id="homeSearch" class="row">
                                <div class="col-sm-12">
                                    <div class="inner">
                                        <form method="get" action="<?php echo $this->url('search'); ?>">
                                            <input name="query" id="googleSearchInput" type="text" class="form-control input-lg" placeholder="Site Search" />
                                            <i class="fa fa-search"></i>
                                            <button type="submit" id="googleSearchButton" class="btn btn-info btn-lg">Search</button>
                                            <input name="search_paths[]" type="hidden" value="">
                                        </form>

                                        <!--<gcse:searchresults-only></gcse:searchresults-only>-->
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

                            <?php Loader::packageElement('partials/recent_news', 'toj'); ?>

                        </div>
                    </div>
                </div>
            </div>

            <?php Loader::packageElement('theme/footer', 'toj', array('c' => $c)); ?>
        </div>
    </div>

<?php Loader::packageElement('theme/site_settings', 'toj'); ?>

<!-- google custom search loader -->
<script>
    /*(function() {
        var cx = '011694434224589997737:sbj5ayzj2fe';
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
        var _timeOut;
        var _contain = function(){ return (_containment = typeof _containment === 'undefined' ? document.querySelector('[id*=gcse]') : _containment); };
        var _gapi    = function(){ return (_googleApi = typeof _googleApi === 'undefined' ? google.search.cse.element.getElement('searchresults-only0') : _googleApi); };

        if( ! Modernizr.touch ){
            function typeDelay( _api, _keyEvent ){
                return setTimeout(function(){
                    _api.execute( _keyEvent.target.value );
                }, 275);
            }
            document.getElementById('googleSearchInput').onkeyup = function( keyEvent ){
                clearTimeout(_timeOut);
                if( typeof(_gapi()) !== 'undefined' ){
                    _contain().style.display = 'block';
                    _timeOut = typeDelay( _gapi(), keyEvent );
                }
            };
        }else{
            document.getElementById('googleSearchButton').onclick = function(){
                _contain().style.display = 'block';
                _gapi().execute( document.getElementById('googleSearchInput').value );
            }
        }
    })();*/
</script>
<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>