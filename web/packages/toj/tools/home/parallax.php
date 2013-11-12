<?php defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getByID(1); $panelCount = 7; ?>
<div id="parallaxL1" class="fullHeight">
    <!-- background container -->
    <div id="panorama" class="backStretch anchorLeft"></div>
    <div id="gradientOverlay"></div>

    <!-- pages -->
    <div id="parallaxSections" class="fullHeight clearfix">
        <?php for($i = 1; $i <= $panelCount; $i++): ?>
            <div class="section fullHeight <?php echo $i === 1 ? 'active' : ''; ?>">
                <div class="inner">
                    <div class="containment">
                        <div class="sectionTitle row">
                            <div class="col-md-12">
                                <?php $a = new Area("Parallax Header {$i}"); $a->setBlockLimit(1); $a->display($c); ?>
                            </div>
                        </div>
                        <div class="sectionContent row">
                            <div class="col-md-12">
                                <div class="opaque">
                                    <div class="scrollme">
                                        <?php $a = new Area("Parallax Content {$i}"); $a->display($c); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>

    <!-- scroll controls -->
    <a class="control left"><i class="fa fa-angle-left"></i></a>
    <a class="control right"><i class="fa fa-angle-right"></i></a>

    <!-- close -->
    <a class="closer"><i class="fa fa-times fa-2x"></i></a>
</div>