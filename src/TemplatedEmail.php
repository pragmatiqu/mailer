<?php

namespace Pragmatic\Mail;

use Twig\Environment;

class TemplatedEmail extends \Symfony\Bridge\Twig\Mime\TemplatedEmail
{

  private ?string $subjectTemplate;

  public function subjectTemplate( ?string $template ): TemplatedEmail
  {
    $this->subjectTemplate = $template;

    return $this;
  }

  public function getSubjectTemplate(): ?string
  {
    return $this->subjectTemplate;
  }

  /**
   * @throws \Twig\Error\RuntimeError
   * @throws \Twig\Error\SyntaxError
   * @throws \Twig\Error\LoaderError
   */
  public function prepareSubject(): TemplatedEmail
  {
    /** @var Environment $twig */
    $twig = app()->get( 'twig' );
    $subject = $twig->render( $this->getSubjectTemplate(), $this->getContext() );

    parent::subject( $subject );

    return $this;
  }
}