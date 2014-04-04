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

            <div id="cL3">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="cL4">

                            <!-- actual page content -->
                            <div id="cPageContent">
                                <div class="unpad-lg">
                                    <div id="areaTop" class="row">
                                        <div class="col-sm-12">
                                            <?php
                                                // editable area *above* navigation
                                                $a = new Area('Top Area'); $a->display($c);

                                                // automatic navigation for agencies
                                                $bt = BlockType::getByHandle('autonav');
                                                $bt->controller->orderBy                 = 'display_asc';
                                                $bt->controller->displayPages 			 = 'third_level';
                                                $bt->controller->displaySubPages 		 = 'all';
                                                $bt->controller->displaySubPageLevels 	 = 'custom';
                                                $bt->controller->displaySubPageLevelsNum = 1;
                                                $bt->render('templates/agency_subnav');
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="body-content unpad-lg">
                                    <div class="tabular">
                                        <!-- left column page content -->
                                        <div class="left cellular">
                                            <div class="column-content">
                                                <?php $a = new Area('Left Content'); $a->display($c); ?>
                                            </div>
                                            <div class="column-content-viewing-posts">
                                                <button class="btn btn-info toggle-posts minimize">Back To Page <i class="fa fa-angle-right"></i></button>
                                            </div>
                                        </div>

                                        <!-- right column -->
                                        <div class="right cellular">
                                            <div class="column-content">
                                                <?php $a = new Area('Right Content'); $a->display($c); ?>

                                                <div id="deptPostsContainer" class="panel panel-default" data-deptid="<?php echo $departmentRootID; ?>" data-deptpath="<?php echo $departmentRootPath; ?>">
                                                    <div class="panel-heading">
                                                        <h3>Department Posts</h3>
                                                    </div>
                                                    <div class="list-group">
                                                        <?php foreach($recentNews AS $pageObj){ /** @var $pageObj Page */
                                                            Loader::packageElement('partials/department_post', 'toj', array(
                                                                'pageObj' => $pageObj
                                                            ));
                                                        } ?>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <a class="toggle-posts expand"><i class="fa fa-plus-circle"></i> Expand</a>
                                                        <a class="toggle-posts view-more"><i class="fa fa-plus-circle"></i> Load More</a>
                                                    </div>
                                                </div>

                                                <?php //$a = new Area('Right Content'); $a->display($c); ?>
                                            </div>
                                        </div>
                                    </div>
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

<?php Loader::packageElement('theme/site_settings', 'toj'); ?>
<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>