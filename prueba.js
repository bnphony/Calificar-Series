function buscarSeries() {
    $.ajax({
        url: 'prueba.php',
        type: 'GET',
        data: {
            'page': 1,
        },
        success: function(response) {
            // let series = JSON.parse(response);
            console.log("SERIES: ", response);
        },
        error: function(xhr, status, error) {
            console.error("Request failed with status: " + status);
            console.error("Error message: " + error);
        }
    });
}

$(function() {
    buscarSeries();

});