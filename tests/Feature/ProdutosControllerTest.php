<?php

namespace Tests\Feature;

use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProdutosControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_store_a_product_with_valid_data(): void
    {
        $payload = [
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição do produto teste',
            'preco' => 10.00,
            'quantidade' => 10
        ];

        $response = $this->post(route('produtos.store'), $payload);

        $response->assertStatus(201);
        $response->assertJson($payload);
        $this->assertDatabaseHas('produtos', $payload);
    }

    public function test_cant_register_a_product_with_invalid_data(): void
    {
        $payload = [
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição do produto teste',
            'preco' => 'teste',
            'quantidade' => 10
        ];

        $response = $this->post(
            route('produtos.store'),
            $payload,
            ['Accept' => 'application/json']
        );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['preco']);
        $this->assertDatabaseMissing('produtos', $payload);
    }

    public function test_cant_store_product_with_no_data(): void
    {
        $payload = [];

        $response = $this->post(
            route('produtos.store'),
            $payload,
            ['Accept' => 'application/json']
        );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nome', 'descricao', 'preco', 'quantidade']);
        $this->assertDatabaseMissing('produtos', $payload);
    }

    public function test_can_update_a_product_with_valid_data(): void
    {
        $product = Produto::factory()->create();

        $payload = [
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição do produto teste',
            'preco' => 10.00,
            'quantidade' => 10
        ];

        $response = $this->put(
            route('produtos.update', $product->id),
            $payload,
            ['Accept' => 'application/json']
        );

        $response->assertStatus(200);
        $response->assertJson($payload);
        $this->assertDatabaseHas('produtos', $payload);
    }

    public function test_cant_update_a_product_with_invalid_data(): void
    {
        $product = Produto::factory()->create();

        $payload = [
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição do produto teste',
            'preco' => 'teste',
            'quantidade' => 10
        ];

        $response = $this->put(
            route('produtos.update', $product->id),
            $payload,
            ['Accept' => 'application/json']
        );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['preco']);
        $this->assertDatabaseMissing('produtos', $payload);
    }

    public function test_can_list_paginated_products(): void
    {
        $response = $this->get(route('produtos.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'pagina_atual',
            'total_paginas',
            'total_registros',
            'registros_por_pagina',
            'registros' => [
                '*' => [
                    'id',
                    'nome',
                    'descricao',
                    'preco',
                    'quantidade'
                ]
            ]
        ]);
    }

    public function test_can_define_dynamically_products_pagination(): void
    {
        $response = $this->get(route('produtos.index', ['per_page' => 10]));

        $response->assertStatus(200);
        $this->assertEquals(10, $response->json('registros_por_pagina'));
    }

    public function test_can_find_a_unique_product(): void
    {
        $product = Produto::factory()->create();

        $response = $this->get(route('produtos.find', $product->id));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'nome',
            'descricao',
            'preco',
            'quantidade'
        ]);
        $response->assertJson([
            'id' => $product->id,
            'nome' => $product->nome,
            'descricao' => $product->descricao,
            'preco' => $product->preco,
            'quantidade' => $product->quantidade
        ]);
    }

    public function test_cant_find_a_product_with_invalid_id(): void
    {
        $response = $this->get(route('produtos.find', 999));

        $response->assertStatus(404);
    }

    public function test_can_successfully_delete_a_product(): void
    {
        $product = Produto::factory()->create();

        $response = $this->delete(route('produtos.delete', $product->id));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('produtos', ['id' => $product->id]);
    }
}
