
  var dataList = document.getElementById('json-datalist');
  var input = document.getElementById('ajax');

  // Create a new XMLHttpRequest.
  var request = new XMLHttpRequest();

  // Handle state changes for the request.
  request.onreadystatechange = function(respone) { //VS Code varnar för att response inte används 
    
    if (request.readyState === XMLHttpRequest.DONE) { 
      if (request.status === 0 || (request.status >= 200 && request.status < 400)) { 
        // Parse the JSON
        var jsonOptions = JSON.parse(request.responseText);
        
        // Create a new <option> element.        
        var option = document.createElement('option');
        
        /*
        Här hämtas innehållet från customers.json, men den läser inte in resultatet i appendChild. 
        I console.log står det att värdet är null.

        Med denna loop fylls alla namn in i option.value, jag misstänker att endast ett namn i taget ska läggas 
        i option.value för att sedan placeras i en Option-tag i HTML koden.
        
        // Loop over the JSON array.
        for(var i in jsonOptions) {
          
          console.log(`${jsonOptions[i]}`)

          // Set the value using the item in the JSON array.
          option.value = jsonOptions[i];
          alert(option);
          // Add the <option> element to the <datalist>.
            
          dataList.appendChild(option);
          //option.value = null;
        }*/
        
        /*
        Här kommer jag inte in i loopen, står i console.log att forEach inte är en funktion.

        // Loop over the JSON array.
        jsonOptions.forEach(function(item) {
          // Create a new <option> element.
          var option = document.createElement('option');
          alert(option.value);
          // Set the value using the item in the JSON array.
          option.value = item;
          // Add the <option> element to the <datalist>.
          dataList.appendChild(option);
        });
        */

        // Update the placeholder text. Även denna varnas ibland att den har vädre null.
        input.placeholder = "Sök efter kund här";
      } else {
        // An error occured :(
        input.placeholder = "Kunde tyvärr inte ladda alternativ";
      }
      }
    };

    // Update the placeholder text. Bort kommenterad för att det stog i console.log att värdet var null.
    //input.placeholder = "Uppdaterar";

    // Set up and make the request.
    request.open('GET', 'customers.json', true);
    request.send(); 