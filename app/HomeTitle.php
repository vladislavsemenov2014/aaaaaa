<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeTitle extends Model
{
    protected $table = 'title';
    protected $fillable = ['id', 'hometitle', 'kichen'];
}
