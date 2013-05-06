<?php namespace Adamsmeat\Deployment;

use Config, View, App, BaseController, Response, Request;

class Controller extends BaseController {

	protected function deploy($required_branch = null)
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

		// skip if $required branch is specified
		if (is_null($required_branch)) {
			// checkout a branch based on current environment
			$map = Config::get('deployment::map');
			if (!empty($map)) 
			{
				foreach ($map as $env => $mapped_branch)
				{
					if (App::environment() == $env) array_push($shell_commands, 'git checkout '.$mapped_branch);
				}
			}
		}
		// force checkout desired branch
		else array_push($shell_commands, 'git checkout '.$required_branch);

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
	}

	protected function filterByClientIp()
	{
		$allowed_client_ips = Config::get('deployment::allowed_client_ips');

		if (! is_null($allowed_client_ips)) {

			// GET requests disabled
			if ($allowed_client_ips === false) 
				return Response::make('GET requests are not allowed', 403);


			// IP filtered
			elseif (! in_array(Request::getClientIp(), $allowed_client_ips))
				return Response::make('Your IP address: '.Request::getClientIp().' is not allowed', 403);			
		}
	}

	public function postDeploy($required_branch = null)
	{
		$output = $this->deploy($required_branch);
		return Response::make('Deployed successfully', 200);
	}

	public function getDeploy($required_branch = null)
	{
		$returned = $this->filterByClientIp();
		if ($returned) return $returned;

		$output = $this->deploy($required_branch);

		return View::make('deployment::deploy', compact('output'));	
	}


	public function getComposerUpdate($composer_options = null) 
	{

		$returned = $this->filterByClientIp();
		if ($returned) return $returned;

		chdir(base_path());
		$command = 'php54 '.__DIR__.'/composer.phar update '.($composer_options ? ' '.$composer_options : '');
		$tmp = shell_exec($command);
		// Output
		$output = '<span class="green">$</span> <span class="blue">'.$command.'</span><br/>';
		if($tmp) $output = '<pre class="bg-black">'.htmlentities(trim($tmp)) . "</pre>";

		return View::make('deployment::composer-update', compact('output'));	

	}

}