<?php

namespace App\Console\Commands;

use App\Enums\OrderTypeEnum;
use App\Enums\TradingAccountStatusEnum;
use App\Enums\TransactionOrderTypeEnum;
use App\Models\TradeOrder;
use App\Models\TradingAccount;
use Illuminate\Console\Command;

class CheckMarginLevels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'margin:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $accounts = TradingAccount::all();
        foreach ($accounts as $account) {
            if ($account->margin_level_percentage < $account->brand->margin_call) {
                $account->status = TradingAccountStatusEnum::MARGIN_CALL;
                $account->save();
                pushLiveDate('trading_accounts','update',$account);
            }
        }
    }

}
