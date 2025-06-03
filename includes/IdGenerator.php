<?php

namespace MD2Elementor;

/**
 * Id generator class
 *
 * @package MD2Elementor
 */
class IdGenerator
{
  /**
   * Instance of the IdGenerator
   *
   * @var IdGenerator
   */
  private static $instance = null;

  /**
   * Element ID
   *
   * @var int
   */
  private $elementId = 0;

  /**
   * Get the instance of the IdGenerator
   *
   * @return IdGenerator
   */
  public static function getInstance()
  {
    if (null === self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Generate a new ID
   *
   * @return string
   */
  public function generate()
  {
    $this->elementId++;
    return (string)$this->elementId;
  }
}
