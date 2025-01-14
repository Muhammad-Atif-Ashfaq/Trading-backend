<?php

namespace App\Http\Requests\Api\Brand\TransactionOrders;

use App\Rules\BrandBelongsToTradingAccount;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class Index extends FormRequest
{
    use ResponseTrait;

    public function rules(): array
    {
        return [
            'trading_account_id' => 'nullable|exists:trading_accounts,id',
            'per_page' => 'nullable',
            'page' => 'nullable',
            'brand_id' => ['required', 'exists:brands,public_key', new BrandBelongsToTradingAccount($this->input('trading_account_id'), 'id')],
        ];
    }
}
