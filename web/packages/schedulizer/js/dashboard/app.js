
    var SchedulizerDashboard;

    $(function(){

        SchedulizerDashboard = (function(){

            var _toolsURI = $('meta[name="schedulizer-tools"]', 'head').attr('content');

            /**
             * Ajaxify form handler
             */
            if( $.fn.ajaxifyForm ){
                $('form[data-method="ajax"]').ajaxifyForm();
                // on complete callback
                $(document).on('ajaxify_complete', 'form[data-method="ajax"]', function(ev, resp){
                    $('.ui-dialog-content').scrollTop(0);
                    if(resp.code === 1){
                        setTimeout(function(){
                            $.fn.dialog.closeTop();
                            $('#schedulizerCalendar').fullCalendar('refetchEvents');
                        }, 1000);
                    }
                });
            }


            /**
             * Tab functionality (mimics twitter bootstrap's thats missing in C5)
             */
            $('a[data-toggle="tab"]').on('click', function(_clickEvent){
                _clickEvent.preventDefault();
                var $this = $(this);
                $this.parent('li').addClass('active').siblings('li').removeClass('active');
                $( $this.attr('href') ).addClass('active').siblings('.tab-pane').removeClass('active');
                // emit custom on_show event
                $this.trigger('tab.show');
            });


            /**
             * Open modal window
             */
            $('.modalize').dialog();


            /**
             * Render the full calendar.
             * @return void
             */
            function renderCalendar(){
                var $calendar   = $('#schedulizerCalendar'),
                    _calendarID = +($calendar.attr('data-calendar-id'));

                $calendar.fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,basicWeek,basicDay'
                    },
                    editable: true,
                    defaultView: 'month',
                    // event feed
                    events: _toolsURI + 'events/feed?' + $.param({
                        calendarID: _calendarID
                    }),
                    // click on a day
                    dayClick: function(date, allDay, jsEvent, view){
                        var _data = $.param({
                            calendarID: _calendarID,
                            year: date.getUTCFullYear(),
                            month: date.getUTCMonth() + 1,
                            day: date.getUTCDate()
                        });
                        /* OPEN EVENT DIALOG TO CREATE NEW */
                        $.fn.dialog.open({
                            width:650,
                            height:525,
                            title: 'New Event: ' + date.toLocaleDateString(),
                            href: _toolsURI + 'events/new?' + _data
                        });
                    },
                    // click on an event
                    eventClick: function(calEvent, jsEvent, view){
                        /* OPEN EVENT DIALOG TO CREATE EDIT */
                        $.fn.dialog.open({
                            width:650,
                            height:525,
                            title: 'Editing Event: ' + calEvent.title,
                            href: _toolsURI + 'events/edit?' + $.param({
                                eventID: calEvent.id,
                                isAlias: calEvent.isAlias,
                                date: $.fullCalendar.formatDate(calEvent.start, 'yyyy-MM-dd')
                            })
                        });
                    }
                });
            }


            /**
             * Listen for on_show from the click on the Events tab.
             */
            $('a[href="#tabGroup2"]').one('tab.show', function(){
                renderCalendar();
            });


            /** Public methods; @return Object */
            return {

            }
        })();

    });