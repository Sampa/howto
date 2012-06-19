<?php

class SiteController extends Controller
{


	/**
	 * Declares class-based actions.
	 */
	public function  actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}




	/**
	 * This is the action to handle external exceptions.
	 */
	public function  actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function  actionContact()
	{
		$model = new ContactForm;
		$this->performAjaxValidation( $model, 'contact-form' );

		if ( isset ( $_POST['ContactForm'] ) )
		{
			$model->attributes = $_POST['ContactForm'];
			if ( $model->validate() )
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render( 'contact',array( 'model'=>$model ) );
	}
	
	//search method
	public function  actionSearch()
	{	
			
		$this->render( 'search',array(  ) );
			
	}

	/**
	 * Displays the login page
	 */
	public function  actionLogin()
	{	
		$model=new LoginForm;
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				  if (Yii::app()->request->isAjaxRequest)
					{			                		
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>'Login',
                        'title'=>'',
                        ));
                    exit;             
					} else{				
						$this->redirect(Yii::app()->user->returnUrl);
						}
				}
		}
		if (Yii::app()->request->isAjaxRequest)
        {
			    
            echo CJSON::encode(array(
                'status'=>'render', 
                'div'=>$this->renderPartial('/site/modalLogin', array('model'=>$model), true)));
            exit;               
        } else{
	
		// display the login form
		$this->render('login',array('model'=>$model));
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function  actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect( Yii::app()->homeUrl );
	}
	
	public function  actionHauth(){
	$this->render('hauth');
	
	}
	
	public function  actionIndex()
	{
		$this->render('pages/index');
	
	}
	
	public function  actionQuestion($q)
	{
		$this->renderPartial('questions/'.$q);
	}
	/**
	 * Restores the database for the demo application.
	 */
	
// UTILITY public function S

public function  nicupload_error($msg) {
    echo nicupload_output(array('error' => $msg)); 
}

public function  nicupload_output($status, $showLoadingMsg = false) {
    $script = '
        try {
            '.(($_SERVER['REQUEST_METHOD']=='POST') ? 'top.' : '').'nicUploadButton.statusCb('.json_encode($status).');
        } catch(e) { alert(e.message); }
    ';
    
    if($_SERVER['REQUEST_METHOD']=='POST') {
        echo '<script>'.$script.'</script>';
    } else {
        echo $script;
    }
    
    if($_SERVER['REQUEST_METHOD']=='POST' && $showLoadingMsg) {      

echo <<<END
    <html><body>
        <div id="uploadingMessage" style="text-align: center; font-size: 14px;">
            <img src="http://js.nicedit.com/ajax-loader.gif" style="float: right; margin-right: 40px;" />
            <strong>Uploading...</strong><br />
            Please wait
        </div>
    </body></html>
END;

    }
    
    exit;
}

public function  nicupload_file_uri($filename) {
    return NICUPLOAD_URI.'/'.$filename;
}

public function  ini_max_upload_size() {
    $post_size = ini_get('post_max_size');
    $upload_size = ini_get('upload_max_filesize');
    if(!$post_size) $post_size = '8M';
    if(!$upload_size) $upload_size = '2M';
    
    return min( ini_bytes_from_string($post_size), ini_bytes_from_string($upload_size) );
}

public function  ini_bytes_from_string($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;
}

public function  bytes_to_readable( $bytes ) {
    if ($bytes<=0)
        return '0 Byte';
   
    $convention=1000; //[1000->10^x|1024->2^x]
    $s=array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB');
    $e=floor(log($bytes,$convention));
    return round($bytes/pow($convention,$e),2).' '.$s[$e];
}
}