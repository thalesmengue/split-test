<?php

namespace App\Actions\Produtos;

use App\Models\Produto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListProdutoAction
{
    public function execute($data): LengthAwarePaginator
    {
        return Produto::query()->paginate($data->query('per_page', 5));
    }
}
