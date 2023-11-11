<?php

namespace App\Actions\Produtos;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Model;

class StoreProdutoAction
{
    public function execute($data): Model
    {
        return Produto::query()->create($data->all());
    }
}
