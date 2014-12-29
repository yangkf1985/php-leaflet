<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\LeafletPHP\Encoder;

use Netzmacht\Javascript\Encoder;
use Netzmacht\Javascript\Event\GetReferenceEvent;
use Netzmacht\LeafletPHP\Definition;
use Netzmacht\LeafletPHP\Definition\Layer;
use Netzmacht\LeafletPHP\Definition\Raster\TileLayer;

/**
 * Class RasterEncoder encodes raster layers.
 *
 * @package Netzmacht\LeafletPHP\Encoder
 */
class RasterEncoder extends AbstractEncoder
{
    /**
     * {@inheritdoc}
     */
    public function setReference(Definition $definition, GetReferenceEvent $event)
    {
        if ($definition instanceof Layer) {
            $event->setReference('layers.' . $definition->getId());
        }
    }

    /**
     * Encode a tile layer.
     *
     * @param TileLayer $layer   The layer.
     * @param Encoder   $builder The builder.
     *
     * @return bool
     *
     * @internal param Encoder $Encoder
     */
    public function encodeTileLayer(TileLayer $layer, Encoder $builder)
    {
        return sprintf(
            '%s = L.tileLayer(%s);',
            $builder->encodeReference($layer),
            $builder->encodeArguments(array($layer->getUrl(), $layer->getOptions()))
        );
    }
}