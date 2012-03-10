<?php
$this->widget('zii.widgets.CMenu', 
	array(
	'items'=>array(
		array(
			'label'=>'Create New Howto',
			'url'=>array( '/howto/create' ), 
			'visible'=>Yii::app()->user->checkAccess( 'Howto.Create' )
		),
		array(
			'label'=>'Manage Howtos', 
			'url'=>array( '/howto/admin' ), 
			'visible'=>Yii::app()->user->checkAccess( 'Howto.Admin' )
		),
		array(
			'label'=>Yii::t( 'blog', 'Approve Comments (:commentCount)', 
				array( ':commentCount'=>Comment::model()->pendingCommentCount ) ), 
					'url'=>array('/comment/index'),
					'visible'=>Yii::app()->user->checkAccess( 'Comment.Approve' )
		),
		array(
			'label'=>'Logout', 
			'url'=>array( '/site/logout' ), 
			'visible'=>!Yii::app()->user->isGuest
		),
	),
));