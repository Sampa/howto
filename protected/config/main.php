<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Howto',

	// preloading 'log' component
	'preload'=>array(
		'log',
		'bootstrap', 
		),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.bootstrap.widgets.*',
		'application.modules.rights.*',
		'application.modules.rights.components.*',
		'ext.xupload.models.XUploadForm',
        'application.components.*',
		'application.modules.yiiauth.models.*',
		'application.modules.yiiauth.components.*',
		'application.extensions.jtogglecolumn.*', 
		'application.modules.badger.models.*',
		'application.modules.pcviewscounter.*',
        'application.modules.pcviewscounter.models.*',
        'application.modules.pcviewscounter.controllers.*',
        'application.modules.pcviewscounter.components.*',
        'application.modules.pcviewscounter.extensions.ViewsCountWidget.*',

	
	),

	'aliases' => array(
    //assuming you extracted the files to the extensions folder
    'xupload' => 'ext.xupload'
),
	// application modules
	'modules'=>array(
		'pcviewscounter' => array(
          'class' => 'application.modules.pcviewscounter.pcviewscounterModule'
		  ),
		'badger' => array(
		  'layout' => '//layouts/main', //default: "//layouts/main"
		  //'userTable' => 'userx', // default: "user"
		  'cacheSec' => 3600 * 24, // cache duration. default: 3600

		  // Creates tables and copy necessary files
		  //'install' => true, // remove/comment after succesful install
		   // drop all badger tables before installing (fresh install)
		  'dropBeforeInstall' => false, 
            ),
		'yiiauth'=>array(
		'userClass'=>'User',
		'config'=>array(
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
				"display" => "page" 
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
	),
		),

		'message' => array(
            'userModel' => 'User',
            'getNameMethod' => 'getFullName',
            'getSuggestMethod' => 'getSuggest',
			'viewPath' => '//messageModuleCustom',
        ),
		'rights'=>array(
			'debug'=>true,
			//'install'=>true,
			'enableBizRuleData'=>true,
		),
	
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		'generatorPaths' => array(
                'ext.bootstrap.gii',
				'application.gii',  //Ajax Crud template path
				'ext.giiplus', 
				),
			),
		),

	// application components
	'components'=>array(
	'cache'=>array(
'class'=>'CDbCache',		
		),
	'geoip' => array(
		'class' => 'ext.PcMaxmindGeoIp.PcMaxmindGeoIp',
	),
	'file'=>array(
        'class'=>'application.extensions.file.CFile',
    ),
		'user'=>array(
			'class'=>'RWebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'clientScript'=>array(
			'class'=>'ClientScript',
		),
		'bootstrap'=>array(
        'class'=>'ext.bootstrap.components.Bootstrap', // assuming you extracted bootstrap under extensions
        'coreCss'=>true, // whether to register the Bootstrap core CSS (bootstrap.min.css), defaults to true
        'responsiveCss'=>true, // whether to register the Bootstrap responsive CSS (bootstrap-responsive.min.css), default to false
        'plugins'=>array(
            // Optionally you can configure the "global" plugins (button, popover, tooltip and transition)
            // To prevent a plugin from being loaded set it to false as demonstrated below
            'transition'=>true, // disable CSS transitions
            'tooltip'=>array(
                'selector'=>'a.tooltip', // bind the plugin tooltip to anchor tags with the 'tooltip' class
                'options'=>array(
                    'placement'=>'bottom', // place the tooltips below instead
                ),
            ),
            
            // If you need help with configuring the plugins, please refer to Bootstrap's own documentation:
            // http://twitter.github.com/bootstrap/javascript.html
        ),
    ),
		
	
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=blog',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),
		'authManager'=>array(
            'class'=>'RDbAuthManager',
            'connectionID'=>'db',
            'itemTable'=>'tbl_authitem',
			'itemChildTable'=>'tbl_authitemchild',
			'assignmentTable'=>'tbl_authassignment',
			'rightsTable'=>'tbl_rights',
        ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'request'=>array(
			'enableCsrfValidation'=>false,
		),
        'urlManager'=>array(
        	'urlFormat'=>'path',
        	'rules'=>array(
				'page/<view:\w+>/*'=>'site/page',
				'contact'=>'site/contact',
				'about'=>'site/page/view/about',
        		'howto/<id:\d+>/<title:.*?>'=>'howto/view',
        		'tag/<tag:.*?>'=>'tag/view',
				'category/<cat:.*?>'=>'category/view',

        		'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'profile/*'=>'yiiauth/user/view',
				'update/*'=>'yiiauth/user/update',
				'user/search/*'=>'yiiauth/user/index',
				'howto/<show:.*?>'=>'howto/index/',
				'viewpdf/*'=>'howto/viewpdf',
				'categories'=>'category/index',
				'login'=>'/site/login',
				'register'=>'yiiauth/user/register',
				'sharing'=>'site/page/view/sharing',
				'reading'=>'site/page/view/reading',
				'creating'=>'site/page/view/creating',
				'dashboard'=>'dashboard/index',
		


				//'<controller:\w+>/<id:\d+>'=>'<controller>/view', 
					),
			'showScriptName'=>false,
			'caseSensitive'=>false, 
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// debug toolbar configuration
				
				// uncomment the following to show log messages on web pages
				
				array(
					'class'=>'CWebLogRoute',
				),
				
			),
		),
		'ePdf' => array(
        'class'         => 'ext.yii-pdf.EYiiPdf',
        'params'        => array(
            'mpdf'     => array(
                'librarySourcePath' => 'application.vendors.mpdf.*',
                'constants'         => array(
                    '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                ),
                'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
                'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                    'mode'              => '', //  This parameter specifies the mode of the new document.
                    'format'            => 'A4', // format A4, A5, ...
                    'default_font_size' => 12, // Sets the default document font size in points (pt)
                    'default_font'      => 'Georgia', // Sets the default font-family for the new document.
                    'mgl'               => 15, // margin_left. Sets the page margins for the new document.
                    'mgr'               => 15, // margin_right
                    'mgt'               => 16, // margin_top
                    'mgb'               => 16, // margin_bottom
                    'mgh'               => 9, // margin_header
                    'mgf'               => 9, // margin_footer
                    'orientation'       => 'P', // landscape or portrait orientation
                )
            ),
          
        ),
    ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);