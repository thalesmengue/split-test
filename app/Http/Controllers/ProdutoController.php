<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProdutoResource;
use App\Http\Requests\ListProdutoRequest;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Actions\Produtos\ListProdutoAction;
use App\Actions\Produtos\StoreProdutoAction;
use Symfony\Component\HttpFoundation\Response;

class ProdutoController extends Controller
{
    public function index(ListProdutoRequest $request, ListProdutoAction $action): JsonResponse
    {
        $data = $action->execute($request);

        return response()->json([
            'pagina_atual' => $data->currentPage(),
            'total_paginas' => $data->lastPage(),
            'total_registros' => $data->total(),
            'registros_por_pagina' => $data->perPage(),
            'registros' => ProdutoResource::collection($data->items()),
        ]);
    }

    public function store(StoreProdutoRequest $request, StoreProdutoAction $action): JsonResponse
    {
       $data = $action->execute($request);

       return (new ProdutoResource($data))
           ->response()
           ->setStatusCode(Response::HTTP_CREATED);
    }

    public function find(Produto $produto): ProdutoResource
    {
        return new ProdutoResource($produto);
    }

    public function update(UpdateProdutoRequest $request, Produto $produto): ProdutoResource
    {
        $produto->update($request->all());

        return new ProdutoResource($produto);
    }

    public function delete(Produto $produto): JsonResponse
    {
        $produto->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
