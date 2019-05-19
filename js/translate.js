$("#analizar").on("click", function(e){
    e.preventDefault();
    obtenerTraduccion();
    e.stopImmediatePropagation();
});

function obtenerTraduccion(){
    $.ajax({
        method: "POST",
        url: "index.php/translate/text",
        data: "text="+$("#textoAnalizar").val()
    }).done(function( data ) {
        if(data.length > 0 && data[0].translations.length > 0){
            var text = data[0].translations[0].text;
            $("#textoAnalizado").val(text);
            analizarTraduccion(text);
        }
    });
}

function analizarTraduccion(text){
    $.ajax({
        method: "POST",
        url: "index.php/analytics/text",
        data: "text="+text
    }).done(function( data ) {
        $("#textoAnalizado").removeClass("is-valid");
        $("#textoAnalizado").removeClass("is-invalid");
        if(data.documents.length > 0){
            var score = data.documents[0].score;
            if(score >= 0.5){
                $("#textoAnalizado").addClass("is-valid");
            }else{
                $("#textoAnalizado").addClass("is-invalid");
            }
        }
    });
}