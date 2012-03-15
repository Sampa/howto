<?php $this->beginContent('application.views.layouts.main'); ?>
<div class="span12 row-fluid" style="margin-left: 0px; margin-top: -18px; min-width: 100%;">
	<div class="span9">
		<div id="content" class="row-fluid" style="padding: 0 0 0 10px;">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span3">
		<div id="sidebar">
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
<!-- siderbar clip--><?php echo $this->clips['sidebar']; ?>

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

		</div><!-- sidebar -->
	</div>
</div>
<?php $this->endContent(); ?>