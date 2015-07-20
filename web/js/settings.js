$(document).ready(function() {
    $('#theme-settings').selectize().on('change', function() {
        var stylesheet = window.highlightBase + 'dist/styles/' + $(this).val() + '.css';
        $('head').append('<link rel="stylesheet" href="' + stylesheet + '" type="text/css" />');
    });

    $('#ace-settings').selectize().on('change', function() {
        if(typeof window.aceeditor !== "undefined") {
            window.aceeditor.setTheme('ace/theme/' + $(this).val());
        }
    });
});