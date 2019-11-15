## FILES 
I have worked in following files:
Controller/HomeController
Views/home.blade.php & results.blade.php
Jobs/WebCrawling
Commands/ProcessUrl

## WORK FLOW:
1.	User goes to the home page. And sees an input form. 
Method:  GET: HomeController/Index(). Method returns a view : home.blade.php

2.	When user clicks on submit button of the form, an anchor tag appears below the form to check results.
Method:  POST: HomeController/RequestStatus.  By clicking on submit button, an Ajax call goes to this RequestStatus method of Controller carrying “URL” parameter with it. Inside that method, we check if any URL of this domain doesn’t already exist in our Databases then we store this URL in Database and return the status back to the home.blade.php view. And anchor tag appears on view.

3.	User clicks on anchor tag to check results.
Method: GET: HomeController/Results. This method returns another view “results.blade.php” and passes URL parameter to it. 

4.	User sees a message saying: “Please wait while results are being fetched.” And then after few seconds, results start to appear below on the same page. And increases with time as the crawler progresses.
Method: POST: HomeController/Status. I have set a timer inside results.blade.php. Which keeps on calling this method of Status after the time interval of few seconds and fetches results and display on view.

## How it Works?
I have set a console command inside Console/ProcessURL. This command is to run the job. 
I have set a Job/WebCrawling. This commands keep on checking Databases and see if there is any URL listed as : completed_at=null, then picks up that URL, fetches the URL/Links and Email Ids given in those page and save them to database. All those URLs are set as completed_at:null because web crawler has not crawled those newly found URLs yet.
After the set time interval of one minute, crawler job checks the Database and fetch the next URL which has null value in completed_at column of URL table. And goes to that URL and fetch the links/urls and email ids found in that URL. Job checks if the fetched URLs already exist in database then it doesn’t store it again otherwise store it in Database and set its completed_url column value as null. And the URL which is being crawled by the crawler, change its value of completed_at column to the date when crawling has occurred on this URL. So, the next time when Job will check next Url which has completed_at value as null, this url will not be picked up again. 



