<div id="primaryNav" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarLinks">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand"><?php echo SITE; ?></a>
    </div>

    <div id="navbarLinks" class="collapse navbar-collapse">
        <!--<ul class="nav navbar-nav navbar-right">
            <li><a href="#">Link</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                </ul>
            </li>
        </ul>-->

        <ul class="nav navbar-nav navbar-right">
            <?php
            $pageList = new PageList();
            $pageList->filterByParentID(1);
            $pageList->filterByAttribute('exclude_nav', 1, '!=');
            $pageList->sortByDisplayOrder();
            $pages = $pageList->get();

            foreach($pages AS $pageObj): ?>
                <li><a class="level-1" href="<?php echo $this->url( $pageObj->getCollectionPath() ); ?>"><?php echo $pageObj->getCollectionName(); ?></a>
                    <div class="subMenu">
                        <div class="container-fluid">
                            <div class="row-fluid">
                                <div class="span6">
                                    <?php $a = new GlobalArea("{$pageObj->getCollectionName()} Menu Left"); $a->display($c); ?>
                                </div>
                                <div class="span6">
                                    <?php $a = new GlobalArea("{$pageObj->getCollectionName()} Menu Right"); $a->display($c); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>

            <li class="hidden-phone"><a class="level-1"><i class="icon-warning-sign" style="color:#66CC00;"></i> Timely Info.</a>
                <div class="subMenu">
                    <?php $a = new GlobalArea('Nav Menu 5'); $a->display($c); ?>
                </div>
            </li>
            <li><a id="openSettings" data-toggle="collapse" data-target=".nav-collapse"><i class="icon-cogs"></i></a></li>
        </ul>
    </div>

    <!--<div class="navbar-inner">
        <div class="container">
            <a class="brand" href="<?php echo $this->url('/'); ?>">Town Of Jackson</a>
            <a class="btn btn-navbar" data-toggle="collapse" data-target="#responsivePrimaryNav">
                <span><span class="hidden-phone">Navigation</span> <i class="icon-reorder"></i></span>
            </a>
            <a class="btn btn-navbar visible-phone">
                <span><i class="icon-warning-sign" style="color:#66CC00;"></i></span>
            </a>
            <div id="responsivePrimaryNav" class="nav-collapse collapse">
                <ul id="primaryNavList" class="nav pull-right">
                    <?php
                        $pageList = new PageList();
                        $pageList->filterByParentID(1);
                        $pageList->filterByAttribute('exclude_nav', 1, '!=');
                        $pageList->sortByDisplayOrder();
                        $pages = $pageList->get();

                        foreach($pages AS $pageObj): ?>
                            <li><a class="level-1" href="<?php echo $this->url( $pageObj->getCollectionPath() ); ?>"><?php echo $pageObj->getCollectionName(); ?></a>
                                <div class="subMenu">
                                    <div class="container-fluid">
                                        <div class="row-fluid">
                                            <div class="span6">
                                                <?php $a = new GlobalArea("{$pageObj->getCollectionName()} Menu Left"); $a->display($c); ?>
                                            </div>
                                            <div class="span6">
                                                <?php $a = new GlobalArea("{$pageObj->getCollectionName()} Menu Right"); $a->display($c); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                    <?php endforeach; ?>

                    <li class="hidden-phone"><a class="level-1"><i class="icon-warning-sign" style="color:#66CC00;"></i> Timely Info.</a>
                        <div class="subMenu">
                            <?php $a = new GlobalArea('Nav Menu 5'); $a->display($c); ?>
                        </div>
                    </li>
                    <li><a id="openSettings" data-toggle="collapse" data-target=".nav-collapse"><i class="icon-cogs"></i></a></li>
                </ul>
            </div>
        </div>
    </div>-->
</div>

<?php if( $c->isEditMode() ): ?>
    <!--<script type="text/javascript">
        // to make hover menus easily editable...
        $(function(){
            $('li > a', '#primaryNavList').on('click', function(_clickEvent){
                _clickEvent.preventDefault(); // prevent from following
                $(this).parent('li').toggleClass('persist');
            });
        });
    </script>-->
<?php endif; ?>
