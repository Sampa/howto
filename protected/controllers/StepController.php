<?php

class StepController extends Controller
{

	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
		);
	}
	
		public function allowedActions()
	{
	 	return 'index,create,update';
	}
	



	public function actionupdatePos ( $howtoid )
		{
			if ( Yii::app()->request->isAjaxRequest )
			{
				foreach ( $_GET['pos'] as $newPos => $id )
				{
					$sql = "UPDATE step SET position=".$newPos;
					$sql .=" WHERE id=".$id." AND howto_id=".$howtoid;
					Yii::app()->db->createCommand($sql)->query();
				}
			
			echo CJSON::encode ( array (
                        'status'=>'success', 
						'div'=>'Saved...',
						'howtoid'=>$howtoid
						));
		
			}
		}
	
	public function actionviewPdf( $id )
	{
		$mPDF1= $this->actionMakePdf();
		$mPDF1->WriteHTML( $this->renderPartial('_pdf', array( 'model' => $this->loadModel( $id ) ), true ) );
		
		return $mPDF1->outPut();
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
public function actionCreate()
    {
        $model = new Step;
 
        // Uncomment the following line if AJAX validation is needed
         $this->performAjaxValidation( $model , 'step-form' );
		if ( isset ( $_GET['howto_id'] ) ) 
		{
			$howto_id = $_GET['howto_id'];
		}
		
        if ( isset ( $_POST['Step'] ) )
        {
			
            $model->attributes = $_POST['Step'];
			$model->howto_id = $howto_id;

            if ( $model->save() )
            {

                if ( Yii::app()->request->isAjaxRequest )
                {
								                		
                	$title = $_POST['Step']['titel'];
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>$title.' has been created, you can add more if you want',
                        'title'=>$title,
                        ));
                    exit;             
                }
                else
                    $this->redirect(array('howto/view','id'=>$howto_id));
            }
        }
 
        if ( Yii::app()->request->isAjaxRequest )
        {


            echo CJSON::encode(array(
                'status'=>'render', 
                'div'=>$this->renderPartial('_form', array('model'=>$model,'howtoid'=>''), true)));
            exit;               
        }
        else
            $this->render('create',array('model'=>$model,'howto'=>$howto_id));
    }
	
	

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
public function actionUpdate($id)
    {
		//$this->layout = '//main';
    	
        $model = $this->loadModel($id);
 
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model,"step-form");

        if ( isset ( $_POST['Step'] ) )
        {
				
            $model->attributes = $_POST['Step'];
			
			if ( isset ( $_GET['howtoid'] ) )
			{
				$model->howto_id = $_GET['howtoid'];
				
			}
            if ( $model->save() )
            {
				$this->redirect( Yii::app()->user->returnUrl );
            }else{}
        }

		$this->render('update',array('model'=>$model,));
	}
       
        
		
	



	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
	if ( Yii::app()->request->isAjaxRequest )
	{
	$this->loadModel( $id )->delete();

	echo CJSON::encode(array(
                        'status'=>'success', 
						'div'=>'Saved...',
						
						));
		exit;
		}
		if ( Yii::app()->request->isPostRequest )
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();
	
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if ( !isset ( $_GET['ajax'] ) )
				$this->redirect( isset ( $_POST['returnUrl'] ) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	
	
	
	}
	public function actionInlineEdit()
	{			
			$model = Step::model()->findByPk($_GET['id']);
		
		if ( Yii::app()->request->isAjaxRequest )
		{				$model->text = $_GET['content'];

			if ( $model->save() ) 
			{
			echo CJSON::encode( array (
					'status'=>'success', 
					) );
			}
			
			
		}
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Step');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Step('search');
		$model->unsetAttributes();  // clear any default values
		if ( isset ( $_GET['Step'] ) )
			$model->attributes = $_GET['Step'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = Step::model()->findByPk($id);
		if ( $model===null )
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	
}
