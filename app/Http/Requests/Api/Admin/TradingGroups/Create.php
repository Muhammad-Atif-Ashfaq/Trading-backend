<?php

namespace App\Http\Requests\Api\Admin\TradingGroups;

use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
{
    use ResponseTrait; // TODO: Using the ResponseTrait for sending responses

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'mass_leverage' => 'nullable|string',
            'mass_swap' => 'nullable|string',
            'symbel_group_ids' => ['nullable', 'array'],
            'symbel_group_ids.*' => ['exists:symbel_groups,id'],
            'trading_account_ids' => ['nullable', 'array'],
            'trading_account_ids.*' => ['exists:trading_accounts,id']
        ];
    }
}
