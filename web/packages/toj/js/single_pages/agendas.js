/**
 * For "agendas" single page.
 */
(function( $ ){

    var $selectList   = $('#agendaSelector'),
        $extraContent = $('.extra-content', '#agendasList'),
        $results      = $('.results', '#agendasList'),
        $btnGetMore   = $('#btnGetMore');

    function toggleLoadMore(){
        $('.panel-footer', '#agendasList').toggleClass('complete', ($results.filter('.active').attr('data-complete') == 'true'));
    }

    // switcher
    $selectList.on('change', function(){
        $extraContent.add($results).removeClass('active').filter('[data-key="'+this.value+'"]').addClass('active');
        // if the active .results container has class .do-first-load, auto-load it
        var $activeResults = $results.filter('.active');
        if( $activeResults.hasClass('do-first-load') ){
            $activeResults.removeClass('do-first-load');
            $btnGetMore.trigger('click.loader');
        }
        toggleLoadMore();
    });

    // load more
    $btnGetMore.on('click.loader', function(){
        var $activeResults = $results.filter('.active'),
            _pageToRequest = +($activeResults.attr('data-page'));

        // disable the button temporarily
        $btnGetMore.attr('disabled', 'disabled');

        // update the data-page attribute (represents page to get *next* time its called)
        $activeResults.attr('data-page', _pageToRequest + 1);

        $.get( $btnGetMore.attr('data-src') + _pageToRequest, {agendaType: $selectList.val()}, function( _html ){
            $btnGetMore.removeAttr('disabled');

            if( ! _html.length ){
                $activeResults.attr('data-complete', 'true');
                toggleLoadMore();
                return;
            }

            $activeResults.append(_html);
        }, 'html');
    });

})( jQuery );