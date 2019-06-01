function jsonAjax(path, type, data, onSuccess, onError)
{
     $.ajax(
        {
            url: path,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: type,
            data: data,
            dataType: "json",
            contentType: "application/json; charset=utf-8",
           success: function (response)
            {
              onSuccess(response)
            },
            error: function (xhr, status, error)
            {
                onError()
            }
        });
}

function formAjax(path, type, data, onSuccess, onError)
{
     $.ajax(
        {
            url: path,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            type: type,
            data: data,
            dataType: "json",
            processData:false,
            contentType:false,
           success: function (response)
            {
              onSuccess(response)
            },
            error: function (xhr, status, error)
            {
                onError()
            }
        });
}

function toggleSidebar()
{
  $('#sidebar').toggleClass('active');
  $('#main').toggleClass('active');
  $('#arrow').toggleClass('fa-angle-right fa-angle-left');

}

function alertSuccess()
{
  alert("success")
}

function alertError()
{
  alert("Request Error")
}

function checkResponse(response)
{
    alert(response.status)
}

function hideOverlay(name, callback)
{
 
  var element = document.getElementById(name);
  if(callback == "")
  {
      element.style.display="none";
  }
  else
  {
      callback(element, "hide");  
  }
}

function showOverlay(name, callback)
{
 
  var element = document.getElementById(name);
  if(callback == "")
  {
      element.style.display="block"
  }
  else
  {
      callback(element, "show");  
  }
}


function toggleOverlay(name)
{
    $(name).toggleClass('active');
}
function productDetailOverlay(element, type)
{
  if(type == "show")
  {
    element.style.display = "block";
    element.style.marginTop = "0";    
  }
  else
  {
    element.style.marginTop = "-90%";        
    element.style.display = "none";
  }
}



