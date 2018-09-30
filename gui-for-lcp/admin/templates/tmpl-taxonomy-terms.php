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
