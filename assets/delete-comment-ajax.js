$(document).ready(function () {
    $('.remove').click(function (){
        var container = $(this).parent();
        var id = $(this).attr('id');
        var string = 'cmtId=' + id;

        $.ajax({
            type: 'POST',
            url: 'views/delete-comment-ajax.php',
            data: string,
            success: function (){
                container.slideUp('slow', function () {container.remove();});
            }
        });
    });
});