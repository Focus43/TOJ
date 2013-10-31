<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

    <ul class="list-unstyled basic-list">
        <?php foreach( $pageCollection AS $pageObj ){
            // determine link URL
            $url = ($pageObj->isExternalLink()) ?
                $pageObj->getCollectionPointerExternalLink()
                : $this->url( $pageObj->getCollectionPath() );
            // determine window target
            $target = ($pageObj->openCollectionPointerExternalLinkInNewWindow()) ?
                '_blank' : '_self';
            ?>
            <li><a href="<?php echo $url; ?>" target="<?php echo $target; ?>"><?php echo $pageObj->getCollectionName(); ?> <i class="icon-angle-right"></i></a></li>
        <?php } ?>
    </ul>