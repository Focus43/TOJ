<div class="fullHeight">
    <div class="inner">
        <div id="alertSection" class="well">
            <span id="importantAlerts">News</span>
            <!--<ul class="unstyled clearfix hidden-phone">
                <li><span class="badge badge-important">0</span> Critical Alert(s)</li>
                <li><span class="badge badge-warning">1</span> Moderate Alert(s)</li>
                <li><span class="badge badge-success">4</span> General Announcements</li>
            </ul>-->
            <div id="alertRotation">
                <ol class="unstyled">
                    <li><span class="label label-warning">May 29, 2013</span> Teton County Elects New Chair of the Sheriff's Department</li>
                    <li><span class="label label-success">May 29, 2013</span> This is a second piece of news that would show up...</li>
                    <li><span class="label label-info">May 29, 2013</span> And this is an example of a different color label for the date</li>
                </ol>
            </div>
            <h4 class="centerize">View More &nbsp;<i class="icon-arrow-right"></i></h4>
        </div>

        <div id="weather"><!-- appended via js --></div>
        
        <!--<ul id="news" class="unstyled">
            <li class="news robotoSlab">News</li>
            <li><a><span class="badge badge-info">5/21/13</span> 13th Annual Beer Festival, Town Square this weekend</a></li>
            <li><a><span class="badge badge-info">5/21/13</span> 13th Annual Beer Festival, Town Square this weekend</a></li>
            <li><a><span class="badge badge-info">5/21/13</span> 13th Annual Beer Festival, Town Square this weekend</a></li>
            <li><a><span class="badge badge-info">5/21/13</span> 13th Annual Beer Festival, Town Square this weekend</a></li>
        </ul>-->


        
        <ul id="alertz" class="unstyled">
            <li><a>National Parks <i class="icon-angle-right"></i></a></li>
            <li><a>Resorts Snow Pack <i class="icon-angle-right"></i></a></li>
            <li><a>Avalanche Conditions <i class="icon-angle-right"></i></a></li>
            <li><a>Nixle Alerts <i class="icon-angle-right"></i></a></li>
            <li><a>WYDOT Alerts <i class="icon-angle-right"></i></a></li>
        </ul>

        <?php $a = new GlobalArea('Global Left'); $a->display($c); ?>
        
        <script type="text/javascript">
            function weatherInit(){
                $.simpleWeather({
                    zipcode: '',
                    woeid: '2357536',
                    location: '83002',
                    unit: 'f',
                    success: function(weather) {
                        html = '<label>Weather in '+weather.city+', '+weather.region+'</label>';
                        html += '<img src="'+weather.thumbnail+'" />'+weather.temp+'&deg;'+weather.units.temp+' &nbsp;<span class="badge">'+weather.currently+'</span>';
                        $("#weather").html(html);
                    },
                    error: function(error) {
                        $("#weather").html('<p>'+error+'</p>');
                    }
                });
            }

            if( ! $.isFunction( $.simpleWeather ) ){
                $.getScript( $('#tojAppPaths', 'head').attr('data-js') + 'libs/jquery.simpleWeather-2.2.min.js', function(){
                    weatherInit();
                });
            }else{
                weatherInit();
            }
        </script>
    </div>
</div>