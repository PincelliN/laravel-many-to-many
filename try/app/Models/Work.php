<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    public function  type(){
        return $this->belongsTo(Type::class);
    }
    protected $fillable=[
        'title',
        'type_id',
        'slug',
        'subject',
        'start_date',
        'end_date',
        'post',
        'collaborators',
        'description',

    ];

}