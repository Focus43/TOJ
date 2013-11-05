<div id="landingPageHeader">
    <div class="topper row">
        <div class="col-sm-12">
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
            <div class="sociable pull-right hidden-xs">
                <a title="Share On Facebook"><i class="fa fa-facebook-square"></i></a>
                <a title="Share On Twitter"><i class="fa fa-twitter-square"></i></a>
                <a title="Share On Google Plus"><i class="fa fa-google-plus-square"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php if( $showAuthor === true ): ?>
                <div class="newsPostMeta pull-right">
                    <div class="circle"><?php echo Page::getCurrentPage()->getCollectionDatePublic('M d, Y'); ?></div>
                    <div class="circle img" style="background-image:url('<?php echo $avatarPath; ?>')"></div>
                    <span class="name"><?php echo $authorName; ?></span>
                </div>
            <?php endif; ?>
            <h1 class="<?php echo $titleClass; ?>"><?php echo Page::getCurrentPage()->getCollectionName(); ?> <?php if(!($hideDescription === true)): ?><small class="visible-desktop"><?php echo Page::getCurrentPage()->getCollectionDescription(); ?></small><?php endif; ?></h1>
        </div>
    </div>
</div>