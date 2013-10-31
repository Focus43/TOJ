<? defined('C5_EXECUTE') or die(_("Access Denied."));

$navItems = $controller->getNavItems();

/*** STEP 1 of 2: Determine all CSS classes (only 2 are enabled by default, but you can un-comment other ones or add your own) ***/
$departmentPage = Page::getCurrentPage();
$departmentName = $departmentPage->getCollectionName();
$departmentURL  = View::url( $departmentPage->getCollectionPath() );

foreach ($navItems as $index => $ni) {
    $classes = array();

    if ($ni->isCurrent) {
        //class for the page currently being viewed
        $classes[] = 'active';
    }

    if ($ni->inPath) {
        //class for parent items of the page currently being viewed
        $classes[] = 'active';
    }

    $classes[] = "depth-{$ni->level}";

    //Put all classes together into one space-separated string
    $ni->classes = implode(" ", $classes);

    if( $index === 0 && is_object($ni) ){
        $departmentPage = Page::getByID( $ni->cObj->cParentID );
        if( $departmentPage instanceof Page ){
            $departmentName = $departmentPage->getCollectionName();
            $departmentURL  = View::url( $departmentPage->getCollectionPath() );
        }
    }
} ?>

<nav class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#departmentNavList">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo $departmentURL; ?>"><?php echo $departmentName; ?> Links</a>
    </div>

    <div id="departmentNavList" class="collapse navbar-collapse">
        <?php if( count($navItems) >= 1 ){
            //*** Step 2 of 2: Output menu HTML ***/
            echo '<ul class="nav navbar-nav">'; //opens the top-level menu

            foreach ($navItems as $ni) {
                echo '<li class="' . $ni->classes . ($ni->hasSubmenu ? ' dropdown' : '') . '">'; //opens a nav item
                echo '<a href="' . $ni->url . '" target="' . $ni->target . '" class="' . ($ni->hasSubmenu ? 'dropdown-toggle ' : '') . $ni->classes . '"' . ($ni->hasSubmenu ? 'data-toggle="dropdown"' : '') . '>' . $ni->name . ($ni->hasSubmenu ? ' <i class="icon-chevron-down"></i>' : '') . '</a>';
                if ($ni->hasSubmenu) {
                    echo '<ul class="dropdown-menu">'; //opens a dropdown sub-menu
                } else {
                    echo '</li>'; //closes a nav item
                    echo str_repeat('</ul></li>', $ni->subDepth); //closes dropdown sub-menu(s) and their top-level nav item(s)
                }
            }

            echo '</ul>'; //closes the top-level menu
        } ?>
    </div>
</nav>