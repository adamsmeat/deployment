# Git Auto Deploy

Allows you to auto-deploy through git's POST hook a git branch that is assigned to an enviroment(edit Config::get('deployment.map')) or any branch by using route parameters. (e.g. deploy/{branch})


## Assumptions

- The server you are posting to has git and assigned a valid SSH key for transaction with your Git provider.
- Your Git provider has POST hook properly setup.
- Apache user has git permission

## Installation

- require "adamsmeat/deployment": "dev-master"
- In L4, register 'Adamsmeat\Deployment\DeploymentServiceProvider' as a provider in your app config
- Edit configuration file created through 'php artisan config:publish adamsmeat/deployment'

## Usage

This is primarily for HTTP POST transaction but you also navigate the configured deploy route in your browser

This will strictly checkout the branch assigned to the current environment if one is assigned.

You can force checking out a branch by appending the branch in url. e.g. your deploy route is /deploy, then to force checkout a 'test1' branch, just visit /deploy/test1

## Config Notes

- 'deployment::route' specifies the url to use for post hook.
- 'deployment::map' is an array which specifies that the key(environment) will auto check out the corresponding value(git branch).