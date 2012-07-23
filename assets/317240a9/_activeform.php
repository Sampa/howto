
<?php $portlets = Dashboard::model()->findAll('user_id='.Yii::app()->user->id);?>
<?php echo CHtml::beginForm('','',array('id'=>'active-portlets-form'));?>    
	
		<div class="row-fluid">
		<?php
			if($adminCheck){
				echo "<h4> Settings </h4>";
				echo "Setting1";
				echo CHtml::checkBox('setting1', 'checked');  
				echo "<br/>";
			
		}?>
		<h4> Select the portlets you want to be visible</h4>
		<?php 
			$data = array();
			$select = array();
				foreach($portlets as $portlet){
					if($portlet->active == 1){
					$checked = true;
					}else{
					$checked = false;
					}
						echo $portlet->title . "&nbsp;#". $portlet->id;
						echo CHtml::checkBox($portlet->id, $checked);  
						echo "<br/>";
				}
	?>
		</div>
<div class="action">
    <?php echo CHtml::submitButton("Save",array('class'=>'btn-primary btn-mini btn')); ?>
</div>
<?php echo CHtml::endForm(); ?>
