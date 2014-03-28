/**
 * For "current" single page.
 */
(function( $ ){

    /**
     * Watch the Load More button (pagination).
     */
    $('#btnLoadMore').on('click.pager', function(){
        var $this = $(this),
            _page = +($this.data('paging') || 2);

        // auto-incr the paging data attr even before querying
        $this.data('paging', _page + 1);

        $.get( $this.attr('data-src') + _page, function( _html ){
            if( !_html.length ){
                $this.replaceWith('<strong class="text-success"><i class="fa fa-check-circle-o"></i> All Posts Loaded!</strong>');
                $this.off('click.pager');
                return;
            }

            var $container = $('.list-group', '#postList');
            if( $container.data('masonry') ){
                var $html = $(_html);
                $container.masonry().append($html).masonry('appended', $html);
            }else{
                $container.append(_html);
            }
        }, 'html');
    });


    /**
     * Grid View using Masonry.
     */
    $('[data-view]', '#postList').on('click', function(){
        var $this = $(this),
            $container = $('.list-group', '#postList');

        $this.addClass('active').siblings('button').removeClass('active');

        if( $this.attr('data-view') === 'grid' ){
            $container.addClass('grid');
            $container.masonry({
                itemSelector: '.list-group-item',
                columnWidth: '.list-group-item',
                gutter: 0,
                transitionDuration: '0.2s'
            });
            return;
        }

        if( $container.data('masonry') ){
            $container.masonry('destroy');
        }
        $container.removeClass('grid');
    });

})( jQuery );