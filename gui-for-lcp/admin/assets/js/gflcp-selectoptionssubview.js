import TaxTermsSubview from './gflcp-taxtermssubview.js';

const SelectOptionsSubview = wp.Backbone.View.extend({
    template: wp.template( 'select-options' ),

    events: {
        'change .gflcp-swtich-checkbox': 'toggleFieldset',
        'change .gflcp-categorypage, .gflcp-currenttags': 'toggleCurrent',
        'change .category-checklist input, .excategory-checklist input': 'handleExcludes',
        'change .tag-checklist input, .extag-checklist input': 'handleExcludes',
        'change [name="ps-mode"], [name="pt-mode"]': 'toggleSelection',
        'click #load-terms': 'onTaxSelect'
    },

    render: function() {
        this.$el.html(this.template(this.model.get('data')));
        this.views.set('#gflcp-taxonomy-terms', new TaxTermsSubview({
            // Use parent's model in the subview
            model: this.model
        }));

        this.$('.gflcp-datepicker').datepicker({
            dateFormat: 'yy/mm/dd'
        });

        this.$('#gflcp-select-accordion').accordion({
            heightStyle: 'content'
        });
        // To avoid fetching categories html twice
        // we will copy the 'select' checklist and modify it to use
        // as 'exclude'
        this.$('.excategory-checklist input').attr('name', 'excat');
        // Do the same for tags
        this.$('.extag-checklist input').attr('name', 'extag');
        return this;
    },

    onTaxSelect: function() {
        const self = this;
        let taxonomies = [];
        this.$('input[name="taxonomy"]:checked').each(function() {
            taxonomies.push(self.$(this).val());
        });
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
        const el = this.$(e.target);
        const cssClass = el.attr('class');
        let targetEl;

        switch (cssClass) {
            case 'gflcp-categorypage':
                targetEl = '.gflcp-cat-select';
                break;
            case 'gflcp-currenttags':
                targetEl = '.gflcp-tag-select';
                break;
        }

        this.$(targetEl).prop('disabled', el.prop('checked'));
    },

    toggleSelection: function(e) {
        const el = this.$(e.currentTarget);
        const name = el.attr('name');

        let targetEl;

        if ('ps-mode' === name) targetEl = '#gflcp-ps-select';
        else if ('pt-mode' === name) targetEl = '#gflcp-pt-select';

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
});

export default SelectOptionsSubview;
