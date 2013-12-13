<?php

    class ModalPageTypeController extends TojPageController {

        public function on_start(){
            if( $this->pagePermissionObject()->canWrite() && !((bool)$_REQUEST['modal'] === true)){
                $this->includeThemeAssets = true;
                $this->set('managementMode', true);
            }

            parent::on_start();
        }

    }