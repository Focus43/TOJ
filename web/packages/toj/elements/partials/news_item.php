<a class="list-group-item" href="<?php echo View::url( $pageObj->getCollectionPath() ); ?>">
    <h4 class="lead"><?php echo $pageObj->getCollectionName(); ?> <small><?php echo $pageObj->getCollectionDatePublic('M d, Y'); ?></small></h4>
    <span><?php echo $pageObj->getCollectionDescription(); ?></span>
</a>