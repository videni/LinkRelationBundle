VideniLinkRelationBundle
=======================

Allowed to add custom links relation to api-platform like `willdurand/hateoas-bundle` does. currently, only support `hal+json`.

# Usage

## Add link to item

Resources/serialization/Order.yml
```
App\Bundle\AppBundle\Entity\Order:
    attributes:
        id:
            groups: [Default, Details]
        total:
            groups: [Default, Details]
        state:
            groups: [Details]
        number:
            groups: [Details]
    relations:
        - rel: view
          href:
            route: api_orders_get_item
            parameters:
                id: expr(object.getId())
          exclusion:
            groups: ['Details']
            exclude_if:  expr(is_granted('app_order_view', object) === false)
        - rel: edit
          href:
            route: api_orders_put_item
            parameters:
                id: expr(object.getId())
          exclusion:
            groups: ['Details']
            exclude_if:  expr(is_granted('app_order_view', object) === false)
        - rel: delete
          href:
            route: api_orders_delete_item
            parameters:
                id: expr(object.getId())
          exclusion:
            groups: ['Details']
            exclude_if:  expr(is_granted('app_order_delete', object) === false)
```
## Add links to collection

first, add configuration to this bundle to show where link relation definition stores.
```
videni_link_relation:
    metadata:
        directories:
            - path: '@AppOrderBundle\Resources\config\serialization'
              namespace_prefix: 'ApiPlatform\Core\Bridge\Doctrine\Orm'
```

second,  add link relation definition.

src/Bundle/OrderBundle/Resources/config/serialization/Paginator.yml
```
ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator:
    relations:
        - rel: create
          href:
            route: api_orders_post_collection
          exclusion:
            groups: ['OrderCollection']
            exclude_if:  expr(is_granted('app_order_create') === false)
```

# An example response for collection
```json
{
    "_links": {
        "self": {
            "href": "/api/admin/orders"
        },
        "item": [
            {
                "href": "/api/admin/orders/338"
            }
        ],
        "create": {
            "href": "/api/admin/orders"
        }
    },
    "totalItems": 1,
    "itemsPerPage": 30,
    "_embedded": {
        "item": [
            {
                "_links": {
                    "self": {
                        "href": "/api/admin/orders/338"
                    },
                    "view": {
                        "href": "/api/admin/orders/338"
                    },
                    "edit": {
                        "href": "/api/admin/orders/338"
                    },
                    "delete": {
                        "href": "/api/admin/orders/338"
                    }
                },
                "id": 338,
                "number": "0b13e52d-b058-32fb-8507-10dec634a07c",
                "items": [],
                "items_total": 0,
                "adjustments": [],
                "adjustments_total": 0,
                "total": 0,
                "state": "fulfilled"
            }
        ]
    }
}
```
# Todo

1. support json-ld
2. remove `"willdurand/hateoas-bundle"` dependency for we only use a little part of it.

# License
this bundle is released under the MIT License.
