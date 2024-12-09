# Coding test:

## How to start

There is a Makefile to makes thing easier, so in order to have the service up and running you only have to do:

```bash
make setup
```

And the service should be running on the local machine.

To execute the unit tests you should write:

```bash
make tests
```

There is some make commands available in the Makefile.

## How to use the service

You can use CURL or a program similar to Postman to send data to the microservice.
The endpoint expects a POST request to https://localhost/discounts with a json body which validates to the next schema:

````json
{
    "$schema": "http://json-schema.org/draft-07/schema#",
    "type": "object",
    "properties": {
        "id": {
            "type": "string"
        },
        "customer-id": {
            "type": "string"
        },
        "items": {
            "type": "array",
            "items": {
                "type": "object",
                "properties": {
                    "product-id": {
                        "type": "string"
                    },
                    "quantity": {
                        "type": "string",
                        "pattern": "^[0-9]+$"
                    },
                    "unit-price": {
                        "type": "string",
                        "pattern": "^[0-9]+(.[0-9]{1,2})?$"
                    },
                    "total": {
                        "type": "string",
                        "pattern": "^[0-9]+(.[0-9]{1,2})?$"
                    }
                },
                "required": [
                    "product-id",
                    "quantity",
                    "unit-price",
                    "total"
                ]
            }
        },
        "total": {
            "type": "string",
            "pattern": "^[0-9]+(.[0-9]{1,2})?$"
        }
    },
    "required": [
        "id",
        "customer-id",
        "items",
        "total"
    ]
}
````

An example of body:
````json
{
    "id": "1",
    "customer-id": "1",
    "items": [
        {
            "product-id": "B102",
            "quantity": "10",
            "unit-price": "4.99",
            "total": "49.90"
        }
    ],
    "total": "49.90"
}
````

The microservice will return a json with recalculated total and a new item called applied_discounts, which will contain the description of the applied discounts, or an empty array.

* Example with empty array:
````json
{
    "id": 1,
    "customer_id": "1",
    "items": [
        {
            "product_id": "B102",
            "quantity": 10,
            "unit_price": 4.99,
            "total": 49.9
        }
    ],
    "total": 49.9,
    "applied_discounts": []
}
````
* Example with applied discounts:

Request:
````json
{
    "id": 1,
    "customer_id": "1",
    "items": [
        {
            "product_id": "B102",
            "quantity": 1000,
            "unit_price": 4.99,
            "total": 4900.9
        }
    ],
    "total": 4900.9,
    "applied_discounts": []
}
````

Response:
````json
{
    "id": 1,
    "customer_id": "1",
    "items": [
        {
            "product_id": "B102",
            "quantity": 1000,
            "unit_price": 4.99,
            "total": 4900.9
        }
    ],
    "total": 3582.47,
    "applied_discounts": [
        "A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.",
        "For every product of category \"Switches\" (id 2), when you buy five, you get a sixth for free."
    ]
}
````

## Things to improve:
* Write Functional and Integration tests, not only unit ones.
* Use a real database. 
* Use some standard for building APIs in JSON like jsonapi
* Implement some publisher to deal with events 
