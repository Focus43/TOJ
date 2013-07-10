<?php if ($managementMode === true): ?>
<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
<?php Loader::packageElement('partials/head_tag_inner', 'toj'); ?>
<?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
</head>

<body class="toj modalPage <?php echo $bodyClass; ?>">
<?php endif; ?>

    <div class="modal <?php if(!($managementMode === true)){ echo 'hide fade'; } ?>">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><?php echo Page::getCurrentPage()->getCollectionName(); ?></h3>
        </div>
        <div class="modal-body">
            <?php $a = new Area('Modal Content'); $a->display($c); ?>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
    </div>

<?php if ($managementMode === true): ?>
<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>
<?php endif; ?>