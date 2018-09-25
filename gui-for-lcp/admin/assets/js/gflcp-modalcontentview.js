import MainModel from './gflcp-mainmodel.js';
import SelectOptionsSubview from './gflcp-selectoptionssubview.js';
import DisplayOptionsSubview from './gflcp-displayoptionssubview.js';
import lcpCreateShortcode from './gflcp-shortcode.js';

const ModalContentView = wp.Backbone.View.extend({
    initialize() {
        this.model = new MainModel();

        // The 'change' event is fired on the model whenever state changes.
        this.listenTo(this.model, 'change:hasData', this.render);
    },

    template: wp.template( 'modal-content' ),

    events: {
        'submit #lcp-insert-form': 'insertShortcode',
        'click .gflcp-footer button': 'checkForm',
        'reset #lcp-insert-form': 'render'
    },

    checkForm: function() {
        const invalid = this.$(':invalid');

        // Don't manipulate any panels if the form is ok
        if (0 === invalid.length) return;

        // Get a zero-based index of a tab.
        const tab = invalid.last().parents('.ui-tabs-panel').prevAll('div').length;

        // Get a zero-based index of a panel.
        const panel = invalid.last().parents('.ui-accordion-content').prevAll('div').length;

        // Open the tab
        this.$('#gflcp-tabs').tabs(
            'option',
            'active',
            tab
        );

        // Open the panel
        this.$('#gflcp-select-accordion').accordion(
            'option',
            'active',
            panel
        );
        // Re-trigger native validation
        setTimeout(() => this.$('.hidden-submit-btn').click(), 500);
    },

    render: function() {
        this.$el.html(this.template({hasData: this.model.get('hasData')}));
        this.views.set('#gflcp-display-options', new DisplayOptionsSubview());
        this.views.set('#gflcp-select-options', new SelectOptionsSubview({
            // Use parent's model in the subview
            model: this.model
        }));

        this.$('#gflcp-tabs').tabs();

        return this;
    },

    insertShortcode: function(e) {
        e.preventDefault();
        const FD = new FormData(e.currentTarget);
        wp.media.editor.insert(lcpCreateShortcode(FD));
        // This view is a subview of wp.media.view.Modal
        // so in order to close the modal on shortcode insertion
        // we can use the reference at this.views.parent
        this.views.parent.close();
    }
});

export default ModalContentView;
