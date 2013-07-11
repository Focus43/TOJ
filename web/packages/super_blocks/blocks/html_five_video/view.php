<?php defined('C5_EXECUTE') or die("Access Denied.");
// All of these will be set to true or false (hence, just testing for isset() instead of true/false)
// *if* there is at least one valid video file uploaded. Otherwise, *none* of these will be set, and
// we output the message that there are no valid video files to view.
?>

<?php if( isset($canViewMp4) || isset($canViewOgg) || isset($canViewWebm) ){ ?>
	
	<?php if( !$canViewMp4 && !$canViewOgg && !$canViewWebm ){ /* no permission to ANY? */ ?>
		
		<div class="well">You don't have permission to view this video.</div>
		
	<?php }else{ ?>
			
			<video id="html5Video-<?php echo $this->controller->bID; ?>" class="video-js vjs-default-skin" <?php echo $this->controller->getVideoTagAttributes(); ?>>
				<?php
					if( $canViewMp4 ){
						echo $this->controller->renderSourceTag( $this->controller->srcMp4FileObj(), HtmlFiveVideoBlockController::VIDEO_TYPE_MP4 );
					}
					
					if( $canViewOgg ){
						echo $this->controller->renderSourceTag( $this->controller->srcOggFileObj(), HtmlFiveVideoBlockController::VIDEO_TYPE_OGG );
					}
					
					if( $canViewWebm ){
						echo $this->controller->renderSourceTag( $this->controller->srcWebmFileObj(), HtmlFiveVideoBlockController::VIDEO_TYPE_WEBM );
					}
				?>
				
				<?php if( $this->controller->captions != '' ){ ?>
					<track kind="captions" src="<?php echo $this->controller->captionsURL(); ?>" srclang="en" label="English" />
				<?php } ?>
			</video>
				
			<script>
				_V_.options.flash.swf = '<?php echo $this->getBlockURL(); ?>/video-js.swf';
			</script>
			
	<?php } ?>
	
<?php }else{ ?>
	
	<div class="well">
		Video file no longer available.
	</div>
	
<?php }