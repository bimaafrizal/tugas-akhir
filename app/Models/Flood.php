<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flood extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    // protected $with = ['ews'];

    public function ews()
    {
        return $this->belongsTo(Ews::class, 'ews_id', 'id');
    }
}
