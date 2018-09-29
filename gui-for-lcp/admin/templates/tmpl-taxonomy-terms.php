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
