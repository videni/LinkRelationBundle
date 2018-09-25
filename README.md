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
# Todo

1. support json-ld
2. remove `"willdurand/hateoas-bundle"` dependency for we only use a little part of it.

# License
this bundle is released under the MIT License.
