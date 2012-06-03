<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/css/bottom.css" rel="stylesheet" />
			<?php  Yii::app()->clientScript->registerScriptFile('/js/jquery.jcarousel.min.js');?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/jquery.pikachoose.js');?>


	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/css/main.css" />

<?php  //helps using more jQuery stuff on same page 

?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/jquery.multiplyforms.js');?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/common.js');?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/jeditable.js');?>
<script type="text/javascript" src="/js/nicedit.js"></script> 

	<title><?= CHtml::encode( $this->pageTitle ); ?></title>



</head>

<body>
	<?php $this->widget('application.extensions.search-and-share.SearchShare'); ?>

<div id="page" >

	<div id="header" style="border:0px solid yellow; height:40px;">
		<div id="logo" class="span2" style="border:0px solid black;">
			<a href="<?=Yii::app()->homeUrl;?>">
				<img src="/images/logo.png" alt="Howto"/>
			</a>
		</div>
	
		<div class="" style="height:29px; float:left; width:29%; padding: 0px;">

	<?php if ( $this->isGuest ):?>	
	

			<button class="btn btn-primary" id="loginButton"><!-- loginbutton-->
				Login
			</button> <!--login button-->

			<button class="btn btn-primary" id="regButton"><!-- sign up button-->
				Sign up
			</button> <!--sign up button-->
			
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
			'buttons'=>
			array(
				array('label'=>$this->user, 
						'url'=>User::getUserUrl( $this->user )),
				array('items'=>
					array(

						array('label'=>'Rights', 'url'=>array( '/rights' ),
								'visible'=>Yii::app()->user->checkAccess(Rights::module()->superuserName ) ),
						array('label'=>'Logout', 'url'=>array('/site/logout'),'id'=>'loggaut'), 
						
						
					),
				)
			))); 
	?>
	</div> <!-- // user button -->
	
	<div style="float:left;">
<!-- messagebutton--><?php 
	if ( Yii::app()->getModule('message')->getCountUnreadedMessages($this->userId) > 0 )
	{
		$unreadCount = '(' . Yii::app()->getModule('message')->getCountUnreadedMessages($this->userId) . ')'; 
	}else{
		$unreadCount = false;
	}
		$this->widget('bootstrap.widgets.BootButtonGroup', 
		array(
			'type'=>'primary', 
			'buttons'=>
			array(
				array('label'=>'Messages'.$unreadCount,
				'url'=>Yii::app()->getModule('message')->inboxUrl,
					'visible' => !Yii::app()->user->isGuest),
				array('items'=>
						array(
							array('label'=>'Sent', 'url'=>Yii::app()->getModule('message')->sentUrl),
							array('label'=>'New message', 'url'=>Yii::app()->getModule('message')->composeUrl),
						)
					),
			),
		)); 
	?>
		</div><!-- // message button-->
	<?php endif; // end is logged in?>	
	
	<div style="float:right;">
<!--howtos--><?php 
		$this->widget('bootstrap.widgets.BootButtonGroup', 
		array(
			'type'=>'primary', 
			'buttons'=>
			array(
				array('label'=>'Howtos', 'url'=>'/howto/show/new'),
				array('items'=>
					array(
						array(
							'label'=>'Create New Howto',
							'url'=>array( '//howto/create' ), 
							'visible'=>!Yii::app()->user->isGuest,
							),
						array('label'=>'New!','url'=>array( '/howto/show/new' ),),
						array('label'=>'Popular!','url'=>array( '/howto/show/popular' ), ),
						array('label'=>'Your Howtos!','url'=>array( '/howto/show/own' ), 
							'visible'=>!Yii::app()->user->isGuest ),
						array(
							'label'=>'Manage Howtos', 
							'url'=>array( '/howto/admin' ), 
							'visible'=>Yii::app()->user->checkAccess( 'Howto.Admin' )
							),
						)
					),
				),
			)
		); 
	?>
		</div> <!-- // howtos button-->
	</div>


	
	<div class="btn-toolbar span8" style="position:absolute; top:2px;right:10px;border:0px solid green; margin:-0px 0 0 -5px; height:auto;">
	<!-- search -->

	</div>
<div style="position:absolute; max-height: 33px; top:34px;left:150px;">
<style type="text/css">
.tab_content{max-width:900px;min-height:36px;;padding: 4px 9px 0px 9px;}
.tab_content a{padding:0px 3px 0px 0px; }
</style>
<?php 
		$tabs = array();
		$parents = Category::model()->findAll("parent='no parent'");
		foreach($parents as $cat)
		{
		$tab_content = '<div class="tab_content">';
		$children = Category::model()->findAll("parent='".$cat->name."'");
			foreach($children as $child)
			{
				$tab_content .= '<a href="/howto/category/'.$child->name.'">'.$child->name.'</a>';
			}
		$tab_content .= '</div>';
		$tabs[] = array('label'=>$cat->name,'content'=>$tab_content);		
		}
$this->widget('bootstrap.widgets.BootTabbable', array(
    'type'=>'tabs',
    'placement'=>'below', // 'above', 'right', 'below' or 'left'
    'tabs'=>$tabs,
)); ?>
</div>
	</div><!--header-->
	

<!-- main menu --><div id="mainmenu_container" style="clear:both">

	</div><!-- //mainmenu -->
	
	<!-- flashes -->
<?php 
	$this->widget('application.extensions.flash.Flash', 
		array(
		'keys'=>array( 'success','error' ),
		'htmlOptions'=>array( 'class'=>'flash' ),
	)); 
?>

	<!-- breadcrumbs -->
<?php
	$this->widget('bootstrap.widgets.BootBreadcrumbs', 
		array(	'links'=>$this->breadcrumbs,
	)); 
?>


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

		<div id="conf"></div>

	</div><!-- footer -->

	</div><!-- page -->
   
</body>
</html>
