<?php

use App\Api\Controller\LanguageController;
use App\Api\Controller\NotificationGatewayController;
use App\Api\Controller\NotificationTriggerController;
use App\Api\Controller\SetupController;
use App\Api\Controller\StatisticController;
use App\Api\Controller\UserController;
use App\Api\Controller\VaultController;
use Illuminate\Support\Facades\Route;

Route::name('language.')->prefix('language')->group(function () {
	Route::get('/', [LanguageController::class, 'languageList'])
		->name('list');
	Route::get('{iso}', [LanguageController::class, 'languageIso'])
		->name('iso');
});

Route::post('setup', [SetupController::class, 'setup'])
	->name('setup');
Route::get('statistics', [StatisticController::class, 'getStatistics'])
	->name('statistics');

Route::middleware(['webapp_auth'])->group(function () {
	/**
	 * user routes
	 */
	Route::name('user.')->prefix('user')->group(function () {
		Route::get('/', [UserController::class, 'getUser'])
			->name('get');
		Route::delete('/', [UserController::class, 'deleteUser'])
			->middleware('uneditable_demo')
			->name('delete');
	});

	/**
	 * vault routes
	 */
	Route::name('vault.')->prefix('user/vault')->group(function () {
		Route::post('/', [VaultController::class, 'createUserVault'])
			->middleware('uneditable_demo')
			->name('create');
		Route::put('{vault}', [VaultController::class, 'updateUserVaultName'])
			->middleware('uneditable_demo')
			->name('create');
		Route::delete('/', [VaultController::class, 'deleteUserVault'])
			->middleware('uneditable_demo')
			->name('delete');
	});

	/**
	 * notification gateway routes
	 */
	Route::name('notification_gateway.')->prefix('user/gateways')->group(function () {
		Route::get('/', [NotificationGatewayController::class, 'getGateways'])
			->name('get');
		Route::post('/', [NotificationGatewayController::class, 'createGateway'])
			->middleware('uneditable_demo')
			->name('create');
		Route::post('test', [NotificationGatewayController::class, 'testGateway'])
			->middleware('uneditable_demo')
			->name('test');
		Route::delete('/', [NotificationGatewayController::class, 'deleteGateway'])
			->middleware('uneditable_demo')
			->name('delete');
	});

	/**
	 * notification trigger routes
	 */
	Route::name('notification_trigger.')->prefix('user/notification')->group(function () {
		Route::get('/', [NotificationTriggerController::class, 'getTrigger'])
			->name('get');
		Route::post('/', [NotificationTriggerController::class, 'createTrigger'])
			->middleware('uneditable_demo')
			->name('create');
		Route::put('/', [NotificationTriggerController::class, 'updateTrigger'])
			->middleware('uneditable_demo')
			->name('update');
		Route::delete('/', [NotificationTriggerController::class, 'deleteTrigger'])
			->middleware('uneditable_demo')
			->name('delete');
	});
});
