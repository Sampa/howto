<?php

class DashboardController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
		);
	}

	public function allowedActions(){
		return 'index,create,updatePortlets,updateportletcontent,active,deactivateportlet';
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Dashboard;

		if(isset($_POST['Dashboard']))
		{
			$model->attributes=$_POST['Dashboard'];
			
			if($model->save()){
				$model->position = $model->id;
				if($model->save())
					echo CJSON::encode('New portlet added');
			}
		}

	}
		public function actionIndex(){
		//new portlet related ('create action')
		$model=new Dashboard;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model,'dashboard-form');
		//index related
		$usercount = User::model()->count();
		$howtocount = Howto::model()->count();
		$commentcount = Comment::model()->count();
		$stepcount = Step::model()->count();
		$socialcount = Social::model()->count();
		
		$criteria = new CDbCriteria(
		array(
			'order'=>'position',
			'condition'=>'user_id='.Yii::app()->user->id,
		));
		$dataProvider = new CActiveDataProvider('dashboard', array(
			'criteria'=>$criteria,
		));
		// if you use renderPartial  for a portlet and want to pass info to them add them to this array in the format 'iportlet-id'=>array('foo1'=>$foo1,'foo2'=>$foo2),
		$renderProperties = Dashboard::renderProperties();
		
		$properties = array(
					'usercount'=>$usercount,
					'howtocount'=>$howtocount,
					'commentcount'=>$commentcount,
					'stepcount'=>$stepcount,
					'socialcount'=>$socialcount,
					);
		if(Yii::app()->user->checkAccess(Rights::module()->superuserName )){
		if(Yii::app()->request->isAjaxRequest){
			$content = 	$this->renderPartial('index',array(
				'properties'=>$properties, 
				'model'=>$model,
				'dataProvider'=>$dataProvider,
				'renderProperties'=>$renderProperties,
				),true);
			echo $content;
		}else{
			$this->render('index',array(
				'properties'=>$properties, 
				'model'=>$model,
				'dataProvider'=>$dataProvider,
				'renderProperties'=>$renderProperties,
				));
			}
		}
	}
	public function actionupdatePortlets(){
		if ( Yii::app()->request->isAjaxRequest )
			{	
				$pos = 0;
				$foo = array();
				 foreach ( $_GET['pos'] as $id )
				 {
					$model = $this->loadModel($id);
					$model->position = $pos;
					$model->save(false);
					$pos = $pos+1;
				}
			echo CJSON::encode(array(
					'status'=>'success',
					'message'=>'Updated the portlets positions',
			));
		}
	}
	public function actionupdateportletcontent(){
		if ( Yii::app()->request->isAjaxRequest ){
					$model = $this->loadModel($_POST['id']);
					$model->content = $_POST['content'];
					$model->title = $_POST['title'];
					$model->save(false);
			
			echo CJSON::encode('Updated the portlet content');
		}
	}
	public function actiondeactivateportlet(){
		if ( Yii::app()->request->isAjaxRequest ){
					$model = $this->loadModel($_POST['id']);
					$model->active = 0;
					$model->save(false);
			
			echo CJSON::encode('Deactivated port');
		}
	}
	public function actionactive(){
		if ( Yii::app()->request->isAjaxRequest ){

			$rows = Dashboard::model()->findAll('user_id=:user_id', array(':user_id'=>Yii::app()->user->id));

			foreach($rows as $row){
				$model = $this->loadModel($row->id);
				$model->active = 0;
				$model->save(false);
			}
			foreach($_POST as $portlet=>$active){
				$model = $this->loadModel($portlet);
				$model->active = 1;
				$model->save(false);
			}
			echo CJSON::encode('Saved settings');
		}
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($_POST['id'])->delete();
			echo CJSON::encode('Deleted the portlet');		
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}




	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Dashboard::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


}
