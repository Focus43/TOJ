<?php

    class TojPageController extends Controller {
        
        const PACKAGE_HANDLE    = 'toj',
              FLASH_TYPE_OK     = 'success',
              FLASH_TYPE_ERROR  = 'error';
              
        protected $requireHttps = false;
        
        
        /**
         * Ruby on Rails "flash" functionality ripoff.
         * @param string $msg Optional, set the flash message
         * @param string $type Optional, set the class for the alert
         * @return void
         */
        public function flash( $msg = 'Success', $type = self::FLASH_TYPE_OK ){
            $_SESSION['flash_msg'] = array(
                'msg'  => $msg,
                'type' => $type
            );
        }


        /**
         * If the page background attribute is set explicitly on the page, that
         * takes precedence. Otherwise, look for and return a randomized image from
         * the Page Backgrounds set.
         * @return string || void
         */
        protected function getPageBackgroundImageURL(){
            $fileObj = $this->getCollectionObject()->getAttribute('page_background');
            if( $fileObj instanceof File ){
                return $fileObj->getRecentVersion()->getRelativePath();
            }

            // get a random one from the Page Backgrounds file set
            $fileListObj = new FileList;
            $fileListObj->filterByExtension('jpg');
            $fileListObj->filterBySet( FileSet::getByName('Page Backgrounds') );
            $imagesList = $fileListObj->get();
            if( !empty($imagesList) ){
                $imageObj = $imagesList[ array_rand($imagesList, 1) ];
                if( $imageObj instanceof File ){
                    return $imageObj->getRecentVersion()->getRelativePath();
                }
            }
        }
        
        
        /**
         * Add js/css + tools URL meta tag; clear the flash.
         * @return void
         */
        public function on_start(){         
            // force https (if $requireHTTPS == true)
            if( $this->requireHttps == true && !( isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on') ) ){
                header("Location: " . str_replace('http', 'https', BASE_URL . Page::getCurrentPage()->getCollectionPath()));
            }
            
            // include main theme assets? (set in the child controller class)
            if( $this->includeThemeAssets === true ){
                $this->_includeThemeAssets();
            }
            
            // body classes (used for edit mode stuff)
            $permissions = new Permissions( $this->getCollectionObject() );
            if( $permissions->canAdminPage() ){
                $bodyClasses = array('editable');
                if( $this->getCollectionObject()->isEditMode() ){
                    $bodyClasses[] = 'editMode';
                }
                $this->set('bodyClass', join($bodyClasses, ' '));
            }
            
            // message flash
            if( isset($_SESSION['flash_msg']) ){
                $this->set('flash', $_SESSION['flash_msg']);
                unset($_SESSION['flash_msg']);
            }
        }


        /**
         * Add "async" attribute to javascript tag output
         * @param $string
         * @return string
         */
        protected function jsAsync( $string ){
            return preg_replace('/<script/', '<script async', $string);
        }


        /**
         * Include assets used for page templates
         * @return void
         */
        protected function _includeThemeAssets(){
            // header and CSS items
            $this->addHeaderItem('<meta id="tojAppPaths" data-js="/packages/toj/js/" data-tools="/tools/packages/toj/" data-images="/packages/toj/images/" />');
            $this->addHeaderItem( $this->getHelper('html')->css('toj-app.min.css', self::PACKAGE_HANDLE) );
            $this->addHeaderItem( $this->getHelper('html')->javascript('libs/modernizr.min.js', self::PACKAGE_HANDLE) );
            
            // ie8 stylesheet
            $ieShim = "<!--[if lt IE 9]>\n" . $this->getHelper('html')->css('ie8.css', self::PACKAGE_HANDLE) . "\n<![endif]-->\n";
            $ieShim .= "<!--[if lt IE 8]>\n" . $this->getHelper('html')->css('font-awesome-ie7.min.css', self::PACKAGE_HANDLE) . "\n<![endif]-->";
            $this->addHeaderItem( $ieShim );

            if( DEPLOYMENT_STATUS_PRODUCTION === true ){
                $this->addFooterItem( $this->jsAsync($this->getHelper('html')->javascript('toj-app.min.js', self::PACKAGE_HANDLE)) );
            }else{
                $this->addFooterItem( $this->jsAsync($this->getHelper('html')->javascript('toj-app.dev.js', self::PACKAGE_HANDLE)) );
            }
        }
        
        
        /**
         * Same as $view->action(), but returns a fully qualified URL prepended
         * with https://
         * @param string $action
         * @param string $task(s)
         * @return string
         */
        public function secureAction($action, $task = null){
            $args = func_get_args();
            array_unshift($args, Page::getCurrentPage()->getCollectionPath());
            $path = call_user_func_array(array('View', 'url'), $args);
            return 'https://' . $_SERVER['HTTP_HOST'] . $path;
        }
        
        
        /**
         * Send back an ajax response if request headers accept json, or handle 
         * redirect if just doing regular http
         * @param bool $okOrFail
         * @param mixed String || Array $message
         * @return void
         */
        protected function formResponder( $okOrFail, $message ){
            $accept = explode( ',', $_SERVER['HTTP_ACCEPT'] );
            $accept = array_map('trim', $accept);
            
            
            // send back a JSON response
            if( in_array($accept[0], array('application/json', 'text/javascript')) || $_SERVER['X_REQUESTED_WITH'] == 'XMLHttpRequest'){
                header('Content-Type: application/json');
                echo json_encode( (object) array(
                    'code'      => (int) $okOrFail,
                    'messages'  => is_array($message) ? $message : array($message)
                ));
                exit;
            }

            // somehow a plain old html browser request got through, redirect it
            $this->flash( $message, ((bool)$okOrFail === true ? self::FLASH_TYPE_OK : self::FLASH_TYPE_ERROR) );
            $this->redirect( Page::getCurrentPage()->getCollectionPath() );
        }
        
        
        /**
         * "Memoize" helpers so they're only loaded once.
         * @param string $handle Handle of the helper to load
         * @param string $pkg Package to get the helper from
         * @return ...Helper class of some sort
         */
        public function getHelper( $handle, $pkg = false ){
            $helper = '_helper_' . preg_replace("/[^a-zA-Z0-9]+/", "", $handle);
            if( $this->{$helper} === null ){
                $this->{$helper} = Loader::helper($handle, $pkg);
            }
            return $this->{$helper};
        }
        
    }
