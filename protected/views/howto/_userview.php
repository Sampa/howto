<div class="well" style="min-height:230px; max-width:180px;">
	<div style=" position:relative; ; top:0px; float:left;" class="">
	<?php
		$this->widget('UserButton', 
				array(
				'id'=>$data->id,
				'userid'=>$data->id,
				'username'=>$data->username,
				'reputation'=>$data->reputation,
				)); 
		?>
	</div>

		<div style="float:left;left:0px;">
			
			<h6 style="	">
				
				<?php echo CHtml::encode($data->created); ?>
			</h6>
		</div>	
		
	<?php 
		if ( $data->avatar ) 
		{
			$avatar  = User::USER_DIR;//path to base-folder for your avatars
			$avatar .= $data->id."/"; //folder where user files is stored
			$avatar .= Chtml::encode($data->avatar); //the image filename
			$img = CHtml::image($avatar, "Avatar", array()); 
			echo CHtml::link($img, $avatar,
			array('class'=>'thumbnail span2','data-title'=>'Tooltip','rel'=>'fancybox'));
		}?>
		

</div>