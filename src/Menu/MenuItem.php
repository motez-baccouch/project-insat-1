<?php


namespace App\Menu;


class MenuItem
{

    private $title;
    private $routeName;
    private $parameters = array();

    public function __construct($title, $routeName, array $parameters = [])
    {
        $this->title = $title;
        $this->routeName = $routeName;
        $this->parameters = $parameters;

        if (!empty($this->routeName) ) return;

        $this->routeName = "underConstruction";
        $this->parameters =['title'=>$title];
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
     * @return mixed
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * @return array|mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}