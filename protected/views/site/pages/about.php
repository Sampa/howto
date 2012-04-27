<?php
/*kommenterar all php kod, men låt den vara kvar

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);  */ /// flyttade till views/site/index.php

$this->widget('ext.yii-facebook-opengraph.plugins.loginbutton', array(
   
));
$this->widget('ext.yii-facebook-opengraph.plugins.LikeButton', array(
   //'href' => 'YOUR_URL', // if omitted Facebook will use the OG meta tag
   'show_faces'=>true,
   'send' => true
)); 
/*
$this->widget('ext.yii-facebook-opengraph.plugins.comments', array(
   
));
*/
?>
<?php $userid = Yii::app()->facebook->getUser();?>
<script>
FB.logout(function(response) {
  // user is now logged out
});
</script>