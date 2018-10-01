const DisplayOptionsSubview = wp.Backbone.View.extend({
    template: wp.template( 'display-options' ),

    events: {
        'change .gflcp-display-checkboxes input': 'toggleFieldset',
        'change .gflcp-toggles-fieldset': 'toggleFieldset',
        'change .gflcp-display-details [type="checkbox"]': 'toggleInput'
    },

    toggleFieldset( e ) {
        const el = this.$( e.target );
        const targetEl = this.$( '.gflcp-' + el.attr( 'name' ) );

        targetEl.prop( 'disabled', ( i, val ) => !val );
    },

    toggleInput( e ) {
        const el = this.$( e.target );
        const targetEl = this.$( `[name="${el.attr( 'toggles' )}"]` );

        targetEl.prop( 'disabled', ( i, val ) => !val );
    },

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
