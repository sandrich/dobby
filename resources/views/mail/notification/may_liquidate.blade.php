@component('mail::message')
# {{ __('notifications/mail/may_liquidate.greeting') }}
{{ __('notifications/mail/may_liquidate.message', [
	'vault_id'       => str_truncate_middle($vault->vaultId, 15, '...'),
    'vault_deeplink' => sprintf(config('links.vault_info_deeplink'), $vault->vaultId),
    'ratio' => $vault->collateralRatio,
]) }}

@component('mail::table')
    | {{ __('notifications/mail/general.table.vault_id') }} | {{ __('notifications/mail/general.table.current_ratio') }} | {{ __('notifications/mail/general.table.collateral_value') }} | {{ __('notifications/mail/general.table.loan_value') }} |
    | ------------- |:-------------:| :----------------: | :--------: |
    | {{ str_truncate_middle($vault->vaultId, 15) }} | {{ $vault->collateralRatio }} % |{{ round($vault->collateralValue, 2) }} USD | {{ round($vault->loanValue, 2) }} USD |
@endcomponent

{{ __('notifications/mail/warning.message_difference', [
	'ratio' => 300,
	'difference' => app(\App\Models\Service\VaultService::class)->calculateCollateralDifference($vault, 300),
]) }}

@component('mail::button', ['url' => sprintf(config('links.vault_info_deeplink'), $vault->vaultId)])
{{ __('notifications/mail/general.button_title') }}
@endcomponent

{{ __('notifications/mail/general.thank_you') }}

{{ __('notifications/mail/general.regards') }}<br>
{{ config('app.name') }}
@endcomponent
