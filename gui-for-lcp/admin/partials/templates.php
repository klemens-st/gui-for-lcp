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
  <div>
  <h1>FORM</h1>
  <form id="lcp-insert-form">
    <ul>
      <li><a href="#gflcp-categories">Categories</a></li>
      <li><a href="#gflcp-author">Author</a></li>
      <li><a href="#gflcp-tags">Tags</a></li>
      <li><a href="#gflcp-taxonomies">Taxonomies</a></li>
      <li><a href="#gflcp-starting-with">Starting with</a></li>
      <li><a href="#gflcp-date">Date</a></li>
      <li><a href="#gflcp-search">Searc</a></li>
      <li><a href="#gflcp-exclude-posts">Exclude posts</a></li>
      <li><a href="#gflcp-offset">Offset</a></li>
      <li><a href="#gflcp-post-types">Post types</a></li>
      <li><a href="#gflcp-post-status">Post status</a></li>
      <li><a href="#gflcp-show-protected">Show protected</a></li>
      <li><a href="#gflcp-parent-post">Parent post</a></li>
      <li><a href="#gflcp-custom-fields">Custom fields</a></li>
    </ul>
    <div id="gflcp-categories">
      <# printSwitchCheckbox('Categories', 'lcp-categories', true) #>
      <fieldset class="lcp-categories">
      <h2>Category</h2>
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
        <h3>Select</h3>
        <ul class="cat-checklist category-checklist">
          {{{data.categories}}}
        </ul>
        <h3>Exclude</h3>
        <ul class="cat-checklist excategory-checklist">
          {{{data.categories}}}
        </ul>

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
    <div id="gflcp-author">
      <# printSwitchCheckbox('Author', 'lcp-author', false) #>
      <fieldset class="lcp-author" disabled>
        <h2>Author</h2>
        <div>
          <select id="lcp-author" name="author">
            <#
              _.each(data.users, function(user) {
                  let userField = '<option value="' + user.user_nicename +
                                  '">' + user.display_name + '</option>';
                  print(userField);
              });
            #>
          </select>
        </div>
      </fieldset>
    </div>
    <div id="gflcp-tags">
      <# printSwitchCheckbox('Tags', 'lcp-tags', false) #>
      <fieldset class="lcp-tags" disabled>
        <h2>Tags</h2>
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
          <h3>Select</h3>
          <ul class="tag-checklist cat-checklist">
            {{{data.tags}}}
          </ul>
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
    <div id="gflcp-taxonomies">
      <# printSwitchCheckbox('Custom taxonomies', 'lcp-taxonomies', false) #>
      <fieldset class="lcp-taxonomies" disabled>
        <h2>Custom tax</h2>
        <div>
          <h3>Choose one or more taxonomies</h3>
          <select id="lcp-tax-select" name="taxonomy" multiple>
            <#
              _.each(data.taxonomies, function(tax) {
                  let taxField = '<option value="' + tax.slug + '">' +
                                 tax.name + '</option>';
                  print(taxField);
              });
            #>
          </select>
          <button type="button" id="load-terms">Load taxonomy terms</button>
        </div>
        <div class="taxonomy-terms"></div>
        <div>
          <h3>Relationship</h3>
          <# printRelationship('taxrel', 'and'); #>
        </div>
      </fieldset>
    </div>
    <div id="gflcp-starting-with">
      <# printSwitchCheckbox('Starting with', 'lcp-starting-with', false) #>
      <fieldset class="lcp-starting-with" disabled>
        <h2>Starting with</h2>
        <div>
          <label>Specify
            <input type="text" name="starting-with">
          </label>
        </div>
      </fieldset>
    </div>
    <div id="gflcp-date">
      <# printSwitchCheckbox('Date', 'lcp-date', false) #>
      <fieldset class="lcp-date" disabled>
        <h2>Date</h2>
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
    <div id="gflcp-search">
      <# printSwitchCheckbox('Search', 'lcp-search', false) #>
      <fieldset class="lcp-search" disabled>
        <h2>Search</h2>
        <div>
          <label>Specify
            <input type="text" name="search">
          </label>
        </div>
      </fieldset>
    </div>
    <div id="gflcp-exclude-posts">
      <# printSwitchCheckbox('Exclude posts', 'lcp-exclude-posts', false) #>
      <fieldset class="lcp-exclude-posts" disabled>
        <h2>Exclude posts</h2>
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
            <input type="text" name="expost">
          </label>
        </div>
      </fieldset>
    </div>
    <div id="gflcp-offset">
      <# printSwitchCheckbox('Offset', 'lcp-offset', false) #>
      <fieldset class="lcp-offset" disabled>
        <h2>Offset</h2>
        <div>
          <label>Specify
            <input type="number" name="offset">
          </label>
        </div>
      </fieldset>
    </div>
    <div id="gflcp-post-types">
      <fieldset class="lcp-post-types">
        <h2>Post type</h2>
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
            <#
              _.each(data.post_types, function(postType) {
                  postTypeField = '<label>' + postType + '<input type="checkbox"' +
                                  ' name="post-type" value="' + postType + '"></label>';
                  print(postTypeField);
              });
            #>
        </fieldset>
      </fieldset>
    </div>
    <div id="gflcp-post-status">
      <fieldset class="lcp-post-status">
        <h2>Post status</h2>
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
          <#
            const statuses = ['publish', 'pending', 'draft', 'auto-draft',
                              'future', 'private', 'inherit', 'trash'];
            _.each(statuses, function(status, key) {
              let checked = key === 0 ? ' checked' : '';
          #>
            <label>{{status}}
              <input type="checkbox" name="post-status" value="{{status}}"{{checked}}>
            </label>
          <#
            });
          #>
        </fieldset>
      </fieldset>
    </div>
    <div id="gflcp-show-protected">
      <fieldset class="lcp-show-protected">
        <h2>Show protected</h2>
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
    <div id="gflcp-parent-post">
      <# printSwitchCheckbox('Parent post', 'lcp-parent-post', false) #>
      <fieldset class="lcp-parent-post" disabled>
        <h2>Parent post</h2>
        <div>
          <label>Disply only children of this parent post
            <input type="number" name="parent-post" min="0">
          </label>
        </div>
      </fieldset>
    </div>
    <div id="gflcp-custom-fields">
      <# printSwitchCheckbox('Custom fields', 'lcp-custom-fields', false) #>
      <fieldset class="lcp-custom-fields" disabled>
        <h2>Custom fields</h2>
        <div>
          <label>Customfield name
            <input type="text" name="customfield-name">
          </label>
          <label>Customfield value
            <input type="text" name="customfield-value">
          </label>
        </div>
      </fieldset>
    </div>
    <button type="submit" class="button media-button button-primary button-large media-button-insert">Insert into page</button>
  </form>
  </div>
</script>

<script type="text/html" id="tmpl-taxonomy-terms">
  <#
    _.each(data, function(terms, taxonomy) {
    #>
    <div id="{{{taxonomy}}}-terms">
    <h3>{{{taxonomy}}}</h3>
    <#
      _.each(terms, function(term) {
      #>
      <label>{{{term.name}}}
        <input type="checkbox" name="{{{taxonomy}}}-term" value="{{{term.slug}}}">
      </label>
      <#
      });
    #>
    </div>
    <#
    });
  #>

</script>