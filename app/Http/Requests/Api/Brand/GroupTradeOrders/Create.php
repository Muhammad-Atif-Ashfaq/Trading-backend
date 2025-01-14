<?php

namespace App\Http\Requests\Api\Brand\GroupTradeOrders;

use App\Enums\OrderTypeEnum;
use App\Enums\TradeOrderTypeEnum;
use App\Models\TradingAccount;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class Create extends FormRequest
{
    use ResponseTrait;

    // TODO: Using the ResponseTrait for sending responses

    public function rules(): array
    {
        return [
            'order_type' => ['required', 'in:' . implode(',', OrderTypeEnum::getOrderTypes())],
            'symbol' => 'required|exists:symbel_settings,feed_fetch_name',
            'feed_name' => 'string|exists:data_feeds,module',
            'trading_group_id' => 'required|exists:trading_groups,id',
            'type' => 'required|in:' . implode(',', TradeOrderTypeEnum::getTypes()),
            'volume' => 'required|string',
            'stopLoss' => 'nullable|string',
            'takeProfit' => 'nullable|string',
            'open_time' => 'required|string',
            'open_price' => 'required|string',
            'close_time' => 'nullable|string',
            'close_price' => 'nullable|string',
            'reason' => 'nullable|string',
            'swap' => 'nullable|string',
            'profit' => 'nullable|string',
            'comment' => 'nullable|string',
            'skip' => 'nullable|boolean'
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $validator->getData();
            $skipAccounts = $data['skip'] ?? false;

            // Get accounts with low balance
            $lowBalanceAccounts = TradingAccount::where('trading_group_id', $data['trading_group_id'])
                ->where('balance', '<=', 0)
                ->pluck('login_id')
                ->toArray();

            // Get accounts with low margin level percentage
            $lowMarginAccounts = TradingAccount::where('trading_group_id', $data['trading_group_id'])
                ->whereHas('brand', function ($q) {
                    $q->whereColumn('brands.stop_out', '>', 'trading_accounts.margin_level_percentage');
                })
                ->pluck('login_id')
                ->toArray();

            // Check if there are any accounts with low balance or low margin level percentage
            if (count($lowBalanceAccounts) || count($lowMarginAccounts)) {
                if (!$skipAccounts) {
                    $errorMessage = '';

                    if (count($lowBalanceAccounts)) {
                        $errorMessage .= '<strong>Low Balance Accounts:</strong> <br/>' . implode(', ', $lowBalanceAccounts) . '<br>';
                    }

                    if (count($lowMarginAccounts)) {
                        $errorMessage .= '<strong>Low Margin Level Percentage Accounts:</strong> <br/>' . implode(', ', $lowMarginAccounts) . '<br>';
                    }

                    $validator->errors()->add('balance', $errorMessage);
                }
            }
        });
    }
}