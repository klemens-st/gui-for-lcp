/* exported TaxTermsSubview */
const TaxTermsSubview = wp.Backbone.View.extend({
    template: wp.template( 'taxonomy-terms' ),

    initialize() {
        this.model = mainModel;
    },

    render: function() {
        this.$el.html(this.template(this.model.get('taxonomies')));
        return this;
    }
});