<?php

class TagController extends Controller
{

	public function allowedActions()
	{
	 	return 'view';
	}
	
	public function actionView($tag)
	{

	$criteria = new CDbCriteria(
		array(
			'order'=>'create_time DESC',
			'with'=>array('tags'),
			'together'=>true,
		));
		$criteria->addCondition('status='.Howto::PUBLIC_STATUS);
		$criteria->addCondition("tags.name=:tag"); 
		$criteria->params = array(':tag' => $tag);
		//*** FIND THE DATA ***
		$dataProvider = new CActiveDataProvider('Howto', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['howtosPerPage'],
			),
			'criteria'=>$criteria,
		));

		$this->render('/howto/index',array(
			'dataProvider'=>$dataProvider,
		));
		/*$this->render('view',array(
			'model'=>$this->loadModel($tag),
		));*/
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}