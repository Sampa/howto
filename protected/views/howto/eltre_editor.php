	
	<?php 
		$this->widget('application.extensions.elrte.elRTE', 
		array(
			'selector'=>'.edit_area',
			'userid'=>Yii::app()->user->id,
		));
	?>