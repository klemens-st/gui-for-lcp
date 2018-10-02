<?php
/**
 * GUI for LCP: Taxonomy terms template.
 *
 * Used by TaxTermsSubview.js.
 *
 * @author     Klemens Starybrat
 *
 * @package gui_for_lcp\admin\templates
 * @since 1.0.0
 */

?>

<script type="text/html" id="tmpl-taxonomy-terms">
  <# _.each(data, function(terms, taxonomy) { #>
    <fieldset id="{{taxonomy}}-terms">
      <legend>{{taxonomy}}</legend>
      <ul class="cat-checklist term-checklist">
        {{{terms}}}
      </ul>
    </fieldset>
  <# }); #>
</script>
