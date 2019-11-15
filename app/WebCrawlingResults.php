<?php



class WebCrawlingResults
{
	public function getUpatedResults(Request $url){


		$urlDomain = $url;
		$urlObjects = Url::where('domain',$urlDomain)->whereNotNull('completed_at')->get();

		
        $results = array();
       
        
        foreach ($urlObjects as $urlObject) {
            $emailObjects = $urlObject->emails()->get();
            $url = $urlObject->url;  

            foreach ($emailObjects as $emailObject) {
                $email = $emailObject->email;          
                $results[] = $url." ------- ".$email;                    
            }                  
        }

        return $results;


	}

}