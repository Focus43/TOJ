<div class="inner">
    <a class="weatherWidget panel panel-default" href="http://www.mountainweather.com/index.php?page=jackson_hole_forecast" target="_blank">
        <div class="panel-heading">
            <h3 class="panel-title">Current Weather</h3>
        </div>
        <div class="panel-body">
            <!-- weather data -->
        </div>
    </a>

    <?php Loader::packageElement('partials/recent_news', 'toj'); ?>

    <?php $a = new GlobalArea('Global Left'); $a->display($c); ?>
</div>