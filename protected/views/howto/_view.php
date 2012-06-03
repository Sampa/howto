<?php
	$created = date('F j, Y',$data->create_time); 
	$updated = date('F j, Y',$data->update_time);
?>

<div class="Howto span6" style="border: 0px solid black; margin-left:0px; margin-bottom:-50px;" >
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
		<br/>
		<div class="edit_area">
		<?php
			echo $data->content;
		?>
		</div>
	</div>
	<div class="nav">

		<b>Tags:</b>
		<?= implode(', ', $data->tagLinks); ?>
		<br/>
<!-- steps-->
	<?php
		$steps ="";
		if (count($data->steps) < 1)
			$steps = "This howto has no steps...";
		foreach ( $data->steps as $step ){
			$steps .=  $step->title.'<br/><div class="well edit_step" ">' . $step->text .'</div>';
		}; 
		echo CHtml::link($data->stepCount.' Steps', $data->url.'#steps', array('class'=>'btn btn-mini  ', 'data-title'=>'Steps preview', 'data-content'=>$steps, 'rel'=>'popover')); 
	?>&nbsp;
<!--print--><?= CHtml::htmlButton('<i class="icon-print icon-white"></i> Print/Pdf', 
				array('class'=>'btn btn-mini btn-primary printpdf') );?>		
	
<!--bookmark--><?php if(!Yii::app()->user == $data->author->id){
				echo CHtml::htmlButton('<i class="icon-bookmark icon-white"></i> Bookmark ', 
					 array(
						'class'=>'btn btn-mini btn-primary bookmark',  
						'name'=>$data->id,
						) );}?>
		<div id="bookmark_success_<?=$data->id;?>" style="display:none"></div>
		
<!--email--><?= CHtml::htmlButton('<i class="icon-envelope icon-white"></i> Mail it', 
					array('class'=>'btn btn-mini btn-primary mail',
					'name'=>'?id='.$data->id.'&title='.$data->title) );?>	
<!-- embed -->
<?= CHtml::htmlButton('<i class="icon-retweet icon-white"></i> Embed', 
					 array('class'=>'btn btn-mini btn-primary embed','id'=>'embedLink'.$data->id,'name'=>$data->id) );?>
<!--edit--><?php 
			if( Yii::app()->user->checkAccess('HowtoUpdateOwn', 
				array('userid'=>$data->author_id))): ?>
			<button class="btn btn-mini btn-primary" id="edit_content">
				<i class="icon-edit icon-white"></i> Edit
			</button> 
<!--delete--> 
			<button id="howtodelete" class="btn btn-mini btn-danger">
				<i class="icon-remove icon-white"></i> Delete
			</button>
				<div id="delete_howto_message" style="display:none"></div>
		<?php endif; ?>   
		

	<div style="display:none;" class="well" id="embedCode<?=$data->id;?>">
	<h4>Copy this code and paste it into your website</h4>
	<h6><?php echo CHtml::encode('<iframe 
   src="http://83.233.118.50/howto/'.$data->id.'/'.$data->title.'!?embed=true" width="550" height="577" marginwidth="0" marginheight="0" frameborder="no"   scrolling="yes"</iframe>');?></h6>
   </div>
	</div><!-- nav -->
	</div><!-- categories and down-->
</div>



<style type="text/css">
.style{min-height:200px;}

</style>

		
	<?php if ( $this->user == $data->author->username):?>
	<div id="elrte_holder" style="clear:both; max-width:50%;">
	<textarea id="elrte_content" style="display:none" ></textarea>
	<?php 
		$this->widget('application.extensions.elrte.elRTE', 
		array(
			'selector'=>'#elrte_content',
			'userid'=>Yii::app()->user->id,
			'event'=>'$("#edit_content").click',
		));
	?>
	</div>
	<button id="save_content" name="<?=$data->id;?>" style="display:none" class="btn btn-mini btn-primary">Save</button>
		<script type="text/javascript">
	$('#edit_content').click(function(){
	 $('#elrte_content').elrte('val', $(".edit_area").html());
	 $('#elrte_content').fadeIn('slow');
	 $('#save_content').fadeIn('slow');
});

	 $('#save_content').click(function(){
	 $('#elrte_content').elrte('updateSource');
		var id = $(this).attr('name');
		var url = '/howto/inlineEdit?id='+id;
		var content = $('#elrte_content').elrte('val');
		jQuery.getJSON(url, {content: content }, function(data) {
			if (data.status == 'success'){
					$('.edit_area').html(data.div);
					$('#elrte_content').elrte('destroy');
					$('#elrte_content').fadeOut('slow');
					$('#save_content').fadeOut('slow');
					window.location.reload();
				}
			});
			return false;
	});
		</script>
		<?php endif;?>

		<script type="text/javascript">
	$(document).ready(function(){
	$(".save_step").hide();
	$(".step_text").click(function(){
		var id = $(this).attr('name');
		$("#"+id).fadeIn('slow');
		$("#div"+id).fadeIn('slow');

	});
	$(".save_step").click(function(){
		var id = $(this).attr('id');
		var url = '/step/inlineEdit?id='+id;
		var content = $('#step_text_div'+id).html();
		jQuery.getJSON(url, {content: content }, function(data) {
			if (data.status == 'success'){
					$("#"+id).fadeOut('slow');
					$("#div"+id).fadeOut('slow');

				}
			});
			return false;
		});
	$(".printpdf").click(function(){
		window.location.href = "/viewpdf/id/<?= $data->id;?>";
	});
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

			$("#howtodelete").click(function(){
				deletehowto(<?php echo $data->id;?>);
			});

		function deletehowto( id ) {
			url = '/howto/delete';
			jQuery.getJSON(url, {id: id}, function(data) {
				if (data.status == 'success')
					{
						$('#delete_howto_message').html(data.div);
						$('#delete_howto_message').fadeIn('slow');			

					} 
				});
				return false;
			}

	
	 $('.edit_step').editable('/step/inlineEdit?id=<?=$data->id;?>&url=<?=$data->url;?>', { 
         type      : 'textarea',
		 data	   : $(this).html(),
         cancel    : 'Cancel',
         submit    : 'OK',
         indicator : '<img src="img/indicator.gif">',
         tooltip   : 'Click to edit...',
		callback : function(value, settings) {

         console.log($(this).html());
     },
     });
 });//document ready
	
	</script>


		<script type="text/javascript">
	$("#embedLink<?=$data->id;?>").click(function(){
		id = <?=$data->id;?>;
		$("#embedCode"+id).toggle();
	});
	
</script>
<?php $this->renderPartial('//howto/_mail');?>
<br/>