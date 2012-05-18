<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>


	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/css/main.css" />

<?php  //helps using more jQuery stuff on same page 

?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/jquery.multiplyforms.js');?>
	<?php  Yii::app()->clientScript->registerScriptFile('/js/common.js');?>
		<?php  Yii::app()->clientScript->registerScriptFile('/js/jeditable.js');?>
    <script src="https://browserid.org/include.js" type="text/javascript"></script>  


	<title><?= CHtml::encode( $this->pageTitle ); ?></title>

</head>

<body>

<div id="page" >

	
	<div id="header" style="border:0px solid yellow; height:40px;">
		<div id="logo" class="span2" style="border:0px solid black;">
			<a href="<?=Yii::app()->homeUrl;?>">
				<img src="/images/logo.png" alt="Howto"/>
			</a>
		</div>
	<?php if ( $this->isGuest ):?>	
		<!-- facebook login-->
	<div style="position:absolute; left:120px; top:0px;">
		<a  id="fb-login"><img src="http://worldthissecond.com/wp-content/themes/tribune/images/icons/facebook.png" 
		alt="facebook"/></a><br/>
		<a href="#" id="browserid" title="Sign-in with BrowserID">  
			<img src="/images/sign_in_blue.png" alt="Sign in">  
		</a>  
	</div>
		<div class="" style="height:27px; float:left; width:28%; padding: 0px;">

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
		<div class="btn-toolbar" style="margin-top:0px;">
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
						
						array('label'=>'Logout from facebook','url'=>'https://www.facebook.com/logout.php?access_token=<?=Yii::app()->facebook->getAccessToken();?>&amp;confirm=1&amp;next=http://83.233.118.50/site/logoutt','visible'=>Yii::app()->facebook->getUser(),
						),
					),
				)
			))); 
	?>
		</div>
<!-- messagebutton--><div style=""><?php 
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

			</div>
		</div>
		<?php endif;?>	
		
		
		<?=$this->clips['header'];?>
		
	</div>
	
	<div class="btn-toolbar span7" style="position:absolute; top:2px;right:10px;border:0px solid green; margin:-0px 0 0 -5px; height:auto;">
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
<!--category select-->
	<?php 
		$categories = array();
		$list = Category::model()->findAll();
		foreach ( $list as $category )
		{
			if ( $category->parent == "no parent" )
				$label = "--".$category->name."--";
				else
				$label = $category->name;
			$categories[] = array('label'=>$label, 'url'=>'/howto/category/'.$category->name);
		
		}
		$this->widget('bootstrap.widgets.BootButtonGroup',
		array( 'type'=>'primary', 
        'buttons'=>array(
            array('label'=>'Categories', 'url'=>'/categories' ,'icon'=>'icon-edit icon-white'),
            array('items'=>$categories) ),
			)); 
		?>	
<!-- search-->		
		<?php $this->widget('CAutoComplete', array(
			'model'=>new Howto,
			'id'=>'searchfield',
			'attribute'=>'tags',
			'url'=>array('/howto/suggestTags'),
			'multiple'=>true,
			'htmlOptions'=>array('size'=>20, 'value'=>'Find Howto\'s by tag','style'=>'margin-top:-11px'),
		)); ?>
		<button class="btn btn-primary" style="margin-top: -20px;" id="searchbutton">
			<i class="icon-search icon-white"></i> Find
		</button>
		<script type="text/javascript">
			$("#searchfield").focus(function(){
				$(this).val('');
			});
			$("#searchbutton").click(function(){
				var val = $("#searchfield").val();
				if(val === 'Find Howto\'s by tag' || val===''){
				alert('Perhaps you should search something real instead ;\)');
				}else{
				val = val.replace(",",'');
				var url = "/tag/"+val; 
				$(location).attr('href',"/tag/"+val);
				}
			})
		</script>
				</div>

	</div><!--header-->
	

<!-- main menu --><div id="mainMenu" style="clear:both">
	
<?php 
	$this->widget('application.extensions.mbmenu.MbMenu',
	array( 
		'items'=>array( //Top level
				array('label'=>'About', 'url'=>array('//about')),
				array('label'=>'Contact', 'url'=>array('/contact')),
				//array('label'=>'Twitter', 'url'=>array('/twitter/index')),
					),
		)); 
?>
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
	//$Badge = new Badge;
//$Badge->onSuccess = array( $object, 'notifyUser'); // add custom event after giving badge to user
//$Badge->checkAndGiveGroup( 'Login' );
?>

	<?= $content; ?>
<a href="https://www.facebook.com/logout.php?access_token=<?=Yii::app()->facebook->getAccessToken();?>&amp;confirm=1&amp;next=http://83.233.118.50/site/logout">hej</a>
		<div id="footer" style="clear:both">
	<?php $this->widget('ext.yii-facebook-opengraph.plugins.LikeButton', array(
	   //'href' => 'YOUR_URL', // if omitted Facebook will use the OG meta tag
	   'show_faces'=>true,
	   'send' => true
	)); ?>
		<br/>
		Copyright &copy; <?= date('Y'); ?><br />
		<div id="conf"></div>
		</div><!-- footer -->

	</div><!-- page -->

	<script type="text/javascript">

jQuery(function($) {  
  var loggedIn = function(res) {

    if (res.returnURI) {
      window.location.assign(res.returnURI);
    } else {
      window.location.reload(true);
    }
  };
  var loggedOut = function(res) {
  };

  var gotAssertion = function(assertion) {
    // got an assertion, now send it up to the server for verification
    if (assertion) {
      $.ajax({
        type: 'POST',
        url: '/user/persona',
        data: { assertion: assertion },
        success: function(res, status, xhr) {
          if (res === null) {
            loggedOut();
          }
          else {
            loggedIn(res);
          }
        },
        error: function(res, status, xhr) {
          alert("Whoops, I failed to authenticate you! " + res.responseText);
        }
      });
    } else {
      loggedOut();
    }
  }

  $('#browserid').click(function() {
    navigator.id.get(gotAssertion, {allowPersistent: true});
    return false;
  });

  // Query persistent login.
  var login = $('head').attr('data-logged-in');
  if (login === "false") {
    navigator.id.get(gotAssertion, {silent: true});
  }
});
</script>
	<script type="text/javascript">
 $("#fb-login").click(function(){
 FB.login(function(response) {
   if (response.authResponse) {
     $("#conf").html('Welcome!  Fetching your information.... ');
     FB.api('/me', function(response) {
       $("#conf").append('Good to see you, ' + response.name + '.');
	  
	   window.location.replace('/user/addUser');
     });
   } else {
  /*   console.log('User cancelled login or did not fully authorize.');*/
   }
 });
 });
 </script>
</body>
</html>