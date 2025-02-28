<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin \Eloquent
 * @property NotificationTrigger trigger
 * @property int                 id
 * @property User                user
 * @property string              userId
 * @property string              type
 * @property string              value
 */
class NotificationGateway extends Model
{
	public $timestamps = false;
	protected $fillable = [
		'userId',
		'type',
		'value',
	];
	protected $hidden = [
		'userId',
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class, 'userId', 'id');
	}

	public function triggers(): BelongsToMany
	{
		return $this->belongsToMany(NotificationTrigger::class, 'notification_gateway_trigger', 'gatewayId', 'triggerId');
	}
}
