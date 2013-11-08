<? defined('C5_EXECUTE') or die(_("Access Denied."));

$navItems = $controller->getNavItems();

/*** STEP 1 of 2: Determine all CSS classes (only 2 are enabled by default, but you can un-comment other ones or add your own) ***/
foreach ($navItems as $ni) {
    $classes = array();

    if ($ni->isCurrent) {
        //class for the page currently being viewed
        $classes[] = 'active';
    }

    if ($ni->inPath) {
        //class for parent items of the page currently being viewed
        $classes[] = 'nav-path-selected';
    }

    //Put all classes together into one space-separated string
    $ni->classes = implode(" ", $classes);
} ?>

<div class="panel panel-default">
<?php if( count($navItems) >= 1 ): ?>
    <div class="panel-heading">
        <?php echo Page::getByID( Page::getCollectionParentIDFromChildID( $navItems[0]->cID ) )->getCollectionName(); ?> Links
        <button class="visible-xs navbar-toggle" data-toggle="collapse" data-target="#sidebarCollapseTarget"><i class="fa fa-bars"></i></button>
    </div>
    <ul id="sidebarCollapseTarget" class="list-group collapse navbar-collapse">
        <?php
            foreach ($navItems as $ni) {
                echo '<li class="list-group-item ' . $ni->classes . '">'; //opens a nav item
                echo '<a href="' . $ni->url . '" target="' . $ni->target . '" class="' . $ni->classes . '">' . $ni->name . '</a>';
                echo '</li>';
            }
        ?>
    </ul>
<?php endif; ?>
</div>