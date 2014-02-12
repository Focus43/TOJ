<?php
$newsList = new TojNewsPageList;
$results = $newsList->get(5);
?>

<div class="recentNews panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title clearfix">Recent Posts <a class="read-more" href="<?php echo View::url('current'); ?>"><i class="fa fa-plus-square-o"></i> &nbsp;View All</a></h3>
    </div>
    <ul class="list-group">
        <?php foreach($results AS $pageObj){ /** @var Page $pageObj */
            $badgeClasses = array('badge');
            if( (bool) $pageObj->getAttribute('alert_warning') ){ array_push($badgeClasses, 'warning'); }
            if( (bool) $pageObj->getAttribute('alert_critical') ){ array_push($badgeClasses, 'critical'); }
            ?>
            <li class="list-group-item">
                <span class="<?php echo join(' ', $badgeClasses); ?>"><?php echo $pageObj->getCollectionDatePublic('M d'); ?></span>
                <a href="<?php echo View::url($pageObj->getCollectionPath()); ?>"><?php echo $pageObj->getCollectionName(); ?></a>
                <?php if((bool)$pageObj->getAttribute('pin_top')): ?>
                    <i class="fa fa-thumb-tack"></i>
                <?php endif; ?>
            </li>
        <?php } ?>
    </ul>
</div>