<?php


namespace Storyfaktor\Mail;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\ViewFinderInterface;
use Illuminate\View\ViewName;
use InvalidArgumentException;

class LiquidViewFactory implements Factory
{

  /**
   * The view finder implementation.
   *
   * @var \Illuminate\View\ViewFinderInterface
   */
  protected $finder;

  /**
   * Data that should be available to all templates.
   *
   * @var array
   */
  protected $shared = [];

  /**
   * Create a new view factory instance.
   *
   * @param \Illuminate\View\ViewFinderInterface $finder
   */
  public function __construct( ViewFinderInterface $finder )
  {
    $this->finder = $finder;
  }

  /**
   * Determine if a given view exists.
   *
   * @param string $view
   * @return bool
   */
  public function exists( $view )
  {
    try
    {
      $this->finder->find( $view );
    }
    catch ( InvalidArgumentException $e )
    {
      return false;
    }

    return true;
  }

  /**
   * Get the evaluated view contents for the given path.
   *
   * @param string                                        $path
   * @param \Illuminate\Contracts\Support\Arrayable|array $data
   * @param array                                         $mergeData
   * @return LiquidView
   */
  public function file( $path, $data = [], $mergeData = [] )
  {
    $data = array_merge( $mergeData, $this->parseData( $data ) );

    return new LiquidView( $path, $path, $data );
  }

  /**
   * Get the evaluated view contents for the given view.
   *
   * @param string                                        $view
   * @param \Illuminate\Contracts\Support\Arrayable|array $data
   * @param array                                         $mergeData
   * @return LiquidView
   */
  public function make( $view, $data = [], $mergeData = [] )
  {
    $path = $this->finder->find(
        $view = ViewName::normalize( $view )
    );

    $data = array_merge( $mergeData, $this->parseData( $data ) );

    return new LiquidView( $view, $path, $data );
  }

  /**
   * Add a piece of shared data to the environment.
   *
   * @param array|string $key
   * @param mixed|null   $value
   * @return mixed
   */
  public function share( $key, $value = null )
  {
    $keys = is_array( $key ) ? $key : [ $key => $value ];

    foreach ( $keys as $key => $value )
    {
      $this->shared[$key] = $value;
    }

    return $value;
  }

  /**
   * Parse the given data into a raw array.
   *
   * @param mixed $data
   * @return array
   */
  protected function parseData( $data )
  {
    return $data instanceof Arrayable ? $data->toArray() : $data;
  }

  /**
   * Add a new namespace to the loader.
   *
   * @param string       $namespace
   * @param string|array $hints
   * @return LiquidViewFactory
   */
  public function addNamespace( $namespace, $hints )
  {
    $this->finder->addNamespace( $namespace, $hints );

    return $this;
  }

  /**
   * Replace the namespace hints for the given namespace.
   *
   * @param string       $namespace
   * @param string|array $hints
   * @return LiquidViewFactory
   */
  public function replaceNamespace( $namespace, $hints )
  {
    $this->finder->replaceNamespace( $namespace, $hints );

    return $this;
  }

  // ---------------------------------------------------------------------------
  // We ignore these events for now. Liquid views can be seen as self contained
  // templates. From Laravel’s point of view, there is no composition to be made.
  // This is done implicitly within the liquid subsystem.

  public function composer( $views, $callback )
  {
    // ignored
  }

  public function creator( $views, $callback )
  {
    // ignored
  }
}