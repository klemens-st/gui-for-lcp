/* global jQuery, _, wp, ajax_object */
$(document).ready(function(){

    $('.insert-lcp').click(lcpOpenMediaWindow);
});

const mainModel = new MainModel();

function lcpOpenMediaWindow() {
    if (this.window === undefined) {

        // Create a modal view.
        this.window = new wp.media.view.Modal({
            // A controller object is expected, but let's just pass
            // a fake one to illustrate this proof of concept without
            // getting console errors.
            controller: { trigger: function() {} }
        });

        this.window.content(new ModalContentView());
    }

    this.window.open();
    return false;
}


// TODO:
// * custom taxonomies - multiple taxonomies handling, debug
// * optimize shortcode creation with helper functions
// Check if better to use target than currentTarget
