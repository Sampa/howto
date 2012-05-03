<?php $this->beginContent('application.views.layouts.main'); ?>
<div class="span12" style="margin-left: 10px; margin-top: -18px; min-width: 100%;">
		<div id="content" style="float:left;border:0px solid black;" class="span1" >
			<?php echo $content; ?>
		</div><!-- content -->
		<div id="sidebar" class="span5" style="z-index:15;padding: 0px; margin-right:1px;">
		
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

<!-- latest howto -->
			<div class="well" style="min-height:300px;"> <h2>Latest knowledge</h2>
				<?php 
					$models = Howto::model()->findAll(array('order' => 'create_time','limit'=>10));
					foreach ($models as $model):
					?>
			<div style="float:left;min-width:100%;margin-bottom:-20px;">		
			<?=CHtml::link(CHtml::encode($model->title), $model->url); ?>
					
					<!-- author link -->
	<div class="author">
		<div style="float:left;">
		Shared by	
		</div>
		<div style="float:left; margin-top:-8px;">
			<ul class="nav nav-pills">
				<li class="dropdown" id="sidebarmenu<?=$model->id;?>">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#sidebarmenu<?=$model->id;?>">
						<?= $model->author->username;?>
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?= User::getUserUrl($model->author->username);?>">View Profile</a></li>
						<li><a href="/message/compose?id=<?=$model->author->id;?>">Send message</a></li>
						<li><a href="/howto/show/by?user=<?=$model->author->username;?>">More by <?=$model->author->username;?></a></li>
						<li><?=$this->renderPartial('/user/reputation',array('id'=>$model->author->id,'reputation'=>$model->author->reputation));?></li>
					</ul>
				</li>
			</ul>
		</div>
<!-- created and last updated dates-->
		<div >
			<?php $created = date('F j, Y @ H:m',$model->create_time); ?> on <i> <?=$created;?></i> 
		</div>
	</div>
	</div>
		<?php endforeach;?>
			</div><!-- latest knowledge-->
		</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>