import MainModel from './gflcp-mainmodel.js';
import SelectOptionsSubview from './gflcp-selectoptionssubview.js';
import DisplayOptionsSubview from './gflcp-displayoptionssubview.js';
import lcpCreateShortcode from './gflcp-shortcode.js';

const ModalContentView = wp.Backbone.View.extend({
    initialize() {
        this.model = new MainModel();

        this.model.getData();

        // The 'change' event is fired on the model whenever state changes.
        this.listenTo( this.model, 'change:hasData', this.render );
        this.listenTo( this.model, 'change:errored', this.render );
    },

    template: wp.template( 'modal-content' ),

    events: {
        'submit #gflcp-form': 'insertShortcode',
        'click .gflcp-footer button': 'checkForm',
        'reset #gflcp-form': 'render',
        'click .gflcp-alert button': 'onTryAgain',
    },

    onTryAgain() {
        this.model.set( 'errored', false );
        this.model.getData();
    },

    checkForm: function() {
        const invalid = this.$( ':invalid' );

        // Don't manipulate any panels if the form is ok
        if ( 0 === invalid.length ) {
            return;
        }

        // Get a zero-based index of a tab.
        const tab = invalid.last()
            .parents( '.ui-tabs-panel' )
            .prevAll( 'div' )
            .length;

        // Get a zero-based index of a panel.
        const panel = invalid.last()
            .parents( '.ui-accordion-content' )
            .prevAll( 'div' )
            .length;

        // Open the tab
        this.$( '#gflcp-tabs' ).tabs(
            'option',
            'active',
            tab
        );

        // Open the panel
        this.$( '#gflcp-select-accordion' ).accordion(
            'option',
            'active',
            panel
        );
        // Re-trigger native validation
        setTimeout( () => this.$( '.gflcp-hidden-btn' ).click(), 500 );
    },

    render: function() {
        this.$el.html( this.template( _.clone( this.model.attributes ) ) );
        this.views.set( '#gflcp-display-options', new DisplayOptionsSubview() );
        this.views.set( '#gflcp-select-options', new SelectOptionsSubview({
            // Use parent's model in the subview
            model: this.model
        }));

        this.$( '#gflcp-tabs' ).tabs();

        return this;
    },

    insertShortcode( e ) {
        e.preventDefault();
        const FD = new FormData( e.currentTarget );
        wp.media.editor.insert( lcpCreateShortcode( FD ) );
        // This view is a subview of wp.media.view.Modal
        // so in order to close the modal on shortcode insertion
        // we can use the reference at this.views.parent
        this.views.parent.close();
    }
});

export default ModalContentView;
