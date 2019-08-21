

$(".add_panier").click(function (event) {
    event.preventDefault();
    var id = $(this).attr('href');
    $.ajax({
        url:"/ajouter/"+id,
        type:'POST',
        success: function (data) {
            $("#notice").html(data.msg);
            $('#exampleModal').modal('show');
            $("#nombre_articles").html(data.nb);
        }
    })
});

