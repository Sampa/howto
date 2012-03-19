<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />

<?php  //to be able to use xupload and eltre on the same page we need this scriptmap
	$scriptmap=Yii::app()->clientScript;
	$scriptmap->scriptMap=array(
	        'jquery.min.js'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js',

			);
?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/jquery.multiplyforms.js');?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/common.js');?>


	<title><?php echo CHtml::encode( $this->pageTitle ); ?></title>
</head>

<body>

<div id="page" >

	
	<div id="header">
		<div id="logo" class="span2" style="border:0px solid black"><h1>Howto<h1>
		<?php
		if ( $this->isGuest ):
		?>

			<button class="btn btn-primary" id="loginButton"><!-- loginbutton-->
				Login
			</button> <!--login button-->
			
			<button class="btn btn-primary" id="regButton"><!-- sign up button-->
				Sign up
			</button> <!--sign up button-->
			<!-- files with modalwindow, ajax calls etc for easier reading -->
			<?php echo $this->renderPartial('//site/_login'); ?> 
			<?php echo $this->renderPartial('//site/_reg');?>
		
		
		<?php endif;?>
		
		<?=$this->clips['header'];?>
		</div><!-- logo -->
	<div class="" style="border: 0px solid red; height:50px; float:left; width:28%"></div>
	<div class="span6" style="border:0px solid blue; margin: 3% 0 0 5%; padding:0px;">
	<div class="btn-toolbar span2" style="border:0px solid green; margin-left:-5px;"><!--category select-->
	<?php 
		$categories = array();
		$list = Category::model()->findAll();
		foreach ( $list as $category )
		{
			$categories[] = array('label'=>$category->name, 'url'=>'/howto/category/'.$category->name);
		
		}
		$this->widget('bootstrap.widgets.BootButtonGroup',
		array( 'type'=>'primary', 
        'buttons'=>array(
            array('label'=>'Categories', 'url'=>'/categories' ,'icon'=>'icon-edit icon-white'),
            array('items'=>$categories) ),
			)); 
		?>
		</div>
		
		<div id="search" class="span4" style="border: 0px solid black; margin-left:30px;">
		<?php $this->widget('CAutoComplete', array(
			'model'=>new Howto,
			'id'=>'searchfield',
			'attribute'=>'tags',
			'url'=>array('/howto/suggestTags'),
			'multiple'=>true,
			'htmlOptions'=>array('size'=>20, 'value'=>'Find Howto\'s by tag','style'=>'margin-top:7px'),
		)); ?>
		<button class="btn btn-primary" style="margin-top: 0px;" id="searchbutton">
<!-- search--><i class="icon-search icon-white"></i> Find
		</button>
		</div>
		<script>
			$("#searchfield").focus(function(){
				$(this).val('');
			});
			$("#searchbutton").click(function(){
				var val = $("#searchfield").val();
				val = val.replace(",",'');
				var url = "/tag/"+val; 
				$(location).attr('href',"/tag/"+val);
			})
		</script>
		</div><!-- search -->
	</div><!--header-->
	

	<div id="mainMenu" style="clear:both">
<?php 
	$this->widget('application.extensions.mbmenu.MbMenu',array( 
		'items'=>array( //Top level
				array('label'=>'Home', 'url'=>'/site/index'),
				array('label'=>'About', 'url'=>array('//about')),
				array('label'=>'Contact', 'url'=>array('//contact')),
				array('label'=>'Howtos','url'=>array( '//howto'),
								'items'=>array( //submenu under "Howtos" If user has Howto.Admin
									array(
										'label'=>'Create New Howto',
										'url'=>array( '//howto/create' ), 
										'visible'=>Yii::app()->user->checkAccess( 'Howto.Create' )
									),
									array('label'=>'New!','url'=>array( '//howto/show/new' ), 
									),
									array('label'=>'Popular!','url'=>array( '/howto/show/popular' ), 
									),
									array('label'=>'Your Howtos!','url'=>array( '/howto/show/new' ), 
										'visible'=>!Yii::app()->user->isGuest
									),
									array(
										'label'=>'Manage Howtos', 
										'url'=>array( '/howto/admin' ), 
										'visible'=>Yii::app()->user->checkAccess( 'Howto.Admin' )
									),
									array(
										'label'=>Yii::t( 'blog', 'Approve Comments (:commentCount)', 
											array( ':commentCount'=>Comment::model()->pendingCommentCount ) ), 
												'url'=>array('/comment/index'),
												'visible'=>Yii::app()->user->checkAccess( 'Comment.Approve' )
									),
								
								), 
							), //End Howtos + submenu
				array('label'=>$this->user, 'url'=>array( User::getUserUrl( $this->user ) ),
				'visible'=>!$this->isGuest,
                  'items'=>array( //Submenu under the users name
					array('label'=>'Profile', 'url'=>array( User::getUserUrl( $this->user ) ) ),
                    array('label'=>'Update','url'=>array( '//user/update/id/' . Yii::app()->user->id ) ), 
					array('label'=>'Rights', 'url'=>array( '/rights' ),
							'visible'=>Yii::app()->user->checkAccess(Rights::module()->superuserName ) ),
					array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 
							'visible'=>!$this->isGuest ),
						
						), 
                  ),//End username + submenu
				
			),
		)); 
?>
	</div><!-- mainmenu -->
	
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

	<?php echo $content; ?>

		<div id="footer" style="clear:both">
			Copyright &copy; <?php echo date('Y'); ?><br />
			All Rights Reserved.<br/>
		</div><!-- footer -->

	</div><!-- page -->

</body>
</html>