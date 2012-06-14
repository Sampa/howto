<div class="well" style="min-height:120px;">
	<?php 
		if ( $data->avatar ) 
		{
			$avatar  = User::USER_DIR;//path to base-folder for your avatars
			$avatar .= $data->id."/"; //folder where user files is stored
			$avatar .= Chtml::encode($data->avatar); //the image filename
			$img = CHtml::image($avatar, "Avatar", array()); 
			echo CHtml::link($img, $avatar,
			array('class'=>'thumbnail span2','data-title'=>'Tooltip','rel'=>'fancybox'));
		}


	?>	

	<h5>
	<?php
		$this->widget('UserButton', 
				array(
				'id'=>$data->id,
				'userid'=>$data->id,
				'username'=>$data->username,
				'reputation'=>$data->reputation,
				)); 
		?>
	</h5>
	<div style=" position:relative; left:-90px; top:20px;" class="span3">
		<h5> Has created <?=$data->howtoCount;?> Howtos</h5>
		
		<h6>
			<?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:
			<?php echo CHtml::encode($data->created); ?>
		</h6>
		<h6>
			<?php echo CHtml::encode($data->getAttributeLabel('last_activity')); ?>:
			<?php echo CHtml::encode($data->last_activity); ?>
		</h6>
	</div>

 



</div>