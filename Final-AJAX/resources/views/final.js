var URL="cse451-tranhuq-web/Final-AJAX/public/api/data";

function get(key, token) {
	return new Promise((resolv,rej) =>{
		$.ajax({
		 url:URL,
		 method: "GET",
		 success: function (data) {
        	resolv(data.numbers)
      	 },
      	 error: function (error) {
        	rej(error)
      	 },
		})
	})
}

async function program() {
	var numbers = [];
	numbers = await get();
	numbers.foreach((num) => {
        $("#table").append("<tr><td>" + num + "</td></tr>");
    });

}

$(document).ready(function() {
    program();
});

