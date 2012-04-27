<?php $this->beginContent('application.views.layouts.main'); ?>
<div class="span12" style="margin-left: 10px; margin-top: -18px; min-width: 100%;">
		<div id="content" style="float:left;border:0px solid black;" class="span1" >
			<?php echo $content; ?>
		</div><!-- content -->
		<div id="sidebar" class="span5" style="z-index:15;padding: 0px; margin-right:1px;">
		<?php /*$this->widget('bootstrap.widgets.BootCarousel', array(
		'items'=>array(
			array('image'=>'http://placehold.it/770x400&text=First+thumbnail', 'label'=>'First Thumbnail label', 'caption'=>'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.'),
			array('image'=>'http://placehold.it/770x400&text=Second+thumbnail', 'label'=>'Second Thumbnail label', 'caption'=>'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.'),
			array('image'=>'http://placehold.it/770x400&text=Third+thumbnail', 'label'=>'Third Thumbnail label', 'caption'=>'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.'),
		),
		'events'=>array(
			'slide'=>"js:function() { console.log('Carousel slide.'); }",
			'slid'=>"js:function() { console.log('Carousel slid.'); }",
		),
	)); */?>
<!-- siderbar clip--><?php echo $this->clips['sidebar']; ?>

<!-- logged in user bookmarks--> <?php if ( !$this->isGuest ):?>
			<div class="well" style=""> <h2>Your Bookmarks</h2>
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
<!-- tagcloud -->
			<div class="well" style=""> <h2>Popular tags</h2>
				<?php 
					$tags = Tag::model()->findTagWeights(20);

					foreach($tags as $tag=>$weight)
					{
						$link = CHtml::link( CHtml::encode( $tag ), array( 'tag/' . $tag ) );
						echo CHtml::tag('span', array(
							'class'=>'tag',
							'style'=>"font-size:{$weight}pt",
						), $link)."\n";
					}
				?>
			</div>


<!--recent comments-->
		<!--	<div class="well" style=""> <h2>Recent Comments</h2>
				<?php 
					// $comments = Comment::model()->findRecentComments(10);
					// if ( $comments )
					// {
						// foreach( $comments as $comment )
						// {
							// echo $comment->authorLink .' on ';
							// echo CHtml::link ( CHtml::encode ($comment->howto->title ) , $comment->getUrl() ) .'<br/>' ; 
						// }
					
					// }
				?>
			</div>-->
		</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>