<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundraisingWithdrawal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'fundraising_id',
      'fundraiser_id',
      'has_received',
      'has_set',
      'amount_requested',
      'amount_received',
      'bank_name',
      'bank_account_name',
      'bank_account_number',
      'proof',
    ];

    public function fundraising()
    {
      return $this->belongsTo('App\Models\Fundraising', 'fundraising_id', 'id');
    }

    public function fundraiser()
    {
      return $this->belongsTo('App\Models\Fundraiser', 'fundraiser_id', 'id');
    }
}
