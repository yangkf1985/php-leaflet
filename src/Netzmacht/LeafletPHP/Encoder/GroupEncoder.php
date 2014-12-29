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
use Netzmacht\Javascript\Exception\GetReferenceFailed;
use Netzmacht\Javascript\Output;
use Netzmacht\LeafletPHP\Definition;
use Netzmacht\LeafletPHP\Definition\Group\FeatureGroup;
use Netzmacht\LeafletPHP\Definition\Group\LayerGroup;

/**
 * Class GroupEncoder encodes group elements.
 *
 * @package Netzmacht\LeafletPHP\Encoder
 */
class GroupEncoder extends AbstractEncoder
{
    /**
     * {@inheritdoc}
     */
    public function setReference(Definition $definition, GetReferenceEvent $event)
    {
        if ($definition instanceof LayerGroup) {
            $event->setReference('layers.' . $definition->getId());
        }
    }

    /**
     * Compile the layer group.
     *
     * @param LayerGroup $layerGroup The layer group.
     * @param Encoder    $builder    The builder.
     * @param Output     $output     The output.
     *
     * @return bool
     */
    public function encodeLayerGroup(LayerGroup $layerGroup, Encoder $builder, Output $output)
    {
        return $this->doGroupEncode('layerGroup', $layerGroup, $builder, $output);
    }

    /**
     * Encode a feature group.
     *
     * @param FeatureGroup $featureGroup The layer group.
     * @param Encoder      $builder      The builder.
     * @param Output       $output       The output.
     *
     * @return bool
     */
    public function encodeFeatureGroup(FeatureGroup $featureGroup, Encoder $builder, Output $output)
    {
        return $this->doGroupEncode('featureGroup', $featureGroup, $builder, $output);
    }

    /**
     * Encode the group.
     *
     * @param string     $type    The group type.
     * @param LayerGroup $group   The group instance.
     * @param Encoder    $builder The builder.
     * @param Output     $output  The output.
     *
     * @return bool
     *
     * @throws GetReferenceFailed If reference could not created.
     */
    private function doGroupEncode($type, LayerGroup $group, Encoder $builder, Output $output)
    {
        $output->addLine(
            sprintf(
                '%s = L.%s(%s);',
                $builder->encodeReference($group),
                $type,
                $builder->encodeArguments(array($group->getLayers()))
            )
        );

        return true;
    }
}