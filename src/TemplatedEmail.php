<?php

namespace Pragmatic\Mail;

use Illuminate\Support\Facades\Log;
use Throwable;
use Twig\Environment;

class TemplatedEmail extends \Symfony\Bridge\Twig\Mime\TemplatedEmail
{

  private ?string $subjectTemplate;

  public function subjectTemplate( string $template ): TemplatedEmail
  {
    $this->subjectTemplate = $template;

    return $this;
  }

  public function getSubjectTemplate(): ?string
  {
    return $this->subjectTemplate;
  }

  public function prepareSubject(): TemplatedEmail
  {
    if ( isset( $this->subjectTemplate ) )
      try
      {
        /** @var Environment $twig */
        $twig = app()->get( 'twig' );
        $subject = $twig->render( $this->getSubjectTemplate(), $this->getContext() );

        parent::subject( $subject );
      }
      catch ( Throwable $t )
      {
        Log::error( $t->getMessage() );
      }
    
    return $this;
  }
}