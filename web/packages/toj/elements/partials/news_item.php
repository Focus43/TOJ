<a class="list-group-item" href="<?php echo View::url( $pageObj->getCollectionPath() ); ?>">
    <h4 class="lead"><?php echo $pageObj->getCollectionName(); ?> <small><?php echo $pageObj->getCollectionDatePublic('M d, Y'); ?></small></h4>
    <span><?php echo $pageObj->getCollectionDescription(); ?></span>
    <?php if((bool)$pageObj->getAttribute('pin_top')): ?>
        <i class="fa fa-thumb-tack"></i>
    <?php endif; ?>
</a>