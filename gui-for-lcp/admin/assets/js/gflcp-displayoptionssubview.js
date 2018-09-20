const DisplayOptionsSubview = wp.Backbone.View.extend({
    template: wp.template( 'display-options' ),

    events: {
        'change .gflcp-display-checkboxes input': 'toggleFieldset'
    },

    toggleFieldset: function(e) {
        const el = this.$(e.target);
        const checked = el.prop('checked');
        const targetEl = this.$('.gflcp-' + el.attr('name'));

        if (true === checked) {
            targetEl.prop('disabled', false);
        } else {
            targetEl.prop('disabled', true);
        }
    },

    render: function() {
        this.$el.html(this.template());
        this.accordion = this.$('.gflcp-display-accordion');
        this.accordion.accordion({
            heightStyle: 'content'
        });

        return this;
    }
});

export default DisplayOptionsSubview;
