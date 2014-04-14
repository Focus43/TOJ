(function( $, Modernizr ){

    // Cache common selectors
    var _self       = this,
        $document   = $(document),
        $body       = $('body'),
        $settings   = $('#siteSettings'),
        $sidebarLeft = $('#sidebarLeft'),
        $sidebarRight = $('#sidebarRight');


    /**
     * Handle large backgrounds. If unsupported natively, Modernizr will take
     * care of. The code below checks if background-size:cover *is* supported,
     * and then adds the background image (acts as a lazy-loader).
     */
    if( typeof(Modernizr) !== 'undefined' && Modernizr.backgroundsize ){
        $('[data-background]').each(function(index, element){
            $(element).css('backgroundImage', 'url('+element.getAttribute('data-background')+')');
        });
    }


    // css transitions
    this.transitionEnd  = 'transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd';


    // lazy-load sidebar content, if visible (auto-triggers on init)
    if( !$body.hasClass('edit-mode') ){
        if( $body.hasClass('cms-admin') ){
            sessionStorage.clear();
        }

        $document.on(_self.transitionEnd, '#cL1', function( _transitionEvent ){
            if( _transitionEvent.target === this ){
                var _bodyWidth = $body.outerWidth();

                if( _bodyWidth >= 1200 ){
                    if( $sidebarLeft.attr('data-load') ){
                        $.clientCache('leftSidebar', function( _task ){
                            $.get($sidebarLeft.attr('data-load'), function( _htmlResponse ){
                                _task.resolve(_htmlResponse);
                            }, 'html');
                        }).done(function( _htmlResults ){
                                $sidebarLeft.append( _htmlResults).removeAttr('data-load');
                                $sidebarLeft.trigger('sidebar_left_open');
                            });
                    }
                }

                if( _bodyWidth >= 1334 ){
                    $.clientCache('rightSidebar', function( _task ){
                        $.get($sidebarRight.attr('data-load'), function( _htmlResponse ){
                            _task.resolve(_htmlResponse);
                        }, 'html');
                    }).done(function( _htmlResults ){
                            $sidebarRight.append( _htmlResults).removeAttr('data-load');
                            $document.off(_self.transitionEnd, '#cL1');
                        });
                }
            }
        });
    }else{
        $('.sidebars').removeAttr('data-load');
    }


    // weather data for sidebars
    $document.on('sidebar_left_open', function(){
        $.clientCache('weatherData', function( _task ){
            $.simpleWeather({location: '83002', unit: 'f', success: function(weather){
                _task.resolve(weather);
            }});
        }, 'json').done(function( weather ){
                $('.panel-body', '#sidebarLeft .weatherWidget').empty().append(function(){
                    return '<img src="'+weather.thumbnail+'" />'+weather.temp+'&deg;'+weather.units.temp+' &nbsp;<span class="badge">'+weather.currently+'</span>';
                });
            });
    });


    // auto-trigger the transition event (load sidebar content) on init
    $('#cL1').trigger('transitionend');


    /**
     * Accessibility settings
     */
    $document.on('click', '#openSettings, #closeSettings', {el: $settings}, function(_clickEv){
        _clickEv.data.el.toggleClass('opend');
    });


    /**
     * Toggle the font size
     */
    $settings.on('click', '.setFontSize', function(){
        var _value = $(this).attr('data-zoom');
        if( _value === 'default' ){
            $body.removeAttr('data-zoom');
            return;
        }
        $body.attr('data-zoom', _value);
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


    // header news & current, set icon class
    $.ajax({
        url: $('#tojAppPaths').attr('data-tools') + '_data/current',
        dataType: 'json',
        cache: false,
        success: function( _resp ){
            var iconColor = (_resp.criticals) ? 'text-danger' : (_resp.warnings) ? 'text-warning' : 'text-success',
                iconClass = (_resp.criticals) ? 'fa-exclamation-triangle' : (_resp.warnings) ? 'fa-exclamation-circle' : 'fa-check-circle';

            // find both icons (mobile and desktop navigation view) to replace
            $('.status-alert-icon', '#primaryNav').find('i.fa').replaceWith('<i class="fa '+iconColor+' '+iconClass+'" />');

            // create alertGroup dom elements
            var $alertGroup = $('<div class="alertGroup" />');

            // append any criticals
            if( _resp.criticals ){
                $.each( _resp.criticals, function(idx, obj){
                    $alertGroup.append('<a class="alert alert-danger" href="'+obj.path+'"><i class="fa fa-exclamation-triangle"></i><span> '+obj.name+'</span></a>');
                });
                $.clientCacheBust('leftSidebar');
            }

            // append any warning
            if( _resp.warnings ){
                $.each( _resp.warnings, function(idx, obj){
                    $alertGroup.append('<a class="alert alert-warning" href="'+obj.path+'"><i class="fa fa-exclamation-circle"></i><span>'+obj.name+'</span></a>');
                });
                $.clientCacheBust('leftSidebar');
            }

            // if theres none of the above, create OK message
            if( ! $('.alert', $alertGroup).length ){
                $alertGroup.append('<a class="alert alert-success no-icon"><span>No warnings or critical alerts are currently issued.</span></a>');
            }

            // replace in desktop hover menu
            $('h5.updating', '#primaryNav').replaceWith($alertGroup);

            // create the popover for mobile
            $('.status-alert-icon', '#primaryNav .navbar-header').popover({
                animation: false,
                html: true,
                placement: 'bottom',
                title: 'Current Alerts',
                content: $alertGroup.clone(),
                trigger: 'click',
                container: '#primaryNav'
            });
        }
    });


    /**
     * Load more news items department pages.
     * @todo: cache the selectors; right now this is stupidly heavy
     */
    $('.toggle-posts').on('click.deptpagination', function(){
        var $this           = $(this),
            $bodyContent    = $('.body-content', '#cPageContent'),
            $postsContainer = $('#deptPostsContainer');

        // close the posts view?
        if( $this.hasClass('minimize') ){
            $bodyContent.removeClass('posts-view');
            return;
        }

        // just expand the posts view?
        if( $this.hasClass('expand') ){
            $bodyContent.addClass('posts-view');
        }

        // if pagination has reached the end, then force stopping here
        if( $postsContainer.data('all_posts_loaded') === true ){
            return;
        }

        // if we're here, paginate...
        var _deptRootID     = $postsContainer.attr('data-deptid'),
            _deptPath       = $postsContainer.attr('data-deptpath'),
            _page           = +($postsContainer.data('pagination') || 2);

        // auto-incr pagination data even before querying
        $postsContainer.data('pagination', _page + 1);

        // load more posts via ajax
        $.get(_deptPath + '_load_posts/' + _deptRootID + '/' + _page, function( _html ){
            // if empty, all posts have been loaded
            if( !_html.length ){
                $('.toggle-posts.view-more').empty().append('<strong class="text-success"><i class="fa fa-check-circle-o"></i> All Posts Loaded!</strong>');
                $postsContainer.data('all_posts_loaded', true);
                return;
            }
            // othwerise append to the DOM
            $('.list-group', '#deptPostsContainer').append(_html);
        }, 'html');
    });


    /**
     * Hook into custom events emitted by schedulizer to show the
     * event info in a modal window.
     */
    $document.on('eventclick.schedulizer', function(clickEv, calEv){
        //console.log(clickEv);
        $.get($('#tojAppPaths').attr('data-tools') + 'schedulizer_event_view', {eventID: calEv.id}, function(_html){
            var $modal = $(_html);
            $modal.appendTo($body).modal();
        }, 'html');
    });


    /**
     * Load the apis for twitter and facebook? only if .sociable is visible...
     */
    if( $('.sociable', '#cPageContent').is(':visible') ){
        // facebook
        $body.append('<div id="fb-root"></div>');
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if(d.getElementById(id)){return;}
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&status=0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        // twitter
        (function(d,s,id){
            var js,fjs=d.getElementsByTagName(s)[0];
            if(!d.getElementById(id)){
                js=d.createElement(s);
                js.id=id;
                js.src="https://platform.twitter.com/widgets.js";
                fjs.parentNode.insertBefore(js,fjs);

            }
        }(document,"script","twitter-wjs"));
    }


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

})( jQuery, Modernizr || {} );