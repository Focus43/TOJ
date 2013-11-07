<?php defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getByID(1); $panelCount = 7; ?>
<div id="parallaxL1" class="fullHeight">
    <!-- background container -->
    <div id="panorama" class="backStretch anchorLeft"></div>
    <div id="gradientOverlay"></div>

    <!-- pages -->
    <div id="parallaxSections" class="fullHeight clearfix">
        <?php for($i = 1; $i <= $panelCount; $i++): ?>
            <div class="section <?php echo $i === 1 ? 'active' : ''; ?>">
                <div class="inner">
                    <div class="row">
                        <div class="col-md-12">
                            <?php $a = new Area("Parallax Header {$i}"); $a->display($c); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="opaque col-md-12">
                            <?php $a = new Area("Parallax Content {$i}"); $a->display($c); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>

        <!--<div class="panel active fullHeight">
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
                            <?php// $a = new Area('Home Panel 2, Left'); $a->display($c); ?>
                        </div>
                        <div class="span8">
                            <?php// $a = new Area('Home Panel 2, Right'); $a->display($c); ?>
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
        </div>-->
    </div>

    <!-- scroll controls -->
    <a class="control left"><i class="fa fa-angle-left"></i></a>
    <a class="control right"><i class="fa fa-angle-right"></i></a>

    <!-- close -->
    <a class="closer"><i class="fa fa-times fa-2x"></i></a>
</div>