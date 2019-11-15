<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Url;
use App\Email;

class WebCrawling implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $url ;
    protected $response;
    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
  public function handle() {
       

    try{
         
///////////////////////// START OF CODE LOGIC ////////////////////////////////
          //  $inputUrl= "https://stackoverflow.com/questions/3901070/in-php-how-do-i-extract-multiple-e-mail-addresses-from-a-block-of-text-and-put";

          $inputUrl = $this->url->url;
          /// Arrays required ///
          $validUrls = array();
          $urls = array();
          $emailIds = array();
          $validEmailIds = array();
          

          /// Fetching PageContent ///
          $pageContent=file_get_contents($inputUrl);
          $doc = new \DOMDocument();
          @$doc->loadHTML($pageContent);
          $urlslist = $doc->getElementsByTagName("a");

          /// Check domain of URL ///
          $domainOfInputUrl   = parse_url($inputUrl)['host'];

          /// Extracting URLs from the given URL ///
          foreach ($urlslist as $url) {
            $urlInLink= $url->getAttribute("href");
            if (filter_var($urlInLink, FILTER_VALIDATE_URL)) {
              if(substr($urlInLink,0,7) !== "mailto:") { 
                $domainOfUrlInLink   = parse_url($urlInLink)['host'];
                if($domainOfInputUrl == $domainOfUrlInLink){
                    $urls[] = $urlInLink;
                }
              }
            }
          }


          $emailIdPattern = '/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i';
    
          /// Matching PageContent with EmailId's Pattern ///
          preg_match_all($emailIdPattern, $pageContent, $emailIds);
        
          /// Removing Duplication in Emails found ///
          $uniqueEmailIds = (array_values(array_unique($emailIds[0])));
            
            /// Validating Emails ///
          foreach($uniqueEmailIds as $uniqueEmailId){
              if(filter_var($uniqueEmailId, FILTER_VALIDATE_EMAIL)){ $validEmailIds[] = $uniqueEmailId;}
          }


            


          /// DATABASE ///
          $dbObjectOfUrl = Url::whereUrl($inputUrl)->first();
          $url_id = $dbObjectOfUrl->id;
            
          /// DATABASE Logic for URLs ///
          foreach ($urls as $validUrl) {
            $url = Url::whereUrl($validUrl)->first();
            if(!$url){
                $url = Url::create(['url'=>$validUrl,'domain'=>$domainOfInputUrl]);
                echo $validUrl."<br>";
            }
          }

          /// DATABASE Logic for EmailIds ///
          foreach ($validEmailIds as $validEmailId) {
            $emailId = Email::whereEmail($validEmailId)->first();
            if(!$emailId){
              $emailId = Email::create(['email'=>$validEmailId]);
              $email_id = $emailId->id;
              $dbObjectOfUrl->emails()->attach($email_id);
          }
          else{
              $email_id = $emailId->id;
              $samePairOfEmailAndUrl = $dbObjectOfUrl->emails()->where('email_id',$email_id)->first();
              if(!$samePairOfEmailAndUrl) {
                  $dbObjectOfUrl->emails()->attach($emailId);} 
              }
            }

$this->url->completed_at=now();
$this->url->save();
/////////////////////////////////////////// END OF CODE LOGIC/////////////////////////////////////////////


          /// IF EVERYTHING GOES WELL ///
          $this->response = "Job processed";
          return $this->response;
      } //END OF TRY

    
        catch (\Exception $e) { $response = $e->getMessage();}

      }// END OF METHOD HANDLE

           

    public function getResponse(){
        return $this->response;
    }


}

