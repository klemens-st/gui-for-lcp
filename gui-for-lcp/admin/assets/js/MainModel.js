/**
 * @file   This file defines the MainModel class.
 * @module MainModel
 * @author Klemens Starybrat.
 * @since  1.0.0
 */

/**
 * Backbone model for the app.
 *
 * Used by all views. Instantiated by ModalContentView.
 * wp.Backbone.Model does not exist. Using wp.media.controller.State
 * because it extends directly from Backbone.Model.
 *
 * @since      1.0.0
 * @package
 *
 * @constructs MainModel
 * @augments   wp.media.controller.State
 * @inheritDoc
 *
 * @see   wp.media.controller.State
 * @see   module:ModalContentView
 */
const MainModel = wp.media.controller.State.extend(/** @lends MainModel.prototype */{
    /**
     * Initial state, with proper data types for reference.
     *
     * @since 1.0.0
     * @private
     * @type {Object}
     */
    defaults: {
        data: {
            categories: '',
            users: '',
            tags: [],
            taxonomies: [],
            post_types: {}
        },
        // Used by TaxTermsSubview
        taxonomies: [],
        // Is display-relevant data present
        hasData: false,
        // Did last fetch fail
        errored: false
    },

    /**
     * Ajax data for getData()
     *
     * @since 1.0.0
     * @private
     * @type {Object}
     */
    ajaxData: {
        'action': 'gflcp_setup',
        'security': ajax_object.nonce,
    },

    /**
     * Ajax data for updateTaxonomies()
     *
     * @since 1.0.0
     * @private
     * @type {Object}
     */
    taxTermsAjaxData:  {
        'action': 'gflcp_load_terms',
        'security': ajax_object.nonce,
        // Placeholder, will be filled dynamically by the update method.
        'taxonomies': []
    },

    /**
     * Gets form data from the server and updates state.
     * Called by ModalContentView.
     *
     * @since 1.0.0
     * @package
     */
    getData() {
        /* Use the Backbone fetch method to get state value.
         * This will trigger a 'change' event on completion.
         */
        this.fetch({
            method: 'POST',
            url: ajax_object.ajax_url,
            data: this.ajaxData,
            success: () => this.set( 'hasData', true ),
            error: () => this.set( 'errored', true ),
        });
    },

    /**
     * Gets taxonomy terms data from the server and updates state.
     * Called by SelectOptionsSubview.
     *
     * @since 1.0.0
     * @package
     */
    updateTaxonomies( taxonomies ) {
        this.fetch({
            method: 'POST',
            url: ajax_object.ajax_url,
            data: _.extend( this.taxTermsAjaxData, { taxonomies } ),
        });
    }
});

export default MainModel;
