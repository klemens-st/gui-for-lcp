/**
 * @file   This file defines the DisplayOptionsSubview class.
 * @module DisplayOptionsSubview
 * @author Klemens Starybrat.
 * @since  1.0.0
 */

/**
 * Backbone view for display options.
 *
 * Used as a subview by ModalContentView.
 *
 * @since      1.0.0
 * @package
 *
 * @constructs DisplayOptionsSubview
 * @augments   wp.Backbone.View
 * @inheritDoc
 *
 * @see   wp.Backbone.View
 * @see   module:ModalContentView
 */
const DisplayOptionsSubview = wp.Backbone.View.extend(/** @lends DisplayOptionsSubview.prototype */{
    /**
     * Loads the template. File: tmpl-display-options.php
     *
     * @since 1.0.0
     * @private
     * @type {function}
     */
    template: wp.template( 'display-options' ),

    /**
     * Event delegation hash.
     *
     * @since 1.0.0
     * @private
     * @type {Object}
     */
    events: {
        'change .gflcp-display-checkboxes input': 'toggleFieldset',
        'change .gflcp-toggles-fieldset': 'toggleFieldset',
        'change .gflcp-display-details [type="checkbox"]': 'toggleInput'
    },

    /**
     * Checkbox event handler for fieldsets.
     *
     * @since 1.0.0
     * @param  {object}  e  Event.
     * @private
     */
    toggleFieldset( e ) {
        const el = this.$( e.target );
        const targetEl = this.$( '.gflcp-' + el.attr( 'name' ) );

        targetEl.prop( 'disabled', ( i, val ) => !val );
    },

    /**
     * Checkbox event handler for individual inputs.
     *
     * @since 1.0.0
     * @param  {object}  e  Event.
     * @private
     */
    toggleInput( e ) {
        const el = this.$( e.target );
        // A custom 'toggles' HTML attribute is parsed here.
        const targetEl = this.$( `[name="${el.attr( 'toggles' )}"]` );

        targetEl.prop( 'disabled', ( i, val ) => !val );
    },

    /**
     * View's render method.
     *
     * @since 1.0.0
     * @package
     *
     * @return {Object}  Instance.
     */
    render: function() {
        this.$el.html( this.template() );
        this.accordion = this.$( '.gflcp-display-accordion' );
        this.accordion.accordion({
            heightStyle: 'content'
        });

        return this;
    }
});

export default DisplayOptionsSubview;
