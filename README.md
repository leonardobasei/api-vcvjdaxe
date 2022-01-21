# ![Laravel Example App](logo.png)

# Version

- `Laravel` - 8.79.0
- `PHP` - 8.0.12
- `Composer` - 2.1.12

The api can be accessed at [http://localhost:8000/api](http://localhost:8000/api).

# Code overview

## Routes

- `stock:GET` - Contains all movements
- `movement:PUT` - Contains all the api controllers
- `product:POST` - Contains the JWT auth middleware

## Default

- `Style Guide` - PSR 12

# Use

## Get All Movements

- No parameters needed 

## Create Product

```json
{
	"name" : "produto 10",
	"quantity" : "100"
}
```

## Create Movement

```json
{
	"sku" : "2",
	"quantity" : "-500"
}
```