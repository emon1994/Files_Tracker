<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'code',
        'country',
        'receiver',
        'status',
        'note',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function fileDetails()
    {
        return $this->hasMany(FileDetail::class);
    }

  
}
