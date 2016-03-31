var $receiveNews = $("#application_receiveNews");
var $zip = $("#application_zip");
var $emailContainer = $("#application_email").parents(".form-group");
var $cityContainer = $("#application_city").parents(".form-group");

$receiveNews.on("change", function(){
    if ($receiveNews.is(":checked")){
        $emailContainer.show();
    }
    else {
        $emailContainer.hide();
    }
});

//cache indirectement le champs email...
$receiveNews.change();


$zip.on("keyup", function(){
    zipVal = $zip.val();
    if (zipVal.length == 5){
        $.ajax({
            url: getCitiesUrl,
            data: {
                'zip': zipVal
            }
        })
        .done(function(response){
            var opt;
            for (i in response){
                opt = $("<option>").attr("value", response[i]['id']);
                opt.text(response[i]['name']);
                $("#application_city").append(opt);
            }
        });
        $cityContainer.show();
    }
    else {
        $cityContainer.hide();
    }
});

$zip.keyup();

/*

$zip.on("keyup", function(){
    var $form = $(this).closest('form');

    var data = {};
    data[$zip.attr('name')] = $zip.val();

    if ($zip.val().length == 5){
        $.ajax({
            url : $form.attr('action'),
            type: $form.attr('method'),
            data : data,
        })
        .done(function(response){
            console.log(response);
        });
        $cityContainer.show();
    }
    else {
        $cityContainer.hide();
    }
});
*/

//$zip.keyup();
