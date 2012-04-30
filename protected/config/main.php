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
		'application.extensions.debugtoolbar.*',
		'ext.xupload.models.XUploadForm',
	
	),

	'aliases' => array(
    //assuming you extracted the files to the extensions folder
    'xupload' => 'ext.xupload'
),
	// application modules
	'modules'=>array(
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
			'generatorPaths'=>array('ext.bootrap.gii.templates.default',),
		),
    ),

	// application components
	'components'=>array(
		'user'=>array(
			'class'=>'RWebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
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
		'facebook'=>array(
		'class' => 'ext.yii-facebook-opengraph.SFacebook',
		'appId'=>'324349220969408', // needed for JS SDK, Social Plugins and PHP SDK
		'secret'=>'5178fb0ce11cdf64f2e18184f1146ad6', // needed for the PHP SDK 
		//'locale'=>'en_US', // override locale setting (defaults to en_US)
		//'jsSdk'=>true, // don't include JS SDK
		//'async'=>true, // load JS SDK asynchronously
		//'jsCallback'=>false, // declare if you are going to be inserting any JS callbacks to the async JS SDK loader
		//'status'=>true, // JS SDK - check login status
		//'cookie'=>true, // JS SDK - enable cookies to allow the server to access the session
		//'oauth'=>true,  // JS SDK -enable OAuth 2.0
		//'xfbml'=>true,  // JS SDK - parse XFBML / html5 Social Plugins
		//'html5'=>true,  // use html5 Social Plugins instead of XFBML
		//'ogTags'=>array(  // set default OG tags
			//'title'=>'MY_WEBSITE_NAME',
			//'description'=>'MY_WEBSITE_DESCRIPTION',
			//'image'=>'URL_TO_WEBSITE_LOGO',
		//),
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
        		'tag/<tag:.*?>'=>'howto/index',
        		'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'profile/*'=>'user/view',
				'howto/<show:.*?>'=>'howto/index/',
				'viewpdf/*'=>'howto/viewpdf',
				'categories'=>'category/index',
				'register'=>'user/register',


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
				array(
					'class'=>'XWebDebugRouter',
					'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
					'levels'=>'error, warning, trace, profile, info',
					'allowedIPs'=>array('127.0.0.1'),
				),
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