<?php defined('C5_EXECUTE') or die(_("Access Denied."));
	
	class SuperBlocksPackage extends Package {
	
	    protected $pkgHandle 			= 'super_blocks';
	    protected $appVersionRequired 	= '5.6.1.2';
	    protected $pkgVersion 			= '0.02';
	
		
		/**
		 * @return string
		 */
	    public function getPackageName(){
	        return t('Super Blocks');
	    }
		
		
		/**
		 * @return string
		 */
	    public function getPackageDescription() {
	        return t('Custom Block Utilities');
	    }


        /**
         * @return void
         */
        public function on_start(){
            define('SUPER_BLOCKS_PACKAGE_DIR', $this->packageObject()->getRelativePath());
            define('SUPER_BLOCKS_TOOLS_URL', BASE_URL . REL_DIR_FILES_TOOLS_PACKAGES . '/' . $this->pkgHandle . '/');
        }


        /**
		 * Proxy to the parent uninstall method
		 * @return void
		 */
	    public function uninstall() {
	        parent::uninstall();
			
			try {
				
			}catch(Exception $e){ /* FAIL GRACEFULLY */ }
	    }
	    
		
		/**
		 * @return void
		 */
	    public function upgrade(){
			parent::upgrade();
			$this->installAndUpdate();
	    }
		
		
		/**
		 * @return void
		 */
		public function install() {
	    	$this->_packageObj = parent::install(); 
			$this->installAndUpdate();
	    }
		
		
		/**
		 * Handle all the updating methods
		 * @return void
		 */
		private function installAndUpdate(){
			$this->setupBlocks();
		}


		/**
		 * @return SuperBlocksPackage
		 */
		private function setupBlocks(){
            // PageChoozer
            if(!is_object(BlockType::getByHandle('page_choozer'))) {
                BlockType::installBlockTypeFromPackage('page_choozer', $this->packageObject());
            }

            // Button Link
            if(!is_object(BlockType::getByHandle('button_link'))) {
                BlockType::installBlockTypeFromPackage('button_link', $this->packageObject());
            }

            // Ace Code Editor
            if(!is_object(BlockType::getByHandle('ace_code_editor'))) {
                BlockType::installBlockTypeFromPackage('ace_code_editor', $this->packageObject());
            }

            // Ace Code Editor
            if(!is_object(BlockType::getByHandle('html_five_video'))) {
                BlockType::installBlockTypeFromPackage('html_five_video', $this->packageObject());
            }
			
			return $this;
		}


        /**
         * Get the package object; if it hasn't been instantiated yet, load it.
         * @return Package
         */
        private function packageObject(){
            if( $this->_packageObj === null ){
                $this->_packageObj = Package::getByHandle( $this->pkgHandle );
            }
            return $this->_packageObj;
        }
	    
	}
