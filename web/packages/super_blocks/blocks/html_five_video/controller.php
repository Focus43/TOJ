<?php defined('C5_EXECUTE') or die("Access Denied.");
	
	
	/**
	 * This is an implementation of the Ace javascript code editor, for
	 * use w/in C5 as a block.
	 * 
	 * http://ace.ajax.org/
	 */
	class HtmlFiveVideoBlockController extends BlockController {

		const VIDEO_TYPE_MP4	 = 'video/mp4',
			  VIDEO_TYPE_OGG	 = 'video/ogg',
			  VIDEO_TYPE_WEBM	 = 'video/webm';
			  //VIDEO_TYPE_YOUTUBE = 'video/youtube';

		protected $btTable 									= 'btHtmlFiveVideo';
		protected $btInterfaceWidth 						= '585';
		protected $btInterfaceHeight						= '440';
		protected $btCacheBlockRecord 						= true;
		protected $btCacheBlockOutput 						= true;
		protected $btCacheBlockOutputOnPost 				= true;
		protected $btCacheBlockOutputForRegisteredUsers 	= true;
		protected $btCacheBlockOutputLifetime 				= CACHE_LIFETIME;
		
		public $srcMp4FileID,
			   $srcOggFileID,
			   $srcWebmFileID,
			   //$srcYoutube,
			   $posterFileID,
			   $width,
			   $height,
			   $captions,
			   $autoplay,
			   $showControls = 1,
			   $preload,
			   $loopVideo;
		
		public function getBlockTypeDescription(){
			return t("Add HTML5 Video (OGG and MPG Formats)");
		}
		
		
		public function getBlockTypeName(){
			return t("HTML5 Video");
		}
		
		
		public function view(){			
			if( $this->srcMp4FileObj(true) ){
				$this->set('canViewMp4', $this->canViewMp4Version());
			}
			
			if( $this->srcOggFileObj(true) ){
				$this->set('canViewOgg', $this->canViewOggVersion());
			}
			
			if( $this->srcWebmFileObj(true) ){
				$this->set('canViewWebm', $this->canViewWebmVersion());
			}
		}
		
		
		/**
		 * Get the full URL to the block tools directory
		 * @return string
		 */
		protected function getBlockToolsURL( $resource = null ){
			if( $this->_btUrl == null ){
				$this->_btUrl = Loader::helper('concrete/urls')->getBlockTypeToolsURL(BlockType::getByHandle('html_five_video'));
			}
			return $resource ? "{$this->_btUrl}/$resource" : $this->_btUrl;
		}
		
		
		/**
		 * Get URL to the captions file
		 * @return string
		 */
		public function captionsURL(){
			return $this->getBlockToolsURL('captions') . '?' . http_build_query(array(
				'blockID' => $this->bID
			));
		}
		
		
		/**
		 * Get the string to output as tags in the <video> html tag
		 */
		public function getVideoTagAttributes(){
			$controls 	= (bool) $this->showControls ? 'controls' : '';
			$autoplay	= (bool) $this->autoplay ? 'autoplay' : '';
			$loop		= (bool) $this->loopVideo ? 'loop' : '';
			$preload	= (bool) $this->preload ? 'preload="auto"' : 'preload="none"';
			$poster		= ($this->posterImageFileObj(true)) ? 'poster="'.$this->posterImageFileObj()->getURL().'"' : '';
			$width		= ($this->width != '') ? 'width="'.$this->width.'"' : '';
			$height		= ($this->height != '') ? 'height="'.$this->height.'"' : '';
			return trim( t("%s %s %s %s %s %s %s", $controls, $autoplay, $loop, $poster, $width, $height, $preload) );
		}
		
		
		/**
		 * Render a <source> tag inside the <video> html tag
		 */
		public function renderSourceTag( File $mixedVideoSrc, $type = self::VIDEO_TYPEMP4 ){
			// dealing with a local file object, get the source url
			if( $mixedVideoSrc instanceof File ){
				return t('<source src="%s" type="%s" />', $mixedVideoSrc->getURL(), $type);
			}
			
			// otherwise, its the youtube source to the video (so a link type string)
			//return t('<source src="%s" type="%s" />', $mixedVideoSrc, $type);
		}
		
		
		/**
		 * Does a) the file exist (is approved)? and b) does user have read-permission?
		 */
		public function canViewMp4Version(){
			if( $this->_mp4FilePermissionObj == null ){
				$this->_mp4FilePermissionObj = new Permissions( $this->srcMp4FileObj() );
			}
			return $this->_mp4FilePermissionObj->canRead();
		}
		
		
		/**
		 * Does a) the file exist (is approved)? and b) does user have read-permission?
		 */
		public function canViewOggVersion(){
			if( $this->_oggFilePermissionObj == null ){
				$this->_oggFilePermissionObj = new Permissions( $this->srcOggFileObj() );
			}
			return $this->_oggFilePermissionObj->canRead();
		}
		
		
		/**
		 * Does a) the file exist (is approved)? and b) does user have read-permission?
		 */
		public function canViewWebmVersion(){
			if( $this->_webmPermissionObj == null ){
				$this->_webmPermissionObj = new Permissions( $this->srcWebmFileObj() );
			}
			return $this->_webmPermissionObj->canRead();
		}
		
		
		/**
		 * @return FileVersion
		 */
		public function srcMp4FileObj( $testIsApproved = false ){
			if( $this->_srcMp4FileObj == null ){
				$this->_srcMp4FileObj = File::getByID( $this->srcMp4FileID );
			}
			return ($testIsApproved) ? $this->_srcMp4FileObj->isApproved() : $this->_srcMp4FileObj;
		}
		
		
		/**
		 * @return FileVersion
		 */
		public function srcOggFileObj( $testIsApproved = false ){
			if( $this->_srcOggFileObj == null ){
				$this->_srcOggFileObj = File::getByID( $this->srcOggFileID );
			}
			return ($testIsApproved) ? $this->_srcOggFileObj->isApproved() : $this->_srcOggFileObj;
		}
		
		
		/**
		 * @return FileVersion
		 */
		public function srcWebmFileObj( $testIsApproved = false ){
			if( $this->_srcWebmFileObj == null ){
				$this->_srcWebmFileObj = File::getByID( $this->srcWebmFileID );
			}
			return ($testIsApproved) ? $this->_srcWebmFileObj->isApproved() : $this->_srcWebmFileObj;
		}
		
		
		/**
		 * @return File
		 */
		public function posterImageFileObj( $testIsApproved = false ){
			if( $this->_posterImageFileObj == null ){
				$this->_posterImageFileObj = File::getByID( $this->posterFileID );
			}
			return ($testIsApproved) ? $this->_posterImageFileObj->isApproved() : $this->_posterImageFileObj;
		}
		
		
		public function save( $data ){
			$args['srcMp4FileID'] 	= (int) $data['srcMp4FileID'];
			$args['srcOggFileID']	= (int) $data['srcOggFileID'];
			$args['srcWebmFileID']	= (int) $data['srcWebmFileID'];
			//$args['srcYoutube']		= $data['srcYoutube'];
			$args['posterFileID']	= (int) $data['posterFileID'];
			$args['width']			= $data['width'];
			$args['height']			= $data['height'];
			$args['captions']		= $data['captions'];
			// attributes
			$args['autoplay']		= (int) in_array('autoplay', (array) $data['attributes']);
			$args['showControls']	= (int) in_array('showControls', (array) $data['attributes']);
			$args['preload']		= (int) in_array('preload', (array) $data['attributes']);
			$args['loopVideo']		= (int) in_array('loopVideo', (array) $data['attributes']);
			parent::save( $args );
		}
		
	}