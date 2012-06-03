<?php

class SearchShare extends CWidget {

    /**
     * Publishes the required assets
     */
    public function init() {
        parent::init();
		$this -> publishAssets();

    }

    public function run() {
		$assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app() -> assetManager -> publish($assets);
        $this->render("SearchShare",array('baseUrl'=>$baseUrl
		));
    }

    /**
     * Publises and registers the required CSS and Javascript
     * @throws CHttpException if the assets folder was not found
     */

    public function publishAssets() {
        $assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app() -> assetManager -> publish($assets);
        if (is_dir($assets)) {
            //the css to use
           Yii::app() -> clientScript -> registerCssFile($baseUrl . '/css/searchandshare.css');
			// the js to use
Yii::app() -> clientScript -> registerScriptFile($baseUrl . '/js/searchandshare.min.js', CClientScript::POS_END);
        } else {
            throw new CHttpException(500, __CLASS__ . ' - Error: Couldn\'t find assets to publish.');
        }
    }

}
