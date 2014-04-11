<?php defined('C5_EXECUTE') or die("Access Denied.");
    /** @var CustomStyleRule $csr */
    $csr = $this->getBlockObject()->getBlockCustomStyleRule();
    // extract the bg color from the style preset and configure it as an rgba *alpha* background
    if( $csr instanceof CustomStyleRule ){
        $styles = $csr->getCustomStyleRuleCustomStylesArray();
        $rgb = Loader::helper('hex_rgb', 'toj')->hex2rgb( $styles['background_color'], true );
        $bgStyle = "background:none !important;background-color:rgba($rgb,.7) !important;";
    }
?>

    <a href="<?php echo $linkUrl; ?>" target="<?php echo $linkTarget; ?>" class="btn-app-style <?php echo $classes; ?>" style="<?php echo $bgStyle; ?>">
        <i class="fa <?php echo $this->controller->fontAwesomeIcon; ?>"></i>
        <span><?php echo $linkDisplayText; ?></span>
    </a>