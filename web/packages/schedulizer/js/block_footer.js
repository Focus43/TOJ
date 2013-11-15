$(function(){
    function initCalendar( settings ){
        var $calendar   = $('.schedulizerCalendar.b-' + settings.bID),
            $eventTable = $('tbody', '#eventTable-' + settings.bID);

        $calendar.fullCalendar({
            header: {
                left: 'title',
                right: 'prev,next'
            },
            editable: false,
            weekMode: 'liquid',
            defaultView: 'month',
            columnFormat: {
                month: 'ddd'
            },
            dayNamesShort: ['S','M','T','W','T','F','S'],
            eventRender: function(calEvent, element, view){
                //console.log(calEvent, element, view);
                $(element).tooltip({
                    animation: false,
                    title: calEvent.title,
                    container: 'body'
                });
            },

            // event feed
            events: settings.eventSrc,
            // click on an event
            eventClick: function(event){
                $calendar.trigger('eventclick.schedulizer', [event]);
            },
            eventAfterAllRender: function(view){
                $eventTable.empty();
                $.each(view.calendar.clientEvents(), function(idx, event){
                $eventTable.append('<tr><td>'+ $.fullCalendar.formatDate(event.start, 'MMM d, yyyy h:mm tt') +'</td><td>'+event.title+'</td></tr>');
                });
            }
        });
    }

    if( typeof(window.schedulizers) !== 'undefined' && window.schedulizers.length ){
        $.each(window.schedulizers, function(idx, settings){
            initCalendar(settings);
        });
    }
});