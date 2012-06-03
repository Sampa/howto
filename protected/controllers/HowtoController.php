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
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			
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
	 	return 'index,view,suggestTags,eltre,rating';
	}
	


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$howto = $this->loadModel();
		$owner = false;
		if ( $howto->author->id == Yii::app()->user->id )
		$owner = true;
		
		if ( isset( $_GET['embed'] ) && $_GET['embed'] == "true" )
		{
		$this->renderPartial( 'embed',array(
			'model'=>$howto,
		));
		
		}else{
		$this->render( 'view',array(
			'model'=>$howto,
			'owner'=>$owner,
		));
		}
	}
	public function actionMail()
	{
		$model = new MailHowtoForm;
		if ( isset ( $_POST['MailHowtoForm'] ) )
		{
			$model->attributes = $_POST['MailHowtoForm'];
			if ( $model->validate() )
			{	
				$model->body .= "<br/>" . $model->url;
				$model->subject = $model->name . " shared a How-to with you";
				$headers="From: {$model->name}\r\nReply-To: {$model->email}";
				mail($model->email,$model->subject,$model->body,$headers);
				
				if ( Yii::app()->request->isAjaxRequest )
				{
				echo CJSON::encode( array (
							'status'=>'success', 
							'div'=>'Mail sent',	
							) );
				}
			}
		}
		if ( Yii::app()->request->isAjaxRequest )
		{
			$link = "http://www.howto.com/howto/".$_GET['id']."/".$_GET['title'];
			echo CJSON::encode( array (
				'status'=>'render', 
				'div'=>$this->renderPartial( 'mailHowtoForm',
				array( 'model'=>$model,'url'=>$link ),true,true ),	
						) );
		}
	
	}
	
	
	public function actionRating()
	{			
		$rating = Rating::model()->findByPk($_GET['id']);
			$rating->vote_count = $rating->vote_count + 1;
			$rating->vote_sum = $rating->vote_sum + $_GET['val'];
			$rating->vote_average = round($rating->vote_sum / $rating->vote_count,2);
		
		if ( Yii::app()->request->isAjaxRequest )
		{	
			if ( $rating->save() ) 
			{
			echo CJSON::encode( array (
						'status'=>'success', 
						'div'=>'Thank you for voting!',	
						'info'=>"Rating: " . $rating->vote_average ." " . $rating->vote_count . " votes",
						) );
			}
		}
	}
	
	public function actionInlineEdit()
	{			
		if(!Yii::app()->user->isGuest)
		{
			$model = Howto::model()->findByPk($_GET['id']);
			
			if ( Yii::app()->request->isAjaxRequest )
			{				$model->content = $_GET['content'];

				if ( $model->save() ) 
				{

					echo CJSON::encode( array (
					'status'=>'success', 
					'div'=>$model->content,
					) );
				}
				
				
			}
		}
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
				{ $message = 'Woho! Added this Howto to your bookmarks'; 
				}
				else { $message = 'Shit, something went wrong. Could not save this bookmark';
				}
							
			} else { $message = 'Oops! You have already bookmarked this Howto'; }
			echo CJSON::encode( array (
					'status'=>'success', 
					'div'=>$message,
					) );
			
		}
	}
	public function checkFiles($post)
	{
		$return = array();
		$files = explode( ';',$post );
		foreach( $files as $key=>$file )
		{
			if($key==0)
				continue;
			if( file_exists ( dirname(__FILE__) . "..\\..\\..\\files\\users\\".Yii::app()->user->id."\\video\\" . $file ) )
			{
				$return[] = $file;	
			}
		}	
		return $return;
	
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
			$rating = new Rating();
			$rating->save();
			$model->rating_id = $rating->id;

			if ( $model->save() )
			{
				
				$files = $this->checkFiles($_POST['Howto']['video']);
				print_r($files);
					foreach($files as $key=>$file)
					{
						$video = new Video;
						$video->user_id = Yii::app()->user->id;
						$video->howto_id = $model->id;
						$video->filename = $file;
						$video->save();
					}
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
	
	//**PDF/PRINT**
	public function actionviewPdf( $id )
	{
		$mPDF1 = $this->actionMakePdf();
		$mPDF1->WriteHTML( $this->renderPartial('_pdf', array( 'model' => $this->loadModel( $id ) ), true ) );
		
		return $mPDF1->outPut();
	}
	
	//**EXCEL**
	public function actionexcel( $id )
	{
		$model = $this->loadModel();
		$model = new CActiveDataProvider($model,
		array(
			'criteria'=>array(
				'condition'=>'id='.$id,
			),));
 
    // Export it (note the way we define columns, the same as in CGridView, thanks to EExcelView)
    $this->toExcel($model,
        array(
            'id',
            'title::Title', // Note the custom header
            'content::Howto',
			'tags',
			//'rating',
			'create_time',
			'status',

        ),
        'Random file',
        array(
            'creator' =>'',
			//'autoWidth'=>false,
        ),
        'Excel2007' // This is the default value, so you can omit it. You can export to CSV, PDF or HTML too
    );
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
		
		//*** SET THE SORT ORDER IF STATEMENTS ***//
		$order = 'create_time DESC';
		$split = explode("/",$show);
		
		if ( $split[0] == "show" )
		{
			switch ($split[1])
			{
				case "popular":
				$order = 'rating.vote_average DESC';
				break;

			}
		}
		//*** INITIATE ***//
		$criteria = new CDbCriteria(
		array(
			'condition'=>'status='.Howto::STATUS_PUBLISHED,
			'order'=>$order,
			'with'=>array('commentCount','rating'),
		));
		
		//*** CONDITION IF STATEMENTS ***//
		
		if ( isset ( $_GET['tag'] ) )
			$criteria->addSearchCondition( 'tags',$_GET['tag'] );
	
		if ( $split[0] == "category" ) 
		{
			$criteria->together = true;
			$criteria->with = 'categories';
			$criteria->Compare('categories.name' ,$split[1] , true );
		}
		
		switch ($show)
		{
			case "show/own":
			if ( Yii::app()->user->isGuest )
				{
					$this->redirect( array( '/reg' , 'ref'=>'own' ) );
				}
				$criteria->addColumnCondition( array ( 'author_id'=>Yii::app()->user->id ) );
			break;
			case "show/by":
			if ( Yii::app()->user->isGuest )
				{
					$this->redirect( array( '/reg' , 'ref'=>'own' ) );
				}
				$user = User::model()->find("username = '" . $_GET['user'] ."'");
				$criteria->addColumnCondition( array ( 'author_id'=>$user->id ) );
			break;
			
			case "show/new":
			$today = new DateTime();
			$today->modify('-1 month'); 
			
			$compareDate = $today->format('Y-m-d');
			$sql = "create_time >".$compareDate;
			$criteria->addCondition($sql);
			break;
			
		}
		//*** FIND THE DATA ***
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
				{
					$condition='status='.Howto::STATUS_PUBLISHED.' OR status='.Howto::STATUS_ARCHIVED;
				}else{
					$condition='';
				}	
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
	 public function registerAssets(){

            Yii::app()->clientScript->registerCoreScript('jquery');

         //IMPORTANT about Fancybox.You can use the newest 2.0 version or the old one
        //If you use the new one,as below,you can use it for free only for your personal non-commercial site.For more info see
		//If you decide to switch back to fancybox 1 you must do a search and replace in index view file for "beforeClose" and replace with 
		//"onClosed"
        // http://fancyapps.com/fancybox/#license
          // FancyBox2
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js_plugins/fancybox2/jquery.fancybox.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js_plugins/fancybox2/jquery.fancybox.css', 'screen');
         // FancyBox
         //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/fancybox/jquery.fancybox-1.3.4.js', CClientScript::POS_HEAD);
         // Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/fancybox/jquery.fancybox-1.3.4.css','screen');
        //JQueryUI (for delete confirmation  dialog)
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/jqui1812/js/jquery-ui-1.8.12.custom.min.js', CClientScript::POS_HEAD);
         Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/jqui1812/css/dark-hive/jquery-ui-1.8.12.custom.css','screen');
          ///JSON2JS
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/json2/json2.js');
       

           //jqueryform js
               Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/jquery.form.js', CClientScript::POS_HEAD);
              Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/form_ajax_binding.js', CClientScript::POS_HEAD);
              Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/client_val_form.css','screen');

 }
}
