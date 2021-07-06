<?php


namespace Storyfaktor\Mail;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\View;
use Liquid\Liquid;
use Liquid\Template;

class LiquidView implements View
{

  /**
   * The name of the view.
   *
   * @var string
   */
  protected $view;

  /**
   * The array of view data.
   *
   * @var array
   */
  protected $data;

  /**
   * The path to the view file.
   *
   * @var string
   */
  protected $path;

  /**
   * Create a new view instance.
   *
   * @param string $view
   * @param string $path
   * @param mixed  $data
   * @return void
   */
  public function __construct( $view, $path, $data = [] )
  {
    $this->view = $view;
    $this->path = $path;

    $this->data = $data instanceof Arrayable ? $data->toArray() : (array) $data;
  }

  /**
   * Get the name of the view.
   *
   * @return string
   */
  public function name()
  {
    return $this->view;
  }

  /**
   * Add a piece of data to the view.
   *
   * @param string|array $key
   * @param mixed        $value
   * @return LiquidView
   */
  public function with( $key, $value = null )
  {
    if ( is_array( $key ) )
    {
      $this->data = array_merge( $this->data, $key );
    }
    else
    {
      $this->data[$key] = $value;
    }

    return $this;
  }

  /**
   * Get the array of view data.
   *
   * @return array
   */
  public function getData()
  {
    return $this->data;
  }

  /**
   * Löst alle Variablen auf und gibt den gerenderten String zurück.
   *
   * @return array|string
   *
   * @throws \Throwable
   */
  public function render()
  {
    // TODO Caching aktivieren
    // @see https://github.com/kalimatas/php-liquid
    Liquid::set( 'INCLUDE_PREFIX', '' );

    // TODO Include Path setzen
    $template = new Template();
    if ( $content = file_get_contents( $this->path ) )
    {
      $template->parse( $content );
    }
    return $template->render( $this->getData() );
  }

  public function raw()
  {
    return file_get_contents( $this->path );
  }
}
