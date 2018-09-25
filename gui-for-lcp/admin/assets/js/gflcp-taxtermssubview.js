const TaxTermsSubview = wp.Backbone.View.extend({
    initialize() {
        this.listenTo(this.model, 'change:taxonomies', this.render);
    },

    template: wp.template( 'taxonomy-terms' ),

    render: function() {
        this.$el.html(this.template(this.model.get('taxonomies')));
        return this;
    }
});

export default TaxTermsSubview;
