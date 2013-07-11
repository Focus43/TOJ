<?php defined('C5_EXECUTE') or die("Access Denied.");
	
	
	/**
	 * This is an implementation of the Ace javascript code editor, for
	 * use w/in C5 as a block.
	 * 
	 * http://ace.ajax.org/
	 */
	class AceCodeEditorBlockController extends BlockController {

		protected $btTable 									= 'btAceCodeEditor';
		protected $btInterfaceWidth 						= '750';
		protected $btInterfaceHeight						= '500';
		protected $btCacheBlockRecord 						= false;
		protected $btCacheBlockOutput 						= false;
		protected $btCacheBlockOutputOnPost 				= false;
		protected $btCacheBlockOutputForRegisteredUsers 	= true;
		protected $btCacheBlockOutputLifetime 				= CACHE_LIFETIME;
		
		
		public $height = 248;
		
		
		public function getAceJsDirPath(){
			return Loader::helper('concrete/urls')->getPackageURL( Package::getByHandle('super_blocks')) . '/js/ace-builds-master/src-min-noconflict/';
		}
		
		
		public function getBlockTypeDescription(){
			return t("Javascript-based, inline code editor");
		}
		
		
		public function getBlockTypeName(){
			return t("Ace Code Editor");
		}
		
		
		public function on_page_view(){
			$this->addHeaderItem('<meta name="aceJsDirPath" value="'.$this->getAceJsDirPath().'" />');
            $this->addFooterItem($this->getHelper('html')->javascript('ace_dependencies.js', 'super_blocks'));
		}
		
		
		public function view(){
			$this->set('aceJsDirPath', $this->getAceJsDirPath());
		}
		
		
		public function add(){
			$this->addAndEdit();
		}
		
		
		public function edit(){
			$this->addAndEdit();
		}
		
		
		private function addAndEdit(){
			$this->set('aceJsDirPath', $this->getAceJsDirPath());
		}
		
		
		public function save( $data ){
			$args['content'] = htmlspecialchars( $data['content'] );
			$args['height']	 = (int) $data['height'];
			parent::save( $args );
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