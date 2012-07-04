<?php
	$created = date('F j, Y',$data->create_time); 
	$updated = date('F j, Y',$data->update_time);
	if(Yii::app()->user->id == $data->author->id){
		$owner = true;
		}else{
		$owner = false;
		}
?>
<script type="text/javascript">
	$(document).ready(function(){
			initThis();
		});
</script>
<div class="Howto  howtopage"  style=" margin:10px 0px 100px 0px;border-bottom:1px inset #08C;" >
<div class="well">
	
	<div class="title ">
		<h2><?= CHtml::link(CHtml::encode($data->title), $data->url); ?></h2>
	</div>
	
<!-- author link -->
	<div class="author span10" style=" max-height:18px;margin-left:0px;">
		<div style="float:left; margin-top:2px;">Shared by&nbsp;</div>
		<?php
			$this->widget('UserButton', 
				array(
				'id'=>$data->id,
				'userid'=>$data->author->id,
				'username'=>$data->author->username,
				'reputation'=>$data->author->reputation,
				)); 
		?>
<!-- created and last updated dates-->
		<div style="margin-top:2px;">
			&nbsp;on <i> <?=$created;?></i>
		</div>
	</div>

	<div style="clear:both"></div>
	<!-- container to adjust the user link-->
	<div  style="position:relative; top:10px;"> 
<?php if ( $owner ):?>
	
		<div  id="nic<?=$data->id;?>" style=" max-width:85%; display:none; float:left;"></div>
		<button  rel="<?=$data->id;?>" style="display:none;" class="btn btn-mini btn-success savecontent">
		<i class="icon-ok icon-white"></i>	Save
		</button>
		<div id="save_content_response<?=$data->id;?>" style="display:none;"></div>
<?php endif;?>
		
		<div class="content">
		<div class="edit_area" name="<?=$data->id;?>" id="edit_content<?=$data->id;?>" style="max-width:90%">
				<?php
					echo $data->content;
				?>
			</div>
		
		</div>
	</div>

</div> <!-- well -->	
<div style="float:left; margin-top:13px;">
		<?php if ( $rating = Rating::model()->findByPk($data->rating_id) )
		{	
// rating
	$this->widget('CStarRating',array(
    'name'=>'rating'.$data->rating_id,
	'starCount'=>5,
	'readOnly'=>false,
	'resetText'=>'',
	'value'=>round($rating->vote_average,0),
    'callback'=>'
        function(){
        	url = "/howto/rating";
			jQuery.getJSON(url, {id: '.$data->rating_id.', val: $(this).val()}, function(data) {
				if (data.status == "success"){

					$("#rating_info_'.$data->rating_id.'").html(data.info);
					$("input[id*='.$data->rating_id.'_]").rating("readOnly",true);
					}
				});}'
			));
?> 	
		<div style="float:left;" id="rating_info_<?=$data->rating_id?>">
<?php 

			echo "<strong>" . $rating->vote_average ."</strong>";
			echo " " . $rating->vote_count . " votes";
		}
?>
		</div>
</div>
<!--buttons-->
<div style="padding-bottom:2px; margin-top:10px; float:left;">

<!--print-->
	<?= CHtml::link('<i class="icon-print"></i> Print/Pdf', '/viewpdf/id/'.$data->id,
				array('class'=>'btn btn-mini printpdf','id'=>$data->id) );?>


	
<!--bookmark--><?php if ( !Yii::app()->user->isGuest )
					{
						echo CHtml::htmlButton('<i class="icon-bookmark"></i> Bookmark ', 
						 array(
							'class'=>'btn btn-mini  bookmark',  
							'name'=>$data->id,
							) );
					}
				?>
		<div id="bookmark_success_<?=$data->id;?>" style="display:none"></div>


<!--Add Step-->
<?php if( $owner): ?>
				<?php if( isset($view) && $view== true):?>
					<button class="btn btn-mini " id="createButton"><!-- sign up button-->
						<i class="icon-plus"></i> Add Step
					</button>
				<?php endif;?>
<!--delete--> 
			<button class="btn btn-mini btn-danger howtodelete" name="<?=$data->id;?>">
				<i class="icon-remove icon-white"></i> Delete
			</button>
				<div id="delete_howto_message<?=$data->id;?>" name="<?=$data->id;?> style="display:none"></div>
<?php endif; ?>   

</div> <!--buttons-->


		<div style="display:none;" class="well" id="embedCode<?=$data->id;?>">
			<h4>Copy this code and paste it into your website</h4>
			<h6><?php echo CHtml::encode('<iframe 
		   src="http://83.233.118.50/howto/'.$data->id.'/'.$data->title.'!?embed=true" width="550" height="577" marginwidth="0" marginheight="0" frameborder="no"   scrolling="yes"</iframe>');?></h6>
	   </div>
</div><!-- howto page-->
	