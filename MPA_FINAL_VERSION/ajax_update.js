// Update the list of the polls in the Main Page every 90 seconds to find out if there are any new polls posted.

function send_ajax_request() {

    var xmlhttp = new XMLHttpRequest();


    // access the onreadystatechange event for the XMLHttpRequest object
    xmlhttp.addEventListener("readystatechange", update_polls, false);

    //Do these three lines to prepare a POST
    xmlhttp.open("POST", "update_mainPage_polls.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send();
}


function update_polls() {
    if (this.readyState == 4 && this.status == 200) {
        
        // Grab the part where the list of top 5 recent polls is listed.
        var mainPolls = document.getElementById("mainPolls");
        var results;

        try {
            results = JSON.parse(this.responseText);
        }catch {
            // Refresh page every 90 seconds
            setInterval(send_ajax_request, 90000);
            return;
        }
    }
}
