<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/** @mixin \App\Models\Statistic */
class StatisticResource extends JsonResource
{
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'date'           => $this->date,
			'user_count'     => $this->user_count,
			'vault_count'    => $this->vault_count,
			'messages'       => [
				'sum_messages' => $this->sum_telegram_messages + $this->sum_mail_messages + $this->sum_webhook_messages,
				'types'        => [
					'info'    => $this->sum_info_notifications,
					'warning' => $this->sum_warning_notifications,
					'daily'   => $this->sum_daily_messages,
				],
				'gateways'     => [
					'telegram' => $this->sum_telegram_messages,
					'mail'     => $this->sum_mail_messages,
					'webhook'  => $this->sum_webhook_messages,
				],
			],
			'sum_collateral' => $this->sum_collateral,
			'sum_loan'       => $this->sum_loan,
			'avg_ratio'      => $this->avg_ratio,
		];
	}
}
