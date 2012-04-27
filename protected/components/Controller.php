<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
	public $clip = "system.web.widgets.CClipWidget";
	protected function afterRender($view, &$output)
{
    parent::afterRender($view,$output);
    //Yii::app()->facebook->addJsCallback($js); // use this if you are registering any $js code you want to run asyc
    Yii::app()->facebook->initJs($output); // this initializes the Facebook JS SDK on all pages
    Yii::app()->facebook->renderOGMetaTags(); // this renders the OG tags
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