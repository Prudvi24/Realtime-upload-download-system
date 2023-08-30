var fileInput, uploadProgress, message;
var PrevLoaded = 0;
function _(el){
               return document.getElementById(el);       //Getting the HTML element by ID
           }

function init() {                                        // Runner function
	fileInput = document.getElementById('file-input');  
	uploadProgress = document.getElementById('upload-progress');
	message = document.getElementById('message');
     cancelbtn = document.getElementById('cancel-file');
	fileInput.addEventListener('change',function() {               //AJAX function to the element file-input
          var xhr = new XMLHttpRequest();                           // It is used to request data from a web server.

          var fd = new FormData();                                  // It is an object that compile a set of key/value pairs to send using XMLHttpRequest
          var ins = document.getElementById('file-input').files.length;   // Total number of files selected for upload
          for(var x=0; x<ins; x++)
          {
               fd.append("files[]",fileInput.files[x]);                  // Appending it to formdata
          }
          //fd.append('file',fileInput.files[0]);
          xhr.upload.onloadstart = function(e)                           // Onload function
          {
          	uploadProgress.classList.add('visible');
          	uploadProgress.value=0;
          	uploadProgress.max=e.total;
          	message.textContent = 'Uploading';
               fileInput.disable = true;
          };

          xhr.upload.onprogress = function(e)                           //Progress bar code
          {
               _("loaded_total").innerHTML = "Uploaded "+(e.loaded/1048576).toFixed(2)+" MB of "+(e.total/1048576).toFixed(2)+" MB";   // Display the loaded MB on the screen
          	uploadProgress.value=e.loaded;
          	uploadProgress.max=e.total;
               var percent = (e.loaded/e.total)*100;
               var speed = e.loaded - PrevLoaded;
               PrevLoaded = e.loaded;
               var remainingBytes = e.total-e.loaded;
               var timeRemaining = (remainingBytes / speed).toFixed(2);
               _("time1").innerHTML= "The remaining time is: "+timeRemaining+" Sec";
               _("status").innerHTML = Math.round(percent)+"%";

               cancelbtn.addEventListener('click', function() {                               // Function to cancelthe file uploading
                    xhr.abort();                                                              // Abort all the request to the server
                    message.textContent = 'File uploading cancelled';                         // Dispaly the message after the abort operation
                    _("loaded_total").innerHTML = " ";
                    _("time1").innerHTML= " ";
                    _("status").innerHTML =" ";
                    uploadProgress.classList.remove('visible');                               // Remove the visibility of the progress bar
               });

               fileInput.disable = false;

          };

          xhr.upload.onloadend = function(e)                     // Message after completion of the file upload(100%)
          {
          	uploadProgress.classList.remove('visible');
          	message.textContent = 'Complete!';
          };

          xhr.onload = function() {                               // Get the response from the server after the file upload
               alert(xhr.responseText);
          	message.textContent = 'Response: "'+ xhr.responseText +'"';    // Getting the reponse in the text format
          }

          xhr.open('POST','SQLphp.php',true);                                    // Using post method to senf files to the server
          xhr.send(fd);                                                         // Sending files to the server
	});


}

init();                                                                       // Call of the main runner function

