<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Klinik Management System',

	// preloading 'log' component
	'preload' => array('log'),

	// autoloading model and component classes
	'import' => array(
		'application.models.*',
		'application.components.*',
		'application.controllers.*',
	),

	'modules' => array(
		// Gii tool for development
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin123',
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
				'bootstrap.gii', // since we're using bootstrap
			),
		),
	),

	// applicatio components
	'components' => array(

		'user' => array(
			'allowAutoLogin' => true,
		),

		// URL Management
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false, 
			'baseUrl' => '/klinik',  
			'rules'=>array(
				'' => 'site/index',
				'login' => 'site/login',
				'logout' => 'site/logout',
				'<controller:\w+>'=>'<controller>/index',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		// database settings are configured in database.php
		'db' => require(dirname(__FILE__) . '/database.php'),

		'errorHandler' => array(
			'errorAction' => YII_DEBUG ? null : 'site/error',
		),

		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

		'authManager' => array(
			'class' => 'CDbAuthManager',
			'connectionID' => 'db',
			'itemTable' => 'auth_item',
			'itemChildTable' => 'auth_item_child',
			'assignmentTable' => 'auth_assignment',
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => array(
		// this is used in contact page
		'adminEmail' => 'webmaster@example.com',
	),
);
