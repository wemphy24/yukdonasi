<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fundraising extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'fundraiser_id',  
      'category_id',  
      'is_active',  
      'has_finished',  
      'name',  
      'slug', 
      'thumbnail',  
      'about',  
      'target_amount',  
    ];

    public function category()
    {
      return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function fundraiser()
    {
      return $this->belongsTo('App\Models\Fundraiser', 'fundraiser_id', 'id');
    }

    public function donaturs()
    {
      return $this->hasMany('App\Models\Donatur', 'fundraising_id')->where('is_paid', 1);
    }

    public function totalReachedAmount()
    {
      return $this->donaturs()->sum('total_amount');
    }

    public function fundraising_withdrawals()
    {
      return $this->hasMany('App\Models\FundraisingWithdrawal', 'fundraising_id');
    }
}
