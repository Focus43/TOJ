<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $this->getBlockObject()->getBlockName(); ?></h3>
        </div>
        <ul class="list-group">

            <?php foreach( $pageCollection AS $pageObj ){
                // determine link URL
                $url = ($pageObj->isExternalLink()) ?
                    $pageObj->getCollectionPointerExternalLink()
                    : $this->url( $pageObj->getCollectionPath() );
                // determine window target
                $target = ($pageObj->openCollectionPointerExternalLinkInNewWindow()) ?
                    '_blank' : '_self';
                ?>
                <li class="list-group-item"><a href="<?php echo $url; ?>" target="<?php echo $target; ?>"><?php echo $pageObj->getCollectionName(); ?> <i class="icon-angle-right"></i></a></li>
            <?php } ?>
        </ul>
    </div>