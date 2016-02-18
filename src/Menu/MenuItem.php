<?php namespace SmallTeam\Dashboard\Menu;

use Illuminate\Support\Collection;

/**
 * MenuItem.
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 18.02.2016
 * */
class MenuItem
{
    /**
     * @var string
     * */
    protected $name;

    /**
     * @var bool
     * */
    protected $active = false;

    /**
     * @var string
     * */
    protected $link;

    /**
     * @var string
     * */
    protected $icon;

    /**
     * @var Collection
     * */
    protected $children;

    /**
     * Constructor.
     *
     * @param string $name
     * @param string|null $link
     * @param bool $active
     * @param string|null $icon
     * @param Collection|null $children
     * */
    public function __construct($name, $link = null, $active = false, $icon = null, Collection $children = null)
    {
        $this->setName($name);
        $this->setLink($link);
        $this->setActive($active);
        $this->setIcon($icon);
        $this->setChildren($children);
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Collection $children
     */
    public function setChildren(Collection $children = null)
    {
        $this->children = $children === null ? new Collection() : $children;
    }

}