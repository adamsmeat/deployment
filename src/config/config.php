<?php

return array(

	// Specifies under which route the post hook calls/visit every git push.
	// Having no params mean that git will use main branch? (master)
	'route' => 'deploy',

	// This package allows you to call the hook by GET request and see output
	// in browser. Setting this to an ip address limits who can do GET request
	// Use null to allow all IP, false to disable GET
	'allowed_client_ips' => array('127.0.0.1'),

	// Limit git provider who can do post hook
	// Bitbucket uses 63.246.22.222
	'allowed_provider_ips' => array('63.246.22.222'),

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
		// below means for env: production, auto checkout master, for local, auto checkout dev
		//'production' => 'master',
		'local' => 'dev',
	),
);