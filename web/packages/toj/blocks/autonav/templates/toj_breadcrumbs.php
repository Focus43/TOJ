<? defined('C5_EXECUTE') or die(_("Access Denied."));

$navItems = $controller->getNavItems(true); ?>

<ul id="breadCrumbs">
    <?php for ($i = 0; $i < count($navItems); $i++):
            $ni = $navItems[$i];

            if ($ni->isCurrent) {
                echo '<li class="current"><a>' . $ni->name . '</a></li>';
            } else {
                echo '<li><a href="' . $ni->url . '" target="' . $ni->target . '">' . $ni->name . '</a></li>';
            }
    endfor; ?>
</ul>