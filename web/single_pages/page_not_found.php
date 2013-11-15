<? defined('C5_EXECUTE') or die("Access Denied."); ?>

    <style type="text/css">
        .searchBox {position:relative;}
        .searchBox input {position:relative;z-index:2;padding-left:35px;}
        .searchBox i {position:absolute;z-index:3;font-size:1.7em;left:8px;top:10px;}
        .searchBox button {position:absolute;z-index:3;right:0;top:0;}
    </style>
    <h3 style="margin-top:0;">Seems like we couldn't find the page you're looking for...</h3>
    <p>We recently launched a totally new TownOfJackson.com, so please bear with us as we work to ensure links pointing to our site get updated. We're working as quickly as we can!</p>

    <form method="get" action="<?php echo View::url('search'); ?>">
        <input name="search_paths[]" type="hidden" value="" />
        <div class="well">
            <p>In the meantime, maybe our custom <i>Site Search</i> feature can help you find what you're looking for:</p>
            <div class="searchBox">
                <input name="query" id="googleSearchInput" type="text" class="form-control input-lg" placeholder="Site Search" value="<?=htmlentities($query, ENT_COMPAT, APP_CHARSET)?>" />
                <i class="fa fa-search"></i>
                <button type="submit" id="googleSearchButton" class="btn btn-info btn-lg">Search</button>
            </div>
        </div>
    </form>


<!--<h1 class="error"><?=t('Page Not Found')?></h1>

<?=t('No page could be found at this address.')?>

<? if (is_object($c)) { ?>
	<br/><br/>
	<? $a = new Area("Main"); $a->display($c); ?>
<? } ?>

<br/><br/>

<a href="<?=DIR_REL?>/"><?=t('Back to Home')?></a>.-->