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

  public function executeDanke(sfWebRequest $request)
  {
    $this->forward404Unless($this->user = Doctrine_Core::getTable('User')->find(array($request->getParameter('id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));
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
      $user->getFullName().', danke für Ihre Gewinnspiel Teilnahme',
      <<<EOF
Vielen Dank für Ihre Teilnahme an unserem Gewinnspiel

Hier ist eCoupon {$user->getCodes()->getName()}.

Falls Sie sich abmelden möchten, klicken Sie bitte auf folgenden Link:

$abmeldenUrl

Ihre Deutsche Bahn.
EOF
    );
    $this->getMailer()->send($message);
  }
}
