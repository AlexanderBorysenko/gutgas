<?php

namespace App\Traits;

use App\Pagination\FrontendPaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait HasFrontendPaginator
{
    public function scopeFrontendPaginate(Builder $query, $perPage = 12, $columns = ['*'], $pageName = 'pageNumber', $page = null)
    {
        $page = $page ?: request()->get($pageName, 1);

        $total = $query->count();

        $items = $query->skip(($page - 1) * $perPage)->take($perPage)->get($columns);

        return new FrontendPaginator($items, $total, $perPage, $page, [
            'path' => FrontendPaginator::resolveCurrentPath(),
            'pageNumber' => $pageName,
        ]);
    }
}
