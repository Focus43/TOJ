<div id="primaryNav" class="navbar navbar-inverse">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="<?php echo $this->url('/'); ?>">Town Of Jackson</a>
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span><span class="hidden-phone">Navigation</span> <i class="icon-reorder"></i></span>
            </a>
            <div class="nav-collapse collapse">
                <ul id="primaryNavList" class="nav pull-right">
                    <?php
                        $pageList = new PageList();
                        $pageList->filterByParentID(1);
                        $pageList->filterByAttribute('exclude_nav', 1, '!=');
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

                    <li><a class="level-1"><i class="icon-warning-sign" style="color:#66CC00;"></i> Timely Info.</a>
                        <div class="subMenu">
                            <?php $a = new GlobalArea('Nav Menu 5'); $a->display($c); ?>
                        </div>
                    </li>
                    <li><a><i class="icon-cogs" style="color:#999;"></i><!--<i class="icon-facebook-sign"></i><i class="icon-twitter-sign"></i><i class="icon-google-plus-sign"></i>--></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php if( $c->isEditMode() ): ?>
    <script type="text/javascript">
        // to make hover menus easily editable...
        $(function(){
            $('li > a', '#primaryNavList').on('click', function(_clickEvent){
                _clickEvent.preventDefault(); // prevent from following
                $(this).parent('li').toggleClass('persist');
            });
        });
    </script>
<?php endif; ?>
