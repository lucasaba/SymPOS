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
```

```yaml
{
  product(id: "aa153b8c-3629-44b7-8980-c03a1e9db479") {
    name
  }
}
```