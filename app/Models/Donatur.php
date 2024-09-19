<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donatur extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'name',  
      'phone_number',  
      'fundraising_id',  
      'total_amount',  
      'notes',  
      'is_paid',  
      'proof',  
    ];

    public function fundraising()
    {
      return $this->belongsTo('App\Models\Fundraising', 'fundraising_id', 'id');
    }
}
