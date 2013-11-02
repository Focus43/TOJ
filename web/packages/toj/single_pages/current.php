<style>
    /* CSS TRANSITION ANIMATIONS */
    .news-grid {
        -webkit-transition-duration: 0.2s;
        -moz-transition-duration: 0.2s;
        -ms-transition-duration: 0.2s;
        -o-transition-duration: 0.2s;
        transition-duration: 0.2s;
    }

    .news-grid {
        -webkit-transition-property: height, width;
        -moz-transition-property: height, width;
        -ms-transition-property: height, width;
        -o-transition-property: height, width;
        transition-property: height, width;
    }

    /*.news-grid .list-group-item {
        -webkit-transition-property: left, right, top;
        -moz-transition-property: left, right, top;
        -ms-transition-property: left, right, top;
        -o-transition-property: left, right, top;
        transition-property: left, right, top;
    }*/
</style>

<div id="cCurrent" class="row">
    <!-- inner sidebar -->
    <div id="currentSidebar" class="col-sm-3 col-sm-push-9">
        <!--<ul class="list-group">
            <li class="list-group-item text-danger"><span class="label label-danger"><?php echo count($criticals); ?></span> Critical Alerts</li>
            <li class="list-group-item text-warning"><span class="label label-warning"><?php echo count($warnings); ?></span> Warnings</li>
        </ul>-->
        <div class="alertGroup">
            <?php if( count($criticals) || count($warnings) ): ?>
                <?php foreach($criticals AS $criticalPageObj): /** @var Page $pageObj */ ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-warning"></i> <a class="alert-link" href="<?php echo $this->url( $criticalPageObj->getCollectionPath() ); ?>"><?php echo $criticalPageObj->getCollectionName(); ?></a>
                    </div>
                <?php endforeach; ?>
                <?php foreach($warnings AS $warningPageObj): /** @var Page $pageObj */ ?>
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-warning"></i> <a class="alert-link" href="<?php echo $this->url( $warningPageObj->getCollectionPath() ); ?>"><?php echo $warningPageObj->getCollectionName(); ?></a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-check-circle"></i> No warnings or critical alerts are currently issued.
                </div>
            <? endif; ?>
        </div>
    </div>

    <!-- content area -->
    <div id="currentMain" class="col-sm-9 col-sm-pull-3">
        <div id="postList" class="panel panel-default">
            <div class="panel-heading">
                <div class="btn-group pull-right">
                    <button type="button" data-view="list" class="btn btn-default active"><i class="fa fa-reorder"></i> List</button>
                    <button type="button" data-view="grid" class="btn btn-default"><i class="fa fa-th"></i> Grid</button>
                </div>
                <h2>Latest News Articles</h2>
            </div>

            <div class="list-group">
                <?php foreach($newsPages AS $pageObj):
                    Loader::packageElement('partials/news_item', 'toj', array('pageObj' => $pageObj));
                endforeach; ?>
            </div>

            <div class="panel-footer">
                <button id="btnLoadMore" data-src="<?php echo $this->action('load_more'); ?>" class="btn btn-info btn-block">
                    <i class="fa fa-retweet"></i> Load More
                </button>
            </div>
        </div>
    </div>
</div>