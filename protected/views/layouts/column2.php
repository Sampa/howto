<?php $this->beginContent('application.views.layouts.main'); ?>
<div class="row-fluid">
	<div class="span9">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span3">
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


			<?php if ( !$this->isGuest ):?>
			<div class="well"> <h2>Bookmarks</h2>
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