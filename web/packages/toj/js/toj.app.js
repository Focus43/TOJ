    // console.log catcher, for sh***y browsers
    if( typeof(console) === 'undefined' || typeof(console.log) === 'undefined' ){
        window.console = {log:function(){}};
    }

    // namespace
    var TOJ;
    
    $(function(){
        
        TOJ = (function(){
            
            var _self       = this,
                $document   = $(document),
                $window     = $(window),
                $body       = $('body');

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