<?php

namespace Lanser\Elastic\ElasticEloquent;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Lanser\Elastic\ElasticEloquent\ElasticEloquentInterface\ElasticEloquentInterface;
use Lanser\Elastic\ElasticSearchBuilder\Interfce\ElasticBuilderInterface;
use stdClass;

class ElasticEloquent implements ElasticEloquentInterface
{
    public stdClass $elasticItem;

    protected function reset(): void
    {
        $this->elasticItem = null;
    }
    public function SetStdClass(stdClass $elasticItem): ElasticEloquentInterface
    {
        $this->reset();
        $this->elasticItem = $elasticItem;
        return $this;
    }


    public function paginate(int $perPage = 1, int $page = 1): LengthAwarePaginator
    {
        $items = $this->elasticItem;
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
    }

    public function find(int $id): ElasticEloquentInterface
    {
        $items = $this->getCollection();
        return $items->where("_id", "=", $id)->first();
    }

    public function getTook(): ElasticEloquentInterface
    {
        return $this->elasticItem->took;
    }

    public function getShards(): ElasticEloquentInterface
    {
        return $this->elasticItem->_shards;
    }

    public function getTotal(): ElasticEloquentInterface
    {
        return $this->elasticItem->hits->total->value;
    }

    public function getItems(): ElasticEloquentInterface
    {
        return $this->elasticItem->hits->hits;
    }

    public function getCollection(): Collection
    {
        return collect($this->getItems());
    }
}
