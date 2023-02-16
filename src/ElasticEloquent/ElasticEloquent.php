<?php

namespace Lanser\Elastic\ElasticEloquent;

use App\Services\MyElastic\ElasticEloquent\ElasticEloquentInterface\ElasticEloquentInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use stdClass;

class ElasticEloquent implements ElasticEloquentInterface
{
    public stdClass $elasticItem;

    public function __construct(stdClass $elasticItem)
    {
        $this->elasticItem = $elasticItem;
    }

    public function paginate(int $perPage = 1, int $page = 1): LengthAwarePaginator
    {
        $items = $this->getItems();
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
    }

    public function find(int $id)
    {
        $items = $this->getCollection();
        return $items->where("_id", "=", $id)->first();
    }

    public function getTook()
    {
        return $this->elasticItem->took;
    }

    public function getShards()
    {
        return $this->elasticItem->_shards;
    }

    public function getTotal()
    {
        return $this->elasticItem->hits->total->value;
    }

    public function getItems()
    {
        return $this->elasticItem->hits->hits;
    }

    public function getCollection(): Collection
    {
        return collect($this->getItems());
    }
}
