function send_ajax_request() {
    alert('here');
    /*var letter = document.getElementById("vote").value;
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.addEventListener("readystatechange", receive_ajax_response, false);

    xmlhttp.open("POST", "updateVotes.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send();*/

}

function receive_ajax_response() {
    if (this.readyState == 4 && this.status == 200) {
        var votesPage = document.getElementById("votesPage");
        var results;
       
        try {
            results = JSON.parse(this.responseText);
            alert("SUCESS HERE!");
        }catch{
            // DOM manipulation to change the radio button to a string - 
            
        }

    }

    return;
}