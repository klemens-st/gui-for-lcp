jQuery(function($) {
	'use strict';
    
    $(document).ready(function(){
		
		$('.insert-lcp').click(lcpOpenMediaWindow);
	});

	function lcpOpenMediaWindow() {
        if (this.window === undefined) {
            
            // Create a modal view.
            this.window = new wp.media.view.Modal({
                // A controller object is expected, but let's just pass
                // a fake one to illustrate this proof of concept without
                // getting console errors.
                controller: { trigger: function() {} }
            });
            
            var ModalContentSubview = wp.Backbone.View.extend({
                template: wp.template( 'taxonomy-terms' ),
                
                render: loadTaxonomyTerms
            });

            var Subview = new ModalContentSubview();

            var self = this;
            this.window.on('select', function() {
				var first = self.window.state().get('selection').first().toJSON();
				wp.media.editor.insert('[myshortcode id="' + first.id + '"]');
			});
            
            let data = {
                'action': 'gflcp_setup',
                'security': ajax_object.nonce,
            };
            $.post(ajax_object.ajax_url, data, function(r) {
                // Create a modal content view.
                
                var ModalContentView = wp.Backbone.View.extend({
                    template: wp.template( 'modal-content' ),
                    
                    events: {
                        "click #load-terms": "loadTerms",
                        "submit #lcp-insert-form": "insertShortcode",
                        "change .lcp-swtich-checkbox": "toggleFieldset",
                        "change .lcp-categorypage, .lcp-currenttags": "toggleCurrent",
                        'change .tag, .extag, .cat, .excat': 'handleExcludes',
                        'change [name="ps-mode"], [name="pt-mode"]': 'toggleSelection'
                    },
                    
                    render: function() {
                        this.$el.html(this.template(JSON.parse(r)));
                        this.$('.lcp-datepicker').datepicker({
                            dateFormat: 'yy/mm/dd'
                        });
                        return this;
                    },
                    
                    loadTerms: function() {
                        this.views.set('.taxonomy-terms', new ModalContentSubview);
                    },
                    
                    toggleFieldset: function(e) {
                        const el = $(e.currentTarget);
                        const checked = el.prop('checked');
                        const targetEl = $('.' + el.attr('name'));
                        
                        if (true === checked) {
                            targetEl.prop('disabled', false);
                        } else {
                            targetEl.prop('disabled', true);
                        }
                    },
                    
                    toggleCurrent: function(e) {
                        const el = $(e.currentTarget);
                        const value = el.val();
                        const cssClass = el.attr('class');
                        let target;
                        
                        if (false === el.prop('checked')) return null;
                        
                        if ('lcp-categorypage' === cssClass) target = '#lcp-cat-select';
                        else if ('lcp-currenttags' === cssClass) target = '#lcp-tag-select';
                        
                        if ('1' === value) $(target).prop('disabled', true);
                        else if ('0' === value) $(target).prop('disabled', false);
                    },
                    
                    toggleSelection: function(e) {
                        const el = $(e.currentTarget);
                        const name = el.attr('name');
                        
                        let targetEl;
                        
                        if ('ps-mode' === name) targetEl = '#lcp-ps-select';
                        else if ('pt-mode' === name) targetEl = '#lcp-pt-select';
                        
                        if (true === el.prop('checked') && 'select' === el.val()) {
                            $(targetEl).prop('disabled', false);
                        }
                        else $(targetEl).prop('disabled', true);
                    },

                    handleExcludes: function(e) {
                        const el = $(e.currentTarget);
                        
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
                        const targetEl = $(`[name="${targetName}"][value="${el.val()}"]`);
                        
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
                    }
                });
                self.window.content( new ModalContentView );
            });
        }

        this.window.open();   
        return false;
	}
    
    function loadTaxonomyTerms() {
        const taxonomies = $('select[name="taxonomy"]').val();
        
        const data = {
            'action': 'gflcp_load_terms',
            'security': ajax_object.nonce,
            'taxonomies': taxonomies
        };
        const self = this;
        $.post(ajax_object.ajax_url, data, function(r) {
            self.$el.html(self.template(JSON.parse(r)));
            return self;
        });
    }
    
    function lcpGetCategories(FD) {
        if (!FD.has('lcp-categories')) return null;
        
        const catRel = (FD.has('catrel')) ? (FD.get('catrel')) : null;
        
        let output= []
        let ids;
        let categories;
        let exCategories;
        let childCat = (FD.has('child-cat')) ? (FD.get('child-cat')) : null;
        
        if ('0' === childCat) {
            output.push('child_categories="false"');
        }
            
        if (FD.has('categorypage') && '1' === FD.get('categorypage')) {
            output.push('categorypage="yes"');
            return output.join(' ');
        }
            
        categories = (FD.has('cat')) ? (FD.getAll('cat')) : [];
        exCategories = (FD.has('excat')) ? (FD.getAll('excat')): [];
        exCategories = _.map(exCategories, function(val) {return '-' + val;});
            
        if ('or' === catRel) {
            ids = categories.concat(exCategories).join(',');
        } else if ('and' === catRel) {
            const exCatSeparator = (_.isEmpty(categories)) ? ',' : '';
            
            categories = categories.join('+');
            exCategories = exCategories.join(exCatSeparator);
            ids = categories + exCategories;
        }
        if (!_.isEmpty(ids)) {
            output.push(`id="${ids}"`);
            return output.join(' ');
        } else return null;
    }
    
    function lcpGetTags(FD) {
        if (!FD.has('lcp-tags')) return null;
        
        const tagRel = (FD.has('tagrel')) ? (FD.get('tagrel')) : null;
        
        let output= []
        let tags;
        let exTags;
        
        if (FD.has('currenttags') && '1' === FD.get('currenttags')) {
            return 'currenttags="yes"';
        }
            
        tags = (FD.has('tag')) ? (FD.getAll('tag')) : [];
        exTags = (FD.has('extag')) ? (FD.getAll('extag')): [];
            
        if ('or' === tagRel) {
            tags = tags.join(',');
        } else if ('and' === tagRel) {
            tags = tags.join('+');
        }
        
        if (!_.isEmpty(tags)) output.push(`tags="${tags}"`);
        if (!_.isEmpty(exTags)) output.push(`exclude_tags="${exTags.join(',')}"`);
        
        if (!_.isEmpty(output)) {
            return output.join(' ');
        } else return null;
    }
    
    function lcpCreateShortcode(FD) {
        let parameters = [];
        
        // Categories 
        const categoryString = lcpGetCategories(FD);
        if (categoryString) parameters.push(categoryString);
        
        // Author
        if (FD.has('author')) {
            const author = FD.get('author');
            if ( ! _.isEmpty( author ) ) {
                parameters.push(`author_posts="${author}"`);
            }
            
        }
        
        // Tags
        const tagString = lcpGetTags(FD);
        if (tagString) parameters.push(tagString);
        
        // Custom taxonomies
        if (FD.has('lcp-taxonomies') && FD.has('taxonomy') && FD.has('taxrel')) {
            const taxonomies = FD.getAll('taxonomy');
            const taxRel = FD.get('taxrel');
            
            let taxonomy;
            let singleTaxTerms;
            let shortcode = '';
            
            if (1 === taxonomies.length) {
                const separator = ( 'and' === taxRel) ? ('+') : (',');
                
                taxonomy = taxonomies[0];
                singleTaxTerms = (FD.has(`${taxonomy}-term`)) ? (FD.getAll(`${taxonomy}-term`)) : null;
                
                if (_.isArray(singleTaxTerms)) {
                    shortcode = `taxonomy="${taxonomy}" terms="${singleTaxTerms.join(separator)}"`
                }
            } else if (taxonomies.length > 1) {
                let taxonomyQueries = []
                _.each(taxonomies, function(taxonomy) {
                    singleTaxTerms = (FD.has(`${taxonomy}-term`)) ? (FD.getAll(`${taxonomy}-term`)) : null;
                    
                    if (_.isArray(singleTaxTerms)) {
                    taxonomyQueries.push(`${taxonomy}:{${singleTaxTerms.join(',')}}`);
                    }
                });
                if (taxonomyQueries.length > 1) {
                    shortcode = `taxonomies_${taxRel}="${taxonomyQueries.join(';')}"`;
                }
            }
            parameters.push(shortcode);
        }
        
        // Starting with
        if (FD.has('starting-with')) {
            const startingWith = FD.get('starting-with');
            if ( ! _.isEmpty( startingWith ) ) {
                parameters.push(`starting_with="${startingWith}"`);
            }
            
        }
        
        // Date
        if (FD.has('month')) {
            const month = FD.get('month');
            if ( ! _.isEmpty( month ) ) {
                parameters.push(`monthnum="${month}"`);
            }
            
        }
        if (FD.has('year')) {
            const year = FD.get('year');
            if ( ! _.isEmpty( year ) ) {
                parameters.push(`year="${year}"`);
            }
            
        }
        
        // Date ranges
        if (FD.has('after')) {
            const after = FD.get('after');
            if ( ! _.isEmpty( after ) ) {
                parameters.push(`after="${after}"`);
            }
            
        }
        if (FD.has('before')) {
            const before = FD.get('before');
            if ( ! _.isEmpty( before ) ) {
                parameters.push(`before="${before}"`);
            }
            
        }
        
        // Search
        if (FD.has('search')) {
            const search = FD.get('search');
            if ( ! _.isEmpty( search ) ) {
                parameters.push(`search="${search}"`);
            }
            
        }
        
        // Exclude posts
        if (FD.has('lcp-exclude-posts')) {
            let exCurPost;
            let exPost;
            let separator;
            
            if (FD.has('excurpost') && '1' === FD.get('excurpost')) {
                exCurPost = 'this';
            } else {
                exCurPost = '';
            }
            exPost = FD.has('expost') ? FD.get('expost') : '';
            exPost = exPost.trim();
            
            separator = (exPost && exCurPost) ? (',') : '';
            
            if (!_.isEmpty(exCurPost) || !_.isEmpty(exPost)) {
                parameters.push(`excludeposts="${exCurPost}${separator}${exPost}"`);
            }
        }
        
        // Offset
        if (FD.has('offset')) {
            const offset = FD.get('offset');
            if ( ! _.isEmpty( offset ) ) {
                parameters.push(`offset="${offset}"`);
            }
            
        }
        
        // Post type
        if (FD.has('post-type-mode')) {
            const postTypeMode = FD.get('post-type-mode');
            let postType = [];
            
            if ('default' === postTypeMode)
                ; // Empty statement
            else if ('any' === postTypeMode) {
                postType = postTypeMode;
            } else if ('select' === postTypeMode) {
                _.each(FD.getAll('post-type'), function(value) {
                    postType.push(value);
                });
                postType = postType.join(',');
            }
            if (!_.isEmpty(postType)) parameters.push(`post_type="${postType}"`);
        }
        
        // Post status
        if (FD.has('post-status-mode')) {
            const postStatusMode = FD.get('post-status-mode');
            let postStatus = [];
            
            if ('default' === postStatusMode)
                ; // Empty statement
            else if ('any' === postStatusMode) {
                postStatus = postStatusMode;
            } else if ('select' === postStatusMode) {
                _.each(FD.getAll('post-status'), function(value) {
                    postStatus.push(value);
                });
                postStatus = postStatus.join(',');
            }
            if (!_.isEmpty(postStatus)) parameters.push(`post_status="${postStatus}"`);
        }
        
        // Show protected
        if (FD.has('show-protected')) {
            const showProtected = FD.get('show-protected');
            if ('1' === showProtected) {
                parameters.push('show_protected="yes"');
            }
            
        }
        
        // Parent post
        if (FD.has('parent-post')) {
            const parentPost = FD.get('parent-post');
            if (!_.isEmpty(parentPost)) {
                parameters.push(`post_parent="${parentPost}"`);
            }
            
        }
        
        // Custom fields
        if (FD.has('lcp-custom-fields')) {
            const customfieldName = FD.get('customfield-name');
            const customfieldValue = FD.get('customfield-value');
            
            if (!_.isEmpty(customfieldName) && !_.isEmpty(customfieldValue)) {
                parameters.push(`customfield_name="${customfieldName}" customfield_value="${customfieldValue}"`);
            }
        }
        
        
        return '[catlist ' + parameters.join(' ') + ']';
    }
});

// TODO:
// * custom taxonomies - multiple taxonomies handling, debug
// * optimize shortcode creation with helper functions
