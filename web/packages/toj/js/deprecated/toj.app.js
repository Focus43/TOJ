    // console.log catcher, for sh***y browsers
    if( typeof(console) === 'undefined' || typeof(console.log) === 'undefined' ){
        window.console = {log:function(){}};
    }

    // namespace
    var TOJ;
    
    $(function(){

        /**
         * Modernizr shims
         */
        Modernizr.load([
            {
                test: Modernizr.mq('only all'),
                nope: '/packages/toj/js/libs/shims/respond.min.js',
                complete: function(){
                    if( typeof(respond) !== 'undefined' ){
                        respond.update();
                    }
                }
            },
            {
                test: Modernizr.placeholder,
                nope: '/packages/toj/js/libs/shims/placeholder.min.js',
                complete: function(){
                    if( typeof(Placeholders) != 'undefined' ){
                        Placeholders.init();
                    }
                }
            },
            {
                test: Modernizr.backgroundsize,
                nope: '/packages/toj/js/libs/shims/backstretch.js',
                complete: function(){
                    if( typeof($) !== 'undefined' && $.isFunction($.backstretch) ){
                        $('[data-background]').each(function(idx, element){
                            $(element).backstretch( element.getAttribute('data-background') );
                        });
                    }
                }
            }
        ]);


        /**
         * TOJ App class
         */
        TOJ = (function(){
            
            var _self       = this,
                $document   = $(document),
                $window     = $(window),
                $body       = $('body'),
                $settings   = $('#siteSettings');

            // css transitions
            this.transitionEnd  = 'transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd';

            
            /**
             * Apply backstretch to any element that has data-background attribute. Since this file
             * is executed last, this is an easy way of lazy loading.
             * @return void
             */
            this.applyBackstretchImages = function(){
                var $domElements = $('[data-background]');
                if( typeof Modernizr !== 'undefined' ){
                    if( Modernizr.backgroundsize && $domElements.length ){
                        $domElements.each(function(idx, element){
                            $(element).css({backgroundImage: 'url('+element.getAttribute('data-background')+')'})
                                .removeAttr('data-background');
                        });
                    }
                }
            };


            // trigger the backstretch function
            $window.on('resize.toj', function(){
                if( $body.width() > 767 ){
                    _self.applyBackstretchImages();
                }
            }).trigger('resize.toj');
            

            // handle ajax loading of sidebar content
            function responsiveSidebars(){
                var $lefty  = $('#cLeft[data-load]:visible'),
                    $righty = $('#cRight[data-load]:visible');

                if( $lefty.length ){
                    $lefty.load( $lefty.attr('data-load')).removeAttr('data-load');
                    console.log('Left Sidebar Loaded');
                }

                if( $righty.length ){
                    $righty.load( $righty.attr('data-load')).removeAttr('data-load');
                    console.log('Right Sidebar Loaded');
                }
            }


            // on init, run the responsiveSidebars() method right out of the gate
            // if we're *NOT* in edit mode
            if( ! $body.hasClass('editMode') ){
                responsiveSidebars();
            }


            // if window changes and sidebars appear, load 'em
            $document.on(_self.transitionEnd, '#cMiddle', function( _transitionEvent ){
                if( _transitionEvent.target === this ){
                    responsiveSidebars();
                }
            });


            // "shim" fallback for loading sidebar content in IE8
            if( $.browser.msie && $.browser.version < 9.0 ){
                $window.on('resize.transition-shim', function(){
                    responsiveSidebars();
                });
            }


            /**
             * Popovers and tooltips
             */
            $document.popover({
                animation: false,
                selector: '.showPopover',
                trigger: 'hover',
                placement: function(){
                    return this.$element.attr('data-placement') || 'top';
                },
                container: 'body'
            }).tooltip({
                animation: false,
                selector: '.showTooltip',
                trigger: 'hover focus',
                placement: function(){
                    return this.$element.attr('data-placement') || 'top';
                },
                container: 'body'
            });


            /**
             * Modal windows
             */
            $document.on('click', '.modalize', function(_clickEvent){
                _clickEvent.preventDefault();
                var $this = $(this),
                    _uri  = $this.attr('href');

                if( _uri.length ){
                    $.get(_uri, {modal:true}, function(_html){
                        var $modal = $(_html);
                        $modal.appendTo($body).modal();
                    }, 'html');
                    return;
                }

                // if we get here, show error message
                alert('Unable to load requested page.');
            });


            /**
             * Auto rotate alert messages on the homepage
             */
            var $alertItems = $('li', '#cMiddle #alertSection ol'),
                _alertCount = $alertItems.length;
            if( $alertItems.length ){
                (function alertRotation(){
                    setTimeout(function(){
                        var $current = $alertItems.filter(':visible'),
                            _index   = $current.index(),
                            $next    = (_index == (_alertCount-1)) ? $('li:first', '#cMiddle #alertSection ol') : $current.next('li');
                        $current.fadeOut(150, function(){
                            $next.fadeIn(150);
                            alertRotation();
                        });
                    }, 3800);
                })();
            }
            
            
            /**
             * Smooth page scrolling
             */
            $document.on('click', 'a[href^="#"]', function( _event ){
                _event.preventDefault();
                var $this   = $(this),
                    $target = $( $this.attr('href') );
                if( !$this.hasClass('carousel-control') ){
                    if( $target.length ){
                        var fromTop = $target.offset().top;
                        $('html,body').stop().animate({scrollTop: fromTop}, 850, 'easeOutExpo');
                    }
                }
            });


            /**
             * Accessibility settings
             */
            $document.on('click', '#openSettings, #closeSettings', {overlay: $settings}, function(_clickEv){
                var _top = _clickEv.data.overlay.data('toggled') === true ? '-100%' : 0;
                $('#siteSettings').animate({top:_top}, 300, 'easeOutExpo').data('toggled', !_clickEv.data.overlay.data('toggled'));
            });

            // toggle font size
            $settings.on('click', '.setFontSize', function(){
                $body.css({zoom: $(this).attr('data-zoom')});
            });


            /**
             * On mobile load, hide the navigation bar (hack for iOS)
             */
            //if( $body.width() < 767 ){
            //    document.body.scrollTop || window.scrollTo(0,17);
            //}


            /**
             * Public methods of the TOJ class
             */
            return {

            }

        })();

        
        /**
         * jQuery Easing Methods
         */
        jQuery.extend( jQuery.easing, {
            easeInSine: function (x, t, b, c, d) {
                return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
            },
            easeInExpo: function (x, t, b, c, d) {
                return (t===0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
            },
            easeOutExpo: function (x, t, b, c, d) {
                return (t===d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
            }
        });
        
    });