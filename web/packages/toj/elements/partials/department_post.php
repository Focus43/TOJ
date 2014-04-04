<?php /** @var $pageObj Page */ ?>
<a class="list-group-item" href="<?php echo View::url($pageObj->getCollectionPath()); ?>">
    <h5><?php echo $pageObj->getCollectionName(); ?></h5>
    <span><?php echo $pageObj->getCollectionDescription(); ?></span>
</a>