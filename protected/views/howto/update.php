<?php
$this->breadcrumbs=array(
	$model->title=>$model->url,
	'Update',
);
?>

<h1>Update <i><?php echo CHtml::encode( $model->title ); ?></i></h1>

	<button id="howtodelete" class="btn btn-danger">
	<i class="icon-remove icon-white"></i>Delete this Howto</button>
	
	<div id="delete_howto_message" style="display:none">

	</div>
<?php 	
	echo $this->renderPartial('_form',
		array( 'model'=>$model,'step'=>$step,'validatedSteps'=>$validatedSteps ) );
?>

	<script>
			$("#howtodelete").click(function(){
				deletehowto(<?php echo $model->id;?>);
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
	</script>
