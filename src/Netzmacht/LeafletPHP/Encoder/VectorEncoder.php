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
use Netzmacht\LeafletPHP\Definition\Vector;
use Netzmacht\LeafletPHP\Definition\Vector\Circle;
use Netzmacht\LeafletPHP\Definition\Vector\CircleMarker;
use Netzmacht\LeafletPHP\Definition\Vector\Polygon;
use Netzmacht\LeafletPHP\Definition\Vector\Polyline;
use Netzmacht\LeafletPHP\Definition\Vector\Rectangle;

/**
 * Class VectorEncoder encodes the vector elements.
 *
 * @package Netzmacht\LeafletPHP\Encoder
 */
class VectorEncoder extends AbstractEncoder
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
     * Compile a polyline.
     *
     * @param Polyline $polyline The polyline.
     * @param Encoder  $builder  The builder.
     *
     * @return void
     */
    public function encodePolyline(Polyline $polyline, Encoder $builder)
    {
        $this->doVectorEncode('polyline', $polyline, $builder);
    }

    /**
     * Compile a polygon.
     *
     * @param Polygon $polygon The polygon.
     * @param Encoder $builder The builder.
     *
     * @return void
     */
    public function encodePolygon(Polygon $polygon, Encoder $builder)
    {
        $this->doVectorEncode('polygon', $polygon, $builder);
    }

    /**
     * Compile a rectangle.
     *
     * @param Rectangle $rectangle The rectangle.
     * @param Encoder   $builder   The builder.
     *
     * @return void
     */
    public function encodeRectangle(Rectangle $rectangle, Encoder $builder)
    {
        $this->doVectorEncode('rectangle', $rectangle, $builder);
    }

    /**
     * Compile a circle.
     *
     * @param Circle  $circle  The circle.
     * @param Encoder $builder The builder.
     *
     * @return void
     */
    public function encodeCircle(Circle $circle, Encoder $builder)
    {
        $this->doCircleEncode('circle', $circle, $builder);
    }

    /**
     * Compile a circle marker.
     *
     * @param CircleMarker $circle  The circle marker.
     * @param Encoder      $builder The builder.
     *
     * @return void
     */
    public function encodeCircleMarker(CircleMarker $circle, Encoder $builder)
    {
        $this->doCircleEncode('circleMarker', $circle, $builder);
    }

    /**
     * Encode a vector.
     *
     * @param string  $type    The type name.
     * @param Vector  $vector  The vector.
     * @param Encoder $builder The builder.
     *
     * @return array
     */
    private function doVectorEncode($type, Vector $vector, Encoder $builder)
    {
        return sprintf(
            '%s = L.%s(%s);',
            $builder->encodeReference($vector),
            $type,
            $builder->encodeArguments(array($vector->getLatLngs(), $vector->getOptions()))
        );
    }

    /**
     * Encode a circle.
     * 
     * @param string  $type    The circle type.
     * @param Circle  $circle  The circle object.
     * @param Encoder $builder The builder.
     *
     * @return array
     */
    private function doCircleEncode($type, Circle $circle, Encoder $builder)
    {
        return sprintf(
            '%s = L.%s(%s);',
            $builder->encodeReference($circle),
            $type,
            $builder->encodeArguments(array($circle->getLatLng(), $circle, $circle->getOptions()))
        );
    }
}
