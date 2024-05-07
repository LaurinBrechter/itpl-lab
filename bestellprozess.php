
<?php
incoming post request
order = {"customer_id": 10,
    "order_items": [
    {"sku": 1, "amount": 100},
    {"sku": 12, "amount": 200}    
    ]}


// order anlegen -> Zeilen anlegen
order_id = insert_order(order.customer_id, "IN_PROCESS")
insert_order_details(order.order_items, order_id)


// prio rausfinden
customer = select_customer(order.customer_id) // SELECT cust_id, isVip FROM Customers WHERE cust_id = order.customer_id


for order_item in order.order_items:

    product = select_sku(order_item.sku) // SELECT storage_amount, sku FROM Products where sku = order_item.sku
    new_amount = product.storage_amount - order_item.amount



    // Bedarf kann mit Lager gedeckt werden
    if new_amount >= 0:
        to_send = order_item.amount
        to_produce = 0

        // unter Mindestbestand?
        if new_amount <= product.min_amount:
            to_produce = product.min_amount - new_amount
    
    // Kundenauftrag muss (teilweise) über Produktion gedeckt werden
    else:
        to_send = storage_amount
        to_produce =  abs(new_amount)

    
    if to_produce != 0:
        insert_production_order(order_item.sku, order_item.amount, order_id, customer.isVip, "OPEN") 
        // INSERT INTO ProductionPlan (sku, amount, order_id, status) VALUES (order_item.sku, order_item.amount, order_id, 'OPEN')

    
    update_storage_log(order_item.sku, to_send, "RESERVED")
    update_product_storage_amount(order_item.sku, to_send)
    


?>