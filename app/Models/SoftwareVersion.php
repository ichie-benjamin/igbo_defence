<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'software_id',
        'version',
        'file',
        'title',
        'description',
    ];
}
