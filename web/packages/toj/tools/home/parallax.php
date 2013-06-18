<?php sleep(1); // ghetto simulate network latency
    $c = Page::getByID(1);
?>
<div id="parallax-L1" class="fullHeight">
    <!-- background container -->
    <div id="panorama" class="backStretch anchorLeft"></div>
    <div id="gradientOverlay"></div>

    <!-- pages -->
    <div id="parallaxPanels" class="fullHeight clearfix">

        <div class="panel active fullHeight">
            <div class="inner">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="span12">
                            <h1 class="centerize">Explore The Wild Outdoors<small>The Pinnacle Of North American Adventure</small></h1>
                        </div>
                    </div>
                </div>

                <div class="dark container-fluid">
                    <div class="row-fluid">
                        <div class="span4">
                            <?php $a = new Area('Home Panel 1, Left'); $a->display($c); ?>
                        </div>
                        <div class="span8">
                            <?php $a = new Area('Home Panel 1, Right'); $a->display($c); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel active fullHeight">
            <div class="inner">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="span12">
                            <h1 class="centerize">Endless Family Adventure<small>The Pinnacle Of North American Adventure</small></h1>
                        </div>
                    </div>
                </div>

                <div class="dark container-fluid">
                    <div class="row-fluid">
                        <div class="span4">
                            <?php $a = new Area('Home Panel 2, Left'); $a->display($c); ?>
                        </div>
                        <div class="span8">
                            <?php $a = new Area('Home Panel 2, Right'); $a->display($c); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel fullHeight">
            this is the third panel
        </div>

        <div class="panel fullHeight">
            this is the fourth panel
        </div>
    </div>

    <!-- scroll controls -->
    <a class="control left"><i class="icon-angle-left"></i></a>
    <a class="control right"><i class="icon-angle-right"></i></a>

    <!-- close -->
    <a class="closer"><i class="icon-remove-sign icon-2x"></i></a>
</div>