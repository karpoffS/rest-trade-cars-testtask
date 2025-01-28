<?php


namespace App\DataMapper;


use App\Utils\PaginatedResult;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class BaseMapper
{
    private Collection $additionals;

    private Collection $collection;

    public function getAdditional(string $key): ?Collection
    {
        return $this->additionals->get($key);
    }

    public function from(object $data, array $additionals = [])
    {
        $this->fromCollection([$data]);

        return $this;
    }

    public function fromCollection($data, array $additionals = [])
    {
        $this->additionals = new ArrayCollection($additionals);
        if (is_array($data)) {
            $this->collection = new ArrayCollection($data);
        } else if ($data instanceof Collection) {
            $this->collection = $data;
        } else {
            throw new \InvalidArgumentException("Invalid collection type");
        }

        return $this;
    }

    /**
     * @param PaginatedResult $paginatedResult
     * @return array
     */
    public function paginate(PaginatedResult $paginatedResult): array
    {
        return [
            'data' => $this->fromCollection($paginatedResult->getItems())->map(true),
            'total' => $paginatedResult->getTotal(),
            'per_page' => $paginatedResult->getLimit(),
            'current_page' => $paginatedResult->getPage()
        ];
    }

    public function map($forceArray = false)
    {
        if (empty($this->collection)) {
            return [];
        }

        $result = array_map(
            fn($obj) => $this->toArray($obj),
            $this->collection->toArray(),
        );

        if (count($this->collection) === 1 && !$forceArray) {
            return $result[0];
        }

        return $result;
    }

    abstract protected function toArray($data);
}
