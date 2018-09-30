import ModalContentView from './gflcp-modalcontentview.js';

// Just to be safe
const $ = jQuery;
let modal;

$( document ).ready( () => {
    $( '.insert-lcp' ).click( lcpOpenMediaWindow );
});

//https://core.trac.wordpress.org/ticket/35243#comment:65
$( document ).on( 'tinymce-editor-setup', function( event, editor ) {
    editor.settings.toolbar1 += ',gflcp';
    editor.addButton( 'gflcp', {
        text: 'LCP',
        icon: false,
        onclick() {
            lcpOpenMediaWindow();
        }
    });
});


function lcpOpenMediaWindow() {
    if ( undefined === modal ) {

        // Create a modal view.
        modal = new wp.media.view.Modal({
            // A controller object is expected, but let's just pass
            // a fake one to avoid console errors.
            controller: { trigger: function() {} },
            className: 'gflcp-modal'
        });

        modal.content(new ModalContentView(
            { className: 'modal-form-view' }
        ));
    }

    modal.open();
    return false;
}
