<div class="row-fluid">
    <div class="span12">
        <div id="breadcrumbs" class="clearfix">
            <div class="pull-left">
                <?php
                    $bt = BlockType::getByHandle('autonav');
                    $bt->controller->orderBy 					= 'display_asc';
                    $bt->controller->displayPages 				= 'top';
                    $bt->controller->displaySubPages 			= 'relevant_breadcrumb';
                    $bt->controller->displaySubPageLevels 		= 'all';
                    $bt->render('templates/toj_breadcrumbs');
                ?>
            </div>
            <div class="pull-right">
                <a class="hidden-phone">
                    <i class="icon-facebook-sign"></i><i class="icon-twitter-sign"></i><i class="icon-google-plus-sign"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <h1><?php echo Page::getCurrentPage()->getCollectionName(); ?> <?php if(!($hideDescription === true)): ?><small class="visible-desktop"><?php echo Page::getCurrentPage()->getCollectionDescription(); ?></small><?php endif; ?></h1>
    </div>
</div>