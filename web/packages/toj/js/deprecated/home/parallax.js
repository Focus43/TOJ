/**
 * Custom parallax scroller for Town Of Jackson.
 * @dependency: greensock.js
 * @author Focus43, LLC. (http://focus-43.com)
 */
(function(){
    
    /**
     * Simultaneously instantiate + bind Parallax object to window
     */
    window.Parallax = new function(){
        
        var self = this,
            $metaPaths = $('#tojAppPaths', 'head'),
            _panoramaImg = $metaPaths.attr('data-images') + 'panorama.jpg', //'/packages/toj/images/panorama.jpg',
            _gsLibrary   = $metaPaths.attr('data-js') + 'libs/greensock.min.js', //'http://cdnjs.cloudflare.com/ajax/libs/gsap/1.9.7/TweenMax.min.js',
            _parallaxDom = $metaPaths.attr('data-tools') + 'home/parallax';

        // css transitions
        this.transitionEnd  = 'transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd';


        /**
         * Add required DOM elements
         * @return $.Deferred.promise()
         */
        function initDom(){
            return $.Deferred(function( _task ){
                $('body').append('<div id="opaqueBack" />').append('<div id="parallaxWrap" />');
                setTimeout(function(){
                    $('body').addClass('parallax');
                    _task.resolve(true);
                }, 10);
            }).promise();
        }


        /**
         * Load an image asynchronously
         * @return $.Deferred.promise()
         */
        function asyncImage( _src ){
            return $.Deferred(function( _defferObj ){
                var _image = new Image();
                _image.onload  = function(){ _defferObj.resolve( _image ); console.log(_src + ' loaded'); }
                _image.onerror = function(){ _defferObj.reject('Image loading failed'); }
                _image.src = _src;
            }).promise();
        }


        /**
         * Load javascript library
         * @return $.Deferred.promise()
         */
        function jsLibrary( _src ){
            return $.Deferred(function( _defferObj ){
                $.getScript( _src ).done(function(script, textStatus){
                    if( $.isFunction(TweenLite) ){
                        _defferObj.resolve(textStatus);
                        console.log(_src + ' loaded');
                    }else{
                        _defferObj.reject('Animation library failed to load.');
                    }
                }).fail(function(xhr, settings, exception){
                    _defferObj.reject('JS Library ' + exception);
                });
            }).promise();
        }


        /**
         * Bind the necessary animation logic to trigger elements (and handle
         * window resizing)
         * @param $parallaxWrap
         * @return void
         */
        function animationBindings( $parallaxWrap ){
            var $panorama   = $('#panorama'),
                $panelsWrap = $('#parallaxPanels'),
                _panelCount = $('.panel', $panelsWrap).length,
                _areaDiff   = $panorama.width() - $parallaxWrap.width();

            // scroll left or right
            $('a.control', $parallaxWrap).on('click', function(){
                var $this       = $(this),
                    $active     = $('.panel.active', $panelsWrap),
                    _startIdx   = $active.index('.panel'),
                    _targetIdx  = $this.hasClass('right') ? (_startIdx + 1) : (_startIdx - 1);

                // move left
                if( (_targetIdx < _startIdx) && (_targetIdx >= 0) ){
                    $active.removeClass('active').prev('.panel').addClass('active');
                    // move right
                }else if( (_targetIdx > _startIdx) && (_targetIdx < _panelCount) ){
                    $active.removeClass('active').next('.panel').addClass('active');
                }

                // scrolling calculations
                var _currentIndex       = $('.panel.active', $panelsWrap).index('.panel'),
                    _panoramaLeft       = (_currentIndex/(_panelCount-1)) * _areaDiff,
                    _contentPanelsLeft  = '-' + (_currentIndex * 100) + '%';

                // trigger animations
                TweenLite.to($panorama, 2.8, {left: -_panoramaLeft, ease:Power4.easeOut} );
                TweenLite.to($panelsWrap, 1.4, {left: _contentPanelsLeft, ease: Power4.easeOut, delay:.15});
            });

            // manage window resizing
            $(window).on('resize.parallax', function(){
                // reset diff
                _areaDiff = $panorama.width() - $parallaxWrap.width();
                // recalc alignments
                var _activeIndex    = $('.panel.active', $panelsWrap).index('.panel'),
                    _panoramaLeft   = (_activeIndex/(_panelCount-1)) * _areaDiff,
                    _panelsLeft     = '-' + (_activeIndex * 100) + '%';
                $panorama.css({left:-_panoramaLeft});
                $panelsWrap.css({left:_panelsLeft});
            });
        }


        /**
         * Kickoff the chain to render the parallax overlay
         * @return void
         */
        $(document).on('click', '#launchParallax', function(){
            $.when( initDom(), jsLibrary(_gsLibrary), asyncImage(_panoramaImg), $.get(_parallaxDom) ).then(
                function(_null, _null, _img, _ajaxResponse){
                    var $parallaxWrap = $('#parallaxWrap');
                    // add html to the DOM
                    $parallaxWrap.append( _ajaxResponse[0] );
                    // set preloaded image as background
                    $('#panorama', $parallaxWrap).css({backgroundImage:'url('+_panoramaImg+')', width:_img.width});
                    // init event listeners and animation stuff
                    animationBindings( $parallaxWrap );
                    // close bindings
                    $('#opaqueBack').one(self.transitionEnd, function(){
                        $parallaxWrap.add('#opaqueBack').remove();
                    });
                    $('.closer', $parallaxWrap).add('#opaqueBack').one('click', function(){
                        $('body').removeClass('parallax');
                        if( !Modernizr.csstransitions ){
                            $parallaxWrap.add('#opaqueBack').remove();
                        }
                        $(window).off('resize.parallax');
                    });
                }, function(_msg){
                    alert('This feature is temporarily unavailable, please try later.');
                    $('#opaqueBack, #parallaxWrap').remove();
                }
            );
        });
        
    }
    
})();
