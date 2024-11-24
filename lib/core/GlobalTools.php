<?php

namespace Lib\core;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use View;

class GlobalTools extends Controller
{
    public function paginate(array $items, int $perPage = 10, $options = [], ?int $page = null): LengthAwarePaginator
    {
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $items = collect($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);


        // $currentPage = $request->input('page', 1);
        // $perPage = 5; // Jumlah item per halaman
        // $currentPageItems = array_slice($dataArray, ($currentPage - 1) * $perPage, $perPage);

        // // Buat paginator
        // $paginator = new LengthAwarePaginator(
        //     $currentPageItems,
        //     count($dataArray),
        //     $perPage,
        //     $currentPage,
        //     [
        //         'path' => $request->url(),
        //         'query' => $request->query(),
        //     ]
        // );


    }
}