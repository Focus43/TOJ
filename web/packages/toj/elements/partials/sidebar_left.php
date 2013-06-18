<div class="fullHeight">
    <div class="inner">
        <div id="weather"><!-- appended via js --></div>
        
        <ul id="news" class="unstyled">
            <li class="news robotoSlab">News</li>
            <li><a><span class="badge badge-info">5/21/13</span> 13th Annual Beer Festival, Town Square this weekend</a></li>
            <li><a><span class="badge badge-info">5/21/13</span> 13th Annual Beer Festival, Town Square this weekend</a></li>
            <li><a><span class="badge badge-info">5/21/13</span> 13th Annual Beer Festival, Town Square this weekend</a></li>
            <li><a><span class="badge badge-info">5/21/13</span> 13th Annual Beer Festival, Town Square this weekend</a></li>
        </ul>
        
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