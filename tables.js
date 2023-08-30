var Container = document.getElementById("table");
function _(el){
               return document.getElementById(el);                           // Returns an element ID
           }

fileInput1 = document.getElementById('file-input1');
fileInput1.addEventListener('click',function() {
	
	var xhr = new XMLHttpRequest();
	xhr.open("get",'RetrieveTable.php',true);
	xhr.onload = function() {
		var data =JSON.parse(xhr.responseText);
		renderHTML(data);
	};                                            
      xhr.send(null);
     fileInput1.classList.add("hide-me");

});


function renderHTML(data) {
//var styleToPage ="<style> table { font-family: arial, sans-serif; border-collapse: collapse; width: 100%; border-radius:6px;} td, th{ border: 1px solid #dddddd; text-align: left; padding: 8px;} tr:nth-child(even){ background-color: #dddddd;}</style>";
var eTable="<table><thead><tr><th colspan='5' >Files in the SQL Server</th></tr><tr><th>ID</th><th>File type</th><th>File name</th><th>File size(MB)</th><th>Link</th></tr></thead><tbody>"
  for(var i=0; i<data.length;i++)
  {
    eTable += "<tr>";
    eTable += "<td>"+data[i]['id']+"</td>";
    eTable += "<td>"+data[i]['FileType']+"</td>";
    eTable += "<td>"+data[i]['FileName']+"</td>";
    eTable += "<td>"+data[i]['FileSize']+"</td>";
    eTable += "<td><button id='linksql'><a href=DownloadSQL.php?id="+data[i]['id']+">Download</a></button></td>";
    eTable += "</tr>";
  }
  eTable +="</tbody></table>";
  //$('#table').css(styleToPage);
  $('#table1').html(eTable);
}