<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnBook extends Model
{
    use HasFactory;
    protected $table = 'return_books';


    protected $fillable = [
        'issue_id',
        'returned_at',
    ];
}
