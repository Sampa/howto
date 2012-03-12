<?php

class HowtoController extends Controller
{

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
		//	'updateOwn + update', // Apply this filter only for the update action.
			'rights',
		);
	}
	
	/**
	 * Filter method for checking whether the currently logged in user
	 * is the author of the Howto being accessed.
	 */
	public function filterUpdateOwn( $filterChain )
	{
		$howto = $this->loadModel();
		
		// Remove the 'rights' filter if the user is updating an own howto
		// and has the permission to do so.
		if ( Yii::app()->user->checkAccess( 'HowtoUpdateOwn', array( 'userid'=>$howto->author_id ) ) )
			$filterChain->removeAt( 1 );
		
		$filterChain->run();
	}

	/**
	* Actions that are always allowed.
	*/
	public function allowedActions()
	{
	 	return 'index, suggestTags,create,update,eltre';
	}
	


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$howto = $this->loadModel();
    	$comment = $this->newComment( $howto );

		$this->render( 'view',array(
			'model'=>$howto,
			'comment'=>$comment,
		));
	}
	
	public function actionEltre()
	{
		$this->renderPartial('_eltre');
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionBookmark()
	{
		if ( Yii::app()->request->isAjaxRequest ) 
		{
			
		if ( !Bookmark::model()->findByAttributes(array('howto_id'=>$_GET['id'],'user_id'=>$this->userId) ) )
			{
				$model = new Bookmark;
				$model->howto_id = $_GET['id'];
				$model->user_id = $this->userId;
				if ( $model->save() )
				{
					echo CJSON::encode( array (
					'status'=>'success', 
					'div'=>'Bookmarked',
					'title'=>'',
					) );			
				}
			}
		}
	}
	
	public function actionCreate()
	{
		Yii::import('ext.multimodelform.MultiModelForm');
		$step = new Step;
		$model = new Howto;
		$validatedSteps = array(); //ensure an empty array

		$this->performAjaxValidation( $model, 'howto-form' );
		if ( isset ( $_POST['Howto'] ) )
		{
			$model->attributes = $_POST['Howto'];
			 if ( $model->save() ){
					$masterValues = array ('howto_id'=>$model->id);

				
			
			 if ( MultiModelForm::save($step,$validatedSteps,$deleteSteps,$masterValues ) )
				$this->redirect( array( 'view' , 'id'=>$model->id ) );
			}
		}
		

		$this->render('create',array(
			'model'=>$model,
			'step'=>$step,
			'validatedSteps'=>$validatedSteps
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	 
	
	public function actionUpdate($id)
	{
		 Yii::import('ext.multimodelform.MultiModelForm');
		$model = $this->loadModel($id);
		$step = new Step;
		$validatedSteps = array(); //ensure an empty array
		$this->performAjaxValidation( $model, 'howto-form' );
	
		
		if ( isset ( $_POST['Howto'] ) )
		{
			$model->attributes = $_POST['Howto'];
			$masterValues = array ('howto_id'=>$model->id);
			 if ( MultiModelForm::save($step,$validatedSteps,$deleteSteps,$masterValues) &&
            $model->save()
           )
				$this->redirect( array( 'view' , 'id'=>$model->id ) );
		}
	
		
		$this->render('update',array(
			'model'=>$model,
			'step'=>$step,
			'validatedSteps'=>$validatedSteps
		));
	}
	
	
	
	

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if ( Yii::app()->request->isAjaxRequest )
		{
			if ( $this->loadModel()->delete() )
				{
					echo CJSON::encode(
						array(
							'status'=>'success', 
							'div'=>"Holy guacamole! You just permently deleted the entire How-to.
				If you want to make a backup of the text this is the time to do it.",	
							));
					exit;
				}
			exit;
		}
		if ( Yii::app()->request->isPostRequest )
		{
			// we only allow deletion via Howto request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if ( !isset ( $_GET['ajax'] ) )
				$this->redirect( array( 'index' ) );
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionviewPdf( $id )
	{
		$mPDF1 = $this->actionMakePdf();
		$mPDF1->WriteHTML( $this->renderPartial('_pdf', array( 'model' => $this->loadModel( $id ) ), true ) );
		
		return $mPDF1->outPut();
	}
	
	/**
	 * Lists all models.
	 */
	public function actionShow()
	{
		$this->forward('index');
	}
	
	public function actionIndex($show="",$category="")
	{
		$criteria = new CDbCriteria(
		array(
			'condition'=>'status='.Howto::STATUS_PUBLISHED,
			'order'=>'update_time DESC',
			'with'=>'commentCount',
		));
		if ( isset ( $_GET['tag'] ) )
			$criteria->addSearchCondition( 'tags',$_GET['tag'] );
	
		if ( isset ( $_GET['category'] ) )
		{
			$criteria->together = true;
			$criteria->with = 'categories';
			$criteria->Compare('categories.category' , $category , true );
		}
		
		if ( isset ( $show ) )
		{
		
			if ( $show == "new" )
			{
			$today = new DateTime();
			$today->modify('-1 month'); 
			
			$compareDate = $today->format('Y-m-d');
			$sql = "create_time >".$compareDate;
			$criteria->addCondition($sql);

			}
			if ( $show == "own" )
			{
				if ( Yii::app()->user->isGuest )
				{
					$this->redirect( array( '/reg' , 'ref'=>'own' ) );
				}
				$criteria->addColumnCondition( array ( 'author_id'=>Yii::app()->user->id ) );
			}
		}
		
		$dataProvider = new CActiveDataProvider('Howto', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['howtosPerPage'],
			),
			'criteria'=>$criteria,
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Howto( 'search' );
		if ( isset( $_GET['Howto'] ) )
			$model->attributes = $_GET['Howto'];
		$this->render('admin',
			array(
				'model'=>$model,
			) );
	}

	/**
	 * Suggests tags based on the current user input.
	 * This is called via AJAX when the user is entering the tags input.
	 */
	public function actionSuggestTags()
	{
		if ( isset ( $_GET['q'] ) && ( $keyword = trim( $_GET['q'] ) )!=='')
		{
			$tags = Tag::model()->suggestTags($keyword);
			if ( $tags!==array() )
				echo implode( "\n",$tags );
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if ( $this->_model === null )
		{
			if ( isset ( $_GET['id'] ) )
			{
				if ( Yii::app()->user->isGuest )
					$condition='status='.Howto::STATUS_PUBLISHED.' OR status='.Howto::STATUS_ARCHIVED;
				else
					$condition='';
				$this->_model=Howto::model()->with('steps')->findByPk($_GET['id'], $condition);
			}
			if ( $this->_model === null )
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Creates a new comment.
	 * This method attempts to create a new comment based on the user input.
	 * If the comment is successfully created, the browser will be redirected
	 * to show the created comment.
	 * @param Howto the Howto that the new comment belongs to
	 * @return Comment the comment instance
	 */
	protected function newComment($howto)
	{
		$comment = new Comment;
		if ( isset ( $_POST['ajax'] ) && $_POST['ajax']==='comment-form' )
		{
			echo CActiveForm::validate($comment);
			Yii::app()->end();
		}
		if ( isset ( $_Post['Comment'] ) )
		{
			$comment->attributes = $_POST['Comment'];
			if ( $howto->addComment( $comment ) )
			{
				if ( $comment->status==Comment::STATUS_PENDING )
					Yii::app()->user->setFlash('commentSubmitted','Thank you for your comment. Your comment will be Howtoed once it is approved.');
				$this->refresh();
			}
		}
		return $comment;
	}
}
