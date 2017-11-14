function file_upload()
{
    // フォームデータを取得

    //var formdata = new FormData();
    var formdata = new FormData($('#my_form').get(0));
    console.log(formdata);

    // POSTでアップロード
    $.ajax({
        url  : "http://localhost/restapi/products/img",
        type : "POST",
        data : formdata,
        cache       : false,
        contentType : false,
        processData : false,
        dataType    : "html"
    })
    .done(function(response){
        alert(response);
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        alert("アップロード失敗:"+errorThrown);
    });




}


$(function(){
  //upLoadFile();
});
