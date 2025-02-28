<?php

namespace App\Notifications;

use App\Channel\WebhookChannel;
use App\Enum\CooldownTypes;
use App\Enum\NotificationGatewayType;
use App\Enum\QueueName;
use App\Models\NotificationTrigger;
use App\Models\Service\StatisticService;
use App\Models\User;
use App\Models\Vault;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use JetBrains\PhpStorm\ArrayShape;

class BaseNotification extends Notification
{
	protected StatisticService $statisticService;

	public function __construct()
	{
		$this->statisticService = app(StatisticService::class);
	}

	#[ArrayShape(['telegram' => "string", 'mail' => "string", WebhookChannel::class => "string"])]
	public function viaQueues(): array
	{
		return [
			'telegram'            => QueueName::NOTIFICATION_TELEGRAM_QUEUE,
			'mail'                => QueueName::NOTIFICATION_EMAIL_QUEUE,
			WebhookChannel::class => QueueName::NOTIFICATION_WEBHOOK_QUEUE,
		];
	}

	protected function snooze(User|NotificationTrigger $model, string $type, Carbon $until): void
	{
		$model->cooldown($type)->until($until);
	}
}
