<?php

// going to deploy/dev will checkout the dev branch
$git_deploy_closure = function($branch = null)
{
	// commands
	$shell_commands = array(
		'echo $PWD',
		'whoami',
		'git pull',
		'git submodule sync',
		'git submodule update',
		'git submodule status',
	);


	// checkout a branch based on current environment
	$map = Config::get('deployment::map');
	if (!empty($map)) 
	{
		foreach ($map as $env => $mapped_branch)
		{
			if (App::environment() == $env) array_push($shell_commands, 'git checkout '.$mapped_branch);
		}
	}


	// force checkout desired branch, limited on master and dev only
	if ($branch === 'master' || $branch === 'dev') array_push($shell_commands, 'git checkout '.$branch);

	// makes sure last command is git status
	array_push($shell_commands, 'git status');

	// Run the commands for output
	$output = '';

	foreach($shell_commands AS $command)
	{
		// Run it
		$tmp = shell_exec($command);
		// Output
		$output .= '<span class="green">$</span> <span class="blue">'.$command.'</span><br/>';
		if($tmp) $output .= '<pre class="bg-black">'.htmlentities(trim($tmp)) . "</pre>";
	}

	return $output;
};

Route::post(Config::get('deployment::route').'/{branch?}', $git_deploy_closure);

Route::get(Config::get('deployment::route').'/{branch?}', function($branch = null) use($git_deploy_closure)
{
	$output = $git_deploy_closure($branch);
	return View::make('deployment::deploy', compact('output'));
});

