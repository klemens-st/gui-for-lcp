<script type="text/html" id="tmpl-select-options">
  <#
    function printRelationship(name, checked) {
        const values = {
            and: '<?php _e('AND', 'gui-for-lcp') ?>',
            or:  '<?php _e('OR', 'gui-for-lcp') ?>'
        };
        _.each(values, (label, value) => {
            let printChecked = value === checked ? ' checked' : '';
            #>
            <label>{{label}}
              <input type="radio" name="{{name}}" value="{{value}}"{{{printChecked}}}>
            </label>
            <#
        });
    }

    function printSwitchCheckbox(label, name, checked) {
        const printChecked = checked ? ' checked' : '';
      #>
        <label>
          <input type="checkbox" name="{{name}}" class="lcp-swtich-checkbox"{{{printChecked}}}>
          {{label}}</label>
      <#
    }
  #>
  <div id="gflcp-select-accordion">
    <h2><?php _e('Category', 'gui-for-lcp') ?></h2>
    <div id="gflcp-categories">
      <# printSwitchCheckbox('<?php _e('Categories', 'gui-for-lcp') ?>', 'lcp-categories', true) #>
      <fieldset class="lcp-categories">
      <div>
        <h3><?php _e('Current category', 'gui-for-lcp') ?></h3>
        <label><?php _e('Yes', 'gui-for-lcp') ?>
          <input type="radio" class="lcp-categorypage" name="categorypage" value="1">
        </label>
        <label><?php _e('No', 'gui-for-lcp') ?>
          <input type="radio" class="lcp-categorypage" name="categorypage" value="0" checked>
        </label>
      </div>
      <fieldset id="lcp-cat-select">
        <div>
          <h3><?php _e('Select', 'gui-for-lcp') ?></h3>
          <ul class="cat-checklist category-checklist">
            {{{data.categories}}}
          </ul>
        </div>
        <div>
          <h3><?php _e('Exclude', 'gui-for-lcp') ?></h3>
          <ul class="cat-checklist excategory-checklist">
            {{{data.categories}}}
          </ul>
        </div>
        <div>
          <h3><?php _e('Relationship', 'gui-for-lcp') ?></h3>
          <# printRelationship('catrel', 'and'); #>
        </div>
      </fieldset>
      <div>
        <h3><?php _e('Child categories', 'gui-for-lcp') ?></h3>
        <label><?php _e('Include', 'gui-for-lcp') ?>
          <input type="radio" name="child-cat" value="1" checked>
        </label>
        <label><?php _e('Exclude', 'gui-for-lcp') ?>
          <input type="radio" name="child-cat" value="0">
        </label>
      </div>
      </fieldset>
    </div>
    <h2><?php _e('Author', 'gui-for-lcp') ?></h2>
    <div id="gflcp-author">
      <# printSwitchCheckbox('<?php _e('Author', 'gui-for-lcp') ?>', 'lcp-author', false) #>
      <fieldset class="lcp-author" disabled>
        <div>
          <select id="lcp-author" name="author">
            <# _.each(data.users, function(user) { #>
              <option value="{{user.user_nicename}}">{{user.display_name}}</option>;
            <# }); #>
          </select>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Tags', 'gui-for-lcp') ?></h2>
    <div id="gflcp-tags">
      <# printSwitchCheckbox('<?php _e('Tags', 'gui-for-lcp') ?>', 'lcp-tags', false) #>
      <fieldset class="lcp-tags" disabled>
        <div>
          <h3><?php _e('Current tags', 'gui-for-lcp') ?></h3>
          <label><?php _e('Yes', 'gui-for-lcp') ?>
            <input type="radio" class="lcp-currenttags" name="currenttags" value="1">
          </label>
          <label><?php _e('No', 'gui-for-lcp') ?>
            <input type="radio" class="lcp-currenttags" name="currenttags" value="0" checked>
          </label>
        </div>
        <fieldset id="lcp-tag-select">
          <div>
            <h3><?php _e('Select', 'gui-for-lcp') ?></h3>
            <ul class="tag-checklist cat-checklist">
              {{{data.tags}}}
            </ul>
          </div>
          <div id="lcp-tags-exclude">
            <h3><?php _e('Exclude', 'gui-for-lcp') ?></h3>
            <ul class="extag-checklist cat-checklist">
              {{{data.tags}}}
            </ul>
          </div>
          <div>
            <h3><?php _e('Relationship', 'gui-for-lcp') ?></h3>
            <# printRelationship('tagrel', 'and'); #>
          </div>
        </fieldset>
      </fieldset>
    </div>
    <h2><?php _e('Custom taxonomies', 'gui-for-lcp') ?></h2>
    <div id="gflcp-taxonomies">
      <# printSwitchCheckbox('<?php _e('Custom taxonomies', 'gui-for-lcp') ?>', 'lcp-taxonomies', false) #>
      <fieldset class="lcp-taxonomies" disabled>
        <div>
          <h3><?php _e('Choose one or more taxonomies', 'gui-for-lcp') ?></h3>
          <ul class="cat-checklist tax-checklist">
            <# _.each(data.taxonomies, function(tax) { #>
              <li>
                <label>
                  <input type="checkbox" name="taxonomy" value="{{tax.slug}}">
                  {{tax.name}}
                </label>
              </li>
            <# }); #>
          </ul>
        </div>
        <button type="button" id="load-terms" class="button">
          <?php _e('Load taxonomy terms', 'gui-for-lcp') ?>
        </button>
        <div class="taxonomy-terms"></div>
        <div>
          <h3><?php _e('Relationship', 'gui-for-lcp') ?></h3>
          <# printRelationship('taxrel', 'and'); #>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Starting with', 'gui-for-lcp') ?></h2>
    <div id="gflcp-starting-with">
      <# printSwitchCheckbox('<?php _e('Starting with', 'gui-for-lcp') ?>', 'lcp-starting-with', false) #>
      <fieldset class="lcp-starting-with" disabled>
        <div>
          <label><?php _e('Comma separated characters', 'gui-for-lcp') ?>
            <input
              type="text"
              name="starting-with"
              title="<?php esc_attr_e('comma separated single characters', 'gui-for-lcp') ?>"
              pattern="[^,](,[^,])*"
            >
          </label>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Date', 'gui-for-lcp') ?></h2>
    <div id="gflcp-date">
      <# printSwitchCheckbox('<?php _e('Date', 'gui-for-lcp') ?>', 'lcp-date', false) #>
      <fieldset class="lcp-date" disabled>
        <div>
          <label><?php _e('Year', 'gui-for-lcp') ?>
            <input name="year" type="number" min="1900" max="3000">
          </label>
          <label><?php _e('Month', 'gui-for-lcp') ?>
            <input name="month" type="number" min="1" max="12">
          </label>
        </div>
        <div>
          <h3><?php _e('Range', 'gui-for-lcp') ?></h3>
          <label><?php _e('After', 'gui-for-lcp') ?>
            <input type="text" name="after" class="lcp-datepicker">
          </label>
          <label><?php _e('Before', 'gui-for-lcp') ?>
            <input type="text" name="before" class="lcp-datepicker">
          </label>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Search', 'gui-for-lcp') ?></h2>
    <div id="gflcp-search">
      <# printSwitchCheckbox('<?php _e('Search', 'gui-for-lcp') ?>', 'lcp-search', false) #>
      <fieldset class="lcp-search" disabled>
        <div>
          <label><?php _e('Search terms', 'gui-for-lcp') ?>
            <input type="text" name="search">
          </label>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Exclude posts', 'gui-for-lcp') ?></h2>
    <div id="gflcp-exclude-posts">
      <# printSwitchCheckbox('<?php _e('Exclude posts', 'gui-for-lcp') ?>', 'lcp-exclude-posts', false) #>
      <fieldset class="lcp-exclude-posts" disabled>
        <div>
          <h3><?php _e('Current post', 'gui-for-lcp') ?></h3>
          <label><?php _e('Yes', 'gui-for-lcp') ?>
            <input type="radio" name="excurpost" value="1">
          </label>
          <label><?php _e('No', 'gui-for-lcp') ?>
            <input type="radio" name="excurpost" value="0" checked>
          </label>
        </div>
        <div>
          <h3><?php _e('List', 'gui-for-lcp') ?></h3>
          <label><?php _e('Post IDs, comma separated', 'gui-for-lcp') ?>
            <input
              type="text"
              name="expost"
              pattern="\d+(,\d)*"
              title="<?php esc_attr_e('Post IDs, comma separated', 'gui-for-lcp') ?>">
          </label>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Offset', 'gui-for-lcp') ?></h2>
    <div id="gflcp-offset">
      <# printSwitchCheckbox('<?php _e('Offset', 'gui-for-lcp') ?>', 'lcp-offset', false) #>
      <fieldset class="lcp-offset" disabled>
        <div>
          <label><?php _e('Offset value', 'gui-for-lcp') ?>
            <input type="number" name="offset" min="0">
          </label>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Post type', 'gui-for-lcp') ?></h2>
    <div id="gflcp-post-types">
      <fieldset class="lcp-post-types">
        <div>
          <label><?php _e('Default', 'gui-for-lcp') ?> - 'post'
            <input type="radio" name="pt-mode" value="default" checked>
          </label>
          <label><?php _e('Any', 'gui-for-lcp') ?>
            <input type="radio" name="pt-mode" value="any">
          </label>
          <label><?php _e('Select', 'gui-for-lcp') ?>
            <input type="radio" name="pt-mode" value="select">
          </label>
        </div>
        <fieldset id="lcp-pt-select" disabled>
          <h3><?php _e('Select', 'gui-for-lcp') ?></h3>
          <ul class="cat-checklist pt-checklist">
            <# _.each(data.post_types, function(pt) { #>
              <li>
                <label>
                  <input type="checkbox" name="post-type" value="{{pt.name}}">
                  {{pt.labels.name}}
                </label>
              </li>
            <# }); #>
          </ul>
        </fieldset>
      </fieldset>
    </div>
    <h2><?php _e('Post status', 'gui-for-lcp') ?></h2>
    <div id="gflcp-post-status">
      <fieldset class="lcp-post-status">
        <div>
          <label><?php _e('Default', 'gui-for-lcp') ?> - 'publish'
            <input type="radio" name="ps-mode" value="default" checked>
          </label>
          <label><?php _e('Any', 'gui-for-lcp') ?>
            <input type="radio" name="ps-mode" value="any">
          </label>
          <label><?php _e('Select', 'gui-for-lcp') ?>
            <input type="radio" name="ps-mode" value="select">
          </label>
        </div>
        <fieldset id="lcp-ps-select" disabled>
        <ul class="cat-checklist ps-checklist">
          <#
            const statuses = ['publish', 'pending', 'draft', 'auto-draft',
                              'future', 'private', 'inherit', 'trash'];
            _.each(statuses, function(status, key) {
              let checked = key === 0 ? ' checked' : '';
          #>
            <li><label>
              <input type="checkbox" name="post-status" value="{{status}}"{{checked}}>
              {{status}}
            </label></li>
          <# }); #>
        </ul>
        </fieldset>
      </fieldset>
    </div>
    <h2><?php _e('Show protected', 'gui-for-lcp') ?></h2>
    <div id="gflcp-show-protected">
      <fieldset class="lcp-show-protected">
        <div>
          <label><?php _e('Yes', 'gui-for-lcp') ?>
            <input type="radio" name="show-protected" value="1">
          </label>
          <label><?php _e('No', 'gui-for-lcp') ?>
            <input type="radio" name="show-protected" value="0" checked>
          </label>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Parent post', 'gui-for-lcp') ?></h2>
    <div id="gflcp-parent-post">
      <# printSwitchCheckbox('<?php _e('Parent post', 'gui-for-lcp') ?>', 'lcp-parent-post', false) #>
      <fieldset class="lcp-parent-post" disabled>
        <div>
          <label><?php _e('Disply only children of this parent post', 'gui-for-lcp') ?>
            <input type="number" name="parent-post" min="0">
          </label>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Custom fields', 'gui-for-lcp') ?></h2>
    <div id="gflcp-custom-fields">
      <# printSwitchCheckbox('<?php _e('Custom fields', 'gui-for-lcp') ?>', 'lcp-custom-fields', false) #>
      <fieldset class="lcp-custom-fields" disabled>
        <div>
          <label><?php _e('Customfield name', 'gui-for-lcp') ?>
            <input type="text" name="customfield-name" required>
          </label>
          <label><?php _e('Customfield value', 'gui-for-lcp') ?>
            <input type="text" name="customfield-value" required>
          </label>
        </div>
      </fieldset>
    </div>
  </div>
</script>
