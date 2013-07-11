<?php defined('C5_EXECUTE') or die("Access Denied.");
	$formHelper	  = Loader::helper('form');
	$assetLibrary = Loader::helper('concrete/asset_library');
?>

	<style type="text/css">
		#html5VbForm table tr td {vertical-align:middle;}
		#html5VbForm table tr td.tableLabel {white-space:nowrap;font-weight:bold;width:1%;}
		#html5VbForm textarea {width:100%;min-height:200px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;}
		#html5VbForm ul.nav.nav-tabs {margin-bottom:8px;}
		#html5VbForm h4 {padding:0;margin:0 0 8px;}
		/*#html5VbForm input.youtube {min-width:100%;}*/
	</style>

	<div id="html5VbForm" class="ccm-ui">
		<ul class="nav nav-tabs">
			<li class="active" href="#html5-sources-options" data-toggle="tab"><a>Sources &amp; Options</a></li>
			<li><a href="#html5-captions" data-toggle="tab">Captions</a></li>
		</ul>
		
		<div class="tab-content">
			<div id="html5-sources-options" class="tab-pane active">
				<h4>Player Settings</h4>
				<table class="table table-bordered">
					<tr>
						<td class="tableLabel">
							<span class="poptip" title="Player Options" data-placement="right" data-content="Customize controls display, preloading, looping, or autoplay.">Options <i class="icon-question-sign"></i></span>
						</td>
						<td colspan="3"><select name="attributes[]" id="videoOpts" multiple data-placeholder="Choose Options" style="width:100%;">
								<option value="autoplay"<?php if( (bool)$this->controller->autoplay ){ echo ' selected="selected"'; } ?>>Autoplay</option>
								<option value="showControls"<?php if( (bool)$this->controller->showControls ){ echo ' selected="selected"'; } ?>>Show Controls</option>
								<option value="preload"<?php if( (bool)$this->controller->preload ){ echo ' selected="selected"'; } ?>>Preload</option>
								<option value="loopVideo"<?php if( (bool)$this->controller->loopVideo ){ echo ' selected="selected"'; } ?>>Loop Playback</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="tableLabel">
							<span class="poptip" title="Poster Image" data-placement="right" data-content="Optionally choose an image to display as a placeholder before the video starts.">Poster Image <i class="icon-question-sign"></i></span>
						</td>
						<td colspan="3"><?php echo $assetLibrary->file('posterSrc', 'posterFileID', 'Choose Poster Image', $this->controller->posterImageFileObj()); ?></td>
					</tr>
					<tr>
						<td class="tableLabel">
							<span class="poptip" title="Width &amp; Height" data-placement="right" data-content="Optionally define a set width and/or height. Defaults to max width.">Width <i class="icon-question-sign"></i></span>
						</td>
						<td><?php echo $formHelper->text('width', $this->controller->width, array('class'=>'span2', 'placeholder'=>'Optional')); ?></td>
						<td class="tableLabel">Height</td>
						<td><?php echo $formHelper->text('height', $this->controller->height, array('class'=>'span2', 'placeholder'=>'Optional')); ?></td>
					</tr>
				</table>
				
				<h4><span class="poptip" title="Video Sources" data-placement="right" data-content="Define video sources. All are optional (of course, have at least 1). The more formats supported the better.">Sources <i class="icon-question-sign"></i></span></h4>
				<table class="table table-bordered">
					<tr>
						<td class="tableLabel">MP4 Source</td>
						<td colspan="3"><?php echo $assetLibrary->file('mp4Src', 'srcMp4FileID', 'Choose MP4 Source', $this->controller->srcMp4FileObj()); ?></td>
					</tr>
					<tr>
						<td class="tableLabel">OGG Source</td>
						<td colspan="3"><?php echo $assetLibrary->file('oggSrc', 'srcOggFileID', 'Choose OGG Source', $this->controller->srcOggFileObj()); ?></td>
					</tr>
					<tr>
						<td class="tableLabel">WebM Source</td>
						<td colspan="3"><?php echo $assetLibrary->file('webmSrc', 'srcWebmFileID', 'Choose Webm Source', $this->controller->srcWebmFileObj()); ?></td>
					</tr>
					<!--<tr>
						<td class="tableLabel">Youtube</td>
						<td colspan="3"><?php echo $formHelper->text('srcYoutube', $this->controller->srcYoutube, array('class' => 'input-block-level youtube', 'placeholder' => 'Youtube page url (copy and paste)')) ?></td>
					</tr>-->
				</table>
			</div>
			<div id="html5-captions" class="tab-pane">
				<h4><span class="poptip" title="Video Captions" data-placement="right" data-content="For supported browsers, you can add video captions using the WebVTT format.">Captions <i class="icon-question-sign"></i></span></h4>
				<p>To learn about the WebVTT format, checkout the handy <a href="http://html5doctor.com/video-subtitling-and-webvtt/" target="_blank">guide by html5doctor.com</a>.</p>
				<?php echo $formHelper->textarea('captions', $this->controller->captions, array('class' => 'input-block-level','placeholder' => 'Optional', 'rows' => '16')); ?>
			</div>
		</div>
	</div>
