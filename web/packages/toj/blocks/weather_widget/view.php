<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

    <div class="weatherWidget <?php echo $containerClass; ?>">
        <!-- appended via js -->
    </div>

    <script type="text/javascript">
        // ensure weatherInit function isn't defined twice
        if( typeof(weatherInit) !== 'function' ){
            function weatherInit(){
                $.simpleWeather({
                    zipcode: '<?php echo $zipCode; ?>',
                    unit: 'f',
                    success: function(weather) {
                        html = '<label>Weather in '+weather.city+', '+weather.region+'</label>';
                        html += '<img src="'+weather.thumbnail+'" />'+weather.temp+'&deg;'+weather.units.temp+' &nbsp;<span class="badge">'+weather.currently+'</span>';
                        $('.<?php echo $containerClass; ?>').html(html);
                    },
                    error: function(error) {
                        $('.<?php echo $containerClass; ?>').html('<p>'+error+'</p>');
                    }
                });
            }
        }

        // load the script on the fly
        $(document).ready(function(){
            if( typeof($.simpleWeather) !== 'undefined' ){
                weatherInit();
            }else{
                $.getScript('<?php echo $toolsURL; ?>', function(){ weatherInit(); });
            }
        });
    </script>