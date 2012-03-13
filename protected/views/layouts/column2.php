<?php $this->beginContent('application.views.layouts.main'); ?>
<div class="container">
	<div class="span-18">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-6 last">
		<div id="sidebar">

			<?php 
				$this->widget('TagCloud', 
				array(
					'maxTags'=>Yii::app()->params['tagCloudCount'],
				)); 
			?>

			<?php 
				$this->widget('RecentComments', 
				array(
					'maxComments'=>Yii::app()->params['recentCommentCount'],
				)); 
			?>
		<?php 
			if ( $this->isGuest ):
			$this->beginWidget('system.web.widgets.CClipWidget', array( 'id'=>'header' ) );   ?>

			<button class="btn btn-primary" id="loginButton"><!-- loginbutton-->
				Login
			</button> <!--login button-->
			
			<button class="btn btn-primary" id="regButton"><!-- sign up button-->
				Sign up
			</button> <!--sign up button-->
			<!-- files with modalwindow, ajax calls etc for easier reading -->
			<?php echo $this->renderPartial('//site/_login'); ?> 
			<?php echo $this->renderPartial('//site/_reg');?>
			<?php $this->endWidget(); endif;?>

			<?php if ( !$this->isGuest ):?>
			<div class="well"> Your Bookmarks:<br/>
			<?php
				$bookmarks = Bookmark::model()->getBookmarks($this->userId);
					if ( $bookmarks ) 
					{
						foreach( $bookmarks as $link )
						{
							echo $link . '<br/>';
						}
					}
			?>
			</div>
			<?php endif;?>
			
			<?php echo $this->clips['sidebar']; ?>


		</div><!-- sidebar -->
	</div>
</div>
<?php $this->endContent(); ?>