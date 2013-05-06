<?php

Route::post(Config::get('deployment::route').'/{required_branch?}', 'Adamsmeat\Deployment\Controller@postDeploy');
Route::get(Config::get('deployment::route').'/{required_branch?}', 'Adamsmeat\Deployment\Controller@getDeploy');
Route::get(Config::get('deployment::composer_update_route').'/{required_branch?}', function($composer_options = null){

	$allowed_client_ips = Config::get('deployment::allowed_client_ips');

	if (! is_null($allowed_client_ips)) {

		// GET requests disabled
		if ($allowed_client_ips === false) 
			return Response::make('GET requests are not allowed', 403);


		// IP filtered
		elseif (! in_array(Request::getClientIp(), $allowed_client_ips))
			return Response::make('Your IP address: '.Request::getClientIp().' is not allowed', 403);			
	}

	chdir(base_path());
	$command = 'php54 '.__DIR__.'/composer.phar update '.($composer_options ? ' '.$composer_options : '');
	$tmp = shell_exec($command);
	// Output
	$output = '<span class="green">$</span> <span class="blue">'.$command.'</span><br/>';
	if($tmp) $output = '<pre class="bg-black">'.htmlentities(trim($tmp)) . "</pre>";

	return View::make('deployment::deploy', compact('output'));	

});
