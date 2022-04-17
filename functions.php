<?php

function getGalleryImages($name,$base=''){
	$working_dir = getcwd();
	$img_dir = __DIR__ . "/uploads/".$name;
	chdir($img_dir);
	$files = glob("*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}", GLOB_BRACE );
	chdir($working_dir);
	if(empty($files)) return false;
	echo '<div class="bxslider '.$name.'">';
	foreach ($files as $file) {
	?>
		<img src="<?php echo "/uploads/" . $name.'/'.$file ?>"/>
	<?php 
	}
	echo '</div>';
	echo <<<SCRIPT
<script type="text/javascript">
$('.bxslider.{$name}').bxSlider({
  auto: true,
  autoControls: true,
  stopAutoOnClick: true,
  pager: true,
  keyboardEnabled: true,
  slideWidth: 800
});
</script>
<style type="text/css">
.bx-wrapper{margin:0 auto;}
</style>
SCRIPT;
}