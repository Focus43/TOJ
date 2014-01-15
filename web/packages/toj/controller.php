<?php defined('C5_EXECUTE') or die(_("Access Denied."));
	
	class TojPackage extends Package {
	
	    protected $pkgHandle 			= 'toj';
	    protected $appVersionRequired 	= '5.6.1.2';
	    protected $pkgVersion 			= '0.68';
	
		
		/**
		 * @return string
		 */
	    public function getPackageName(){
	        return t('Town Of Jackson');
	    }
		
		
		/**
		 * @return string
		 */
	    public function getPackageDescription() {
	        return t('Town Of Jackson Site Package');
	    }
	
		
		/**
		 * Run hooks high up in the load chain
		 * @return void
		 */
	    public function on_start(){
	        define('TOJ_TOOLS_URL', BASE_URL . REL_DIR_FILES_TOOLS_PACKAGES . '/' . $this->pkgHandle . '/');
			define('TOJ_IMAGES_URL', DIR_REL . '/packages/' . $this->pkgHandle . '/images/');
			
			// autoload classes
			Loader::registerAutoload(array(
				// page controller
				'TojPageController'	=> array('library', 'toj_page_controller', $this->pkgHandle),
                'TojNewsPageList'   => array('model', 'news_page_list', $this->pkgHandle)
			));

            // hook into system events
            if( User::isLoggedIn() ){
                Events::extend('on_page_update', 'TojPageEvents', 'onPageUpdate', "packages/{$this->pkgHandle}/libraries/system_event_hooks/page_events.php");
            }
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
         * Run before install or upgrade to ensure dependencies are present
         * @dependency concrete_redis package
         */
        private function checkDependencies(){
            // test for the redis package
            $masonryPackage = Package::getByHandle('masonry_grid');
            $masonryPackageAvail = false;
            if( $masonryPackage instanceof Package ){
                if( (bool) $masonryPackage->isPackageInstalled() ){
                    $masonryPackageAvail = true;
                }
            }

            if( !$masonryPackageAvail ){
                throw new Exception('Installation requires the Masonry Grid package for Concrete5.');
            }
        }
	    
		
		/**
		 * @return void
		 */
	    public function upgrade(){
            $this->checkDependencies();
			parent::upgrade();
			$this->installAndUpdate();
	    }
		
		
		/**
		 * @return void
		 */
		public function install() {
            $this->checkDependencies();
	    	$this->_packageObj = parent::install(); 
			$this->installAndUpdate();
	    }
		
		
		/**
		 * Handle all the updating methods
		 * @return void
		 */
		private function installAndUpdate(){
			$this->setupUserGroups()
                 ->setupAttributeTypes()
                 ->attributeTypeAssociations()
				 ->setupUserAttributes()
				 ->setupCollectionAttributes()
				 ->setupBlocks()
				 ->setupTheme()
				 ->setupPageTypes()
				 ->setupSitePages()
                 ->setupFileSets();

            // remove weather block, if installed
            $weatherBlockType = BlockType::getByHandle('weather_widget');
            if( $weatherBlockType instanceof BlockType ){
                if( $weatherBlockType->canUninstall() ){
                    $weatherBlockType->delete();
                }
            }
		}
		
		
		/**
		 * @return TojPackage
		 */
		private function setupUserGroups(){
			if( !(Group::getByName('Department Admins') instanceof Group ) ){
				Group::add('Department Admins', 'Town Of Jackson Department Admins');
			}
			
			return $this;
		}


        /**
         * @return TojPackage
         */
        private function setupAttributeTypes(){
            if( ! is_object($this->attributeType('selectable')) ){
                AttributeType::add('selectable', t('Selectable'), $this->packageObject());
            }

            return $this;
        }


        /**
         * @return TojPackage
         */
        private function attributeTypeAssociations(){
            try {
                if( is_object( $this->attributeKeyCategory('collection') ) ){
                    $this->attributeKeyCategory('collection')->associateAttributeKeyType( $this->attributeType('selectable') );
                }
            }catch(Exception $e){ /* KEY IS ALREADY ASSIGNED; FAIL GRACEFULLY */ }

            return $this;
        }


		/**
		 * @return TojPackage
		 */
		private function setupUserAttributes(){
			if( !(is_object(UserAttributeKey::getByHandle('first_name'))) ){
				UserAttributeKey::add($this->attributeType('text'), array(
					'akHandle'					=> 'first_name', 
					'akName'					=> t('First Name'),
					'uakRegisterEdit'			=> 1,
					'uakRegisterEditRequired' 	=> 1
				), $this->packageObject())->setAttributeSet( $this->getOrCreateAttributeSet('user_info', 'user') );
			}
			
			if( !(is_object(UserAttributeKey::getByHandle('last_name'))) ){
				UserAttributeKey::add($this->attributeType('text'), array(
					'akHandle'					=> 'last_name', 
					'akName'					=> t('Last Name'),
					'uakRegisterEdit'			=> 1,
					'uakRegisterEditRequired' 	=> 1
				), $this->packageObject())->setAttributeSet( $this->getOrCreateAttributeSet('user_info', 'user') );
			}
			
			return $this;
		}
		
		
		/**
	     * @return TojPackage 
	     */
	    private function setupCollectionAttributes(){
	        if( !is_object(CollectionAttributeKey::getByHandle('page_background')) ){
	            CollectionAttributeKey::add($this->attributeType('image_file'), array(
	                'akHandle'  => 'page_background',
	                'akName'    => 'Page Background'
	            ), $this->packageObject());
	        }

            if( !is_object(CollectionAttributeKey::getByHandle('alert_warning')) ){
                CollectionAttributeKey::add($this->attributeType('boolean'), array(
                    'akHandle'              => 'alert_warning',
                    'akName'                => 'Alert Level: Warning',
                    'akIsSearchableIndexed' => 1,
                    'akIsSearchable'        => 1
                ), $this->packageObject());
            }

            if( !is_object(CollectionAttributeKey::getByHandle('alert_critical')) ){
                CollectionAttributeKey::add($this->attributeType('boolean'), array(
                    'akHandle'              => 'alert_critical',
                    'akName'                => 'Alert Level: Critical',
                    'akIsSearchableIndexed' => 1,
                    'akIsSearchable'        => 1
                ), $this->packageObject());
            }

            if( !is_object(CollectionAttributeKey::getByHandle('sticky_until')) ){
                CollectionAttributeKey::add($this->attributeType('date_time'), array(
                    'akHandle'              => 'sticky_until',
                    'akName'                => 'Sticky Until',
                    'akIsSearchableIndexed' => 1,
                    'akIsSearchable'        => 1
                ), $this->packageObject());
            }

            if( !is_object(CollectionAttributeKey::getByHandle('agenda_type')) ){
                $agendaTypeAk = CollectionAttributeKey::add($this->attributeType('selectable'), array(
                    'akHandle'              => 'agenda_type',
                    'akName'                => 'Agenda Type',
                    'akIsSearchableIndexed' => 1,
                    'akIsSearchable'        => 1
                ), $this->packageObject());

                // setup alert level values
                SelectableAttributeTypeOption::create($agendaTypeAk, 'town_council', 'Town Council', 1);
                SelectableAttributeTypeOption::create($agendaTypeAk, 'pzcba', 'PZCBA', 2);
                SelectableAttributeTypeOption::create($agendaTypeAk, 'jim', 'Joint Information Meeting', 3);
            }
	        
	        return $this;
	    }


		/**
		 * @return TojPackage
		 */
		private function setupBlocks(){
            // Weather Widget
            //if(!is_object(BlockType::getByHandle('weather_widget'))) {
            //    BlockType::installBlockTypeFromPackage('weather_widget', $this->packageObject());
            //}
			
			return $this;
		}
		
		
		/**
		 * @return TojPackage
		 */
		private function setupTheme(){
            try {
                PageTheme::add('toj_wyo', $this->packageObject());
            }catch(Exception $e){ /* fail gracefully */ }
			
			return $this;
		}
		
		
		/**
		 * @return TojPackage
		 */
		private function setupPageTypes(){
			if( !is_object($this->pageType('home')) ){
	            CollectionType::add(array('ctHandle' => 'home', 'ctName' => 'Home'), $this->packageObject());
	        }

			if( !is_object($this->pageType('default')) ){
	            CollectionType::add(array('ctHandle' => 'default', 'ctName' => 'Default'), $this->packageObject());
	        }
			
			if( !is_object($this->pageType('full_width')) ){
	            CollectionType::add(array('ctHandle' => 'full_width', 'ctName' => 'Full Width'), $this->packageObject());
	        }

            if( !is_object($this->pageType('news_post')) ){
                CollectionType::add(array('ctHandle' => 'news_post', 'ctName' => 'News Post'), $this->packageObject());
                // assign default attribute "Alert Level"
                $this->pageType('news_post')->update(array(
                    'ctName'    => 'News Post',
                    'ctHandle'  => 'news_post',
                    'ctIcon'    => 'main.png',
                    'akID'      => array(
                        CollectionAttributeKey::getByHandle('alert_level')->getAttributeKeyID()
                    )
                ));
            }

            if( !is_object($this->pageType('modal')) ){
                CollectionType::add(array('ctHandle' => 'modal', 'ctName' => 'Modal'), $this->packageObject());
            }

            if( !is_object($this->pageType('department')) ){
                CollectionType::add(array('ctHandle' => 'department', 'ctName' => 'Department', 'ctIcon' => 'right_sidebar.png'), $this->packageObject());
            }

            if( !is_object($this->pageType('agenda')) ){
                CollectionType::add(array('ctHandle' => 'agenda', 'ctName' => 'Agenda'), $this->packageObject());
            }

			return $this;
		}
		
		
		/**
		 * @return TojPackage
		 */
		private function setupSitePages(){
            SinglePage::add('current', $this->packageObject());
            $agendasPage = SinglePage::add('agendas', $this->packageObject());
            if( is_object($agendasPage) ){
                $agendasPage->setAttribute('exclude_nav', 1);
                $agendasPage->setAttribute('exclude_page_list', 1);
            }

			return $this;
		}


        /**
         * @return TojPackage
         */
        private function setupFileSets(){
            if( ! (FileSet::getByName('Page Backgrounds') instanceof FileSet) ){
                FileSet::createAndGetSet('Page Backgrounds', FileSet::TYPE_PUBLIC);
            }

            return $this;
        }


		/**
		 * @param Page $parent The parent page that the page being added should go under
		 * @param string $name Name of the page
		 * @param string Handle of the page_type to use
		 * @return Page
		 */
		private function pageFactory( Page $parent, $name, $typeHandle = 'default' ){
			return $parent->add( $this->pageType($typeHandle), array(
				'cName' => $name,
				'pkgID' => $this->packageObject()->getPackageID()
			));
		}
		
		
		/**
		 * Get or create an attribute set, for a certain attribute key category (if passed).
		 * Will automatically convert the $attrSetHandle from handle_form_name to Handle Form Name
		 * @param string $attrSetHandle
		 * @param string $attrKeyCategory
		 * @return AttributeSet
		 */
		private function getOrCreateAttributeSet( $attrSetHandle, $attrKeyCategory = null ){
			if( $this->{ 'attr_set_' . $attrSetHandle } === null ){
				// try to load an existing Attribute Set
				$attrSetObj = AttributeSet::getByHandle( $attrSetHandle );
				
				// doesn't exist? create it, if an attributeKeyCategory is passed
				if( !is_object($attrSetObj) && !is_null($attrKeyCategory) ){
					// ensure the attr key category can allow multiple sets
					$akc = AttributeKeyCategory::getByHandle( $attrKeyCategory );
					$akc->setAllowAttributeSets( AttributeKeyCategory::ASET_ALLOW_MULTIPLE );
					
					// *now* add the attribute set
					$attrSetObj = $akc->addSet( $attrSetHandle, t( $this->getHelper('text')->unhandle($attrSetHandle) ), $this->packageObject() );
				}
				
				// assign the $attrSetObj
				$this->{ 'attr_set_' . $attrSetHandle } = $attrSetObj;
			}
			
			return $this->{ 'attr_set_' . $attrSetHandle };
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
		
		
		/**
		 * @return CollectionType
		 */
		private function pageType( $handle ){
			if( $this->{ "pt_{$handle}" } === null ){
				$this->{ "pt_{$handle}" } = CollectionType::getByHandle( $handle );
			}
			return $this->{ "pt_{$handle}" };
		}
		
		
		/**
		 * @return AttributeType
		 */
		private function attributeType( $atHandle ){
			if( $this->{ "at_{$atHandle}" } === null ){
                $attributeType = AttributeType::getByHandle( $atHandle );
                if( $attributeType->getAttributeTypeID() >= 1 ){
                    $this->{ "at_{$atHandle}" } = $attributeType;
                }

			}
			return $this->{ "at_{$atHandle}" };
		}
		
		
		/**
		 * Get an attribute key category object (eg: an entity category) by its handle
		 * @return AttributeKeyCategory
		 */
		private function attributeKeyCategory( $handle ){
			if( !($this->{ "akc_{$handle}" } instanceof AttributeKeyCategory) ){
				$this->{ "akc_{$handle}" } = AttributeKeyCategory::getByHandle( $handle );
			}
			return $this->{ "akc_{$handle}" };
		}
		
		
		/**
		 * "Memoize" helpers so they're only loaded once.
		 * @param string $handle Handle of the helper to load
		 * @param string $pkg Package to get the helper from
		 * @return ...Helper class of some sort
		 */
		private function getHelper( $handle, $pkg = false ){
			$helper = '_helper_' . preg_replace("/[^a-zA-Z0-9]+/", "", $handle);
			if( $this->{$helper} === null ){
				$this->{$helper} = Loader::helper($handle, $pkg);
			}
			return $this->{$helper};
		}
	    
	}
