<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{

	public $clip = "system.web.widgets.CClipWidget";
	public function init()
    {
	parent::init();
	}
	public function hybridAuthConfig(){
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | https://github.com/hybridauth/hybridauth
*  (c) 2009-2011 HybridAuth authors | hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

return 
	array(
		"base_url" => "http://83.233.118.50/hybridauth/", 

		"providers" => array ( 
			// openid providers
			"OpenID" => array (
				"enabled" => true
			),

			"Yahoo" => array ( 
				"enabled" => true 
			),

			"AOL"  => array ( 
				"enabled" => true 
			),

			"Google" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" ),
				"scope"   => ""
			),

			"Facebook" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "324349220969408", "secret" => "5178fb0ce11cdf64f2e18184f1146ad6" ),

				// A comma-separated list of permissions you want to request from the user. See the Facebook docs for a full list of available permissions: http://developers.facebook.com/docs/reference/api/permissions.
				"scope"   => "", 

				// The display context to show the authentication page. Options are: page, popup, iframe, touch and wap. Read the Facebook docs for more details: http://developers.facebook.com/docs/reference/dialogs#display. Default: page
				"display" => "" 
			),

			"Twitter" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "rPmGEE1Wvsf56BSyQaWXw", "secret" => "V4SK09O0cPOgkabsxR5AruBSNrc0b1tzoBeWkL7ew0" ) 
			),

			// windows live
			"Live" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),

			"MySpace" => array ( 
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" ) 
			),

			"LinkedIn" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "", "secret" => "" ) 
			),

			"Foursquare" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),
		),

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,

		"debug_file" => "",
	);

	}
	protected function afterRender($view, &$output)
	{
		parent::afterRender($view,$output);

		return true;
	}
	
	
	
	public function ajaxDelete( $id , $model )
	{
		if ( Yii::app()->request->isAjaxRequest )
		{
			
				if ( $model::loadModel( $id )->delete() )
				{
					echo CJSON::encode(
						array(
							'status'=>'success', 
							'div'=>'Deleted...',	
							));
					exit;
				}
			
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

	}
	protected function performAjaxValidation( $model , $form)
	{
		if ( isset ( $_POST['ajax'] ) && $_POST['ajax']===$form )
		{
			echo CActiveForm::validate( $model );
			Yii::app()->end();
		}
	}
	
	public function actionMakePdf()
	{
		
	$mPDF1 = Yii::app()->ePdf->mpdf();
 
        // You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
 
        // render (full page)
       
 
        // Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
        $mPDF1->WriteHTML($stylesheet, 1);
 
        // renderPartial (only 'view' of current controller)
 
        // Renders image
        $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.png' ));
 
        // Outputs ready PDF
       return  $mPDF1;


	}
}