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

        if ($feed->init()) {
            foreach ($feed->get_items() as $item) {
                rss_job::create([
                    'title'=>(string)$item->get_title() ,
                    'date'=> (string)$item->get_date() ,
                    'link'=> (string)$item->get_link(),
                    'author'=> (string)$item->get_author(),
                    'description'=> (string)$item->get_description(),
                    'category'=> (string)$item->get_category(),
                    'guid'=> (string)$item->get_id(),
                ]);
            }
            return redirect()->route('get.home')->with('success', 'RSS feed fetched and stored successfully.');
        } else {

            try {
                $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n")); 
                $context = stream_context_create($opts);
                $response = file_get_contents($request->url, false, $context);
            
                if ($response !== false) {

                    error_log($response);
            

                    $xml = @simplexml_load_string($response);
            
                    if ($xml !== false) {
                        foreach ($xml->channel->item as $item) {
                            rss_job::create([
                                'title'=> $item->get_title ,
                                'date'=> (string)$item->get_date,
                                'link'=> (string)$item->get_link,
                                'author'=> (string)$item->get_author,
                                'description'=> (string)$item->get_description,
                                'category'=> (string)$item->get_category,
                                'guid'=>(strlen((string)$item->get_id) > 1500) ? null : (string)$item->get_id,
                            ]);
                        }
                        return redirect()->route('get.home')->with('success', 'RSS feed fetched and stored successfully.');
                    } else {
                        // Failed to parse XML content
                        return redirect()->route('get.home')->with('error', 'Error parsing XML content. Please try again later.');
                    }
                } else {
                    // Failed to fetch XML content
                    return redirect()->route('get.home')->with('error', 'Error fetching XML content. Please try again later.');
                }
            } catch (\Exception $e) {

                return redirect()->route('get.home')->with('error', $e->getMessage());
            }
            

            // // try{

            //     $opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n")); 
            //     $context = stream_context_create($opts);
            //     $response = file_get_contents($request->url, false, $context);
            //     if ($response != false) {
            //         // $response = file_get_contents($request->url);
            //         $xml = simplexml_load_string($response);
            //         // dd($xml);
            //         foreach ($xml->channel->item as $item) {
            //             rss_job::create([
            //                 'title'=> $item->get_title ,
            //                 'date'=> (string)$item->get_date,
            //                 'link'=> (string)$item->get_link,
            //                 'author'=> (string)$item->get_author,
            //                 'description'=> (string)$item->get_description,
            //                 'category'=> (string)$item->get_category,
            //                 'guid'=>(strlen((string)$item->get_id) > 1500) ? null : (string)$item->get_id,
            //             ]);
            //         }
            //         return redirect()->route('get.home')->with('success', 'RSS feed fetched and stored successfully.');
            //         // $feed->error()
                    
            //     }else{
            //         return redirect()->route('get.home')->with('error', 'Error initializing feed. Please try again later.');
            //     }
            // // } catch (\Exception $e) {
            // //     return redirect()->route('get.home')->with('error',$e->getMessage());
            // // }
        }
    }
}
