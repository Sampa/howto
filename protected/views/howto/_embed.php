<?php
	$created = date('F j, Y',$data->create_time); 
	$updated = date('F j, Y',$data->update_time);
?>

<div class="Howto">
	<div class="title">
		<h2>	
			<?= CHtml::link(CHtml::encode($data->title), $data->url,array('target'=>'_blank')); ?>
		</h2>
	</div>
<!-- author link -->
	<div class="author">
		<div style="float:left;">
		Shared by&nbsp; 	
		</div>
		<?= CHtml::link($data->author->username,$data->url,array('target'=>'_blank'));?>
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
		<br/>
		<div  id="rating_info_<?=$data->rating_id?>">
<?php 
	if ( $rating = Rating::model()->findByPk($data->rating_id) )
		{	
			echo "Rating: <strong>" . $rating->vote_average ."</strong>";
			echo " " . $rating->vote_count . " votes";
		}
?>
		</div>



	<div class="content">
		<br/>
		<div class="edit_area">
		<?php
			echo CHtml::encode($data->content);
		?>
		</div>
	</div>
	<div class="nav">
		<b>Tags:</b>
		<?= implode(', ', $data->tagLinks); ?>
		<br/>


<!--print--><?= CHtml::link('<i class="icon-print icon-white"></i> Print/Pdf', 
					array('/viewpdf/id/' . $data->id ), array('class'=>'btn btn-primary','target'=>'_blank') );?>		
		

	</div><!-- nav -->
	</div><!-- categories and down-->
</div>

	
<?php $this->renderPartial('//howto/_mail');?>
