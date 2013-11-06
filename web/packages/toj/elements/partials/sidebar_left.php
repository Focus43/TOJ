<div class="inner">
    <div id="sidebarWeather" class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Weather: Jackson, WY</h3>
        </div>
        <div class="panel-body">
            <!-- weather data -->
        </div>
    </div>

    <?php
        $newsList = new TojNewsPageList;
        $newsList->filterByNewsPostsOnly();
        $newsList->sortByPublicDateDescending();
        $results = $newsList->get(5);
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Recent News</h3>
        </div>
        <ul class="list-group">
            <?php foreach($results AS $pageObj){ /** @var Page $pageObj */ ?>
                <li class="list-group-item">
                    <span class="badge"><?php echo $pageObj->getCollectionDatePublic('M d') ?></span>
                    <a href="<?php echo View::url($pageObj->getCollectionPath()); ?>"><?php echo $pageObj->getCollectionName(); ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>

    <?php $a = new GlobalArea('Global Left'); $a->display($c); ?>
</div>