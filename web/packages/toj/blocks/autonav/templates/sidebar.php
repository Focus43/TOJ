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
}

if( count($navItems) >= 1 ){
    //*** Step 2 of 2: Output menu HTML ***/
    echo '<ul id="sidebarNav" class="nav nav-list">'; //opens the top-level menu

    $parentID = Page::getCollectionParentIDFromChildID( $navItems[0]->cID );
    $parent   = Page::getByID( $parentID );
    echo '<li class="nav-header">' . $parent->getCollectionName() . '</li>';

    foreach ($navItems as $ni) {

        echo '<li class="' . $ni->classes . '">'; //opens a nav item

        echo '<a href="' . $ni->url . '" target="' . $ni->target . '" class="' . $ni->classes . '">' . $ni->name . '</a>';

        if ($ni->hasSubmenu) {
            echo '<ul>'; //opens a dropdown sub-menu
        } else {
            echo '</li>'; //closes a nav item
            echo str_repeat('</ul></li>', $ni->subDepth); //closes dropdown sub-menu(s) and their top-level nav item(s)
        }
    }

    echo '</ul>'; //closes the top-level menu
}