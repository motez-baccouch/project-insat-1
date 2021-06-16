<?php


namespace App\Menu;


class Menu
{
    private $sections = array();
    private $columns;

    public function __construct(array $sections)
    {
        $this->sections = $sections;
        $this->columns = 1;

        if(empty($sections))
            return;

        $itemsCount = 0;
        foreach ($sections as $section)
        {
            $itemsCount += count($section->getMenuItems());
        }
        $this->columns = intdiv($itemsCount, 8);
        if ($itemsCount % 8 > 0)
            $this->columns++;
    }

    /**
     * @return array
     */
    public function getSections(): array
    {
        return $this->sections;
    }

    /**
     * @return mixed
     */
    public function getColumns()
    {
        return $this->columns;
    }

}