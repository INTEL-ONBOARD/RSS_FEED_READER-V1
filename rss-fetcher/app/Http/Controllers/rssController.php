<?php

namespace App\Http\Controllers;

use App\Models\rss_job;
use Illuminate\Http\Request;
use SimplePie\SimplePie;


class rssController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function post_rssJobData(Request $request)
    {
        $feed = new SimplePie();
        $feed->set_feed_url($request->url);
        $feed->enable_cache(false);
        $feed->set_output_encoding('utf-8');

        if (!$feed->init()) {
                try{
                    $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n")); 
                    $context = stream_context_create($opts);
                    $response = file_get_contents($request->url, false, $context);
                    $feed = new SimplePie();
                    $feed->set_raw_data($response);
                    $feed->init();
                }catch(\Exception $e){
                    return redirect()->route('get.home')->with('error','Error fetching XML content. Please try again later. '.$e->getMessage());
                }

        }
        try{
            foreach ($feed->get_items() as $item) {
                $params=[
                    'title'=>(string)$item->get_title() ,
                    'date'=> (string)$item->get_date() ,
                    'link'=> (string)$item->get_link(),
                    'description'=> (string)$item->get_description(),
                    'guid'=> (string)$item->get_id(),
                ];
                if ($item->get_author() ? $params['author'] = (string)$item->get_author()->get_name():$params['author']= null);
                if ($item->get_category() ? $params['category'] = (string)$item->get_category()->get_label():$params['category']= null);
                rss_job::create($params);
            }
            
            return redirect()->route('get.home')->with('success', 'RSS feed fetched and stored successfully.'. sizeof( $feed->get_items()).' items stored!');
        }catch (\Exception $e){
            return redirect()->route('get.home')->with('error','Error fetching XML content. Please try again later. '.$e->getMessage());
        }

    }
}





// if ($feed->init()) {
//     foreach ($feed->get_items() as $item) {
//         $params=[
//             'title'=>(string)$item->get_title() ,
//             'date'=> (string)$item->get_date() ,
//             'link'=> (string)$item->get_link(),
//             'description'=> (string)$item->get_description(),
//             'guid'=> (string)$item->get_id(),
//         ];
//         if ($item->get_author() ? $params['author'] = (string)$item->get_author()->get_name():$params['author']= null);
//         if ($item->get_category() ? $params['category'] = (string)$item->get_category()->get_label():$params['category']= null);
//         rss_job::create($params);
//     }
//     return redirect()->route('get.home')->with('success', 'RSS feed fetched and stored successfully.');
// } else {
//     // Failed to fetch XML content
//     return redirect()->route('get.home')->with('error', 'Error fetching XML content. Please try again later.');
// }
// // return redirect()->route('get.home')->with('error', $e->getMessage());