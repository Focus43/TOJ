<div class="inner">
    <div class="content">
        <?php $a = new GlobalArea('Global Right'); $a->display($c); ?>
    </div>

    <?php
    /** @var FileList $fileList */
    $fileList = new FileList;
    $fileList->setPermissionLevel('view_file_set_file');
    $fileList->filterBySet( FileSet::getByName('Sidebar Photos') );
    $fileListResults = $fileList->get(40);

    /** @var Concrete5_Helper_Image $imageHelper */
    $imageHelper = Loader::helper('image');
    $imageHelper->setJpegCompression(88);

    // build out the results to JSON-format friendly array, while also creating the
    // resized/cached thumbnail images
    $imageList = array();
    foreach( $fileListResults AS $fileObj ){ /** @var File $fileObj */
        $approved  = $fileObj->getVersion(); /** @var FileVersion $approved */
        $thumbnail = $imageHelper->getThumbnail( $fileObj, 1000, 800 );

        array_push($imageList, (object) array(
            'name'   => $approved->getFileName(),
            'descr'  => $approved->getDescription(),
            'url'    => $thumbnail->src,
            'width'  => $thumbnail->width,
            'height' => $thumnail->height
        ));
    }

    // randomize
    shuffle($imageList);

    foreach($imageList AS $_index => $shortObj): ?>
        <div class="thumbEl">
            <span class="thumb" data-src="<?php echo $shortObj->url ?>" style="display:block;background-image:url('<?php echo $shortObj->url; ?>');"></span>
        </div>
    <?php if($_index == 2){ break; } endforeach; ?>

    <div class="content">
        <?php $a = new GlobalArea('Global Right 2'); $a->display($c); ?>
    </div>
</div>

<script type="text/javascript">
    //sessionStorage.clear(); // temporary for development
    $(function(){
        var $elmnts  = $('.thumbEl', '#sidebarRight'),
            imgList  = <?php echo Loader::helper('json')->encode( array_values($imageList) ); ?>,
            listSize = imgList.length;

        // auto-rotation
        var _i = 0;
        (function recurse(){
            setTimeout(function(){
                var rand = imgList[Math.floor(Math.random() * listSize)],
                    $pre = $('<img />').attr('src', rand.url);

                $pre.one('load', {obj: rand}, function( _ev ){
                    var $span = $('<span class="thumb" />').attr('data-src', _ev.data.obj.url).css('background-image', 'url('+_ev.data.obj.url+')');
                    $elmnts.eq(_i).append($span);
                    $span.fadeIn().siblings('.thumb').fadeOut(function(){
                        //$(this).remove();
                    });
                    _i = (_i == ($elmnts.length-1)) ? 0 : _i + 1;
                    // *now* call the method to begin recursion
                    recurse();
                });
            }, 1800);
        })();

        // modal
        $('#sidebarRight').on('click', 'span.thumb', function(){
            var $this  = $(this),
                $html  = $('<div id="sidebarGallery"><div class="wrap"><img src="' + $this.attr('data-src') + '" /></div></div>'),
                $close = $('<a class="closable"><i class="fa fa-times"></i></a>');
            $('.wrap', $html).append($close);
            $('body').append($html);

            $html.on('click', function( _clickEvent ){
                if( ! $(_clickEvent.target).is('img') ){
                    $html.fadeOut(450, function(){
                        $html.remove();
                    });
                }
            });
        });
    });
</script>