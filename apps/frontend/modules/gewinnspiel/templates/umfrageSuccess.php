Fragebogen:<br/>
<br/><br/>
<form class="dankeUmfrage" action="<?php echo url_for('gewinnspiel/umfrage'.(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>&step=<?php $sf_request->getParameter('step', 1)?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <fieldset>
    <?php include_partial($formPartial, array('form' => $form));?>
  </fieldset>
</form>