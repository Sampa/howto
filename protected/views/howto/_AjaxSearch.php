<?php
	$created = date('F j, Y',$data->create_time); 
	$updated = date('F j, Y',$data->update_time);
?>

<div class="Howto well" style=" overflow:auto;max-width:180px;;" >
	<div class="title">
		<h4>	
			<?= CHtml::link(CHtml::encode($data->title), $data->url); ?>
		</h4>
	</div>
<!-- author link -->
	<div class="author" style=" max-height:18px;margin-left:-15px;">
		<div style="position:relative;left:5px;">
		<span style="position:relative;top:3px;"><i> <?=$created;?></i></span>
		<?php
			$this->widget('UserButton', 
				array(
				'id'=>$data->id,
				'userid'=>$data->author->id,
				'username'=>$data->author->username,
				'reputation'=>$data->author->reputation,
				)); 
		?>
			</div> 


	</div>
	<div style="clear:both"></div>
	<!-- created and last updated dates-->
		
	<!-- container to adjust the user link-->
	<div  style="position:relative;float:left; top:-17px;"> 

		<div  id="rating_info_<?=$data->rating_id?>">
<?php 
	if ( $rating = Rating::model()->findByPk($data->rating_id) )
		{	
			echo "Rating: <strong>" . $rating->vote_average ."</strong>";
			echo " " . $rating->vote_count . " votes";
		}
?>
		</div>


		<div class="edit_area" style="">
		<?php
			echo substr($data->content,0,150);
		?>
	
		</div>
	</div>
</div><!-- categories and down-->
		

