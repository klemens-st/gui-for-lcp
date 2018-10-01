/**
 * @file   This file defines the TaxTermsSubview class.
 * @module TaxTermsSubview
 * @author Klemens Starybrat.
 * @since  1.0.0
 */

const TaxTermsSubview = wp.Backbone.View.extend(/** @lends TaxTermsSubview.prototype */{
    /**
    * Backbone view for taxonomy terms.
    *
    * Used as a subview by SelectOptionsSubview.
    *
    * @since      1.0.0
    * @package
    *
    * @constructs TaxTermsSubview
    * @augments   wp.Backbone.View
    *
    * @see module:SelectOptionsSubview
    *
    * @param {Object}   [options]      The view's options.
    * @param {Object}   options.model  Backbone model.
    */
    initialize() {
        this.listenTo( this.model, 'change:taxonomies', this.render );
    },

    /**
     * Loads the template. File: tmpl-taxonomy-terms.php
     *
     * @since 1.0.0
     * @private
     * @type {function}
     */
    template: wp.template( 'taxonomy-terms' ),

    /**
     * View's render method.
     *
     * @since 1.0.0
     * @package
     *
     * @return {Object} Instance.
     */
    render: function() {
        this.$el.html( this.template( this.model.get( 'taxonomies' ) ) );
        return this;
    }
});

export default TaxTermsSubview;
