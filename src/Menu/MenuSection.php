<?php


namespace App\Menu;


class MenuSection
{
    private $title;
    private $menuItems = array();

    public function __construct($title, $menuItems = [])
    {
        $this->title = $title;
        $this->menuItems = $menuItems;
    }

    public function addMenuItem(MenuItem $item) :self
    {
        if ($item)
        array_push($this->menuItems, $item);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function getMenuItems(): array
    {
        return $this->menuItems;
    }

    /**
     * @param array $menuItems
     */
    public function setMenuItems(array $menuItems): void
    {
        $this->menuItems = $menuItems;
    }



}