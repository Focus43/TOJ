<?php defined('C5_EXECUTE') or die("Access Denied.");

    /**
     * Modal pages are special cases where we may want to exclude the complete page
     * wrapper, and just send the inner content.
     */
    class ModalPageTypeController extends TojPageController {

        public function on_start(){
            if( $this->pagePermissionObject()->canWrite() && !((bool)$_REQUEST['modal'] === true)){
                $this->includeThemeAssets = true;
                $this->set('managementMode', true);
            }

            parent::on_start();
        }

    }