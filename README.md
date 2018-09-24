Allowed to add custom links relation to api-platform like `willdurand/hateoas-bundle` does.

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
        - rel: create
          href:
            route: api_orders_delete_item
            parameters:
                id: expr(object.getId())
          exclusion:
            groups: ['Details']
            exclude_if:  expr(is_granted('app_order_create') === false)
```
