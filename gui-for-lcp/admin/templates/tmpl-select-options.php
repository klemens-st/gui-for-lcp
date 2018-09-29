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
    <div>
      <# printSwitchCheckbox('<?php _e('Categories', 'gui-for-lcp') ?>', 'gflcp-categories', true) #>
      <fieldset class="gflcp-categories">
      <div>
        <h3><?php _e('Current category', 'gui-for-lcp') ?></h3>
        <label><?php _e('Yes', 'gui-for-lcp') ?>
          <input type="radio" class="gflcp-categorypage" name="categorypage" value="1">
        </label>
        <label><?php _e('No', 'gui-for-lcp') ?>
          <input type="radio" class="gflcp-categorypage" name="categorypage" value="0" checked>
        </label>
      </div>
      <fieldset id="gflcp-cat-select">
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
    <div>
      <# printSwitchCheckbox('<?php _e('Author', 'gui-for-lcp') ?>', 'gflcp-author', false) #>
      <fieldset class="gflcp-author" disabled>
        <div>
          <select id="gflcp-author" name="author">
            <# _.each(data.users, function(user) { #>
              <option value="{{user.user_nicename}}">{{user.display_name}}</option>;
            <# }); #>
          </select>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Tags', 'gui-for-lcp') ?></h2>
    <div>
      <# printSwitchCheckbox('<?php _e('Tags', 'gui-for-lcp') ?>', 'gflcp-tags', false) #>
      <fieldset class="gflcp-tags" disabled>
        <div>
          <h3><?php _e('Current tags', 'gui-for-lcp') ?></h3>
          <label><?php _e('Yes', 'gui-for-lcp') ?>
            <input type="radio" class="gflcp-currenttags" name="currenttags" value="1">
          </label>
          <label><?php _e('No', 'gui-for-lcp') ?>
            <input type="radio" class="gflcp-currenttags" name="currenttags" value="0" checked>
          </label>
        </div>
        <fieldset id="gflcp-tag-select">
          <div>
            <h3><?php _e('Select', 'gui-for-lcp') ?></h3>
            <ul class="tag-checklist cat-checklist">
              {{{data.tags}}}
            </ul>
          </div>
          <div id="gflcp-tag-exclude">
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
    <div>
      <# printSwitchCheckbox('<?php _e('Custom taxonomies', 'gui-for-lcp') ?>', 'gflcp-taxonomies', false) #>
      <fieldset class="gflcp-taxonomies" disabled>
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
        <div id="gflcp-taxonomy-terms"></div>
        <div>
          <h3><?php _e('Relationship', 'gui-for-lcp') ?></h3>
          <# printRelationship('taxrel', 'and'); #>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Starting with', 'gui-for-lcp') ?></h2>
    <div>
      <# printSwitchCheckbox('<?php _e('Starting with', 'gui-for-lcp') ?>', 'gflcp-starting-with', false) #>
      <fieldset class="gflcp-starting-with" disabled>
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
    <div>
      <# printSwitchCheckbox('<?php _e('Date', 'gui-for-lcp') ?>', 'gflcp-date', false) #>
      <fieldset class="gflcp-date" disabled>
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
            <input type="text" name="after" class="gflcp-datepicker">
          </label>
          <label><?php _e('Before', 'gui-for-lcp') ?>
            <input type="text" name="before" class="gflcp-datepicker">
          </label>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Search', 'gui-for-lcp') ?></h2>
    <div>
      <# printSwitchCheckbox('<?php _e('Search', 'gui-for-lcp') ?>', 'gflcp-search', false) #>
      <fieldset class="gflcp-search" disabled>
        <div>
          <label><?php _e('Search terms', 'gui-for-lcp') ?>
            <input type="text" name="search">
          </label>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Exclude posts', 'gui-for-lcp') ?></h2>
    <div>
      <# printSwitchCheckbox('<?php _e('Exclude posts', 'gui-for-lcp') ?>', 'gflcp-exclude-posts', false) #>
      <fieldset class="gflcp-exclude-posts" disabled>
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
    <div>
      <# printSwitchCheckbox('<?php _e('Offset', 'gui-for-lcp') ?>', 'gflcp-offset', false) #>
      <fieldset class="gflcp-offset" disabled>
        <div>
          <label><?php _e('Offset value', 'gui-for-lcp') ?>
            <input type="number" name="offset" min="0">
          </label>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Post type', 'gui-for-lcp') ?></h2>
    <div>
      <fieldset class="gflcp-post-types">
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
        <fieldset id="gflcp-pt-select" disabled>
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
    <div>
      <fieldset class="gflcp-post-status">
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
        <fieldset id="gflcp-ps-select" disabled>
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
    <div>
      <fieldset class="gflcp-show-protected">
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
    <div>
      <# printSwitchCheckbox('<?php _e('Parent post', 'gui-for-lcp') ?>', 'gflcp-parent-post', false) #>
      <fieldset class="gflcp-parent-post" disabled>
        <div>
          <label><?php _e('Disply only children of this parent post', 'gui-for-lcp') ?>
            <input type="number" name="parent-post" min="0">
          </label>
        </div>
      </fieldset>
    </div>
    <h2><?php _e('Custom fields', 'gui-for-lcp') ?></h2>
    <div>
      <# printSwitchCheckbox('<?php _e('Custom fields', 'gui-for-lcp') ?>', 'gflcp-custom-fields', false) #>
      <fieldset class="gflcp-custom-fields" disabled>
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
