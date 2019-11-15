<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\WebCrawling;
use Carbon\Carbon;
use DB;
use DOMDocument;

use App\Tet;
use App\Email;
use App\Url;



class HomeController extends Controller
{


    public function Index(){

            return view('home');
    }


   public function RequestStatus(Request $request)
     {
        $inputUrl=$request->url; 
        $domain = parse_url($inputUrl)['host'];
        $response = ""; 

        if (filter_var($inputUrl, FILTER_VALIDATE_URL)) {
            $response = "Your request is being prccessed. Please wait...";
        }
        else { $response = "URL is not Valid"; }

        
        $url = Url::whereUrl($inputUrl)->first();
            if(!$url){
                $url = Url::create(['url'=>$inputUrl,'domain'=>$domain]);
            }


        return response()->json([
            'message'=>$response,
            'url'=>route('status',$domain),
        ],200);

     }

   
   public function Results(Request $request){
        $url = $request->url;
       
        return view('results',['url'=>$request->url]);
   }




    public  function Status(Request $request){

       // $urlResults = array();
       // $emailResults = array();
        $results = array();
        //$domain = $request->url;
//echo $request->url;
     //   console.log("hi");
        $urlDomain = $request->url;
        $urlObjects = Url::where('domain',$urlDomain)->whereNotNull('completed_at')->get();

        
        $results = array();
       
        
        foreach ($urlObjects as $urlObject) {
            $emailObjects = $urlObject->emails()->get();
            $url = $urlObject->url;  

            foreach ($emailObjects as $emailObject) {
                $email = $emailObject->email; 
             
             $results[]= $url."----".$email;               
            }                  
        }
      

        $dataLength = count($results);
        
        return response()->json([
           
            'results' => $results,
            'count' =>  $dataLength
        ],200);

    } 



}