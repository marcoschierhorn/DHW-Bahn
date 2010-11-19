<form class="dankeUmfrage" action="<?php echo url_for('gewinnspiel/umfrage?step='.$nextStep)?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <fieldset>
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