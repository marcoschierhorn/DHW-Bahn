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
    /*
    $q = Doctrine::getTable('Codes')
      ->createQuery('c')
      ->orderBy('RAND()')
      ->where('c.used != 1')
      ->limit(1);
     $code = $q->fetchOne();
		*/
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

  }

  public function executeDanke(sfWebRequest $request)
  {
    $this->forward404Unless($this->user = Doctrine_Core::getTable('User')->find(array($this->getUser()->getAttribute('user_id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));
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

      $this->getUser()->setAttribute('user_id', $user->getId());
      $this->getUser()->setAttribute('show4', false);
      $this->redirect('gewinnspiel/danke');
    }
  }

  public function executeUmfrage(sfWebRequest $request)
  {

    if (!$this->getUser()->hasAttribute('user_id') || (int) $this->getUser()->getAttribute('user_id') <= 0)
    {
      $this->redirect('gewinnspiel/index');
    }

    $this->forward404Unless($this->user = Doctrine_Core::getTable('User')->find(array($this->getUser()->getAttribute('user_id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));

    if ($this->getUser()->hasAttribute('lastStep'))
    {
      if ((int) $this->getUser()->getAttribute('lastStep') + 2 < (int) $request->getParameter('step', 1))
      {
        $this->redirect('gewinnspiel/umfrage?step='.intval($this->getUser()->getAttribute('lastStep')+1));
      }
    }

    $this->form = new UserSurveyForm($this->user, array('step' => $request->getParameter('step', 1)));

    if ((int) $request->getParameter('step', 1)>1)
      $this->oldForm = new UserSurveyForm($this->user, array('step' => intval($request->getParameter('step', 1)-1)));
    else
      $this->oldForm = null;

    $this->nextStep = intval($request->getParameter('step', 1))+1;

    $this->formPartial = $this->form->formPartial;

    $this->processUmfrageForm($request, $this->form, $this->oldForm, $this->user);

    if ((int) $request->getParameter('step', 1)==2)
    {
      if ((int) $this->oldForm->getValue('survey_angebot_bekannt_id')==4)
      {
        $this->getUser()->setAttribute('show4', true);
      }
    }

    if ((int) $request->getParameter('step', 1)==3 && $this->getUser()->getAttribute('show4')==false)
    {
      $this->getUser()->setAttribute('lastStep', 4);;
      $this->nextStep = 5;
    }

    if ((int) $request->getParameter('step', 1)>6)
    {
      $this->getUser()->setAttribute('user_id', false);
      $this->redirect('gewinnspiel/dankeUmfrage?id='.$this->user->getId());
    }
  }

  protected function processUmfrageForm(sfWebRequest $request, sfForm $form, $oldForm = null, User $user)
  {
    if ($oldForm!=null)
    {
      $oldForm->bind($request->getParameter($oldForm->getName()), $request->getFiles($oldForm->getName()));

      if ($oldForm->isValid())
      {
        $oldForm->save();
        $this->getUser()->setAttribute('lastStep', (int) $oldForm->getOption('step'));
      }
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

    $username   = $user->getFullName();
    $couponCode = $user->getCodes()->getName();

    $message = $this->getMailer()->compose(
      array('wohin-du-willst@deutschebahn.com' => 'Quer-durchs-Land'),
      $user->getEmail(),
      'Teilnahmebestätigung und Rabatt-Coupon für ein Quer-durchs-Land-Ticket!',
      'wohin-du-willst@bahn.unispezial.de',
      <<<EOF
Hallo $username,

vielen Dank für Deine Teilnahme an unserem „Wohin-Du-willst“-Gewinnspiel.

Wir drücken Dir die Daumen, dass Du zu den glücklichen Gewinnern von einem der 11 iPads oder 111 Quer-durchs-Land-Tickets gehörst.

Für Dein Interesse am Quer-durchs-Land-Ticket bedanken wir uns außerdem mit einem persönlichen eCoupon*, mit dem Du 6 Euro Rabatt auf ein Quer-durchs-Land-Ticket bekommst.

Dein persönlicher eCoupon*: $couponCode

Also: Bis 30.04.2011 online ein Quer-durchs-Land-Ticket buchen, 6 Euro sparen, die Flatrate für ganz Deutschland testen und so weit, so oft und wohin Du willst fahren!

Mit besten Grüßen

Dein bahn.de-Team

* Der eCoupon ist vom 13.12.2010 bis 30.04.2011 gültig. Nur ein Coupon pro Ticket. Der Coupon gilt ausschließlich für den angegebenen Zeitraum. Umtausch, Erstattung und Barauszahlung sind grundsätzlich ausgeschlossen. Einlösung nur unter www.bahn.de bei Online-Buchung eines Quer-durchs-Land-Tickets zum Selbstausdrucken. Weitere Infos unter www.bahn.de/wohin-du-willst

Du hast diese E-Mail erhalten, weil Du an unserem „Wohin-Du-willst“-Gewinnspiel (www.bahn.de/wohin-du-willst) teilgenommen hast. Solltest Du Dich nicht selbst angemeldet haben oder Dich vom Gewinnspiel wieder abmelden wollen, klicke bitte hier $abmeldenUrl, um alle Deine Daten zu löschen.
EOF
    );
    $this->getMailer()->send($message);
  }
}
