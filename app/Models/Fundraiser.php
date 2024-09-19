<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fundraiser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'user_id',  
      'is_active',  
    ];

    public function user()
    {
      return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function fundraisings()
    {
      return $this->hasMany('App\Models\Fundraising', 'fundraiser_id');
    }

    public function fundraising_withdrawals()
    {
      return $this->hasMany('App\Models\FundraisingWithdrawal', 'fundraiser_id');
    }
}
