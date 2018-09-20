<script type="text/html" id="tmpl-modal-content">
  <#
    function printRelationship(name, checked) {
        const values = ['and', 'or']
        for (let i = 0; i < 2; i++) {
            let value = values[i];
            let printValue = value.toUpperCase();
            let printChecked = value === checked ? ' checked' : '';
            #>
            <label>{{{printValue}}}
              <input type="radio" name="{{{name}}}" value="{{{value}}}"{{{printChecked}}}>
            </label>
            <#
        }
    }

    function printSwitchCheckbox(label, name, checked) {
        const printChecked = checked ? ' checked' : '';
      #>
        <label>
          <input type="checkbox" name="{{{name}}}" class="lcp-swtich-checkbox"{{{printChecked}}}>
        {{{label}}}</label>
      <#
    }
  #>
  <header>
    <h1>List Category Posts shortcode creator</h1>
  </header>
  <form id="lcp-insert-form">
    <div id="gflcp-select-accordion">
      <h2>Category</h2>
      <div id="gflcp-categories">
        <# printSwitchCheckbox('Categories', 'lcp-categories', true) #>
        <fieldset class="lcp-categories">
        <div>
          <h3>Current</h3>
          <label>Yes
            <input type="radio" class="lcp-categorypage" name="categorypage" value="1">
          </label>
          <label>No
            <input type="radio" class="lcp-categorypage" name="categorypage" value="0" checked>
          </label>
        </div>
        <fieldset id="lcp-cat-select">
          <div>
            <h3>Select</h3>
            <ul class="cat-checklist category-checklist">
              {{{data.categories}}}
            </ul>
          </div>
          <div>
            <h3>Exclude</h3>
            <ul class="cat-checklist excategory-checklist">
              {{{data.categories}}}
            </ul>
          </div>
          <div>
            <h3>Relationship</h3>
            <# printRelationship('catrel', 'and'); #>
          </div>
        </fieldset>
        <div>
          <h3>Child categories</h3>
          <label>Include
            <input type="radio" name="child-cat" value="1" checked>
          </label>
          <label>Exclude
            <input type="radio" name="child-cat" value="0">
          </label>
        </div>
        </fieldset>
      </div>
      <h2>Author</h2>
      <div id="gflcp-author">
        <# printSwitchCheckbox('Author', 'lcp-author', false) #>
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
      <h2>Tags</h2>
      <div id="gflcp-tags">
        <# printSwitchCheckbox('Tags', 'lcp-tags', false) #>
        <fieldset class="lcp-tags" disabled>
          <div>
            <h3>Current</h3>
            <label>Yes
              <input type="radio" class="lcp-currenttags" name="currenttags" value="1">
            </label>
            <label>No
              <input type="radio" class="lcp-currenttags" name="currenttags" value="0" checked>
            </label>
          </div>
          <fieldset id="lcp-tag-select">
            <div>
              <h3>Select</h3>
              <ul class="tag-checklist cat-checklist">
                {{{data.tags}}}
              </ul>
            </div>
            <div id="lcp-tags-exclude">
              <h3>Exclude</h3>
              <ul class="extag-checklist cat-checklist">
                {{{data.tags}}}
              </ul>
            </div>
            <div>
              <h3>Relationship</h3>
              <# printRelationship('tagrel', 'and'); #>
            </div>
          </fieldset>
        </fieldset>
      </div>
      <h2>Custom tax</h2>
      <div id="gflcp-taxonomies">
        <# printSwitchCheckbox('Custom taxonomies', 'lcp-taxonomies', false) #>
        <fieldset class="lcp-taxonomies" disabled>
          <div>
            <h3>Choose one or more taxonomies</h3>
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
            <button type="button" id="load-terms" class="button">Load taxonomy terms</button>
          </div>
          <div class="taxonomy-terms"></div>
          <div>
            <h3>Relationship</h3>
            <# printRelationship('taxrel', 'and'); #>
          </div>
        </fieldset>
      </div>
      <h2>Starting with</h2>
      <div id="gflcp-starting-with">
        <# printSwitchCheckbox('Starting with', 'lcp-starting-with', false) #>
        <fieldset class="lcp-starting-with" disabled>
          <div>
            <label>Specify
              <input
                type="text"
                name="starting-with"
                title="comma separated single characters"
                pattern="[^,](,[^,])*"
              >
            </label>
          </div>
        </fieldset>
      </div>
      <h2>Date</h2>
      <div id="gflcp-date">
        <# printSwitchCheckbox('Date', 'lcp-date', false) #>
        <fieldset class="lcp-date" disabled>
          <div>
            <label>Year
              <input name="year" type="number" min="1900" max="3000">
            </label>
            <label>Month
              <input name="month" type="number" min="1" max="12">
            </label>
          </div>
          <div>
            <h3>Range</h3>
            <label>After
              <input type="text" name="after" class="lcp-datepicker">
            </label>
            <label>Before
              <input type="text" name="before" class="lcp-datepicker">
            </label>
          </div>
        </fieldset>
      </div>
      <h2>Search</h2>
      <div id="gflcp-search">
        <# printSwitchCheckbox('Search', 'lcp-search', false) #>
        <fieldset class="lcp-search" disabled>
          <div>
            <label>Specify
              <input type="text" name="search">
            </label>
          </div>
        </fieldset>
      </div>
      <h2>Exclude posts</h2>
      <div id="gflcp-exclude-posts">
        <# printSwitchCheckbox('Exclude posts', 'lcp-exclude-posts', false) #>
        <fieldset class="lcp-exclude-posts" disabled>
          <div>
            <h3>Current</h3>
            <label>Yes
              <input type="radio" name="excurpost" value="1">
            </label>
            <label>No
              <input type="radio" name="excurpost" value="0" checked>
            </label>
          </div>
          <div>
            <h3>List</h3>
            <label>Post IDs, comma separated
              <input type="text" name="expost" pattern="\d+(,\d)*" title="comma separated post IDs">
            </label>
          </div>
        </fieldset>
      </div>
      <h2>Offset</h2>
      <div id="gflcp-offset">
        <# printSwitchCheckbox('Offset', 'lcp-offset', false) #>
        <fieldset class="lcp-offset" disabled>
          <div>
            <label>Specify
              <input type="number" name="offset" min="0">
            </label>
          </div>
        </fieldset>
      </div>
      <h2>Post type</h2>
      <div id="gflcp-post-types">
        <fieldset class="lcp-post-types">
          <div>
            <label>Default - 'post'
              <input type="radio" name="pt-mode" value="default" checked>
            </label>
            <label>Any
              <input type="radio" name="pt-mode" value="any">
            </label>
            <label>Select
              <input type="radio" name="pt-mode" value="select">
            </label>
          </div>
          <fieldset id="lcp-pt-select" disabled>
            <h3>Select</h3>
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
      <h2>Post status</h2>
      <div id="gflcp-post-status">
        <fieldset class="lcp-post-status">
          <div>
            <label>Default - 'publish'
              <input type="radio" name="ps-mode" value="default" checked>
            </label>
            <label>Any
              <input type="radio" name="ps-mode" value="any">
            </label>
            <label>Select
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
      <h2>Show protected</h2>
      <div id="gflcp-show-protected">
        <fieldset class="lcp-show-protected">
          <div>
            <label>Yes
              <input type="radio" name="show-protected" value="1">
            </label>
            <label>No
              <input type="radio" name="show-protected" value="0" checked>
            </label>
          </div>
        </fieldset>
      </div>
      <h2>Parent post</h2>
      <div id="gflcp-parent-post">
        <# printSwitchCheckbox('Parent post', 'lcp-parent-post', false) #>
        <fieldset class="lcp-parent-post" disabled>
          <div>
            <label>Disply only children of this parent post
              <input type="number" name="parent-post" min="0">
            </label>
          </div>
        </fieldset>
      </div>
      <h2>Custom fields</h2>
      <div id="gflcp-custom-fields">
        <# printSwitchCheckbox('Custom fields', 'lcp-custom-fields', false) #>
        <fieldset class="lcp-custom-fields" disabled>
          <div>
            <label>Customfield name
              <input type="text" name="customfield-name" required>
            </label>
            <label>Customfield value
              <input type="text" name="customfield-value" required>
            </label>
          </div>
        </fieldset>
      </div>
    </div>
    <div id="gflcp-display-options"></div>
    <button type="submit" class="hidden-submit-btn">Submit</button>
  </form>
  <footer class="gflcp-footer">
    <button
      type="submit"
      class="button media-button button-primary button-large media-button-insert"
      form="lcp-insert-form"
    >
      Insert into page
    </button>
  </footer>
