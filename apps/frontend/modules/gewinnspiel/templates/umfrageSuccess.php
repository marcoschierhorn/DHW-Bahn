<script type="text/javascript">

      var uncheckValues = new Array(<?php echo implode(', ', (isset($uncheckValues) ? sfOutputEscaperArrayDecorator::unescape($uncheckValues) : array()));?>);
      function in_array (needle, haystack, argStrict) {
        var key = '', strict = !!argStrict;

        if (strict) {
            for (key in haystack) {
                if (haystack[key] === needle) {
                    return true;
                }
            }
        } else {
            for (key in haystack) {
                if (haystack[key] == needle) {
                    return true;
                }
            }
        }

        return false;
    }
    	function clearFormAndSetCheck(checkBox)
    	{
				if (in_array(checkBox.val(), uncheckValues))
				{
    	  	jQuery('input:checkbox').removeAttr('checked');
    	  	checkBox.attr("checked", "checked");
				}
    	}
    </script>
<form class="dankeUmfrage" action="<?php echo url_for('gewinnspiel/umfrage?step='.$nextStep)?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <fieldset>
  	<?php if ((int)$sf_request->getParameter('failure', 0)==1 || $form->hasErrors()):?>
  	<ul class="error_list" style="margin: 0 0 10px 0 !important;">
  		<li>Bitte wählen Sie eine der unten stehenden Antworten aus</li>
  	</ul>
  	<?php endif;?>
    <?php include_partial($formPartial, array('form' => $form));?>
  </fieldset>
  <fieldset>
        <div class="button-inside">
          <!-- Submit -->
          <span class="button-border right">
            <button type="submit" name="startbutton" class="highlight" value="1" title="Weiter">
              <span>Weiter</span>
            </button>
          </span>
        </div>
      </fieldset>
</form>