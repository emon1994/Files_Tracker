<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileDetail extends Model
{
    use HasFactory;
    protected $fillable = ['filename', 'file_path'];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
