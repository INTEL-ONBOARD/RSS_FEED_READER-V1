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



        // echo "<p>date:". $item->get_date() . "</p><br>";
        // echo "<p>Title: " . $item->get_title() . "</p>";
        // echo "<p>link:". $item->get_link() . "</p>";
        // echo "<p>Description:". $item->get_description() . "</p>";
        // echo "<p>Category:". $item->get_category(). "</p>";
        // echo "<p>guid:". $item->get_id(). "</p>";



        // //$response = Http::get($rssUrl);
        // $response = file_get_contents($rssUrl);
        // dd($response);
        // // $xml = simplexml_load_string($response);
        // // //dd($xml);
        // // foreach ($xml->channel->item as $item) {
        // //     echo "<p>Title: " . (string) $item->title . "</p>";
        // //     echo "<p>Link: " . (string) $item->link . "</p>";
        // //     echo "<p>Description: " . (string) $item->description . "</p>";
        // //     echo "<br>";
        // // }