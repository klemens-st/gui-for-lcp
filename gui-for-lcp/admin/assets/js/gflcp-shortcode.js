const shortcodeHelpers = [
    function lcpGetCategories(FD) {
        if (!FD.has('lcp-categories')) return [];

        const catRel = (FD.has('catrel')) ? (FD.get('catrel')) : null;

        let output= [];
        let ids;
        let categories;
        let exCategories;
        let childCat = (FD.has('child-cat')) ? (FD.get('child-cat')) : null;

        if ('0' === childCat) {
            output.push('child_categories="false"');
        }

        if (FD.has('categorypage') && '1' === FD.get('categorypage')) {
            output.push('categorypage="yes"');
            return output;
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
            return output;
        } else return [];
    },

    function lcpGetTags(FD) {
        if (!FD.has('lcp-tags')) return [];

        const tagRel = (FD.has('tagrel')) ? (FD.get('tagrel')) : null;

        let output= [];
        let tags;
        let exTags;

        if (FD.has('currenttags') && '1' === FD.get('currenttags')) {
            return ['currenttags="yes"'];
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
            return output;
        } else return [];
    },

    function lcpGetAuthor(FD) {
        if (!FD.has('author')) return [];

        const author = FD.get('author');
        if ( ! _.isEmpty( author ) ) {
            return [`author_posts="${author}"`];
        } else return [];
    },

    function lcpGetCustomTaxonomies(FD) {
        if (!FD.has('lcp-taxonomies') || !FD.has('taxonomy') || !FD.has('taxrel')) {
            return [];
        }
        const taxonomies = FD.getAll('taxonomy');
        const taxRel = FD.get('taxrel');

        let taxonomy;
        let singleTaxTerms;
        let output = [];

        if (1 === taxonomies.length) {
            const separator = ( 'and' === taxRel) ? ('+') : (',');

            taxonomy = taxonomies[0];
            singleTaxTerms = (FD.has(`${taxonomy}-term`)) ? (FD.getAll(`${taxonomy}-term`)) : null;

            if (_.isArray(singleTaxTerms)) {
                output.push(`taxonomy="${taxonomy}" terms="${singleTaxTerms.join(separator)}"`);
            }
        } else if (taxonomies.length > 1) {
            let taxonomyQueries = [];
            _.each(taxonomies, function(taxonomy) {
                singleTaxTerms = (FD.has(`${taxonomy}-term`)) ? (FD.getAll(`${taxonomy}-term`)) : null;

                if (_.isArray(singleTaxTerms)) {
                    taxonomyQueries.push(`${taxonomy}:{${singleTaxTerms.join(',')}}`);
                }
            });
            if (taxonomyQueries.length > 1) {
                output.push(`taxonomies_${taxRel}="${taxonomyQueries.join(';')}"`);
            }
        }
        return output;
    },

    function lcpGetStartingWith(FD) {
        if (!FD.has('starting-with')) return [];

        const startingWith = FD.get('starting-with');
        let output = [];

        if ( ! _.isEmpty( startingWith ) ) {
            output.push(`starting_with="${startingWith}"`);
        }
        return output;
    },

    function lcpGetDate(FD) {
        let output = [];

        if (FD.has('month')) {
            const month = FD.get('month');
            if ( ! _.isEmpty( month ) ) {
                output.push(`monthnum="${month}"`);
            }
        }

        if (FD.has('year')) {
            const year = FD.get('year');
            if ( ! _.isEmpty( year ) ) {
                output.push(`year="${year}"`);
            }
        }
        return output;
    },

    function lcpGetDateRanges(FD) {
        let output = [];

        if (FD.has('after')) {
            const after = FD.get('after');
            if ( ! _.isEmpty( after ) ) {
                output.push(`after="${after}"`);
            }
        }

        if (FD.has('before')) {
            const before = FD.get('before');
            if ( ! _.isEmpty( before ) ) {
                output.push(`before="${before}"`);
            }
        }
        return output;
    },

    function lcpGetSearch(FD) {
        let output = [];

        if (FD.has('search')) {
            const search = FD.get('search');
            if ( ! _.isEmpty( search ) ) {
                output.push(`search="${search}"`);
            }
        }
        return output;
    },

    function lcpGetExcludedPosts(FD) {
        if (!FD.has('lcp-exclude-posts')) return [];

        let exCurPost;
        let exPost;
        let separator;
        let output = [];

        if (FD.has('excurpost') && '1' === FD.get('excurpost')) {
            exCurPost = 'this';
        } else {
            exCurPost = '';
        }
        exPost = FD.has('expost') ? FD.get('expost') : '';
        exPost = exPost.trim();

        separator = (exPost && exCurPost) ? (',') : '';

        if (!_.isEmpty(exCurPost) || !_.isEmpty(exPost)) {
            output.push(`excludeposts="${exCurPost}${separator}${exPost}"`);
        }
        return output;
    },

    function lcpGetOffset(FD) {
        let output = [];

        if (FD.has('offset')) {
            const offset = FD.get('offset');
            if ( ! _.isEmpty( offset ) ) {
                output.push(`offset="${offset}"`);
            }
        }
        return output;
    },

    function lcpGetPostType(FD) {
        if (!FD.has('pt-mode')) return [];

        const postTypeMode = FD.get('pt-mode');
        let postType = [];
        let output = [];

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

        if (!_.isEmpty(postType)) {
            output.push(`post_type="${postType}"`);
        }
        return output;
    },

    function lcpGetPostStatus(FD) {
        if (!FD.has('ps-mode')) return [];

        const postStatusMode = FD.get('ps-mode');
        let postStatus = [];
        let output = [];

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

        if (!_.isEmpty(postStatus)) {
            output.push(`post_status="${postStatus}"`);
        }
        return output;
    },

    function lcpGetShowProtected(FD) {
        let output = [];

        if (FD.has('show-protected')) {
            const showProtected = FD.get('show-protected');
            if ('1' === showProtected) {
                output.push('show_protected="yes"');
            }
        }
        return output;
    },

    function lcpGetParentPost(FD) {
        let output = [];

        if (FD.has('parent-post')) {
            const parentPost = FD.get('parent-post');
            if (!_.isEmpty(parentPost)) {
                output.push(`post_parent="${parentPost}"`);
            }
        }
        return output;
    },

    function lcpGetCustomFields(FD) {
        if (!FD.has('lcp-custom-fields')) return [];

        const customfieldName = FD.get('customfield-name');
        const customfieldValue = FD.get('customfield-value');
        let output = [];

        if (!_.isEmpty(customfieldName) && !_.isEmpty(customfieldValue)) {
            output.push(
                `customfield_name="${customfieldName}" customfield_value="${customfieldValue}"`
            );
        }
        return output;
    },

    function getDisplayAuthor(FD) {
        if (FD.has('display-author')) {
            return [
                'author="yes"',
                ...getTagsAndClasses(FD, 'display-author', 'author')
            ];
        } else {
            return [];
        }
    },

    function getCommets(FD) {
        if (FD.has('comments')) {
            return [
                'comments="yes"',
                ...getTagsAndClasses(FD, 'comments', 'comments')
            ];
        } else {
            return [];
        }
    },

    function getContent(FD) {
        if (FD.has('content')) {
            const mode = FD.has('content-full') ? 'full' : 'yes';

            return [
                `content="${mode}"`,
                ...getTagsAndClasses(FD, 'content', 'content')
            ];
        } else {
            return [];
        }
    },

    function getCustomfieldDisplay(FD) {
        if (! FD.has('customfield')) {
            return [];
        }
        const cfDisplay =           FD.get('customfield-display');
        const cfDisplaySeparately = FD.has('customfield-display-separately');
        const cfDisplayGlue =       FD.get('customfield-display-glue');
        const cfDisplayName =       FD.has('customfield-display-name');
        const cfDisplayNameGlue =   FD.get('customfield-display-name-glue');

        let output = [`customfield_display="${cfDisplay}"`];

        if (cfDisplaySeparately) {
            output.push('customfield_display_separately="yes"');
        } else {
            if (! _.isEmpty(cfDisplayGlue)) {
                output.push(`customfield_display_glue="${cfDisplayGlue}"`);
            }
        }

        if (false === cfDisplayName) {
            output.push('customfield_display_name="no"');
        } else {
            if (! _.isEmpty(cfDisplayNameGlue)) {
                output.push(`customfield_display_name_glue="${cfDisplayNameGlue}"`);
            }
        }

        return [
            ...output,
            ...getTagsAndClasses(FD, 'customfield', 'customfield')
        ];
    },

    function getDisplayDate(FD) {
        if (FD.has('display-date')) {
            return [
                'date="yes"',
                ...getTagsAndClasses(FD, 'display-date', 'date')
            ];
        } else {
            return [];
        }
    },

    function getDateModified(FD) {
        if (FD.has('date-modified')) {
            return [
                'date_modified="yes"',
                ...getTagsAndClasses(FD, 'date-modified', 'date_modified')
            ];
        } else {
            return [];
        }
    },

    function getExcerpt(FD) {
        if (! FD.has('excerpt')) {
            return [];
        }
        const mode = FD.has('excerpt-full') ? 'full' : 'yes';

        let output = [`excerpt="${mode}"`];

        if ('yes' === mode) {
            const excerptOverwrite = FD.has('excerpt-overwrite');
            const excerptStrip     = FD.has('excerpt-strip');
            const excerptSize      = FD.get('excerpt-size');

            if (true === excerptOverwrite) {
                output.push('excerpt_overwrite="yes"');
            }
            if (true === excerptStrip) {
                output.push('excerpt_strip="yes"');
            }
            if (! _.isEmpty(excerptSize)) {
                output.push(`excerpt_size="${excerptSize}"`);
            }
        }

        return [
            ...output,
            ...getTagsAndClasses(FD, 'excerpt', 'excerpt')
        ];
    },

    function getDisplayId(FD) {
        if (FD.has('posts-id')) {
            return ['display_id="yes"'];
        } else {
            return [];
        }
    },

    function getPostSuffix(FD) {
        if (FD.has('suffix')) {
            const postSuffix = FD.get('post-suffix');

            if (! _.isEmpty(postSuffix)) {
                return [`post_suffix="${postSuffix}"`];
            } else {
                return [];
            }
        }
    },

    function getPostsMorelink(FD) {
        if (FD.has('posts-morelink')) {
            return [
                'posts_morelink="yes"',
                ...getTagsAndClasses(FD, 'posts-morelink', 'posts_morelink')
            ];
        } else {
            return [];
        }
    },

    function getTagsAsClass(FD) {
        return (FD.has('tags-as-class')) ? ['tags_as_class="yes"'] : [];
    },

    function getTitle(FD) {
        if (FD.has('post-title')) {
            const titleLimit = FD.get('title-limit');
            const linkTitles = FD.has('link-titles');

            let output = [];

            if (! linkTitles) {
                output.push('link_titles="false"');
            }

            if (! _.isEmpty(titleLimit)) {
                output.push(`title_limit=${titleLimit}`);
            }

            return output;
        } else {
            return ['no_post_titles="yes"'];
        }
    },

    function getThumbnail(FD) {
        if (! FD.has('thumbnail')) {
            return [];
        }
        const forceThumbnail = FD.has('force-thumbnail');
        const thumbnailSize  = FD.get('thumbnail-size');
        const thumbnailClass = FD.get('thumbnail-class');

        let output = ['thumbnail="yes"'];

        if (forceThumbnail) {
            output.push('force_thumbnail="yes"');
        }
        if (! _.isEmpty(thumbnailSize)) {
            output.push(`thumbnail_size="${thumbnailSize}"`);
        }
        if (! _.isEmpty(thumbnailClass)) {
            output.push(`thumbnail_class="${thumbnailClass}"`);
        }

        return output;
    },

    function getConditionalTitle(FD) {
        if (FD.has('show-conditional-title')) {
            const conditionalTitle = FD.get('conditional-title');

            return [
                `conditional_title="${conditionalTitle}"`,
                ...getTagsAndClasses(FD, 'conditional-title', 'conditional_title')
            ];
        } else {
            return [];
        }
    },

    function getCategoryTitle(FD) {
        if (FD.has('category-title')) {
            const mode = FD.has('catlink') ? 'catlink' : 'catname';
            const categoryCount = FD.has('category-count');

            let output = [`${mode}="yes"`];
            if (categoryCount) {
                output.push('category_count="yes"');
            }

            return [
                ...output,
                ...getTagsAndClasses(FD, 'catlink', 'catlink')
            ];
        } else {
            return [];
        }
    },
];

function getTagsAndClasses(FD, name, shortcodeParam) {

    let output = [];
    const tag = FD.get(`${name}-tag`);
    const className = FD.get(`${name}-class`);

    if (! _.isEmpty(tag)) {
        output.push(`${shortcodeParam}_tag="${tag}"`);
    }
    if (! _.isEmpty(className)) {
        output.push(`${shortcodeParam}_class="${className}"`);
    }

    return output;
}

function lcpCreateShortcode(FD) {
    // This will gather helper functions output.
    let parameters = [];

    _.each(shortcodeHelpers, (func) => (
        parameters = parameters.concat(func(FD))
    ));

    return '[catlist ' + parameters.join(' ') + ']';
}

export default lcpCreateShortcode;
