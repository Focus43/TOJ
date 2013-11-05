<div class="inner">
    <?php $a = new GlobalArea('Global Right'); $a->display($c); ?>
    <?php /*
        $fileList = new FileList;
        $fileList->setPermissionLevel('view_file_set_file');
        $fileList->filterBySet( FileSet::getByName('Sidebar Photos') );
        $results = $fileList->get(40);

        foreach($results AS $fileObj){ /** @var File $fileObj ?>
            <span class="thumb" style="background-image:url('<?php echo $fileObj->getApprovedVersion()->getRelativePath(); ?>');"></span>
        <?php } */ ?>
</div>