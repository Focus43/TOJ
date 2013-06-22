<?php $textHelper = Loader::helper('text'); ?>

<div id="alertSection" class="well">
    <span id="importantAlerts">News <span class="hidden-sidebar hidden-phone">&amp; Current Events</span></span>
    <div id="alertRotation">
        <ol class="unstyled">
            <?php foreach( $pages AS $pageObj ):
                    $labelClass = 'label-default';
                    $alertLevel = $pageObj->getAttribute('alert_level');
                    if( $alertLevel == 'Warning' ){ $labelClass = 'label-warning'; }
                    if( $alertLevel == 'Extreme' ){ $labelClass = 'label-important'; }
                ?>
                <li>
                    <a href="<?php echo View::url( $pageObj->getCollectionPath() ); ?>">
                        <span class="label <?php echo $labelClass; ?>"><?php echo $pageObj->getCollectionDatePublic('M d, Y'); ?></span>
                        <?php echo $textHelper->entities( $textHelper->shortenTextWord($pageObj->getCollectionDescription(), 75) ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
    <h4 class="centerize">View More &nbsp;<i class="icon-arrow-right"></i></h4>
</div>