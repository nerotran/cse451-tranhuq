/*
Name: Nero Tran Huu
Course: CSE 551
Assignment: rest3-billboard
Date: 3/28/2022
File: index.js
*/
var URL="https://tranhuq.451.csi.miamioh.edu/rest3-billboard/rest.php/api/v1/";
var thumbs;

function post(id, thumbs) {
	var data = {
		nonce: nonce,
		token: token,
		songPK: id,
		state: thumbs
	}
	$.ajax({
		 url:URL + "songs",
		 method: "POST",
		 data: JSON.stringify(data),
		 contentType: "application/json; charset=utf-8",
		}).fail(function(data) {
			console.log("Error: " + data);
		});

	location.reload();

}

//handler on up arrow click
function arrowUp(id) {
	post(id,1);
}

//handler on down arrow click
function arrowDown(id) {
	post(id,2);
}

function getThumbs(id) {
	return new Promise((resolv,rej) =>{ 
		$.ajax({
		 url:URL + "overthumbs/" + id,
		 method: "GET",
		success: function (data) {
        	resolv(data.thumbs)
      	},
      	error: function (error) {
        	rej(error)
      	},
		})
	})
}

function getSong() {
	return new Promise((resolv,rej) =>{ 
		$.ajax({
		 url:URL + "songs/0",
		 method: "GET",
		success: function (data) {
        	resolv(data.songs)
      	},
      	error: function (error) {
        	rej(error)
      	},
		})
	})
}

async function program() {
	var songs = await getSong();
	for (const song of songs) {
		var thumbs = await getThumbs(song["id"]);
		thumbsString = "";
		thumbsString += "<td><span onclick='arrowUp("+song['id']+")' class='bi bi-arrow-up-circle-fill'></span><br>" + song["likes"] + 
		"<br>" + thumbs[song["id"]]["likes"] + "</td>";
		thumbsString += "<td><span onclick='arrowDown("+song['id']+")' class='bi bi-arrow-down-circle-fill'></span><br>" + song["dislikes"] + 
		"<br>" + thumbs[song["id"]]["dislikes"] + "</td>";
		$("#table").append("<tr><td>" + song['date'] + "</td><td>" + song['song'] + "</td><td>" + song['artist'] + 
		"</td><td>" + song['rank'] + "</td>" + thumbsString + "</tr>");
	}	
}

$(document).ready(function() {
    program();
});

