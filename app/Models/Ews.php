<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ews extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    // protected $with = ['flood'];

    public function flood()
    {
        return $this->hasMany(Flood::class);
    }
}
