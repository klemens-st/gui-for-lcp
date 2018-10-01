/**
 * @file   This file contains shortcode building functions.
 * @module createShortcode
 * @author Klemens Starybrat.
 * @since  1.0.0
 */

/**
 * Contains shortcode building methods only. Each method corresponds with
 * a specific LCP functionality supported by this plugin.
 *
 * @since 1.0.0
 * @protected
 * @namespace shortcodeHelpers
 *
 * @type {Object}
 */
const shortcodeHelpers = {
    getCategories( FD ) {
        if ( ! FD.has( 'gflcp-categories' ) ) {
            return [];
        }

        const catRel = FD.get( 'catrel' );

        let output= [];
        let ids;
        let categories;
        let exCategories;

        if ( '0' === FD.get( 'child-cat' ) ) {
            output.push( 'child_categories="false"' );
        }

        if ( FD.has( 'categorypage' ) ) {
            output.push( 'categorypage="yes"' );
            return output;
        }

        categories = FD.getAll( 'cat' );
        exCategories = FD.getAll( 'excat' );
        exCategories = _.map( exCategories, ( val ) => '-' + val );

        if ( 'or' === catRel ) {
            ids = categories.concat( exCategories ).join( ',' );
        } else if ( 'and' === catRel ) {
            const exCatSeparator = ( _.isEmpty( categories ) ) ? ',' : '';

            ids = categories.join( '+' ) + exCategories.join( exCatSeparator );
        }

        if ( ! _.isEmpty( ids ) ) {
            output.push( `id="${ids}"` );
            return output;
        } else {
            return [];
        }
    },

    getTags( FD ) {
        if ( ! FD.has( 'gflcp-tags' ) ) {
            return [];
        }

        const tagRel = FD.get( 'tagrel' );

        let output= [];
        let tags;
        let exTags;

        if ( FD.has( 'currenttags' ) ) {
            return [ 'currenttags="yes"' ];
        }

        tags = FD.getAll( 'tag' );
        exTags = FD.getAll( 'extag' );

        if ( 'or' === tagRel ) {
            tags = tags.join( ',' );
        } else if ( 'and' === tagRel ) {
            tags = tags.join( '+' );
        }

        if ( ! _.isEmpty( tags ) ) {
            output.push( `tags="${tags}"` );
        }
        if ( ! _.isEmpty( exTags ) ) {
            output.push( `exclude_tags="${exTags.join(',')}"` );
        }

        return output;
    },

    getAuthor( FD ) {
        return getSimpleParam( FD, 'author', 'author_posts' );
    },

    getCustomTaxonomies( FD ) {
        const taxonomies = FD.getAll( 'taxonomy' );
        const taxRel = FD.get( 'taxrel' );

        if ( _.isEmpty( taxonomies ) ) {
            return [];
        }

        let singleTaxTerms;
        let output = [];

        const separator = ( 'and' === taxRel ) ? '+' : ',';
        let taxonomyQueries = [];

        _.each( taxonomies, ( taxonomy ) => {
            singleTaxTerms = FD.getAll( `${taxonomy}-term` );

            if ( ! _.isEmpty( singleTaxTerms ) ) {
                /*
                 * There is a different syntax when using more than one
                 * taxonomy.
                 */
                if ( 1 === taxonomies.length) {
                    output.push(
                        `taxonomy="${taxonomy}"`,
                        `terms="${singleTaxTerms.join( separator )}"`
                    );
                } else {
                    taxonomyQueries.push(
                        `${taxonomy}:{${singleTaxTerms.join( ',' )}}`
                    );
                }
            }
        } );
        if ( ! _.isEmpty( taxonomyQueries ) ) {
            output.push(
                `taxonomies_${taxRel}="${taxonomyQueries.join( ';' )}"`
            );
        }
        return output;
    },

    getStartingWith( FD ) {
        return getSimpleParam( FD, 'starting-with', 'starting_with');
    },

    getDate( FD ) {
        return [
            ...getSimpleParam( FD, 'month', 'monthnum' ),
            ...getSimpleParam( FD, 'year', 'year' )
        ];
    },

    getDateRanges( FD ) {
        return [
            ...getSimpleParam( FD, 'after', 'after' ),
            ...getSimpleParam( FD, 'before', 'before' )
        ];
    },

    getSearch( FD ) {
        return getSimpleParam( FD, 'search', 'search' );
    },

    getExcludedPosts( FD ) {
        let excludePosts = [];
        let output = [];
        let exPost = FD.get( 'expost' );

        if ( FD.has( 'excurpost' ) ) {
            excludePosts.push( 'this' );
        }

        if ( ! _.isEmpty( exPost ) ) {
            excludePosts.push( exPost.trim() );
        }

        if ( ! _.isEmpty( excludePosts ) ) {
            output.push( `excludeposts="${excludePosts.join( ',' )}"` );
        }
        return output;
    },

    getOffset( FD ) {
        return getSimpleParam( FD, 'offset', 'offset' );
    },

    getPostType( FD ) {
        return typesStatusesHelper( FD, 'pt', 'post-type', 'post_type' );
    },

    getPostStatus(FD) {
        return typesStatusesHelper( FD, 'ps', 'post-status', 'post_status' );
    },

    getShowProtected( FD ) {
        return getCheckboxParam( FD, 'show-protected', 'show_protected' );
    },

    getParentPost( FD ) {
        return getSimpleParam( FD, 'parent-post', 'post_parent' );
    },

    getCustomFields( FD ) {
        let output = [];

        output = output.concat(
            getSimpleParam( FD, 'customfield-name', 'customfield_name' )
        );
        output = output.concat(
            getSimpleParam( FD, 'customfield-value', 'customfield_value' )
        );
        // Checks if both name and value are specified.
        if ( 2 === output.length ) {
            return output;
        } else {
            return [];
        }
    },

    getDisplayAuthor( FD ) {
        return getCheckboxParam( FD, 'display-author', 'author', true );
    },

    getCommets( FD ) {
        return getCheckboxParam( FD, 'comments', 'comments', true );
    },

    getContent( FD ) {
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

    getCustomfieldDisplay( FD ) {
        if ( ! FD.has('customfield' ) ) {
            return [];
        }

        const cfDisplay =           FD.get( 'customfield-display' );
        const cfDisplaySeparately = FD.has( 'customfield-display-separately' );
        const cfDisplayGlue =       FD.get( 'customfield-display-glue' );
        const cfDisplayName =       FD.has( 'customfield-display-name' );
        const cfDisplayNameGlue =   FD.get( 'customfield-display-name-glue' );

        let output = [ `customfield_display="${cfDisplay}"` ];

        if ( cfDisplaySeparately ) {
            output.push( 'customfield_display_separately="yes"' );
        } else {
            if ( ! _.isEmpty( cfDisplayGlue ) ) {
                output.push( `customfield_display_glue="${cfDisplayGlue}"` );
            }
        }

        if ( ! cfDisplayName ) {
            output.push( 'customfield_display_name="no"' );
        } else {
            if ( ! _.isEmpty( cfDisplayNameGlue ) ) {
                output.push(
                    `customfield_display_name_glue="${cfDisplayNameGlue}"`
                );
            }
        }

        return [
            ...output,
            ...getTagsAndClasses( FD, 'customfield', 'customfield' )
        ];
    },

    getDisplayDate( FD ) {
        return getCheckboxParam( FD, 'display-date', 'date', true );
    },

    getDateModified( FD ) {
        return getCheckboxParam( FD, 'date-modified', 'date_modified', true );
    },

    getExcerpt( FD ) {
        if (! FD.has( 'excerpt' ) ) {
            return [];
        }
        const mode = FD.has( 'excerpt-full' ) ? 'full' : 'yes';

        let output = [ `excerpt="${mode}"` ];

        if ( 'yes' === mode ) {
            const excerptOverwrite = FD.has( 'excerpt-overwrite' );
            const excerptStrip     = FD.has( 'excerpt-strip' );
            const excerptSize      = FD.get( 'excerpt-size' );

            if ( excerptOverwrite ) {
                output.push( 'excerpt_overwrite="yes"' );
            }
            if ( excerptStrip ) {
                output.push( 'excerpt_strip="yes"' );
            }
            if ( ! _.isEmpty( excerptSize ) ) {
                output.push( `excerpt_size="${excerptSize}"` );
            }
        }

        return [
            ...output,
            ...getTagsAndClasses( FD, 'excerpt', 'excerpt' )
        ];
    },

    getDisplayId( FD ) {
        return getCheckboxParam( FD, 'posts-id', 'display_id' );
    },

    getPostSuffix( FD ) {
        return getSimpleParam( FD, 'suffix', 'post_suffix' );
    },

    getPostsMorelink( FD ) {
        return getCheckboxParam( FD, 'posts-morelink', 'posts_morelink', true );
    },

    getTagsAsClass( FD ) {
        return getCheckboxParam( FD, 'tags-as-class', 'tags_as_class' );
    },

    getTitle( FD ) {
        if ( FD.has( 'post-title' ) ) {
            const titleLimit = getSimpleParam( FD, 'title-limit', 'title_limit' );
            const linkTitles = FD.has( 'link-titles' );

            let output = [];

            if ( ! linkTitles ) {
                output.push( 'link_titles="false"' );
            }

            output.push( ...titleLimit );

            return output;
        } else {
            return [ 'no_post_titles="yes"' ];
        }
    },

    getThumbnail( FD ) {
        if ( ! FD.has( 'thumbnail' ) ) {
            return [];
        }

        let output = [ 'thumbnail="yes"' ];

        output.push(
            ...getCheckboxParam( FD, 'force-thumbnail', 'force_thumbnail' )
        );

        output.push(
            ...getSimpleParam( FD, 'thumbnail-size', 'thumbnail_size' )
        );

        output.push(
            ...getSimpleParam( FD, 'thumbnail-class', 'thumbnail_class' )
        );

        return output;
    },

    getConditionalTitle( FD ) {
        return getSimpleParam( FD, 'conditional-title', 'conditional_title', true );
    },

    getCategoryTitle( FD ) {
        if ( FD.has( 'category-title' ) ) {
            const mode = FD.has( 'catlink' ) ? 'catlink' : 'catname';
            const categoryCount = FD.has( 'category-count' );

            let output = [ `${mode}="yes"` ];
            if ( categoryCount ) {
                output.push( 'category_count="yes"' );
            }

            return [
                ...output,
                ...getTagsAndClasses( FD, 'catlink', 'catlink' )
            ];
        } else {
            return [];
        }
    },

    getCategoryDescription( FD ) {
        return getCheckboxParam(
            FD,
            'category-description',
            'category_description'
        );
    },

    getMorelink( FD ) {
        return getCheckboxParam( FD, 'morelink', 'morelink', true );
    },

    getWrapperClass( FD ) {
        return getSimpleParam( FD, 'wrapper-class', 'class' );
    },

    getPagination( FD ) {
        return getCheckboxParam( FD, 'pagination', 'pagination' );
    },

    getNumberposts( FD ) {
        return getSimpleParam( FD, 'numberposts', 'numberposts' );
    },

    getOrderBy( FD ) {
        const orderBy = FD.get( 'orderby' );

        if ( 'date' !== orderBy ) {
            return [ `orderby="${orderBy}"` ];
        } else {
            return [];
        }
    },

    getOrder( FD ) {
        const order = FD.get( 'order' );

        if ( 'asc' === order ) {
            return [ 'order="ASC"' ];
        } else {
            return [];
        }
    },

    getTemlate( FD ) {
        return getSimpleParam( FD, 'template', 'template' );
    },
};

/**
 * Helper for building post status and post type shortcode parameters.
 *
 * Called by shortcodeHelper methods.
 *
 * @since      1.0.0
 * @private
 *
 * @see  shortcodeHelpers
 *
 * @param {Object}   FD              FormData instance.
 * @param {string}   mode            Either 'pt' or 'ps'.
 * @param {string}   name            Key of the FormData instance.
 * @param {string}   shortcodeParam  LCP shortcode parameter.
 *
 * @return {Array} Parsed shortcode parameters.
 */
function typesStatusesHelper( FD, mode, name, shortcodeParam ) {
    mode = FD.get( `${mode}-mode` );
    let paramValue = [];
    let output = [];

    if ( 'any' === mode ) {
        paramValue = mode;
    } else if ( 'select' === mode ) {
        _.each( FD.getAll( name ), ( value ) => {
            paramValue.push( value );
        } );
        paramValue = paramValue.join( ',' );
    }

    if ( ! _.isEmpty( paramValue ) ) {
        output.push( `${shortcodeParam}="${paramValue}"` );
    }
    return output;
}

/**
 * Helper for building shortcode parameters from form checkboxes.
 *
 * Called by shortcodeHelper methods.
 *
 * @since      1.0.0
 * @private
 *
 * @see  shortcodeHelpers
 *
 * @param {Object}   FD                      FormData instance..
 * @param {string}   name                    Key of the FormData instance.
 * @param {string}   shortcodeParam          LCP shortcode parameter.
 * @param {boolean}  [tagsAndClasses=false]  Should tags and classes be included.
 *
 * @return {Array} Parsed shortcode parameters.
 */
function getCheckboxParam( FD, name, shortcodeParam, tagsAndClasses = false ) {
    let output = [];

    if ( FD.has( name ) ) {
        output.push( `${shortcodeParam}="yes"` );

        if ( tagsAndClasses ) {
            output.push( ...getTagsAndClasses( FD, name, shortcodeParam ) );
        }
    }

    return output;
}

/**
 * Helper for building shortcode parameters from simple inputs.
 *
 * Called by shortcodeHelper methods.
 *
 * @since      1.0.0
 * @private
 *
 * @see  shortcodeHelpers
 *
 * @param {Object}   FD                      FormData instance..
 * @param {string}   name                    Key of the FormData instance.
 * @param {string}   shortcodeParam          LCP shortcode parameter.
 * @param {boolean}  [tagsAndClasses=false]  Should tags and classes be included.
 *
 * @return {Array} Parsed shortcode parameters.
 */
function getSimpleParam( FD, name, shortcodeParam, tagsAndClasses = false ) {
    const paramValue = FD.get( name );
    let output = [];

    if ( ! _.isEmpty( paramValue ) ) {
        output.push( `${shortcodeParam}="${paramValue}"` );

        if ( tagsAndClasses ) {
            output.push( ...getTagsAndClasses( FD, name, shortcodeParam ) );
        }
    }

    return output;
}

/**
 * Helper for tags and classes.
 *
 * Takes a FormData instance, form field name and an LCP shortcode
 * parameter name. Builds corresponsing tag and class paramters.
 *
 * @example
 * // returns ['author_class="foo"', 'author_tag="bar"']
 * getTagsAndClasses( FD, 'display-author', 'author' );
 *
 * @since      1.0.0
 * @protected
 *
 * @param {Object}   FD               FormData instance.
 * @param {string}   name             Key of the FormData instance.
 * @param {string}   shortcodeParam   LCP shortcode parameter.
 *
 * @return {Array} Parsed shortcode parameters.
 */
function getTagsAndClasses( FD, name, shortcodeParam ) {

    let output = [];
    const tag = FD.get( `${name}-tag` );
    const className = FD.get( `${name}-class` );

    if ( ! _.isEmpty( tag ) ) {
        output.push( `${shortcodeParam}_tag="${tag}"` );
    }
    if ( ! _.isEmpty( className ) ) {
        output.push( `${shortcodeParam}_class="${className}"` );
    }

    return output;
}

/**
 * Shortcode building function.
 *
 * Calls all methods of shortcodeHelpers to build the shortcode.
 * Returns it as a string. This is the only item exported by this module.
 *
 * @since      1.0.0
 * @package
 *
 * @see  module:ModalContentView
 * @see  shortcodeHelpers
 *
 * @param {Object}  FD  FormData instance.
 *
 * @return {string} Full built shortcode.
 */
function createShortcode( FD ) {
    // This will gather helper functions output.
    let parameters = [];

    _.each( shortcodeHelpers, ( func ) => (
        parameters = parameters.concat( func( FD ) )
    ) );

    return '[catlist ' + parameters.join( ' ' ) + ']';
}

export default createShortcode;
