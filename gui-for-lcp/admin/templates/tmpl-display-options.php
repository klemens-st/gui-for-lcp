<script type="text/html" id="tmpl-display-options">
  <div class="gflcp-display-accordion">
    <h2><?php _e('Pagination, Number of posts & Order'); ?></h2>
    <div class="gflcp-display-details">
      <label>
        <input type="checkbox" name="pagination">
        <?php _e('Pagination', 'gui-for-lcp') ?>
      </label>
      <label>
        <?php _e('Number of posts (per page if pagination is on)', 'gui-for lcp') ?>
        <input type="number" name="numberposts" min="1">
        <small><?php printf(
          /* translators: %s: Default form field value */
          __('Default: %s', 'gui-for-lcp'),
          '10'
        ) ?></small>
      </label>
      <label>
        <?php _e('Order by', 'gui-for-lcp') ?>
        <select name="orderby">
          <#
            const orderbyOptions = {
              author:     '<?php _e('Author ID', 'gui-for-lcp') ?>',
              category:   '<?php _e('Category ID', 'gui-for-lcp') ?>',
              content:    '<?php _e('Content', 'gui-for-lcp') ?>',
              date:       '<?php _e('Creation date', 'gui-for-lcp') ?>',
              ID:         '<?php _e('Post ID', 'gui-for-lcp') ?>',
              menu_order: '<?php _e('Menu order', 'gui-for-lcp') ?>',
              mime_type:  '<?php _e('MIME type', 'gui-for-lcp') ?>',
              modified:   '<?php _e('Last modified date', 'gui-for-lcp') ?>',
              name:       '<?php _e('Slug', 'gui-for-lcp') ?>',
              parent:     '<?php _e('Parent ID', 'gui-for-lcp') ?>',
              password:   '<?php _e('Password', 'gui-for-lcp') ?>',
              rand:       '<?php _e('Random', 'gui-for-lcp') ?>',
              status:     '<?php _e('Status', 'gui-for-lcp') ?>',
              title:      '<?php _e('Title', 'gui-for-lcp') ?>',
              type:       '<?php _e('Type', 'gui-for-lcp') ?>',
            };

            _.each(orderbyOptions, function(val, key) {
          #>
              <option value="{{key}}"<# 'date' === key ? print(' selected') : null #>>{{val}}</option>
          <# }); #>
        </select>
      </label>
      <p><?php _e('Order', 'gui-for-lcp') ?>:</p>
      <label>
        <input type="radio" name="order" value="desc" checked>
        <?php _e('Descending', 'gui-for-lcp') ?>
      </label>
      <label>
        <input type="radio" name="order" value="asc">
        <?php _e('Ascending', 'gui-for-lcp') ?>
      </label>
    </div>
    <h2><?php _e('List-specific options', 'gui-for-lcp') ?></h2>
    <div>
      <div class="gflcp-display-checkboxes">
        <label>
          <input type="checkbox" name="show-conditional-title">
          <?php _e('Conditional title', 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="category-title">
          <?php _e('Category title', 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="category-description" value="1">
          <?php _e('Category description', 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="morelink" value="1">
          <?php _e('Morelink', 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="wrapper-class" value="1">
          <?php _e('Specify wrapper class', 'gui-for-lcp') ?>
        </label>
      </div>
      <div class="gflcp-display-details">
        <fieldset class="gflcp-category-title" disabled>
          <legend><?php _e('Category title', 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <input type="checkbox" name="catlink" value="1" checked>
              <?php _e("Wrap in a link to the category's archive", 'gui-for-lcp') ?>
            </label>
          </div>
          <div>
            <label>
              <input type="checkbox" name="category-count" value="1">
              <?php _e('Display number of posts next to the title', 'gui-for-lcp') ?>
            </label>
          </div>
          <div>
            <label>
              <?php _e("CSS class", 'gui-for-lcp') ?>
              <input type="text" name="catlink-class">
            </label>
            <label>
              <?php _e('HTML tag', 'gui-for-lcp') ?>
              <input type="text" name="catlink-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-show-conditional-title" disabled>
          <legend><?php _e('Conditional title', 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <?php _e('A custom title before the posts list. Only displayed if the list is not empty.', 'gui-for-lcp') ?>
              <input type="text" name="conditional-title">
            </label>
          </div>
          <div>
            <label>
              <?php _e('CSS class', 'gui-for-lcp') ?>
              <input type="text" name="conditional-title-class">
            </label>
            <label>
              <?php _e('HTML tag', 'gui-for-lcp') ?>
              <input type="text" name="conditional-title-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-morelink" disabled>
          <legend><?php _e('Morelink', 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <?php _e('CSS class', 'gui-for-lcp') ?>
              <input type="text" name="morelink-class">
            </label>
            <label>
              <?php _e('HTML tag', 'gui-for-lcp') ?>
              <input type="text" name="morelink-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-wrapper-class" disabled>
          <legend><?php _e("Wrapper's class", 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <?php _e('CSS class', 'gui-for-lcp') ?>
              <input type="text" name="class">
            </label>
          </div>
        </fieldset>
      </div>
    </div>
    <h2><?php _e('Post-specific options', 'gui-for-lcp') ?></h2>
    <div>
      <div class="gflcp-display-checkboxes">
        <label>
          <input type="checkbox" name="display-author" value="1">
          <?php _e('Author', 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="comments" value="1">
          <?php _e('Comment count', 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="content" value="1">
          <?php _e('Content', 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="customfield" value="1">
          <?php _e('Custom fields', 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="display-date" value="1">
          <?php _e('Date', 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="date-modified" value="1">
          <?php _e('Date modified', 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="excerpt" value="1">
          <?php _e('Excerpt', 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="posts-id" value="1">
          <?php _e('Post ID', 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="suffix" value="1">
          <?php _e("Post's suffix", 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="posts-morelink" value="1">
          <?php _e("Post's morelink", 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="tags-as-class" value="1">
          <?php _e('Tags as class', 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="post-title" value="1" checked>
          <?php _e('Title', 'gui-for-lcp') ?>
        </label>
        <label>
          <input type="checkbox" name="thumbnail" value="1">
          <?php _e('Thumbnail', 'gui-for-lcp') ?>
        </label>
      </div>
      <div class="gflcp-display-details">
        <fieldset class="gflcp-display-author" disabled>
          <legend><?php _e('Author', 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <?php _e("Author's CSS class", 'gui-for-lcp') ?>
              <input type="text" name="display-author-class">
            </label>
            <label>
              <?php _e('HTML tag', 'gui-for-lcp') ?>
              <input type="text" name="display-author-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-comments" disabled>
          <legend><?php _e('Comment count', 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <?php _e('CSS class', 'gui-for-lcp') ?>
              <input type="text" name="comments-class">
            </label>
            <label>
              <?php _e('HTML tag', 'gui-for-lcp') ?>
              <input type="text" name="comments-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-content" disabled>
          <legend><?php _e('Content', 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <input type="checkbox" name="content-full" value="1">
              <?php _e("Ignore post's 'more' tag", 'gui-for-lcp') ?>
            </label>
          </div>
          <div>
            <label>
              <?php _e('CSS class', 'gui-for-lcp') ?>
              <input type="text" name="content-class">
            </label>
            <label>
              <?php _e('HTML tag', 'gui-for-lcp') ?>
              <input type="text" name="content-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-customfield gflcp-row-span-2" disabled>
          <legend><?php _e('Custom fields', 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <?php _e("Custom fields' names, comma separated", 'gui-for-lcp') ?>
              <input type="text" name="customfield-display">
            </label>
          </div>
          <div>
            <label>
              <input
                type="checkbox"
                name="customfield-display-separately"
                value="1"
                toggles="customfield-display-glue"
              >
              <?php _e('Display separately', 'gui-for-lcp') ?>
            </label>
            <label>
              <?php _e('Text to display between custom fields', 'gui-for-lcp') ?>
              <input type="text" name="customfield-display-glue">
              <small><?php printf(
                /* translators: %s: Default form field value */
                __('Default: %s', 'gui-for-lcp'),
                __('empty string', 'gui-for-lcp')
              ) ?></small>
            </label>
          </div>
          <div>
            <label>
              <input
                type="checkbox"
                name="customfield-display-name"
                value="1"
                checked
                toggles="customfield-display-name-glue"
              >
              <?php _e("Display each custom field's name", 'gui-for-lcp') ?>
            </label>
            <label>
              <?php _e('Text to display between name and value of each custom field', 'gui-for-lcp') ?>
              <input type="text" name="customfield-display-name-glue">
              <small><?php printf(
                /* translators: %s: Default form field value */
                __('Default: %s', 'gui-for-lcp'),
                ' : '
              ) ?></small>
            </label>
          </div>
          <div>
            <label>
               <?php _e('CSS class', 'gui-for-lcp') ?>
              <input type="text" name="customfield-class">
            </label>
            <label>
              <?php _e('HTML tag', 'gui-for-lcp') ?>
              <input type="text" name="customfield-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-display-date" disabled>
          <legend><?php _e('Date', 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <?php _e('CSS class', 'gui-for-lcp') ?>
              <input type="text" name="display-date-class">
            </label>
            <label>
              <?php _e('HTML tag', 'gui-for-lcp') ?>
              <input type="text" name="display-date-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-date-modified" disabled>
          <legend><?php _e('Date modified', 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <?php _e('CSS class', 'gui-for-lcp') ?>
              <input type="text" name="date-modified-class">
            </label>
            <label>
              <?php _e('HTML tag', 'gui-for-lcp') ?>
              <input type="text" name="date-modified-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-excerpt gflcp-row-span-2" disabled>
          <legend><?php _e('Excerpt', 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <input type="checkbox" name="excerpt-full" value="1" class="gflcp-toggles-fieldset">
              <?php _e('Use full excerpt', 'gui-for-lcp') ?>
            </label>
            <fieldset class="gflcp-excerpt-full">
              <legend>Auto-generated excerpt</legend>
              <label>
                <input type="checkbox" name="excerpt-overwrite" value="1">
                <?php _e("Ignore post's explicit excerpt", 'gui-for-lcp') ?>
              </label>
              <label>
                <input type="checkbox" name="excerpt-strip" value="1" checked>
                <?php _e('Strip HTML tags', 'gui-for-lcp') ?>
              </label>
              <label>
                <?php _e("Excerpt's size (word count)", 'gui-for-lcp') ?>
                <input type="number" name="excerpt-size" min="1">
                <small><?php printf(
                  /* translators: %s: Default form field value */
                  __('Default: %s', 'gui-for-lcp'),
                  '55'
                ) ?></small>
              </label>
            </fieldset>
          </div>
          <div>
            <label>
              <?php _e('CSS class', 'gui-for-lcp') ?>
              <input type="text" name="excerpt-class">
            </label>
            <label>
              <?php _e('HTML tag', 'gui-for-lcp') ?>
              <input type="text" name="excerpt-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-suffix" disabled>
          <legend><?php _e("Post's suffix", 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <?php _e('Text to display after the title', 'gui-for-lcp') ?>
              <input type="text" name="post-suffix">
              <small><?php printf(
                /* translators: %s: Default form field value */
                __('Default: %s', 'gui-for-lcp'),
                __('empty string', 'gui-for-lcp')
              ) ?></small>
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-posts-morelink" disabled>
          <legend><?php _e("Post's morelink", 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <?php _e('CSS class', 'gui-for-lcp') ?>
              <input type="text" name="posts-morelink-class">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-post-title">
          <legend><?php _e('Title', 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <?php _e('Character limit', 'gui-for-lcp') ?>
              <input type="number" name="title-limit" min="1">
              <small><?php printf(
                /* translators: %s: Default form field value */
                __('Default: %s', 'gui-for-lcp'),
                __('no limit', 'gui-for-lcp')
              ) ?></small>
            </label>
          </div>
          <div>
            <label>
              <input type="checkbox" name="link-titles" value="1" checked>
              <?php _e('Wrap titles in links', 'gui-for-lcp') ?>
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-thumbnail" disabled>
          <legend><?php _e('Thumbnail', 'gui-for-lcp') ?></legend>
          <div>
            <label>
              <input type="checkbox" name="force-thumbnail" value="1">
              <?php _e('Force thumbnail', 'gui-for-lcp') ?>
            </label>
          </div>
          <div>
            <label>
              <?php _e("Thumbnail's size", 'gui-for-lcp') ?>
              <input type="text" name="thumbnail-size">
            </label>
          </div>
          <div>
            <label>
              <?php _e('CSS class', 'gui-for-lcp') ?>
              <input type="text" name="thumbnail-class">
            </label>
          </div>
        </fieldset>
      </div>
    </div>
    <h2><?php _e('Template', 'gui-for-lcp') ?></h2>
    <div>
      <label>
        <?php _e("Template's name", 'gui-for-lcp') ?>
        <input type="text" name="template">
      </label>
    </div>
  </div>
</script>