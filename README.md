# Adamsmeat/Deployment, git auto-deploy made easy

Allows you to auto-deploy through git's POST hook a git branch that is assigned to an enviroment(edit Config::get('deployment.map')) or any branch by using route parameters. (e.g. deploy/{branch})

Most likely scenario is that you have a master branch in production, which is updated by git pull

#### Assumptions

- The server you are posting to has git and assigned a valid SSH key for transaction with your Git provider.
- Your Git provider has POST hook properly setup.
- Apache user has git permission

#### Installation

- require "adamsmeat/deployment": "dev-master"
- In L4, register 'Adamsmeat\Deployment\DeploymentServiceProvider' as a provider in your app config
- Edit configuration file created through 'php artisan config:publish adamsmeat/deployment'

#### Usage

##### POST

In your git provider's panel, go to the main repo for your Laravel 4 project. Add a POST service which is
just your git provider, generating a POST request to a specified url. By default, it is 'http://yourdomain.com/deploy'

##### GET

You yourself can initiate a git pull. Just do a GET request to the same route as in POST service.

Naturally, you want an endpoint(production), to have the master branch and so your Git POST service handles that
But just in case you want to use a different git branch on another endpoint, that is also handled by a POST service,
Then configure 'deployment::map' value to specify which branch should be checked out 

On the ply, you can have a different git branch deployed(checked out) by going to http://yourdomain.com/deploy/{branchname}

#### Added features

1. Block client IPs who can do a GET request, By default, 127.0.0.1 is allowed
2. Block who can do post service to mitigate abuse. By default, Bitbucket is allowed

## Config Notes

It is advised that you use your own config: php artisan config:publish adamsmeat/deployment

- 'deployment::route' specifies the route used and must correspond to what was set in your git provider's POST service.
- 'deployment::allowed_client_ips' limits who can do GET request.
- 'deployment::allowed_provider_ips' limits who can do git POST service.
- 'deployment::map' use this to auto checkout a git branch based on environment.