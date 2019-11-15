<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
    margin-left:5%;
    margin-right:5%;
    margin-top:5%;
}
</style>


<h3> Please wait while results are being fetched.</h3>
<input type="text" value="{{ $url }}" style="display: none" id="url"/>

<div id="results"></div>
<script>

$(document).ready(function() { 



function fetchData(){

    var postUrl = '/results/'+$("#url").val();
    var url =$("#url").val();

      $.ajax({ 

            url : postUrl,
            dataType:'json',
            type: 'post',
            data:{url:url},
         
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                
            success: function (data){
                    var count=data["count"];
                     $("#results").html("");
                    for(var i=0;i<count;i++){
                      
                     $("#results").append("<h4>"+data["results"][i]+"</h4>"); 
                     
                  }

            }

      });

      setTimeout(fetchData, 3000);
}


fetchData();


});

</script>



