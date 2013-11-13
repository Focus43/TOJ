<div class="innerHead">

    <div class="breadcrumbSocial row">
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
                <div class="social-tw"><a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a></div>
                <div class="social-fb"><div class="fb-share-button" data-type="button_count"></div></div>
            </div>
        </div>
    </div>

    <div class="pageTitle row">
        <div class="col-sm-12">
            <?php if( $showAuthor === true ): ?>
                <div class="pageMeta pull-right">
                    <div class="circle"><?php echo Page::getCurrentPage()->getCollectionDatePublic('M d, Y'); ?></div>
                    <div class="circle img" style="background-image:url('<?php echo $avatarPath; ?>')"></div>
                    <span class="name"><?php echo $authorName; ?></span>
                </div>
            <?php endif; ?>
            <h1 class="<?php echo $titleClass; ?>"><?php echo Page::getCurrentPage()->getCollectionName(); ?> <?php if(!($hideDescription === true)): ?><small class="visible-desktop"><?php echo Page::getCurrentPage()->getCollectionDescription(); ?></small><?php endif; ?></h1>
        </div>
    </div>

</div>