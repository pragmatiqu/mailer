<?php

namespace Storyfaktor\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\HtmlString;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Table\TableExtension;
use Liquid\Template;

class LiquidMailable extends Mailable
{

  /**
   * @var LiquidViewFactory
   */
  private $factory;

  /**
   * Das Layout, das für das Mail zu verwenden ist.
   *
   * @var string
   */
  protected $layout;

  /**
   * Der unformatierte Markdown String, e.g. aus einem Formular.
   *
   * @var string
   */
  protected $content;

  /**
   * Build the view for the message.
   *
   * @return array|string
   *
   * @throws \ReflectionException
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   * @throws \Throwable
   */
  protected function buildView()
  {
    $this->factory = app( LiquidViewFactory::class );

    $data = $this->buildViewData();

    if ( isset( $this->content ) )
    {
      $template = new Template();
      $template->parse( $this->content );
      $text = $template->render( $data );
    }
    else
    {
      $text = $this->factory->make( $this->view, $data )->render();
    }

    $environment = Environment::createCommonMarkEnvironment();
    $environment->addExtension( new TableExtension );
    $converter = new CommonMarkConverter( [
        'allow_unsafe_links' => false,
    ], $environment );
    $this->html = $converter->convertToHtml( $text );
    $this->textView = strip_tags( $this->html );

    return [
        'html' => $this->renderMarkdownHtml(),
        'text' => $this->renderMarkdownText()
    ];
  }

  /**
   * Build the Markdown view for the message.
   *
   * @return HtmlString
   *
   * @throws \Throwable
   */
  protected function renderMarkdownHtml()
  {
    $merged = $this->factory->make( 'layouts.' . $this->layout . '.layout', [
        'body'      => $this->html,
        'preheader' => mb_substr( $this->textView, 0, 60 ),
        'home'      => config( 'ci.home' ),
        'facebook'  => config( 'ci.facebook' ),
        'youtube'   => config( 'ci.youtube' ),
        'instagram' => config( 'ci.instagram' ),
        'url'       => config( 'app.url' )
    ] )->render();
    return new HtmlString( $merged );
  }

  /**
   * Build the text view for a Markdown message.
   *
   * @return HtmlString
   *
   * @throws \Throwable
   */
  protected function renderMarkdownText()
  {
    $view = $this->factory->make( 'layouts.' . $this->layout . '.text', [
        'body'      => $this->textView,
        'preheader' => mb_substr( $this->textView, 0, 60 ),
        'home'      => config( 'ci.home' ),
        'facebook'  => config( 'ci.facebook' ),
        'youtube'   => config( 'ci.youtube' ),
        'instagram' => config( 'ci.instagram' ),
        'url'       => config( 'app.url' )
    ] );
    return new HtmlString( $view->render() );
  }

  /**
   * Setzt die View für das Mailable und setzt die optionalen from und bcc Header.
   *
   * @param string $view
   * @param array  $data
   *
   * @return $this
   */
  public function liquid( $view, array $data = [] )
  {
    $this->view = $view;

    if ( isset( $data['from'] ) ) // Absender setzen
    {
      if ( isset( $data['from_name'] ) )
      {
        $this->from( $data['from'], $data['from_name'] );
      }
      else
      {
        $this->from( $data['from'] );
      }
    }

    if ( isset( $data['bcc'] ) )
    {
      $this->bcc( $data['bcc'] );
    }

    return $this;
  }

  /**
   * @param string $layout
   *
   * @return $this
   */
  public function layout( $layout )
  {
    $this->layout = $layout;

    return $this;
  }

  /**
   * @param string $content
   *
   * @return $this
   */
  public function content( $content )
  {
    $this->content = $content;

    return $this;
  }

  /**
   * Set the subject of the message. Allows for replacement placeholders.
   *
   * @param string $subject
   * @param array  $data
   *
   * @return $this
   */
  public function subject( $subject, $data = [] )
  {
    $template = new Template();
    $template->parse( $subject );
    $this->subject = $template->render( $data );

    return $this;
  }
}
