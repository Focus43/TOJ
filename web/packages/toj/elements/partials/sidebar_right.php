<div class="inner">
    <?php
        // top editable area
        $a = new GlobalArea('Global Right'); $a->display($c);

        $fileList = new FileList;
        $fileList->setPermissionLevel('view_file_set_file');
        $fileList->filterBySet( FileSet::getByName('Sidebar Photos') );

        // turn into shorter more serializable objects
        $imageList = array_map(function( $fileObj ){ /** @var File $fileObj */
            $approved = $fileObj->getVersion();
            return (object) array(
                'name'  => $approved->getFileName(),
                'descr' => $approved->getDescription(),
                'url'   => $approved->getRelativePath()
            );
        }, $fileList->get(40));

        // randomize
        shuffle($imageList);

        foreach($imageList AS $_index => $fileObj): /** @var File $fileObj */ ?>
            <div class="thumbEl">
                <span class="thumb" style="display:block;background-image:url('<?php echo $fileObj->url; ?>');"></span>
            </div>
        <?php if($_index == 2){ break; } endforeach;

        // bottom editable area
        $a1 = new GlobalArea('Global Right Bottom'); $a1->display($c);
    ?>
</div>

<script type="text/javascript">
    $(function(){
        var $three   = $('.thumbEl', '#sidebarRight'),
            imgList  = <?php echo Loader::helper('json')->encode( array_values($imageList) ); ?>,
            listSize = imgList.length;

        var _i = 0;
        (function recurse(){
            setTimeout(function(){
                var rand = imgList[Math.floor(Math.random() * listSize)],
                    $pre = $('<img />').attr('src', rand.url);

                $pre.one('load', {url: rand.url}, function( _ev ){
                    var $span = $('<span class="thumb" />').css('background-image', 'url('+_ev.data.url+')');
                    $three.eq(_i).append($span);
                    $span.fadeIn().siblings('.thumb').fadeOut(function(){
                        $(this).remove();
                    });
                    _i = (_i == 2) ? 0 : _i + 1;
                    // *now* call the method to begin recursion
                    recurse();
                });
            }, 1800);
        })();
    });
</script>