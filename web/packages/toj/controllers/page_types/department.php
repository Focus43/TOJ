<?php

    class DepartmentPageTypeController extends TojPageController {
        
        protected $includeThemeAssets = true;

        public function on_start(){
            $this->set('backgroundImage', $this->getPageBackgroundImageURL());
            parent::on_start();
        }
        
    }