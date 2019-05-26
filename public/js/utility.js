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

function hideOverlay(name)
{
  document.getElementById(name).style.display = "none";
}

function showOverlay(name)
{
  document.getElementById(name).style.display = "block";
}

function firstLetterToUpperE(element)
{
  var text = element.value.trim();

  if(text.length >= 1)
  {

    element.value = text.charAt(0).toUpperCase() + text.substring(1).toLowerCase();
    element.dispatchEvent(new Event('input'));
  } 
}

