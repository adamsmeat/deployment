<?php

Route::post(Config::get('deployment::route').'/{required_branch?}', 'Adamsmeat\Deployment\Controller@postDeploy');
Route::get(Config::get('deployment::route').'/{required_branch?}', 'Adamsmeat\Deployment\Controller@getDeploy');
Route::get(Config::get('deployment::composer_update_route').'/{composer_options?}', 'Adamsmeat\Deployment\Controller@getComposerUpdate');

