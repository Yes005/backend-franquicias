<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Paginable
{
    public function scopePaginateData($query, Request $request)
    {
        $perPage = $request->query('per_page',10);
        $page = $request->query('page',1);

        if ($perPage == -1){

            $data = $query->get();

            return [
                'data' => $data,
                'total' => $data->count(),
            ];
        }

        $paginated = $query->paginate($perPage,['*'],'page', $page);

        return [
            'data' => $paginated->items(),
            'total' => $paginated->total(),
        ];
    }
}
