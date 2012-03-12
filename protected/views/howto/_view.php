<div class="Howto">
	<div class="title">
		<?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?>
	</div>
	<div class="author">
		Shared by <?php echo User::getUserLink($data->author->username) . ' on ' . date('F j, Y',$data->create_time); ?>
	</div>
	<div class="content">
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
		<?php echo CHtml::link('Permalink', $data->url); ?> |
		<?php echo CHtml::link("Comments ({$data->commentCount})",$data->url.'#comments'); ?> |
		<?php if( Yii::app()->user->checkAccess('HowtoUpdateOwn', array('userid'=>$data->author_id))): ?>
			<?php echo CHtml::link('Update', array('/howto/update','id'=>$data->id)); ?> |
		<?php endif; ?>
		Last updated on <?php echo date('F j, Y',$data->update_time); ?>     
		
<!--print--><?= CHtml::link('<i class="icon-print icon-white"></i>Print/Pdf', 
					array('/howto/viewpdf/id/' . $data->id ), array('class'=>'btn btn-primary') );?>		
		
<!--bookmark--><?= CHtml::link('<i class="icon-bookmark icon-white"></i>Bookmark ', 
					array(''), array(
						'class'=>'btn btn-primary bookmark',  
						'name'=>$data->id,
						) );?> <div id="bookmark_success_<?=$data->id;?>" style="display:none"></div>
		
		

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
					$('#bookmark_success_'+id).fadeOut('slow');
				}
			});
			return false;
		});
	</script>
