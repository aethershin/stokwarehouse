          
                  var fileReader = new FileReader();
                  fileReader.onload = function(event) {
                    var data = event.target.result;

                    var workbook = XLSX.read(data, {
                      type: "binary"
                    });
                    workbook.SheetNames.forEach(sheet => {
                      let rowObject = XLSX.utils.sheet_to_row_object_array(
                        workbook.Sheets[sheet]
                      );
                      let jsonObject = JSON.stringify(rowObject);
                      
                      $('#jsonData').val(jsonObject);
                      var element = document.getElementById("jsonData");
                            element.style.display = "block";
                    });
                  };
                 
        
      });