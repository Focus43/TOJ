<div class="inner">
    <?php //$a = new GlobalArea('Global Right'); $a->display($c);
        $fileList = new FileList;
        $fileList->filterBySet( FileSet::getByName('Sidebar Photos') );
        $files = $fileList->get(40);

        foreach($files AS $fileObj){ /** @var File $fileObj */ ?>
            <span class="thumb" style="background-image:url('<?php echo $fileObj->getApprovedVersion()->getRelativePath(); ?>');"></span>
        <?php } ?>
</div>