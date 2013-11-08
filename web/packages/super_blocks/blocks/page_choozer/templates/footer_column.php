<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

    <div class="resources">
        <a class="blockName" data-toggle="collapse" data-target="#footer-list-<?php echo $this->controller->bID; ?>">
            <?php echo $this->getBlockObject()->getBlockName(); ?>
        </a>
        <ul id="footer-list-<?php echo $this->controller->bID; ?>" class="list-unstyled collapse">
            <?php foreach( $pageCollection AS $pageObj ){
                // determine link URL
                $url = ($pageObj->isExternalLink()) ?
                    $pageObj->getCollectionPointerExternalLink() : $this->url( $pageObj->getCollectionPath() );
                // determine window target
                $target = ($pageObj->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : '_self';
                ?>
                <li><a href="<?php echo $url; ?>" target="<?php echo $target; ?>"><?php echo $pageObj->getCollectionName(); ?></a></li>
            <?php } ?>
        </ul>
    </div>