<div classs="clearfix">
    <label>2.   Wir würden gern wissen, wie gut Dir das Quer-durchs-Land-Ticket gefällt. Bitte gib zu jeder der folgenden Aussagen an, inwieweit diese Deiner Einschätzung nach auf das Angebot zutrifft, oder nicht. Du hast hierzu eine Skala von 5= 'trifft voll und ganz zu’ bis 1 = 'trifft überhaupt nicht zu' zur Verfügung. Mit den Werten dazwischen kannst Du Deine Beurteilung abstufen. Das Quer-durchs-Land-Ticket …</label>
  </div>

  <div class="clearfix matrix">
    <?php include_partial('matrixheader')?>
    <label>ist ein preislich attraktives Angebot</label><?php echo $form['preislich']->render();?>
  </div>
  <div class="clearfix matrix">
    <?php include_partial('matrixheader')?>
    <label>ist eine gute Alternative für spontane</label><?php echo $form['spontan']->render();?>
  </div>

  <div class="clearfix matrix">
    <?php include_partial('matrixheader')?>
    <label>ist insgesamt ein sehr gutes Angebot</label><?php echo $form['gutes_angebot']->render();?>
  </div>

  <div class="clearfix matrix">
    <?php include_partial('matrixheader')?>
    <label>ist das ideale Angebot für Reisen mit Freunden</label><?php echo $form['freunden']->render();?>
  </div>

  <div class="clearfix matrix">
    <?php include_partial('matrixheader')?>
    <label>ist besonders für weite Entfernungen geeignet</label><?php echo $form['entfernung']->render();?>
  </div>

  <div class="clearfix matrix">
    <?php include_partial('matrixheader')?>
    <label>ist ein tolles Angebot für junge Leute</label><?php echo $form['junge']->render();?>
  </div>