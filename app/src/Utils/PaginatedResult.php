<?php


namespace App\Utils;


class PaginatedResult
{
    private array $items = [];
    private int $total;
    private int $page;
    private int $limit;

    /**
     * PaginatedResult constructor.
     * @param array $items
     * @param int $total
     * @param int $page
     * @param int $limit
     */
    public function __construct(array $items, int $total, int $page, int $limit)
    {
        $this->items = $items;
        $this->total = $total;
        $this->page = $page;
        $this->limit = $limit;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }
}