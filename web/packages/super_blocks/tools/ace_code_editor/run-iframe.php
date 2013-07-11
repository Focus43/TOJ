<?php header('X-XSS-Protection: 0'); ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE; ?>">
<head>
	<!-- make sure the iframe has jquery available -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>

<body>
    <div class="container-fluid">
    	<div class="row-fluid">
    		<div class="span12">
    			<?php echo $_POST['code']; ?>
    		</div>
    	</div>
    </div>
    <script type="text/javascript">
    	window.onload = function(){
    		parent.iframeLoaded('<?php echo $_REQUEST['iframeBlockID']; ?>');
    	}
    </script>
</body>
</html>