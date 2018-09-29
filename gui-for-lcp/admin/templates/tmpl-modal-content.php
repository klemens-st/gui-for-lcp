<script type="text/html" id="tmpl-modal-content">
  <header>
    <h1>List Category Posts: <?php _e('Shortcode Creator', 'gui-for-lcp') ?></h1>
  </header>
  <# if (data.hasData) { #>
  <form id="gflcp-form">
    <div id="gflcp-tabs">
      <ul>
        <li><a href="#gflcp-select-options"><?php _e('Selection', 'gui-for-lcp') ?></a></li>
        <li><a href="#gflcp-display-options"><?php _e('Display', 'gui-for-lcp') ?></a></li>
      </ul>
      <div id="gflcp-select-options"></div>
      <div id="gflcp-display-options"></div>
    </div>
    <button type="submit" class="gflcp-hidden-btn">Submit</button>
  </form>
  <# } else if (data.errored) { #>
  <div class="gflcp-alert">
    <p><?php _e('Failed fetching data from the server!', 'gui-for-lcp') ?></p>
    <button  type="button" class="button"><?php _e('Try again', 'gui-for-lcp') ?></button>
  </div>
  <# } else { #>
  <img
      src="<?php echo esc_url(plugin_dir_url(__FILE__)) ?>../assets/img/Spinner-1s-200px.svg"
      alt="<?php esc_attr_e('Loading', 'gui-for-lcp') ?>"
      class="gflcp-spinner"
    />
  <# } #>
  <footer class="gflcp-footer">
    <button
      type="submit"
      class="button media-button button-primary button-large media-button-insert"
      form="gflcp-form"
    >
      <?php _e('Insert into editor', 'gui-for-lcp') ?>
    </button>
    <button
      type="reset"
      form="gflcp-form"
      id="gflcp-reset"
      class="button"
    >
      <?php _e('Reset', 'gui-for-lcp') ?>
    </button>
  </footer>
</script>
