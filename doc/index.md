```yaml
mutation {
  addProduct(input:{
    name:"Product name"
    price:10.56
    image:"no_image_available.png"
  }){
    id
  }
}

mutation {
  addCategory(input:{
    name:"Panini"
    image:"no_image_available.png"
    products: [
      {
        name:"Coca"
        price:2.00
        image:"Coca.png"
      }
    ]
  }){
    id
  }
}
```

```yaml
{
  product(id: "aa153b8c-3629-44b7-8980-c03a1e9db479") {
    name
  }
}

{
  product(id: "80dd98f3-6be8-47e1-b647-c31ddef3087f") {
    name
    category {
      name
      products {
        name
      }
    }
  }
}
```

```php
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
```