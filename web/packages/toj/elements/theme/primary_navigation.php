<div id="primaryNav" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarLinks">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo $this->url('/'); ?>"><?php echo SITE; ?></a>
    </div>

    <div id="navbarLinks" class="collapse navbar-collapse">
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
                        <div class="container">
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

            <li>
                <a class="level-1" href="<?php echo $this->url('/current'); ?>"><i class="fa fa-spinner fa-spin"></i>&nbsp; News &amp; Current</a>
                <div class="subMenu">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="well well-sm">
                                    <?php
                                        $newsPosts = new TojNewsPageList;
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-6">

                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <li>
                <a id="openSettings" data-toggle="collapse" data-target=".nav-collapse"><i class="fa fa-cogs"></i></a>
            </li>
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
