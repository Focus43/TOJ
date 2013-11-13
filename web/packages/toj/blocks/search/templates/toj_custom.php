<? defined('C5_EXECUTE') or die("Access Denied."); ?>
<style type="text/css">
    .searchBox {position:relative;}
    .searchBox input {position:relative;z-index:2;padding-left:35px;}
    .searchBox i {position:absolute;z-index:3;font-size:1.7em;left:8px;top:10px;}
    .searchBox button {position:absolute;z-index:3;right:0;top:0;}
    .ccm-search-block-form h3 {margin-top:6px;}
    .ccm-search-block-form .ccm-pagination {text-align:center;}
    .ccm-search-block-form .ccm-pagination span {display:inline-block;}
    .ccm-search-block-form .ccm-pagination span span,
    .ccm-search-block-form .ccm-pagination span a,
    .ccm-search-block-form .ccm-pagination span strong {display:block;padding:5px 1em;}
</style>

<? if (isset($error)) { ?>
	<?=$error?><br/><br/>
<? } ?>

<form action="<?=$this->url( $resultTargetURL )?>" method="get" class="ccm-search-block-form">

	<? if(strlen($query)==0){ ?>
	<input name="search_paths[]" type="hidden" value="<?=htmlentities($baseSearchPath, ENT_COMPAT, APP_CHARSET) ?>" />
	<? } else if (is_array($_REQUEST['search_paths'])) { 
		foreach($_REQUEST['search_paths'] as $search_path){ ?>
			<input name="search_paths[]" type="hidden" value="<?=htmlentities($search_path, ENT_COMPAT, APP_CHARSET) ?>" />
	<?  }
	} ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="searchBox">
                <input name="query" id="googleSearchInput" type="text" class="form-control input-lg" placeholder="Site Search" value="<?=htmlentities($query, ENT_COMPAT, APP_CHARSET)?>" />
                <i class="fa fa-search"></i>
                <button type="submit" id="googleSearchButton" class="btn btn-info btn-lg">Search</button>
            </div>
        </div>
        <div class="list-group">
            <? $tt = Loader::helper('text');
                if ($do_search) {
                    if(count($results)==0){ ?>
                        <li class="list-group-item">
                            <h4 style="margin-top:32px"><?=t('There were no results found. Please try another keyword or phrase.')?></h4>
                        </li>
                    <? }else{ ?>
                        <? foreach($results as $r) {
                            $currentPageBody = $this->controller->highlightedExtendedMarkup($r->getBodyContent(), $query);?>
                            <li class="list-group-item">
                                <h3><a href="<?=$r->getPath()?>" class="<?php echo (Collection::getByID($r->cID)->getVersionObject()->ctHandle === 'modal') ? 'modalize' : ''; ?>"><?=$r->getName()?></a></h3>
                                <p>
                                    <? if ($r->getDescription()) { ?>
                                        <?php  echo $this->controller->highlightedMarkup($tt->shortText($r->getDescription()),$query)?><br/>
                                    <? } ?>
                                    <?php echo $currentPageBody; ?>
                                    <a href="<?php  echo $r->getPath(); ?>" class="pageLink"><?php  echo $this->controller->highlightedMarkup($r->getPath(),$query)?></a>
                                </p>
                            </li>
                        <? 	}//foreach search result ?>
                    <?
                    } //results found
                }
            ?>
        </div>
        <div class="panel-footer">
            <? if($paginator && strlen($paginator->getPages())>0){ ?>
                <div class="ccm-pagination">
                    <span class="ccm-page-left"><?=$paginator->getPrevious()?></span>
                    <?=$paginator->getPages()?>
                    <span class="ccm-page-right"><?=$paginator->getNext()?></span>
                </div>
            <? } ?>
        </div>
    </div>
</form>