<?php namespace SmallTeam\Dashboard\Menu;

use Illuminate\Support\Collection;
use SmallTeam\Dashboard\DashboardInterface;
use SmallTeam\Dashboard\Entity\EntityInterface;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Countable;
use IteratorAggregate;
use ArrayAccess;

/**
 * MenuBuilder
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 29.06.2015
 * */
class MenuBuilder implements Arrayable, Jsonable, JsonSerializable, Countable, IteratorAggregate, ArrayAccess
{

    /**
     * @var DashboardInterface
     * */
    protected $dashboard;

    /**
     * @var Collection
     * */
    protected $items;

    /**
     * Constructor.
     *
     * @param DashboardInterface $dashboard
     * */
    public function __construct(DashboardInterface $dashboard)
    {
        $this->dashboard = $dashboard;
        $this->items = new Collection();
    }

    /**
     * Build dashboard menu.
     *
     * @return void
     */
    public function build()
    {
        $entities = $this->dashboard->getEntities();

        if(!count($entities)) {
            return;
        }

        foreach ($entities as $name => $entity) {
            /** @var EntityInterface $entity */
            $this->add(new MenuItem(
                $entity->getName(),
                $this->dashboard->url($name),
                $this->dashboard->getEntity() === $entity,
                $entity->getIcon()
            ));
        }
    }

    /**
     * Add menu item.
     *
     * @param MenuItem $item
     *
     * @return self
     */
    public function add(MenuItem $item)
    {
        $this->items->push($item);

        return $this;
    }

    /**
     * Get all menu items.
     * 
     * @return Collection
     * */
    public function all()
    {
        return $this->items;
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return $this->items->getIterator();
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->items->offsetExists($key);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items->offsetGet($key);
    }

    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * @inheritdoc
     * */
    public function toArray()
    {
        return $this->items->toArray();
    }

    /**
     * @inheritdoc
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize ()
    {
        return $this->toArray();
    }

}