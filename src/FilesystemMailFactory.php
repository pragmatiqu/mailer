<?php


namespace Pragmatic\Mail;


class FilesystemMailFactory implements Contracts\MailFactory
{

  private string $root;
  private string $extension;

  public function __construct( string $root, string $extension = 'twig' )
  {
    $this->root = $root;
    $this->extension = $extension;
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
      return is_file( $this->root . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'text.' . $this->extension );
    }
    elseif ( 'html' === $kind )
    {
      return is_file( $this->root . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'html.' . $this->extension );
    }
    elseif ( 'subject' === $kind )
    {
      return is_file( $this->root . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'subject.' . $this->extension );
    }
    return false;
  }

  protected function getTxtTemplateName( string $name ): string
  {
    return sprintf( "%s%stext.%s", $name, DIRECTORY_SEPARATOR, $this->extension );
  }

  protected function getSubjectTemplateName( string $name ): string
  {
    return sprintf( "%s%ssubject.%s", $name, DIRECTORY_SEPARATOR, $this->extension );
  }

  protected function getHtmlTemplateName( string $name ): string
  {
    return sprintf( "%s%shtml.%s", $name, DIRECTORY_SEPARATOR, $this->extension );
  }

  /**
   * @inheritDoc
   */
  public function create( string $name, array $data = [] ): TemplatedEmail
  {
    $email = ( new TemplatedEmail() )->context( $data );

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
      $email->subjectTemplate( $this->getSubjectTemplateName( $name ) );
    }
    return $email;
  }

  public function getTemplateRoot(): string
  {
    return $this->root;
  }
}