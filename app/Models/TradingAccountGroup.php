<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingAccountGroup extends Model
{
    use HasFactory;
    protected $fillable = ['trading_group_id', 'trading_account_id'];
}