<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/css/bottom.css" rel="stylesheet" />


	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/css/global.css" />
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/css/jcloud.css" />
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/css/elfinder.min.css" />
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/css/jquery.toastmessage.css" />

	<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css" />
	<?php  //helps using more jQuery stuff on same page 
		$scriptmap=Yii::app()->clientScript;
		$scriptmap->scriptMap=array(
				'jquery.min.js'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js',
				'jquery.js'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js',
				'jquery-ui.min.js'=>'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js',
				'jquery-ui.js'=>'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js',
				);
	?>

	<?php  Yii::app()->clientScript->registerScriptFile("/js/jquery-ui.min.js");?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/common.js');?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/nicedit.js');?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/jquery.vticker.js');?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/jquery.toastmessage.js');?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/jquery.livesearch.js');?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/jquery.jcloud.js');?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/jquery.tinycarousel.min.js');?>


	<title><?= CHtml::encode( $this->pageTitle ); ?></title>
</head>

<body>	

<div id="page" >
	<div id="header" style="border:0px solid red; min-height:70px;">
		<div id="logo" class="span2" style="border:0px solid black;">
			<a href="<?=Yii::app()->homeUrl;?>">
				<img src="/images/logo.png" alt="Howto"/>
			</a>
		</div>
			<?= CHtml::link('<i class="icon-white icon-plus-sign"></i> Howto',array('//howto/create'),
				array('class'=>'btn btn-large btn-success','style'=>'float:left;'));?>
<div class="" style="height:29px; float:left; width:30%; border:0px solid black; padding-left: 10px;">

	<?php if ( $this->isGuest ):?>	

			<a class="btn btn-large btn-primary" href="/login"><!-- loginbutton-->
				Login
			</a> <!--login button-->

			<a class="btn btn-large btn-primary" href="/register"><!-- sign up button-->
				Sign up
			</a> <!--sign up button-->
			
			<!-- files with modalwindow, ajax calls etc for easier reading -->
		<?php $this->renderPartial('//site/_login'); 
		      $this->renderPartial('//site/_reg');?>
			  
		
		<?php endif;?>
		

		<!--om man är inloggad -->
	<?php if ( !$this->isGuest ):?>
		<!--userbutton-->
	<div style="float:left;">
		<?php
		$this->widget('bootstrap.widgets.BootButtonGroup', 
		array(
			'type'=>'primary',
			'size'=>'large',
			'buttons'=>array(
				array('label'=>$this->user, 
						'url'=>User::getUserUrl( $this->user )),
				array('items'=>array(
						array('label'=>'Rights', 'url'=>array( '/rights' ),
							'visible'=>Yii::app()->user->checkAccess(Rights::module()->superuserName ) ),
						array('label'=>'Dashboard', 'url'=>array( '/dashboard' ),
								'visible'=>Yii::app()->user->checkAccess(Rights::module()->superuserName ) ),
						array('label'=>'Logout', 'url'=>array('/site/logout'),'id'=>'loggaut'), 
					),
				)
			))); 
	?>
	</div> <!-- // user button -->
		<?php endif; // end is logged in?>	

	<div style="float:left;">

	
	<div style="position:absolute; top:2px; left:430px;">
	<?= CHtml::link('<i class="icon-time"></i> New!',array('//howto/show/new'),
				array('class'=>'btn btn-large','style'=>'float:left;'));?>
	<?= CHtml::link('<i class="icon-fire"></i> Popular!',array('//howto/show/popular'),
				array('class'=>'btn btn-large','style'=>'float:left;'));?>
		
	</div> <!-- // howtos button-->
			
	</div>

	
	
	
</div>
	
<div class="btn-toolbar span5" style="position:absolute; top:2px;right:00px; margin:-0px 0 0 -5px;">
	<!-- search -->
	<?php $this->renderPartial('//site/search');?>
	</div>
<style type="text/css">
.tab_content a{padding:0px 3px 0px 0px; }
</style>
<?php
		$tabs = array();
		$parents = Category::model()->findAll("parent='no parent'");
		$active = true;
		foreach($parents as $cat)
		{
		$tab_content = '<div class="tab_content" style="margin-bottom:7px;">';
		$children = Category::model()->findAll("parent='".$cat->name."'");
			foreach($children as $child)
			{
				$tab_content .= '<a href="/category/'.$child->name.'">'.$child->name.'</a>';
			}
		$tab_content .= '</div>';
		$tabs[] = array('label'=>$cat->name,'content'=>$tab_content,'active'=>$active);		
		$active = false;
		}

?><div style="position:absolute; max-height: 33px; top:45px;left:130px; border:0px solid blue;">
<?php
 $this->widget('bootstrap.widgets.BootTabbable', array(
    'type'=>'tabs',
    'placement'=>'below', // 'above', 'right', 'below' or 'left'
    'tabs'=>$tabs,
    )); ?>
	</div>

</div><!--header-->

	<!-- flashes -->
<?php 
	$this->widget('application.extensions.flash.Flash', 
		array(
		'keys'=>array( 'success','error' ),
		'htmlOptions'=>array( 'class'=>'flash' ),
	)); 
?>
<div style="clear:both;"></div>
	<!-- breadcrumbs -->
<?php $this->widget('bootstrap.widgets.BootBreadcrumbs', array(
    'links'=>array('How2'),
)); ?>


<?php
//$Badge = new Badge;
//$Badge->onSuccess = array( $object, 'notifyUser'); // add custom event after giving badge to user
//$Badge->checkAndGiveGroup( 'Login' );
?>

	<?= $content; ?>

	<div id="footer" style="clear:both;min-height:130px;"><!-- footer-->
		<div style="float:left; margin-top:px;"><!-- contact -->
				<ul class="nav nav-pills">
					<li class="dropdown" id="contact">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#contact">
							Contact us
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="/contact">Ask Question</a></li>
							<li><a href="http://www.facebook.com/worldofhowto">On Facebook</a></li>
						</ul>
					</li>
				</ul>
		</div>
		<div style="float:left; margin-top:px;"><!-- info -->
			<ul class="nav nav-pills">
				<li class="dropdown" id="information">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#information">
						Information
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="/faq">Faq</a></li>
						<li><a href="/about">About Howto</a></li>
						<li><a href="/feedback">Feedback</a></li>
						<li><a href="/rules">Rules</a></li>
					</ul>
				</li>
			</ul>
		</div>


	</div><!-- footer -->

	</div><!-- page -->

		

</body>
</html>
<script type="text/javascript">
/*
	$().toastmessage('showNoticeToast', 'some message here');
	$().toastmessage('showSuccessToast', "some message here");
	$().toastmessage('showWarningToast', "some message here");
	$().toastmessage('showErrorToast', "some message here");
*/
</script>
<?php
		$this->widget('application.extensions.fancybox.EFancyBox', array(
			'target'=>'a[rel=fbox]',
			'config'=>array(),
			)
		);
	?>