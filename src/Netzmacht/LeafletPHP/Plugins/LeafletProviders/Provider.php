<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\LeafletPHP\Plugins\LeafletProviders;

use Netzmacht\Javascript\Encoder;
use Netzmacht\Javascript\Type\ConvertsToJavascript;
use Netzmacht\LeafletPHP\Definition\AbstractDefinition;
use Netzmacht\LeafletPHP\Definition\LabelTrait;
use Netzmacht\LeafletPHP\Definition\Layer;
use Netzmacht\LeafletPHP\Definition\MapObject;
use Netzmacht\LeafletPHP\Definition\MapObjectTrait;

/**
 * Class Provider provides the L.tileLayer.provider plugin.
 *
 * @package Netzmacht\LeafletPHP\Plugins\LeafletProviders
 */
class Provider extends AbstractDefinition implements Layer, MapObject, ConvertsToJavascript
{
    use LabelTrait;
    use MapObjectTrait;

    /**
     * {@inheritdoc}
     */
    public static function getRequiredLibraries()
    {
        $libs   = parent::getRequiredLibraries();
        $libs[] = 'leaflet-providers';

        return $libs;
    }

    /**
     * Get the type of the definition.
     *
     * @return string
     */
    public static function getType()
    {
        return 'TileLayer.provider';
    }

    /**
     * Provider name.
     *
     * @var string
     */
    private $provider;

    /**
     * Variant name.
     *
     * @var string
     */
    private $variant;

    /**
     * Construct.
     *
     * @param string $identifier Element identifier.
     * @param string $provider   Provider name.
     * @param string $variant    Map variant.
     */
    public function __construct($identifier, $provider, $variant = null)
    {
        parent::__construct($identifier);

        $this->provider = $provider;
        $this->variant  = $variant;
    }

    /**
     * Get the provider.
     *
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Get the variant.
     *
     * @return string
     */
    public function getVariant()
    {
        return $this->variant;
    }

    /**
     * {@inheritdoc}
     */
    public function encode(Encoder $encoder, $finish = true)
    {
        $name = $this->getProvider();

        if ($this->getVariant()) {
            $name .= '.' . $this->getVariant();
        }

        return sprintf(
            '%s = L.tileLayer.provider(\'' . $name . '\')' . ($finish ? ';' : ''),
            $encoder->encodeReference($this)
        );
    }
}
