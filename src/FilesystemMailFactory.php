<?php


namespace Pragmatic\Mail;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;

// TODO Die Fileextension der Templates ist ja per config einstellbar…
//
class FilesystemMailFactory implements Contracts\MailFactory
{

  private string $root;

  public function __construct( string $root )
  {
    $this->root = $root;
  }

  /**
   * @inheritDoc
   */
  public function exists( string $name, string $kind = null ): bool
  {
    if ( is_null( $kind ) )
    {
      return is_dir( $this->root . DIRECTORY_SEPARATOR . $name );
    }
    elseif ( 'text' === $kind )
    {
      return is_file( $this->root . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'text.twig' );
    }
    elseif ( 'html' === $kind )
    {
      return is_file( $this->root . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'html.twig' );
    }
    elseif ( 'subject' === $kind )
    {
      return is_file( $this->root . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'subject.twig' );
    }
    return false;
  }

  protected function getTxtTemplateName( string $name )
  {
    return sprintf( "%s%stext.twig", $name, DIRECTORY_SEPARATOR );
  }

  protected function getSubjectTemplateName( string $name )
  {
    return sprintf( "%s%ssubject.twig", $name, DIRECTORY_SEPARATOR );
  }

  protected function getHtmlTemplateName( string $name )
  {
    return sprintf( "%s%shtml.twig", $name, DIRECTORY_SEPARATOR );
  }

  /**
   * @inheritDoc
   */
  public function create( string $name, array $data = [] ): TemplatedEmail
  {
    $email = ( new TemplatedEmail() )
      ->context( $data );

    if ( $this->exists( $name, 'html' ) )
    {
      $email->htmlTemplate( $this->getHtmlTemplateName( $name ) );
    }
    if ( $this->exists( $name, 'text' ) )
    {
      $email->textTemplate( $this->getTxtTemplateName( $name ) );
    }
    if ( $this->exists( $name, 'subject' ) )
    {
      //$email->subjectTemplate( $this->getSubjectTemplateName( $name ) )
    }
    return $email;
  }

  public function getTemplateRoot(): string
  {
    return $this->root;
  }
}