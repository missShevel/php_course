<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $table = 'issues';


    protected $fillable = [
        'book_id',
        'reader_id',
        'issued_at'
    ];
}
