<?php

return array(
	/*
	|--------------------------------------------------------------------------
	| Deployment route
	|--------------------------------------------------------------------------
	|
	| Specifies under which route the post hook calls/visit every git push.
	| Having no params mean that git will use main branch? (master)
	|
	*/
	'route' => 'deploy',

	/*
	|--------------------------------------------------------------------------
	| Environment-to-Branch mapping
	|--------------------------------------------------------------------------
	|
	| Forces a certain environment to auto checkout a branch
	| when a pair is declared here
	|
	*/
	'map' => array(
		// uncomment below if you have a 'stage' environment that requires the git 'dev' branch to be checked out
		//'stage' => 'dev'
	),
);