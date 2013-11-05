<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

    <a href="<?php echo $linkUrl; ?>" target="<?php echo $linkTarget; ?>" class="<?php echo $classes; ?>">
        <i class="fa <?php echo $this->controller->fontAwesomeIcon; ?>"></i>
        <span><?php echo $linkDisplayText; ?></span>
    </a>