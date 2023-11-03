<?php
namespace App\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

class FrontendPaginator extends LengthAwarePaginator
{
    public function url($page)
    {
        if ($page <= 0) {
            $page = 1;
        }

        // remove ?page={number} from url and add 'page-{number}' if not added
        $url = preg_replace('/\?page=\d+/', '', $this->path());
        $url = preg_replace('/\/page-\d+/', '', $url);
        $url = rtrim($url, '/');
        $url = $url . '/page-' . $page;
        $url = preg_replace('/\/page-1/', '', $url);
        $url = $url . '?' . http_build_query(request()->query());
        return $url;
    }
}
