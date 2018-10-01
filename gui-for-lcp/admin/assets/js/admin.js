/**
 * @file   Main module: adds TinyMCE button, manages the modal instance.
 * @module admin
 * @author Klemens Starybrat.
 * @since  1.0.0
 */

import ModalContentView from './ModalContentView.js';

// Just to be safe
const $ = jQuery;

/**
 * Instance of wp.media.view.Modal.
 *
 * @type {wp.media.view.Modal}
 * @protected
 */
let modal;

/**
 * Registers the 'LCP' TinyMCE button.
 *
 * @see {@link https://core.trac.wordpress.org/ticket/35243#comment:65}
 */
$( document ).on( 'tinymce-editor-setup', function( event, editor ) {
    editor.settings.toolbar1 += ',gflcp';
    editor.addButton( 'gflcp', {
        text: 'LCP',
        icon: false,
        onclick() {
            openMediaWindow();
        }
    });
});

/**
 * This function handles opening the modal window.
 *
 * Fired when the 'LCP' button is clicked. Closes over modal variable
 * to store the modal instance. A new instance is created when the modal
 * is opened for the first time after loading a page.
 *
 * @since      1.0.0
 * @protected
 * @requires  ModalContentView
 *
 * @see       module:ModalContentView
 * @see       wp.media.view.Modal
 *
 * @return    {boolean} Always returns false.
 */
function openMediaWindow() {
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
