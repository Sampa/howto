<?php

class UserButton extends CWidget {
	public $id;
	public $userid;
	public $username;
	public $reputation;
    public $profileLink = true;
	/**
     * Publishes the required assets
     */
    public function init() {
        parent::init();
    }

    public function run() {
	
        $this->render("UserButton",array(
			'id'=>$this->id,
			'userid'=>$this->userid,
			'username'=>$this->username,
			'reputation'=>$this->reputation,
			'profileLink'=>$this->profileLink,
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
         //   Yii::app() -> clientScript -> registerCssFile($baseUrl . '/css/google_search.css');
			/* the js to use
			U must edit one line in it to work with your URL*/
           // Yii::app() -> clientScript -> registerScriptFile($baseUrl . '/js/google_search.js', CClientScript::POS_END);
   
        } else {
            throw new CHttpException(500, __CLASS__ . ' - Error: Couldn\'t find assets to publish.');
        }
    }

}
