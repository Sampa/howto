<?php
	$this->breadcrumbs = array( $model->title, );
	$this->pageTitle = $model->title;
	$this->layout = "column1";
	$updated = date('F j, Y',$model->update_time);

?>
<?php  Yii::app()->clientScript->registerScriptFile('/js/howto.view.js',CClientScript::POS_BEGIN);?>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "072ae230-75fe-4c32-ab84-c2c0cb6ce84e"}); </script>
	
<div id="howto_container" class="span12" style="padding-left: 5px; float:left; ">

	<div id="left" class="span6" style="" >
	
		<?php $this->renderPartial('_view',array('data'=>$model,'owner'=>$owner ,'view'=>true ),false ); ?>
	<h5>Last updated: <i><?= $updated?></i> </h5>
	
	<!-- steps-->
	<div id="steps" class="span12" style=" float:left;">
		<?php if ( $owner ):?>
			<!-- files with modalwindow, ajax calls etc for easier reading -->
		<?php $this->renderPartial('//step/_create',array('howto'=>$model->id)); ?>
		<?php if ( $model->stepCount >= 1 ): ?>
			<h3>
				<?= $model->stepCount>1 ? $model->stepCount . ' steps' : 'One step'; ?>
			</h3>
		<?php endif; ?>
		<?php
		Yii::app()->user->setFlash('info', 'Drag the titles of the steps to  re-arrange them <br/>
		Change the steps by clicking on the step text.');
		$this->widget('bootstrap.widgets.BootAlert'); 
		endif;
		?>
		<div id="stepsUpdated"></div>
		
			<ul id="sortable" style="">	
		<?php
	
		foreach ( $model->steps as $step ):
			if($owner){
				echo '<li id="'.$step->id.'" class="ui-state-highlight" style="border:0px solid green">';
			}
			echo "<h5>".$step->title."</h5>";
			echo '<br/><div id="div'.$step->id.'" style="display:none;"></div>';
			echo '<div  name="'.$step->id.'" id="step_text_div'.$step->id.'" class="well step_text" ">' . $step->text .'</div>';
			if($owner):
			echo '<button class="btn btn-mini btn-success save_step" name ="'.$step->id.'" 
			id="button'.$step->id.'" style="display:none;">Save</button>';;
		 ?>
		 <script type="text/javascript">
			
			bkLib.onDomLoaded(function() {
			var myNicEditor = new nicEditor({uploadURI:'/nic/upload.php?hej=<?=$model->id;?>'});
			myNicEditor.setPanel('div<?=$step->id;?>');
			myNicEditor.addInstance('step_text_div<?=$step->id;?>');

			});
		</script>
			<?php if($owner){echo "</li>";}?>
		<?php endif;?>
		<?php endforeach; ?>
			</ul>
	</div><!--steps-->
	<?php if($related): ?>
		
		<div id="slider-code" class="span12">
				<h3>You might also like:</h3>

			<a class="buttons prev" href="#"><img src="/images/arrow_left.gif" alt="left"/></a>
			<div class="viewport">
				<ul class="overview" >
				<?php
				foreach ( $related as $link=>$weight )
				{
					echo '<li class="well">'.$link.'</li>';
				}
				?>
				<li> some shits</li>
				<li> some second shits</li>
				<li> some third shits</li>
				<li> some  fourth shits</li>
				</ul>
			</div>
			<a class="buttons next" href="#"><img src="/images/arrow_right.gif" alt="right"/></a>
		</div>
			
		<?php endif;?>
	
</div><!-- left-->

<!------ RIGHT COLUMN -->

	<div id="side" style="margin: 25px 0px 0 25px;padding-left:25px; border-left:0px solid #08c" class="span5" >
		<!-- CATEGORIES -->
		<?php
		if (!count($model->categoryLinks) < 1){
		foreach ( $model->categoryLinks as $catLink ){echo ''.$catLink.'';}
		}
		?>
		<?php 
	
		if(count($model->tagLinks) > 0)
		{
			foreach($model->tagLinks as $taglink)
			{	echo $taglink. "&nbsp;"; }
		}
		?>
		<hr/>
<?php /// SLIDES
	/*if( $owner ) {
		echo "<br/><br/>".CHtml::htmlButton('<i class="icon-edit icon-white"></i> Manage Slides',
		array('class'=>'btn btn-mini btn-primary manage_slide'));
		$slide = new Slide('search');
		$this->renderPartial('//slide/index',array('model'=>$slide,'howto'=>$model->id));
		}
	
	$panels = Slide::model()->findAll('howto_id='.$model->id);
	if ( $panels )
	{
		$this->renderPartial('_slide',array('howto'=>$model->id,'panels'=>$panels));
	} 
	 
	foreach($videos as $video):

	endforeach;
*/ ?>
	<script type="text/javascript">
	
function getCreate(id,content,response){
	if(response == ""){
	response = false;
	}
	var content = $(content).html();
    var url = '/comment/new?howto_id='+id;
    jQuery.getJSON(url, {content: content,response:response}, function(data) {
        if (data.status == 'success') {
           return true;	
			
        }else{return false;}          
	});}
	
$(document).ready(function() {

$('#slider-code').tinycarousel({display:2, controls:true});

$(".save_step").hide();
	$(".step_text").click(function(){
		var id = $(this).attr('name');
		console.log(id);
		$("#button"+id).fadeIn('slow');
		$("#div"+id).fadeIn('slow');

	});
	$(".save_step").click(function(){
		var id = $(this).attr('name');
		var url = '/step/inlineEdit?id='+id;
		var content = $('#step_text_div'+id).html();
		jQuery.getJSON(url, {content: content }, function(data) {
			if (data.status == 'success'){
					$("#button"+id).fadeOut('slow');
					$("#div"+id).fadeOut('slow');
				}
			});
			return false;
		});


initThis();/*  this is the js file with all code for each _view file*/


$(".alert").click(function(){
$(this).hide();
});
	
<!-- EVENT! When the user has sorted a step to a new position -->
$("#sortable").bind( "sortupdate", function(event, ui) {
updatePos();
});
function updatePos() {
    var pos = $("#sortable").sortable('toArray');
        url = '/step/updatePos/howtoid/'+<?php echo $model->id;?>;
 
    jQuery.getJSON(url, {pos: pos}, function(data) {
        if (data.status == 'success') {
            $('#stepsUpdated').fadeIn('slow');			
            $('#stepsUpdated').html(data.div);
			$('#stepsUpdated').fadeOut('slow');
        }
    });
    return false;
}
<!-- END EVENT -->
	$(".manage_slide").click(function(){
			$("#slide_div").toggle();
		});
});

</script>
		
		<div style=" clear:both;position:relative; width:120%;top:0px; left:0px; ">
				<span class='st_sharethis' displayText='ShareThis'></span>
				<span class='st_twitter' displayText='Tweet'></span>
				<span class='st_email' displayText='Email'></span>
				<span class='st_plusone' displayText='Google +1'></span>
				<span class='st_fbsend' displayText='Facebook Send'></span>
				<span class='st_fbrec' displayText='Facebook Recommend'></span>
		</div>	


<?php if($model->commentCount>=1): ?>
		<h5>
			<?php echo $model->commentCount>1 ? $model->commentCount . ' comments' : 'One comment'; ?>
		</h5>
		<div id="current">
		<?php $this->renderPartial('_comments',array(
			'howto'=>$model,
			'comments'=>$model->comments,
		)); ?>
		</div>
	<?php endif; ?>


	<?php if ( !Yii::app()->user->isGuest ){
	
		$this->renderPartial('/comment/_form',array(
			'model'=>$comment,
			'howto'=>$model,
		)); 
	}else{ echo "You must be signed in to comment";}

	?>
	</div><!-- comments -->
	<!-- to fix the rating breaking in view but not index-->
	<script>
	 $("[id^=rating]").each(function () {
       $(this).find("input").rating();
		});
	</script>
