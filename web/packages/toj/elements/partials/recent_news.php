<?php
$newsList = new TojNewsPageList;
$newsList->filterByNewsPostsOnly();
$newsList->sortByPublicDateDescending();
$results = $newsList->get(5);
?>

<div class="recentNews panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title clearfix">Recent News <a class="read-more" href="<?php echo View::url('current'); ?>"><i class="fa fa-plus-square-o"></i> &nbsp;View All</a></h3>
    </div>
    <ul class="list-group">
        <?php foreach($results AS $pageObj){ /** @var Page $pageObj */ ?>
            <li class="list-group-item">
                <span class="badge"><?php echo $pageObj->getCollectionDatePublic('M d'); ?></span>
                <a href="<?php echo View::url($pageObj->getCollectionPath()); ?>"><?php echo $pageObj->getCollectionName(); ?></a>
            </li>
        <?php } ?>
    </ul>
</div>