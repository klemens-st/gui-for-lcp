import MainModel from './gflcp-mainmodel.js';
import TaxTermsSubview from './gflcp-taxtermssubview.js';
import lcpCreateShortcode from './gflcp-shortcode.js';

const ModalContentView = wp.Backbone.View.extend({
    initialize() {
        this.model = new MainModel();
        // Get init data from the server
        this.model.getInit();

        // The 'change' event is fired on the model whenever state changes.
        this.listenTo(this.model, 'change:init', this.render);
        this.listenTo(this.model, 'change:taxonomies', this.renderSubviews);
    },

    template: wp.template( 'modal-content' ),

    events: {
        'click #load-terms': 'onTaxSelect',
        'submit #lcp-insert-form': 'insertShortcode',
        'change .lcp-swtich-checkbox': 'toggleFieldset',
        'change .lcp-categorypage, .lcp-currenttags': 'toggleCurrent',
        'change .category-checklist input, .excategory-checklist input': 'handleExcludes',
        'change .tag-checklist input, .extag-checklist input': 'handleExcludes',
        'change [name="ps-mode"], [name="pt-mode"]': 'toggleSelection'
    },

    render: function() {
        this.$el.html(this.template(this.model.get('init')));
        this.$('.lcp-datepicker').datepicker({
            dateFormat: 'yy/mm/dd'
        });
        this.$('#lcp-insert-form').tabs();
        // To avoid fetching categories html twice
        // we will copy the 'select' checklist and modify it to use
        // as 'exclude'
        this.$('.excategory-checklist input').attr('name', 'excat');
        // Do the same for tags
        this.$('.extag-checklist input').attr('name', 'extag');
        return this;
    },

    renderSubviews: function() {
        this.views.set('.taxonomy-terms', new TaxTermsSubview());
    },

    onTaxSelect: function() {
        const taxonomies = this.$('select[name="taxonomy"]').val();
        this.model.updateTaxonomies(taxonomies);
    },

    toggleFieldset: function(e) {
        const el = this.$(e.currentTarget);
        const checked = el.prop('checked');
        const targetEl = this.$('.' + el.attr('name'));

        if (true === checked) {
            targetEl.prop('disabled', false);
        } else {
            targetEl.prop('disabled', true);
        }
    },

    toggleCurrent: function(e) {
        const el = this.$(e.currentTarget);
        const value = el.val();
        const cssClass = el.attr('class');
        let target;

        if (false === el.prop('checked')) return null;

        if ('lcp-categorypage' === cssClass) target = '#lcp-cat-select';
        else if ('lcp-currenttags' === cssClass) target = '#lcp-tag-select';

        if ('1' === value) this.$(target).prop('disabled', true);
        else if ('0' === value) this.$(target).prop('disabled', false);
    },

    toggleSelection: function(e) {
        const el = this.$(e.currentTarget);
        const name = el.attr('name');

        let targetEl;

        if ('ps-mode' === name) targetEl = '#lcp-ps-select';
        else if ('pt-mode' === name) targetEl = '#lcp-pt-select';

        if (true === el.prop('checked') && 'select' === el.val()) {
            this.$(targetEl).prop('disabled', false);
        }
        else this.$(targetEl).prop('disabled', true);
    },

    handleExcludes: function(e) {
        const el = this.$(e.currentTarget);

        let targetName;

        switch (el.attr('name')) {
            case 'cat':
                targetName = 'excat';
                break;
            case 'excat':
                targetName = 'cat';
                break;
            case 'tag':
                targetName = 'extag';
                break;
            case 'extag':
                targetName = 'tag';
                break;
        }
        const targetEl = this.$(`[name="${targetName}"][value="${el.val()}"]`);

        if (true === el.prop('checked')) {
            targetEl.prop('disabled', true);
        } else {
            targetEl.prop('disabled', false);
        }

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