</script>

<script type="text/html" id="tmpl-taxonomy-terms">
  <# _.each(data, function(terms, taxonomy) { #>
    <div id="{{taxonomy}}-terms">
      <h3>{{taxonomy}}</h3>
      <ul class="cat-checklist term-checklist">
        {{{terms}}}
      </ul>
    </div>
  <# }); #>
</script>

<script type="text/html" id="tmpl-display-options">
  <div class="gflcp-display-accordion">
    <h2>Pagination, Number of posts & Order</h2>
    <div></div>
    <h2>List-specific options</h2>
    <div>
      <div class="gflcp-display-checkboxes">
        <label>
          <input type="checkbox" name="title">
          Title
        </label>
        <label>
          <input type="checkbox" name="category-description" value="1">
          Category description
        </label>
        <label>
          <input type="checkbox" name="morelink">
          Morelink
        </label>
      </div>
      <div class="gflcp-display-details">
        <fieldset class="gflcp-title" disabled>
          <section>
            <h3>Category title</h3>
            <div>
              <label>
                <input type="radio" name="catlink" value="0" checked>
                No
              </label>
              <label>
                <input type="radio" name="catlink" value="catname">
                Yes
              </label>
              <label>
                <input type="radio" name="catlink" value="catlink">
                Yes, wrapped in a link to the category's archive
              </label>
            </div>
            <div>
              <label>
                <input type="checkbox" name="category-count" value="1">
                Display number of posts next to the title
              </label>
            </div>
            <div>
              <label>
                Category title's class
                <input type="text" name="catlink-class">
              </label>
              <label>
                Category title's HTML tag
                <input type="text" name="catlink-tag">
              </label>
            </div>
          </section>
          <section>
            <h3>Conditional title</h3>
            <div>
              <label>
                A custom title before the posts list. Only displayed if the list is not empty
                <input type="text" name="conditional-title">
              </label>
            </div>
            <div>
              <label>
                Conditional title's class
                <input type="text" name="catlink-class">
              </label>
              <label>
                Conditional title's HTML tag
                <input type="text" name="catlink-tag">
              </label>
            </div>
          </section>
        </fieldset>
        <fieldset class="gflcp-morelink" disabled>
          <h3>Morelink</h3>
          <div>
            <label>
              Morelink's class
              <input type="text" name="morelink-class">
            </label>
            <label>
              Morelink's HTML tag
              <input type="text" name="morelink-tag">
            </label>
          </div>
        </fieldset>
      </div>
    </div>
    <h2>Post-specific options</h2>
    <div>
      <h2>Date</h2>
      <div></div>
      <h2>Author</h2>
      <div></div>
      <h2>Excerpt</h2>
      <div></div>
      <h2>Content</h2>
      <div></div>
      <h2>Comments</h2>
      <div></div>
      <h2>Thumbnail</h2>
      <div></div>
      <h2>Post suffix</h2>
      <div></div>
      <h2>Post ID</h2>
      <div></div>
      <h2>Custom fields</h2>
      <div></div>
      <h2>Post's morelink</h2>
    </div>
    <h2>Template</h2>
    <div></div>
  </div>
</script>

