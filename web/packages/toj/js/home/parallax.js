/*!
 * "Explore Jackson" super sexy parallax.
 * @dependency Greensock animation library
 */
$(function(){

    window.ExploreJackson = (function(){

            // paths
        var $paths   = $('#tojAppPaths', 'head'),
            htmlPath = $paths.attr('data-tools') + 'home/parallax',
            panoramaPath = $paths.attr('data-images') + 'panorama.jpg';


        function preloadImage( _src ){
            return $.Deferred(function( _task ){
                var img = new Image();
                img.onload = function(){
                    _task.resolve(img);
                };
                img.src = _src;
            }).promise();
        }


        function initAnimationBindings( $plxWrap ){
            var $panorama   = $('#panorama'),
                $panelsWrap = $('#parallaxSections'),
                _panelCount = $('.section', $panelsWrap).length,
                _areaDiff   = $panorama.width() - $plxWrap.width();

            // scroll left or right
            $('a.control', $plxWrap).on('click', function(){
                var $this       = $(this),
                    $active     = $('.section.active', $panelsWrap),
                    _startIdx   = $active.index('.section'),
                    _targetIdx  = $this.hasClass('right') ? (_startIdx + 1) : (_startIdx - 1);

                // move left
                if( (_targetIdx < _startIdx) && (_targetIdx >= 0) ){
                    $active.removeClass('active').prev('.section').addClass('active');
                    // move right
                }else if( (_targetIdx > _startIdx) && (_targetIdx < _panelCount) ){
                    $active.removeClass('active').next('.section').addClass('active');
                }

                // scrolling calculations
                var _currentIndex       = $('.section.active', $panelsWrap).index('.section'),
                    _panoramaLeft       = (_currentIndex/(_panelCount-1)) * _areaDiff,
                    _contentPanelsLeft  = '-' + (_currentIndex * 100) + '%';

                // trigger animations
                TweenLite.to($panorama, 2.8, {left: -_panoramaLeft, ease:Power4.easeOut} );
                TweenLite.to($panelsWrap, 1.4, {left: _contentPanelsLeft, ease: Power4.easeOut, delay:0.15});
            });

            // manage window resizing
            $(window).on('resize.parallax', function(){
                // reset diff
                _areaDiff = $panorama.width() - $plxWrap.width();
                // recalc alignments
                var _activeIndex    = $('.section.active', $panelsWrap).index('.section'),
                    _panoramaLeft   = (_activeIndex/(_panelCount-1)) * _areaDiff,
                    _panelsLeft     = '-' + (_activeIndex * 100) + '%';
                $panorama.css({left:-_panoramaLeft});
                $panelsWrap.css({left:_panelsLeft});
            });
        }


        function fitContent( $plxWrap ){
            $('.opaque', $plxWrap).css('max-height', $plxWrap.outerHeight() - 180);
            $('.scrollme', $plxWrap).height($plxWrap.outerHeight() - 240).perfectScrollbar();
        }


        $(window).on('resize', function(){
            var $plxWrap = $('#parallaxWrap');
            $('.opaque', $plxWrap).css('max-height', $plxWrap.outerHeight() - 180);
            $('.scrollme', $plxWrap).height($plxWrap.outerHeight() - 240).perfectScrollbar('update');
        });


        function launch(){
            // create the wrapper element
            var $plxWrap = $('<div id="parallaxWrap" />');
            // append to body and add body class
            $('body').append($plxWrap).addClass('parallax');
            // animate in
            //TweenLite.to($plxWrap, 0.8, {autoAlpha:1, ease:Elastic.easeOut, delay: 0.5});

            // start preloading, and then proceed when finished
            $.when( preloadImage(panoramaPath), $.get(htmlPath) ).then(function( panorama, html ){
                // add html to dom container
                $plxWrap.append( html[0] );
                // set preloaded image as background
                $('#panorama', $plxWrap).css({backgroundImage:'url('+panoramaPath+')', width:panorama.width});
                // initialize the animation listeners n shit
                initAnimationBindings( $plxWrap );
                fitContent( $plxWrap );
                // close handler
                $('.closer', $plxWrap).one('click', function(){
                    $plxWrap.remove();
                    $('body').removeClass('parallax');
                    $(window).off('resize.parallax');
                });
            }, function(){
                alert('Oh no! Something went wrong, please try again later');
                $plxWrap.remove();
                $('body').removeClass('parallax');
            });
        }


        return {
            open: launch
        };
    }());

});