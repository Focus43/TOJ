<div id="primaryNav" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a data-href="<?php echo View::url('current'); ?>" class="status-alert-icon">
            <i class="fa fa-spinner fa-spin"></i>
        </a>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navCollapseTarget">
            <span class="sr-only">Toggle navigation</span>
            <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand" href="<?php echo $this->url('/'); ?>"><?php echo SITE; ?>
            <img class="img-responsive" src="<?php echo TOJ_IMAGES_URL; ?>toj_logo_borderless.png" />
        </a>
    </div>

    <div id="navCollapseTarget" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
            <?php
            $pageList = new PageList();
            $pageList->filterByParentID(1);
            $pageList->filterByAttribute('exclude_nav', 1, '!=');
            $pageList->sortByDisplayOrder();
            $pages = $pageList->get();

            foreach($pages AS $pageObj): ?>
                <li>
                    <a class="level-1" href="<?php echo $this->url( $pageObj->getCollectionPath() ); ?>"><?php echo $pageObj->getCollectionName(); ?></a>
                    <div class="subMenu">
                        <div class="menuInner">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="well well-sm">
                                        <?php $a = new GlobalArea("{$pageObj->getCollectionName()} Menu Left"); $a->display($c); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <?php $a = new GlobalArea("{$pageObj->getCollectionName()} Menu Right"); $a->display($c); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>

            <!-- news and current -->
            <li class="newsAndCurrent">
                <a class="level-1" href="<?php echo $this->url('/current'); ?>"><span class="status-alert-icon"><i class="fa fa-spinner fa-spin"></i></span>&nbsp; News &amp; Current</a>
                <div class="subMenu">
                    <div class="menuInner">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- replaced via ajax -->
                                <h5 class="updating"><i class="fa fa-spinner fa-spin"></i> Checking for alert updates...</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="list-unstyled">
                                    <?php
                                    $textHelper = Loader::helper('text');
                                    $newsPosts = new TojNewsPageList;
                                    $newsPosts->sortByPublicDateDescending();
                                    $results   = $newsPosts->get(3);
                                    foreach($results AS $pageObj): /** @var Page $pageObj */ ?>
                                        <li>
                                            <a href="<?php echo View::url( $pageObj->getCollectionPath() ); ?>">
                                                <h5><?php echo $pageObj->getCollectionName(); ?></h5>
                                                <span><?php echo $textHelper->shortenTextWord( $pageObj->getCollectionDescription(), 100 ); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <a href="<?php echo $this->url('/current'); ?>" class="btn btn-info btn-block">More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <!-- accessibility settings -->
            <li><a id="openSettings"><i class="fa fa-cogs"></i></a></li>
        </ul>
    </div>
</div>

<?php if( $c->isEditMode() ): ?>
    <script type="text/javascript">
        // to make hover menus stay open while in edit mode for CMS admins
        $(function(){
            $('#primaryNav a.level-1').on('click', function(_clickEvent){
                _clickEvent.preventDefault(); // prevent from following
                $(this).parent('li').toggleClass('sticky');
            });
        });
    </script>
<?php endif; ?>
