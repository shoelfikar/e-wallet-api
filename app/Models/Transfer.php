<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'amuont',
        'type',
        'transfer_id',
        'received_id'
    ];
}
