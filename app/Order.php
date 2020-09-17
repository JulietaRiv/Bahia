<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use FullTextSearch;
    
    protected $table = 'orders';

    protected $casts = [
        'items' => 'array'
    ];

    protected $searchable = [
        'name',
        'cel',
        'address',
        'comment',
    ];

}
