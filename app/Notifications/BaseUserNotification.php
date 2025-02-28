<?php

namespace App\Notifications;

use App\Channel\WebhookChannel;
use App\Enum\CooldownTypes;
use App\Enum\NotificationGatewayType;
use App\Models\User;
use App\Models\Vault;

class BaseUserNotification extends BaseNotification
{
	public function __construct(protected Vault $vault)
	{
		parent::__construct();
	}

	public function via(User $user): array
	{
		$methods = [];
		if ($user->hasGateway(NotificationGatewayType::TELEGRAM)
			&& $user->cooldown($this->cooldownIdentifier(CooldownTypes::TELEGRAM_NOTIFICATION))->passed()) {
			$methods[] = NotificationGatewayType::TELEGRAM;
		}
		if ($user->hasGateway(NotificationGatewayType::WEBHOOK)) {
			$methods[] = WebhookChannel::class;
		}
		if ($user->hasGateway(NotificationGatewayType::MAIL)
			&& $user->cooldown($this->cooldownIdentifier(CooldownTypes::MAIL_NOTIFICATION))->passed()) {
			$methods[] = NotificationGatewayType::MAIL;
		}

		return $methods;
	}

	protected function cooldownIdentifier(string $type): string
	{
		return sprintf('%s_%s_%s', get_class($this), $this->vault->vaultId, $type);
	}
}
