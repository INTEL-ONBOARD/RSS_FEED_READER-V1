<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use SimplePie\SimplePie;

class rss_job extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'date',
        'link',
        'author',
        'description',
        'category',
        'guid',
    ];

}


