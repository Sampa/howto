<?php
	$created = date('F j, Y',$data->create_time); 
	$updated = date('F j, Y',$data->update_time);
?>

<div class="Howto">
	<div class="title">
		<h2>	
			<?= CHtml::link(CHtml::encode($data->title), $data->url); ?>
		</h2>
	</div>
<!-- author link -->
	<div class="author">
		<div style="float:left;">
		Shared by	
		</div>
		<div style="float:left; margin-top:-8px;">
			<ul class="nav nav-pills">
				<li class="dropdown" id="menu<?=$data->id;?>">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#menu<?=$data->id;?>">
						<?= $data->author->username;?>
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?= User::getUserUrl($data->author->username);?>">View Profile</a></li>
						<li><a href="/message/compose?id=<?=$data->author->id;?>">Send message</a></li>
						<li><a href="/howto/show/by?user=<?=$data->author->username;?>">More by <?=$data->author->username;?></a></li>
					</ul>
				</li>
			</ul>
		</div>
<!-- created and last updated dates-->
		<div >
			on <i> <?=$created;?></i>
			and last updated on <i><?= $updated;?></i> 
		</div>
	</div>
	<div style="clear:both"></div>
	<!-- container to adjust the user link-->
	<div  style="position:relative; top:-20px;"> 
<!-- Categories-->
		<div>
<?php 
	if ( $data->categories ):
		foreach ( $data->categories as $category ):
			echo $category->name;
		endforeach; 
	endif;
?>
		</div>
		<div  id="rating_info_<?=$data->rating_id?>">
<?php 
	if ( $rating = Rating::model()->findByPk($data->rating_id) )
		{	
			echo "Rating: <strong>" . $rating->vote_average ."</strong>";
			echo " " . $rating->vote_count . " votes";
		}
?>
		</div>

	
<?php // rating
	$this->widget('CStarRating',array(
    'name'=>'rating'.$data->rating_id,
	'starCount'=>10,
	'readOnly'=>false,
	'resetText'=>'',
	'value'=>round($rating->vote_average,0),
    'callback'=>'
        function(){
        	url = "/howto/rating";
			jQuery.getJSON(url, {id: '.$data->rating_id.', val: $(this).val()}, function(data) {
				if (data.status == "success"){
					$("#rating_success_'.$data->rating_id.'").html(data.div);
					$("#rating_success_'.$data->rating_id.'").fadeIn("slow");		
					var pause = setTimeout("$(\"#rating_success_'.$data->rating_id.'\").fadeOut(\"slow\")",5000);
					$("#rating_info_'.$data->rating_id.'").html(data.info);
					$("input[id*='.$data->rating_id.'_]").rating("readOnly",true);
					}
				});}'
			));
?> 	
<div id="rating_success_<?=$data->id;?>" style="display:none"></div>

	<div class="content">
	<br/><br/>
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->content;
			$this->endWidget();
		?>
	</div>
	<div class="nav">
		<?= $data->stepCount;?> Steps
		<b>Tags:</b>
		<?= implode(', ', $data->tagLinks); ?>
		<br/>
<!--Read--><?=CHtml::link('<i class="icon-eye-open icon-white"></i> Read', $data->url,array('class'=>'btn btn-success' ) ); ?> 

<!--comments--><?=CHtml::link("<i class='icon-comment icon-white'></i> Comments ({$data->commentCount})",$data->url.'#comments',
			array('class'=>'btn btn-primary' ) ); ?> 
		
<!--print--><?= CHtml::link('<i class="icon-print icon-white"></i> Print/Pdf', 
					array('/viewpdf/id/' . $data->id ), array('class'=>'btn btn-primary') );?>		
		
<!--bookmark--><?= CHtml::link('<i class="icon-bookmark icon-white"></i> Bookmark ', 
					array(''), array(
						'class'=>'btn btn-primary bookmark',  
						'name'=>$data->id,
						) );?>
		<div id="bookmark_success_<?=$data->id;?>" style="display:none"></div>
		
<!--email--><?= CHtml::link('<i class="icon-envelope icon-white"></i> Mail it', 
					array(), array('class'=>'btn btn-primary mail',
					'name'=>'?id='.$data->id.'&title='.$data->title) );?>	
<!--edit--><?php 
			if( Yii::app()->user->checkAccess('HowtoUpdateOwn', 
				array('userid'=>$data->author_id))): ?>
			<?=CHtml::link('<i class="icon-edit icon-white"></i> Edit', array('/howto/update','id'=>$data->id),
			array('class'=>'btn btn-primary' ) ); ?> 
		<?php endif; ?>   
		

	</div><!-- nav -->
	</div><!-- categories and down-->
</div>




	<script>
	$(".bookmark").click(function(){
		id = $(this).attr('name');
		url = '/howto/bookmark';
		jQuery.getJSON(url, {id: id}, function(data) {
			if (data.status == 'success'){
					$('#bookmark_success_'+id).html(data.div);
					$('#bookmark_success_'+id).fadeIn('slow');			
					var pause = setTimeout("$('#bookmark_success_'+id).fadeOut('slow')",5000);
					
				}
			});
			return false;
		});
	</script>
<?php $this->renderPartial('//howto/_mail');?>