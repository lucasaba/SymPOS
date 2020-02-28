<?php

namespace App\Tests\Functional\GraphQL\Mutation;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductTest extends WebTestCase
{
    public function testProductCanBeAdded()
    {
        $client = $this->createClient();
        $client->request('POST', '/', [
            'query' => 'mutation {
                addProduct(input:{
                    name:"Product test name"
                    price:10,
                    image:"no_image.png"
                }){
                    id
                }
            }']);

        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $response = json_decode($client->getResponse()->getContent());

        $client->request('POST', '/', [
            'query' => '
                {
                  product(id: "' . $response->data->addProduct->id .'") {
                    name
                  }
                }
            ']);

        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $response = json_decode($client->getResponse()->getContent());
        $this->assertEquals('Product test name', $response->data->product->name);
    }
}
