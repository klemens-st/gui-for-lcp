<script type="text/html" id="tmpl-display-options">
  <div class="gflcp-display-accordion">
    <h2>Pagination, Number of posts & Order</h2>
    <div class="gflcp-display-details">
      <label>
        <input type="checkbox" name="pagination">
        Pagination
      </label>
      <label>
        Number of posts (per page if pagination is on)
        <input type="number" name="numberposts" min="1">
        <small>Default: 10</small>
      </label>
      <label>
        Order by
        <select name="orderby">
          <#
            const orderbyOptions = {
              author: 'Author ID',
              category: 'Category ID',
              content: 'Content',
              date: 'Creation date',
              ID: 'Post ID',
              menu_order: 'Menu order',
              mime_type: 'MIME type',
              modified: 'Last modified date',
              name: 'Stub',
              parent: 'Parent ID',
              password: 'Password',
              rand: 'Random',
              status: 'Status',
              title: 'Title',
              type: 'Type',
            };

            _.each(orderbyOptions, function(val, key) {
          #>
              <option value="{{key}}"<# 'date' === key ? print(' selected') : null #>>{{val}}</option>
          <# }); #>
        </select>
      </label>
      <p>Order:</p>
      <label>
        Descending
        <input type="radio" name="order" value="desc" checked>
      </label>
      <label>
        Ascending
        <input type="radio" name="order" value="asc">
      </label>
    </div>
    <h2>List-specific options</h2>
    <div>
      <div class="gflcp-display-checkboxes">
        <label>
          <input type="checkbox" name="show-conditional-title">
          Conditional title
        </label>
        <label>
          <input type="checkbox" name="category-title">
          Category title
        </label>
        <label>
          <input type="checkbox" name="category-description" value="1">
          Category description
        </label>
        <label>
          <input type="checkbox" name="morelink" value="1">
          Morelink
        </label>
        <label>
          <input type="checkbox" name="wrapper-class" value="1">
          Specify wrapper class
        </label>
      </div>
      <div class="gflcp-display-details">
        <fieldset class="gflcp-category-title" disabled>
          <h3>Category title</h3>
          <div>
            <label>
              <input type="checkbox" name="catlink" value="1" checked>
              Wrap in a link to the category's archive
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
        </fieldset>
        <fieldset class="gflcp-show-conditional-title" disabled>
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
              <input type="text" name="conditional-title-class">
            </label>
            <label>
              Conditional title's HTML tag
              <input type="text" name="conditional-title-tag">
            </label>
          </div>
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
        <fieldset class="gflcp-wrapper-class" disabled>
          <h3>Wrapper's class</h3>
          <div>
            <label>
              CSS class
              <input type="text" name="class">
            </label>
          </div>
        </fieldset>
      </div>
    </div>
    <h2>Post-specific options</h2>
    <div>
      <div class="gflcp-display-checkboxes">
        <label>
          <input type="checkbox" name="display-author" value="1">
          Author
        </label>
        <label>
          <input type="checkbox" name="comments" value="1">
          Comment count
        </label>
        <label>
          <input type="checkbox" name="content" value="1">
          Content
        </label>
        <label>
          <input type="checkbox" name="customfield" value="1">
          Custom fields
        </label>
        <label>
          <input type="checkbox" name="display-date" value="1">
          Date
        </label>
        <label>
          <input type="checkbox" name="date-modified" value="1">
          Date modified
        </label>
        <label>
          <input type="checkbox" name="excerpt" value="1">
          Excerpt
        </label>
        <label>
          <input type="checkbox" name="posts-id" value="1">
          Post's ID
        </label>
        <label>
          <input type="checkbox" name="suffix" value="1">
          Post's suffix
        </label>
        <label>
          <input type="checkbox" name="posts-morelink" value="1">
          Post's morelink
        </label>
        <label>
          <input type="checkbox" name="tags-as-class" value="1">
          Tags as class
        </label>
        <label>
          <input type="checkbox" name="post-title" value="1" checked>
          Title
        </label>
        <label>
          <input type="checkbox" name="thumbnail" value="1">
          Thumbnail
        </label>
      </div>
      <div class="gflcp-display-details">
        <fieldset class="gflcp-display-author" disabled>
          <h3>Author</h3>
          <div>
            <label>
              Author's class
              <input type="text" name="display-author-class">
            </label>
            <label>
              Author's HTML tag
              <input type="text" name="display-author-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-comments" disabled>
          <h3>Comment count</h3>
          <div>
            <label>
              Comment count's class
              <input type="text" name="comments-class">
            </label>
            <label>
              Comment count's HTML tag
              <input type="text" name="comments-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-content" disabled>
          <h3>Content</h3>
          <div>
            <label>
              <input type="checkbox" name="content-full" value="1">
              Ignore post's 'more' tag
            </label>
          </div>
          <div>
            <label>
              Content's class
              <input type="text" name="content-class">
            </label>
            <label>
              Comntent's HTML tag
              <input type="text" name="content-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-customfield gflcp-row-span-2" disabled>
          <h3>Custom fields</h3>
          <div>
            <label>
              Custom fields' names, comma separated
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
              Display separately
            </label>
            <label>
              Text to display between custom fields
              <input type="text" name="customfield-display-glue">
              <small>Default: empty string</small>
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
              Display each custom field's name
            </label>
            <label>
              Text to display between name and value of each custom field
              <input type="text" name="customfield-display-name-glue">
              <small>Default: ' : '</small>
            </label>
          </div>
          <div>
            <label>
               Custom fields' class
              <input type="text" name="customfield-class">
            </label>
            <label>
              Custom fields' HTML tag
              <input type="text" name="customfield-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-display-date" disabled>
          <h3>Date</h3>
          <div>
            <label>
              Date's class
              <input type="text" name="display-date-class">
            </label>
            <label>
              Date's HTML tag
              <input type="text" name="display-date-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-date-modified" disabled>
          <h3>Date modified</h3>
          <div>
            <label>
              Date modified's class
              <input type="text" name="date-modified-class">
            </label>
            <label>
              Date modified's HTML tag
              <input type="text" name="date-modified-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-excerpt gflcp-row-span-2" disabled>
          <h3>Excerpt</h3>
          <div>
            <label>
              <input type="checkbox" name="excerpt-full" value="1" class="gflcp-toggles-fieldset">
              Use full excerpt
            </label>
            <fieldset class="gflcp-excerpt-full">
              <label>
                <input type="checkbox" name="excerpt-overwrite" value="1">
                Ignore post's explicit excerpt
              </label>
              <label>
                <input type="checkbox" name="excerpt-strip" value="1" checked>
                Strip HTML tags
              </label>
              <label>
                Excerpt's size (word count)
                <input type="number" name="excerpt-size" min="1">
                <small>Default: 55</small>
              </label>
            </fieldset>
          </div>
          <div>
            <label>
              Excerpt's class
              <input type="text" name="excerpt-class">
            </label>
            <label>
              Excerpt's HTML tag
              <input type="text" name="excerpt-tag">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-suffix" disabled>
          <h3>Post's suffix</h3>
          <div>
            <label>
              Text to display after the title
              <input type="text" name="post-suffix">
              <small>Default: empty string</small>
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-posts-morelink" disabled>
          <h3>Post's morelink</h3>
          <div>
            <label>
              Post's morelink's class
              <input type="text" name="posts-morelink-class">
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-post-title">
          <h3>Title</h3>
          <div>
            <label>
              Character limit
              <input type="number" name="title-limit" min="1">
              <small>Default: unlimited</small>
            </label>
          </div>
          <div>
            <label>
              <input type="checkbox" name="link-titles" value="1" checked>
              Wrap titles in links
            </label>
          </div>
        </fieldset>
        <fieldset class="gflcp-thumbnail" disabled>
          <h3>Thumbnail</h3>
          <div>
            <label>
              <input type="checkbox" name="force-thumbnail" value="1">
              Force thumbnail
            </label>
          </div>
          <div>
            <label>
              Thumbnail size
              <input type="text" name="thumbnail-size">
            </label>
          </div>
          <div>
            <label>
              Thumbnail's class
              <input type="text" name="thumbnail-class">
            </label>
          </div>
        </fieldset>
      </div>
    </div>
    <h2>Template</h2>
    <div>
      <label>
        Template's name
        <input type="text" name="template">
      </label>
    </div>
  </div>
</script>