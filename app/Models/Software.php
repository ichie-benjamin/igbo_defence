<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class Software extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','software_id'
    ];

    public function licenses(): HasMany
    {
        return $this->hasMany(Site::class,'software_id');
    }


}
