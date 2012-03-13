<?php
	$created = date('F j, Y',$data->create_time); 
	$updated = date('F j, Y',$data->update_time);
?>

<div class="Howto">
	<div class="title">
		<h2>	
			<?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?>
		</h2>
	</div>
	<div class="author">
		
<?= "Shared by " . User::getUserLink( $data->author->username ) . ' on <i>' . $created . '</i>'; 
		echo " and last updated on <i>" . $updated . "</i>"; ?>	
	</div>
		
	<div id="rating_info_<?=$data->rating_id?>">
<?php 
	if ( $rating = Rating::model()->findByPk($data->rating_id) )
		{	
			echo "Rating: " . $rating->vote_average;
			echo " " . $rating->vote_count . " votes";
		}
?>
	</div>
	
<?php // rating
	$this->widget('CStarRating',array(
    'name'=>'rating'.$data->rating_id,
    'callback'=>'
        function(){
        	url = "/howto/rating";
			jQuery.getJSON(url, {id: '.$data->rating_id.', val: $(this).val()}, function(data) {
				if (data.status == "success"){
					$("#rating_success_'.$data->rating_id.'").html(data.div);
					$("#rating_success_'.$data->rating_id.'").fadeIn("slow");		
					var pause = setTimeout("$(\"#rating_success_'.$data->rating_id.'\").fadeOut(\"slow\")",5000);
					$("#rating_info_'.$data->rating_id.'").html(data.info);
					}
				});}'
			));
?> 	<div id="rating_success_<?=$data->id;?>" style="display:none"></div>

	<div class="content">
	<br/><br/>
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->content;
			$this->endWidget();
		?>
	</div>
	<div class="nav">
		<?php echo $data->stepCount;?> Steps
		<b>Tags:</b>
		<?php echo implode(', ', $data->tagLinks); ?>
		<br/>
<!--permalink--><?=CHtml::link('<i class="icon-eye-open icon-white"></i> Permalink', $data->url,array('class'=>'btn btn-primary' ) ); ?> 

<!--comments--><?=CHtml::link("<i class='icon-comment icon-white'></i> Comments ({$data->commentCount})",$data->url.'#comments',
			array('class'=>'btn btn-primary' ) ); ?> 
		
<!--print--><?= CHtml::link('<i class="icon-print icon-white"></i> Print/Pdf', 
					array('/howto/viewpdf/id/' . $data->id ), array('class'=>'btn btn-primary') );?>		
		
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