$(document).ready(function() {
    a=$.ajax({
    url: "https://tranhuq.451.csi.miamioh.edu/cse451-tranhuq-web/Buildings/public/index.php/api/temp",
    method: "GET"
    }).done(function(data) {
        console.log(data);
        $("#temp").append(data["temp"]);
    }).fail(function(xhr, status, error) {
        document.getElementById("zip").value = "";
        $("#errorLog").html("Error - " + xhr.status + ": " + xhr.Message);   
    }); 

})