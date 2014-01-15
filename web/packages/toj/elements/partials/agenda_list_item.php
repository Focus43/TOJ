<?php /** @var Page $pageObj */ $description = $pageObj->getCollectionDescription(); ?>
<a class="list-group-item" href="<?php echo View::url( $pageObj->getCollectionPath() ); ?>">
    <span class="date">Meeting Date: <strong><?php echo $pageObj->getCollectionDatePublic('M d, Y'); ?></strong></span>
    <h4 class="lead"><?php echo $pageObj->getCollectionName(); ?></h4>
    <p><?php echo !empty($description) ? $description : 'No description available.'; ?></p>
</a>