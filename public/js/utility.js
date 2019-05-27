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

function showOverlay(name, callback)
{
 
  callback(document.getElementById(name));
}

function productDetailOverlay(element)
{
  element.style.display = "block";
  element.style.marginTop = "0";
}

