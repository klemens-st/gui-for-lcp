/**
 * @file   This file defines the ModalContentView class.
 * @module ModalContentView
 * @author Klemens Starybrat.
 * @since  1.0.0
 */

import MainModel from './MainModel.js';
import SelectOptionsSubview from './SelectOptionsSubview.js';
import DisplayOptionsSubview from './DisplayOptionsSubview.js';
import createShortcode from './createShortcode.js';

const ModalContentView = wp.Backbone.View.extend(/** @lends ModalContentView.prototype */{
    /**
     * Main modal view.
     *
     * This is the main view attached to the media modal. App's main
     * model is an instance of this view and is later passed by reference
     * to all subviews that require it. On initialization this view listens
     * to change events on the model and binds its render method to them.
     *
     * @since      1.0.0
     * @package
     *
     * @constructs ModalContentView
     * @augments   wp.Backbone.View
     *
     * @requires  MainModel
     *
     * @see module:admin
     *
     * @param {Object}   [options]           The view's options.
     * @param {string}   options.className   Wrapper's CSS class.
     */
    initialize() {
        this.model = new MainModel();

        this.model.getData();

        // The 'change' event is fired on the model whenever state changes.
        this.listenTo( this.model, 'change:hasData', this.render );
        this.listenTo( this.model, 'change:errored', this.render );
    },

    /**
     * Loads the template. File: tmpl-modal-content.php
     *
     * @since 1.0.0
     * @private
     * @type {function}
     */
    template: wp.template( 'modal-content' ),

    /**
     * Event delegation hash.
     *
     * @since 1.0.0
     * @private
     * @type {Object}
     */
    events: {
        'submit #gflcp-form': 'insertShortcode',
        'click .gflcp-footer button': 'checkForm',
        'reset #gflcp-form': 'render',
        'click .gflcp-alert button': 'onTryAgain',
    },

    /**
     * Try again button handler.
     *
     * @since 1.0.0
     * @private
     */
    onTryAgain() {
        this.model.set( 'errored', false );
        this.model.getData();
    },

    /**
     * Form validation hanler.
     *
     * @since 1.0.0
     * @private
     */
    checkForm: function() {
        const invalid = this.$( ':invalid' );

        // Don't manipulate any panels if the form is ok
        if ( 0 === invalid.length ) {
            return;
        }

        // Get a zero-based index of a tab.
        const tab = invalid.last()
            .parents( '.ui-tabs-panel' )
            .prevAll( 'div' )
            .length;

        // Get a zero-based index of a panel.
        const panel = invalid.last()
            .parents( '.ui-accordion-content' )
            .prevAll( 'div' )
            .length;

        // Open the tab
        this.$( '#gflcp-tabs' ).tabs(
            'option',
            'active',
            tab
        );

        // Open the panel
        this.$( '#gflcp-select-accordion' ).accordion(
            'option',
            'active',
            panel
        );
        // Re-trigger native validation
        setTimeout( () => this.$( '.gflcp-hidden-btn' ).click(), 500 );
    },

    /**
     * View's render method. Two main subviews are attached here.
     *
     * @since 1.0.0
     * @package
     *
     * @requires  SelectOptionsSubview
     * @requires  DisplayOptionsSubview
     *
     * @return {Object} Instance.
     */
    render: function() {
        this.$el.html( this.template( _.clone( this.model.attributes ) ) );
        this.views.set( '#gflcp-display-options', new DisplayOptionsSubview() );
        this.views.set( '#gflcp-select-options', new SelectOptionsSubview({
            // Use parent's model in the subview
            model: this.model
        }));

        this.$( '#gflcp-tabs' ).tabs();

        return this;
    },

    /**
     * Form submission handler.
     *
     * @requires  createShortcode
     *
     * @since 1.0.0
     * @private
     */
    insertShortcode( e ) {
        e.preventDefault();
        const FD = new FormData( e.currentTarget );
        wp.media.editor.insert( createShortcode( FD ) );
        /*
         * This view is a subview of wp.media.view.Modal
         * so in order to close the modal on shortcode insertion
         * we can use the reference at this.views.parent
         */
        this.views.parent.close();
    }
});

export default ModalContentView;
