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
