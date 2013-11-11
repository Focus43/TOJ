<?php defined('C5_EXECUTE') or die("Access Denied.");
    /** @var $eventObj SchedulizerEvent */
    $eventObj = SchedulizerEvent::getByID((int)$_REQUEST['eventID']);
?>
<div class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3><?php echo $eventObj; ?></h3>
            </div>
            <div class="modal-body">
                <?php echo $eventObj->getDescription(); ?>
            </div>
        </div>
    </div>
</div>