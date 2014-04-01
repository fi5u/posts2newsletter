(function ($) {
    'use strict';

    $(function () {

        /* DRAG AND DROP */
        $('.active-campaign__select-item').draggable({
            appendTo: 'body',
            helper: 'clone'
        });

        $('#active-campaign-posts').droppable({
            activeClass: 'ui-state-default',
            hoverClass: 'ui-state-hover',
            accept: ':not(.ui-sortable-helper)',
            drop: function (event, ui) {
                $(this).find('.placeholder').remove();
                var thisId = $(ui.draggable).attr('id');
                $('<li id="selected-' + thisId + '"></li>').text(ui.draggable.text()).appendTo(this);
            }
        }).sortable({
            items: 'li:not(.placeholder)',
            sort: function () {
                $(this).removeClass('ui-state-default');
            }
        });


        /* SAVE CAMPAIGN */
        $('#btn-save-campaign').click(function (e) {
            function listToArray($element) {
                var arr = [];
                $element.find('li:not(.placeholder)').each(function () {
                    var thisId = $(this).attr('id'),
                        idNumber = thisId.replace( /^\D+/g, '');
                    arr.push(idNumber);
                });

                var returnArr = arr.join();
                return returnArr;
            }

            var data = {
                action: 'save_campaign',
                name: $('#input-active-campaign-name').val(),
                post_ids: listToArray($('#active-campaign-posts'))
            };

            $.post(posts2newsletter_campaigns_object.ajax_url, data, function (response) {
                alert(response);
            });

            e.preventDefault();
        });
    });

}(jQuery));