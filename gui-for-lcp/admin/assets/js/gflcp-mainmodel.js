// wp.Backbone.Model does not exist so I'm using wp.media.controller.State
// because it extends directly from Backbone.Model
'use strict';
const MainModel = wp.media.controller.State.extend({
    // Initial state, with proper data types for reference
    defaults: {
        init: {
            categories: '',
            users: '',
            tags: [],
            taxonomies: [],
            post_types: {}
        },
        // Used by TaxTermsSubview
        taxonomies: [],
        // Is display-relevant data present
        hasData: false
    },

    ajaxData: {
        'action': 'gflcp_setup',
        'security': ajax_object.nonce,
    },

    taxTermsAjaxData:  {
        'action': 'gflcp_load_terms',
        'security': ajax_object.nonce,
        // Placeholder, will be filled dynamically by the update method.
        'taxonomies': []
    },

    getInit() {
        // Use the Backbone fetch method to get state value.
        // This will trigger a 'change' event on completion.
        this.fetch({
            method: 'POST',
            url: ajax_object.ajax_url,
            data: this.ajaxData,
            success: () => this.set('hasData', true)
        });
    },

    updateTaxonomies(taxonomies) {
        this.fetch({
            method: 'POST',
            url: ajax_object.ajax_url,
            data: _.extend(this.taxTermsAjaxData, {taxonomies}),
        });
    }
});

export default MainModel;
