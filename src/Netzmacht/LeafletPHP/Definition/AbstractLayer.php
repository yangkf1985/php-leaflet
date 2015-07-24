<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\LeafletPHP\Definition;

/**
 * Bas class for the layer implementation.
 *
 * @package Netzmacht\LeafletPHP\Definition
 */
abstract class AbstractLayer extends AbstractDefinition implements Layer
{
    use LabelTrait;
    use OptionsTrait;

    /**
     * The connected map.
     *
     * @var Map
     */
    protected $map;

    /**
     * Add layer to the map.
     *
     * Instead create an addTo method, it's assigned to the map.
     * This is required so that the encoder knows the relation between the map and the layer.
     *
     * @param Map $map The leaflet map.
     *
     * @return $this
     */
    public function addTo(Map $map)
    {
        $this->map = $map;
        $map->addLayer($this);

        return $this->addMethod('addTo', array($map));
    }

    /**
     * Get the map.
     *
     * @return Map|null
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Remove the layer from the map.
     *
     * @return $this
     */
    public function remove()
    {
        if (!$this->map) {
            return $this;
        }

        return $this->removeFrom($this->map);
    }

    /**
     * @param HasRemovableLayers $container
     *
     * @return $this
     */
    public function removeFrom(HasRemovableLayers $container)
    {
        $container->removeLayer($this);

        return $this;
    }

    /**
     * Set the pane option.
     *
     * @param string $name The name of the pane.
     *
     * @return $this
     */
    public function setPane($name)
    {
        return $this->setOption('pane', $name);
    }

    /**
     * Get the pane option.
     *
     * This method does not work like L.Layer.getPane which returns a pane defined in the map.
     * Use getMap()->getPane('name') instead.
     *
     * @return string.
     */
    public function getPane()
    {
        return $this->getOption('pane', 'overlayPane');
    }

    /**
     * Set the names of non bubling events.
     *
     * @param array $events The name of events.
     *
     * @return $this
     */
    public function setNonBubblingEvents(array $events)
    {
        return $this->setOption('nonBubblingEvents', $events);
    }

    /**
     * Get the non bubling events option.
     *
     * @return array
     */
    public function getNonBubblingEvents()
    {
        return $this->getOption('nonBubblingEvents', []);
    }

    /**
     * Call the isPopupOpen method.
     *
     * @return $this
     */
    public function isPopupOpen()
    {
        return $this->addMethod('isPopupOpen');
    }
}
