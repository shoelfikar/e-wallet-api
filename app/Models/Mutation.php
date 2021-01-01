<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amuont',
        'status',
        'type',
        'saldo',
        'transaction_id',
        'keterangan'
    ];


    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
