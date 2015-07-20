$('.vote-up, .vote-down').on('click', function(e) {
    $.ajax({
        url: $(this).attr('href')
    }).always(function(data) {
        var type = 'success';
        if(typeof data.responseJSON !== "undefined") {
            data = data.responseJSON;
            type = 'danger';
        }

        var $paste = $('#paste-' + data.id);

        var alert = $('<div class="alert alert-' + type + ' alert-dismissible" id="alert-' + data.id + '">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                data.message +
            '</div>').hide().appendTo('.alerts').slideDown();

        $paste.find('.vote-up, .vote-down').addClass('disabled');

        setTimeout(function() {
            alert.slideUp(250, function() {
                alert.remove();
            })
        }, 1500);

        if(type === 'success') {
            var $score = $paste.find('.score');
            $paste.find('.score').class = 'score';

            if(data.score > 0) {
                $score.addClass('text-success');
                data.score = '+' + data.score;
            } else if(data.score < 0) {
                $score.addClass('text-danger');
            }

            $score.html(data.score);
        }
    });

    e.preventDefault();
});