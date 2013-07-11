<?php defined('C5_EXECUTE') or die("Access Denied.");

    if( Page::getCurrentPage()->isEditMode() ){ ?>
        <div style="padding:10px;background:#e1e1e1;">Output is disabled while in edit mode.</div>
    <?php }else{
        echo htmlspecialchars_decode( $this->controller->content );
    }
