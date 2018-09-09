const TaxTermsSubview = wp.Backbone.View.extend({
    template: wp.template( 'taxonomy-terms' ),

    render: function() {
        this.$el.html(this.template(
            // Use the parent view's model
            this.views.parent.model.get('taxonomies')
        ));
        return this;
    }
});

export default TaxTermsSubview;
