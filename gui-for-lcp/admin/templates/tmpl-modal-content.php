<script type="text/html" id="tmpl-modal-content">
  <header>
    <h1>List Category Posts: Shortcode Creator</h1>
  </header>
  <# if (data.hasData) { #>
  <form id="lcp-insert-form">
    <div id="gflcp-tabs">
      <ul>
        <li><a href="#gflcp-select-options">Selection</a></li>
        <li><a href="#gflcp-display-options">Display</a></li>
      </ul>
      <div id="gflcp-select-options"></div>
      <div id="gflcp-display-options"></div>
    </div>
    <button type="submit" class="hidden-submit-btn">Submit</button>
  </form>
  <# } else if (data.errored) { #>
  <div class="gflcp-alert">
    <p>Failed fetching data from the server!</p>
    <button  type="button" class="button">Try again</button>
  </div>
  <# } else { #>
  <img
      src="<?php echo plugin_dir_url(__FILE__) ?>../assets/img/Spinner-1s-200px.svg"
      alt="Loading"
      class="gflcp-spinner"
    />
  <# } #>
  <footer class="gflcp-footer">
    <button
      type="submit"
      class="button media-button button-primary button-large media-button-insert"
      form="lcp-insert-form"
    >
      Insert into page
    </button>
    <button
      type="reset"
      form="lcp-insert-form"
      id="gflcp-reset"
      class="button"
    >
      Reset
    </button>
  </footer>
</script>
