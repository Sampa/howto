<?php
/*kommenterar all php kod, men låt den vara kvar

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);  */ /// flyttade till views/site/index.php

/*$this->widget('ext.yii-facebook-opengraph.plugins.loginbutton', array(
'registration_url'=>'/site/login',
));*/
/*$this->widget('ext.yii-facebook-opengraph.plugins.LikeButton', array(
   //'href' => 'YOUR_URL', // if omitted Facebook will use the OG meta tag
   'show_faces'=>true,
   'send' => true
)); */
/*
$this->widget('ext.yii-facebook-opengraph.plugins.comments', array(
   
));
*/
?>
<div class="well span7">

<h2> Here we go!</h2>
<p>
	Here we go, Howto is live! Please note that we currently are at a beta stage.
	This means that some things might not work as expected. <br/>
	Please report it to us if you stumble upon something that does not work properly.<br/>
</p>
<p>
	Also, most important of all please give us feedback, what features would you like to see
	here at Howto? ANY feedback is welcome, positive aswell as negative.<br/>
	<br/>
	Use the comment form below or mail us using our <?=CHtml::link('contact form',array('/contact'));?>
</p>
<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'howtos'; // required: replace example with your forum shortname
/*	var disqus_url = $data->url;*/

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
</div>