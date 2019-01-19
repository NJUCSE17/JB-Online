/**
 * Setup jQueryConfirm plugin
 */

/**
 * Allows you to add data-method="METHOD to links to automatically inject a form
 * with the method on click
 *
 * Example: <a href="{{route('customers.destroy', $customer->id)}}"
 * data-method="delete" name="delete_item">Delete</a>
 *
 * Injects a form with that's fired on click of the link with a DELETE request.
 * Good because you don't have to dirty your HTML with delete forms everywhere.
 */
function JQueryConfirm() {
    $('[data-method]').append(function () {
        if (!$(this).find('form').length > 0)
            return "\n" +
                "<form action='" + $(this).attr('href') + "' method='POST' name='delete_item' style='display:none'>\n" +
                "<input type='hidden' name='_method' value='" + $(this).attr('data-method') + "'>\n" +
                "<input type='hidden' name='_token' value='" + $('meta[name="csrf-token"]').attr('content') + "'>\n" +
                "</form>\n";
        else
            return "";
    })
        .removeAttr('href')
        .attr('style', 'cursor:pointer;')
        .attr('onclick', '$(this).find("form").submit();');
}

/**
 * Place any jQuery/helper plugins in here.
 */
$(function () {
    /**
     * Add the data-method="delete" forms to all delete links
     */
    JQueryConfirm();

    /**
     * Disable all submit buttons once clicked
     */
    $('form').submit(function () {
        $(this).find('input[type="submit"]').attr("disabled", true);
        $(this).find('button[type="submit"]').attr("disabled", true);
        return true;
    });

    /**
     * Bind all bootstrap tooltips & popovers
     */
    $("[data-toggle='tooltip']").tooltip();

    /**
     * Generic confirm form delete using JQuery-Confirm v3
     */
    $('body').on('submit', 'form[name=delete_item]', function (e) {
        e.preventDefault();

        let form = this,
            link = $('a[data-method="delete"]'),
            cancel = (link.attr('data-trans-button-cancel')) ? link.attr('data-trans-button-cancel') : "取消 Cancel",
            confirm = (link.attr('data-trans-button-confirm')) ? link.attr('data-trans-button-confirm') : "确认 Yes",
            content = (link.attr('data-trans-title')) ? link.attr('data-trans-title') : "Are you sure you want to delete this item?";

        $.confirm({
            title: 'Are you sure?',
            content: content,
            icon: 'fas fa-exclamation-triangle',
            typeAnimated: true,
            buttons: {
                confirm: {
                    text: confirm,
                    btnClass: 'btn-green',
                    action: function () {
                        form.submit();
                    }
                },
                cancel: {
                    text: cancel,
                    btnClass: 'btn-red',
                },
            }
        });
    }).on('click', 'a[name=confirm_item]', function (e) {
        /**
         * Generic 'are you sure' confirm box
         */
        e.preventDefault();

        let link = $(this),
            content = (link.attr('data-trans-title')) ? link.attr('data-trans-title') : "你确定你要这么做吗？<br />Are you sure you want to do this?",
            cancel = (link.attr('data-trans-button-cancel')) ? link.attr('data-trans-button-cancel') : "取消 Cancel",
            confirm = (link.attr('data-trans-button-confirm')) ? link.attr('data-trans-button-confirm') : "确认 Yes";

        $.confirm({
            title: 'Are you sure?',
            content: content,
            icon: 'fas fa-question-circle',
            typeAnimated: true,
            buttons: {
                confirm: {
                    text: confirm,
                    btnClass: 'btn-green',
                    action: function () {
                        window.location.assign(link.attr('href'))
                    }
                },
                cancel: {
                    text: cancel,
                    btnClass: 'btn-red',
                },
            }
        });
    });
});

/**
 * Display an error.
 * @param error
 */
window.alertError = function (error) {
    console.log(error);
    $.alert({
        icon: 'fas fa-times-circle',
        title: 'Fail',
        content: "Failed to proceed. " + error,
        type: 'red',
        typeAnimated: true,
        backgroundDismiss: 'close',
        buttons: {
            close: function () {
            }
        }
    });
};