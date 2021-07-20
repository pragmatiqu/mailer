<?php


namespace Storyfaktor\Mail;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;

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
  public function exists( string $name ): bool
  {
    return is_dir( $this->root . DIRECTORY_SEPARATOR . $name );
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
    return ( new TemplatedEmail() )
      ->htmlTemplate( $this->getHtmlTemplateName( $name ) )
      ->textTemplate( $this->getTxtTemplateName( $name ) )
      //->subjectTemplate( $this->getSubjectTemplateName( $name ) )
      ->context( $data );
  }
}