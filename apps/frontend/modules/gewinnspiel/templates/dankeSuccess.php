<div class="section clearfix" id="dankeGewinnspiel">
<p>
  <?php if (isset($user) && is_object($user) && $user->getAnrede()=='Herr'): ?>
  Lieber <?php echo $user->getFullName()?>,
  <?php else: ?>
  Liebe <?php echo $user->getFullName()?>,
  <?php endif;?>
  <br/><br/>
  vielen Dank für Deine Teilnahme an unserem „Wohin-Du-willst“-Gewinnspiel.
  <br/><br/>
  Wir drücken Dir die Daumen, dass Du eines von 11 iPads oder 111 Quer-durchs-Land-Tickets gewinnst.
  <br/><br/>
  Deinen persönlichen eCoupon-Code im Wert von 6 Euro, den Du bis 30. April 2011 für den Online-Kauf eines Quer-durchs-Land-Tickets einsetzen kannst, senden wir Dir gleich an Deine angegebene E-Mail-Adresse.
  <br/><br/>
  Wir würden uns freuen, wenn Du uns nachfolgend noch ein paar kurze Fragen beantworten könntest. Du hilfst uns damit, unser Angebot und unseren Service weiter zu verbessern.
  <br/><br/>
  Das Ausfüllen des Fragebogens ist freiwillig. Deine Angaben werden nicht personenbezogen erfasst und zur Beantwortung der 5 bis 6 Fragen benötigst Du nur ca. 5 Minuten.
  <br/><br/>
  Die Auswertung erfolgt anonym, ausschließlich zu Marktforschungszwecken und selbstverständlich unter Einhaltung der gesetzlichen Vorschriften des Datenschutzes und der <span class="texturl"><a target="_blank" href="http://www.bahn.de/p/view/home/info/schutz.shtml">Datenschutzgrundsätze</a></span> der Deutschen Bahn.
  <br/><br/>
  Für Deine Zeit und Mühe bedanken wir uns schon jetzt recht herzlich,
  <br/><br/>
  Dein bahn.de-Team
  <br/><br/>
  <p class="button-inside right" style="float:right;">
    <!-- Submit -->
     <span class="button-border">
    	<a href="<?php echo url_for('gewinnspiel/umfrage?id='.$user->getId().'&step=1', true)?>">
       	<span>Hier geht's zur Umfrage</span>
      </a>
    </span>
    <br/><br/>
    <span class="button-border">
 			<a href="http://www.bahn.de/quer-durchs-land" target="_blank"><span>Hier geht's zum Quer-durchs-Land-Ticket</span></a>
 		</span>
  </div>
</p>
</div>
