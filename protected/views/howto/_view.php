<div class="Howto">
	<div class="title">
		<?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?>
	</div>
	<div class="author">
		Posted by <?php echo $data->author->username . ' on ' . date('F j, Y',$data->create_time); ?>
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
		
		<?= CHtml::link('<i class="icon-print icon-white"></i>Print/Pdf', 
		array('/howto/viewpdf/id/' . $data->id ), array('class'=>'btn btn-primary') );
?>
	</div>
</div>
