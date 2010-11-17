<?php

/**
 * gewinnspiel actions.
 *
 * @package    bahn
 * @subpackage gewinnspiel
 * @author     Marco Schierhorn <marco.schierhorn@gmail.com>
 * @version    SVN: $Id$
 */
class gewinnspielActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new UserForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new UserForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('index');
  }

  public function executeDankeUmfrage(sfWebRequest $request)
  {
    //$this->forward404Unless($this->user = Doctrine_Core::getTable('User')->find(array($request->getParameter('id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));
  }

  public function executeDanke(sfWebRequest $request)
  {
    $this->forward404Unless($this->user = Doctrine_Core::getTable('User')->find(array($request->getParameter('id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));
    $this->form = new UserSurveyForm($this->user = Doctrine_Core::getTable('User')->find(array($request->getParameter('id', 1))));

    $this->processSurveyForm($request, $this->form);
  }

  protected function processSurveyForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter('user_survey'));
    if ($request->isMethod('post') && $form->isValid())
    {
      // Get a random eCoupon Code and store it in the Users Table

      $this->redirect('gewinnspiel/dankeUmfrage?id='.$form->getObject()->getId());
    }
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      // Get a random eCoupon Code and store it in the Users Table
      $q = Doctrine::getTable('Codes')
      ->createQuery('c')
      ->orderBy('RAND()')
      ->where('c.used != 1')
      ->limit(1);

      $code = $q->fetchOne();
      $user = $form->save();

      $user->setCodes($code);
      $user->save();

      $code->setUsed(true);
      $code->save();

      $this->sendCouponEmail($user);

      $this->redirect('gewinnspiel/danke?id='.$user->getId());
    }
  }

  public function executeAbmelden(sfWebRequest $request)
  {
    $this->forward404Unless($this->user = Doctrine_Core::getTable('User')->find(array($request->getParameter('id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($this->user->getUserSecCode()==$request->getParameter('sec'));

    $this->user->setAbgemeldet(true);
    $this->user->save();

  }

  function sendCouponEmail(User $user)
  {
    $abmeldenUrl = $this->getController()->genUrl('gewinnspiel/abmelden?id='.$user->getId().'&sec='.$user->getUserSecCode(), true);

    $message = $this->getMailer()->compose(
      array('m.schierhorn@esv-media.de' => 'Marco Schierhorn'),
      $user->getEmail(),
      'Teilnahmebestätigung und persönlicher eCoupon für Quer-durchs-Land-Ticket!',
      <<<EOF
Hallo $user->getFullName(),

vielen Dank für Deine Teilnahme an unserem „Wohin-Du-willst“-Gewinnspiel.

Wir drücken Dir die Daumen, dass Du zu den glücklichen Gewinnern von einem der 11 iPads oder 111 Quer-durchs-Land-Tickets gehörst.

Für Dein Interesse am Quer-durchs-Land-Ticket bedanken wir uns außerdem mit einem persönlichen eCoupon*, mit dem Du 6 Euro Rabatt auf ein Quer-durchs-Land-Tickets bekommst.

Dein persönlicher eCoupon*: $user->getCodes()->getName(

Also: Bis 30.04.2011 online ein Quer-durchs-Land-Ticket buchen, 6 Euro sparen, die Flatrate für ganz Deutschland testen und so weit, so oft und wohin Du willst fahren!

Mit besten Grüßen

Dein bahn.de-Team

* Der eCoupon ist vom 13.12.2010 bis 30.04.2011 gültig. Nur ein Coupon pro Ticket. Der Coupon gilt ausschließlich für den angegebenen Zeitraum. Umtausch, Erstattung und Barauszahlung sind grundsätzlich ausgeschlossen. Einlösung nur unter www.bahn.de bei Online-Buchung eines Quer-durchs-Land-Tickets zum Selbstausdrucken. Weitere Infos unter www.bahn.de/wohin-du-willst

Du hast diese E-Mail erhalten, weil Du an unserem „Wohin-Du-willst“-Gewinnspiel (www.bahn.de/wohin-du-willst unterlegen) teilgenommen hast. Solltest Du Dich nicht selbst angemeldet haben oder Dich vom Gewinnspiel wieder abmelden wollen, klicke bitte hier $abmeldenUrl, um alle Deine Daten zu löschen.
EOF
    );
    $this->getMailer()->send($message);
  }
}
