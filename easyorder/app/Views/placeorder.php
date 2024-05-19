<?= $this->extend('templatelogin') ?>
<?= $this->section('content') ?>

<main class="py-5">
    <div class="container">
        <h1 class="display-4 mb-5">Place your order - Table <?= $table['table_number'] ?></h1>
        <div id="order-items">
            <?php foreach ($categories as $category) : ?>
                <h2 class="card-title"><?= esc($category['category_name']) ?></h2>
                <hr>
                <?php foreach ($category['menu_items'] as $item) : ?>
                    <div class="row mb-4 align-items-start">
                        <div class="col-md-8">
                            <h5><strong><?= esc($item['item_name']) ?></strong></h5>
                            <?= esc($item['description']) ?>
                        </div>
                        <div class="col-md-2"><strong>$<?= esc($item['price']) ?></strong></div>
                        <div class="col-md-2 quantity-controls">
                            <button class="btn btn-dark" onclick="updateQuantity(this, -1, <?= $item['menu_item_id'] ?>)">-</button>
                            <input type="text" class="form-control quantity-input" data-menu-item-id="<?= $item['menu_item_id'] ?>" value="0" readonly>
                            <button class="btn btn-dark" onclick="updateQuantity(this, 1, <?= $item['menu_item_id'] ?>)">+</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
        <div class="mb-3">
            <label for="customer-email" class="form-label"><strong>Email</strong></label>
            <input type="email" class="form-control" id="customer-email" name="customer_email">
        </div>
        <div class="d-flex justify-content-between mt-5">
            <h3>Total Price: $<span id="total-price">0.00</span></h3>
            <button type="button" class="btn btn-primary bg-dkgreen" id="submit-order">Submit Order</button>
        </div>
    </div>
</main>

<script>
    function updateQuantity(button, change, menuItemId) {
        const quantityInput = button.parentNode.querySelector('.quantity-input');
        let quantity = parseInt(quantityInput.value);
        quantity += change;
        if (quantity < 0) {
            quantity = 0;
        }
        quantityInput.value = quantity;
        calculateTotalPrice();
    }

    function calculateTotalPrice() {
        const quantityInputs = document.querySelectorAll('.quantity-input');
        let totalPrice = 0;
        quantityInputs.forEach(input => {
            const price = parseFloat(input.parentNode.previousElementSibling.querySelector('strong').textContent.slice(1));
            const quantity = parseInt(input.value);
            totalPrice += price * quantity;
        });
        document.getElementById('total-price').textContent = totalPrice.toFixed(2);
    }

    document.getElementById('submit-order').addEventListener('click', function() {
        const customerEmail = document.getElementById('customer-email').value;
        const orderItems = Array.from(document.querySelectorAll('.quantity-input'))
            .filter(input => parseInt(input.value) > 0)
            .map(input => ({
                menu_item_id: parseInt(input.getAttribute('data-menu-item-id')),
                quantity: parseInt(input.value)
            }));

        if (orderItems.length > 0) {
            const totalPrice = parseFloat(document.getElementById('total-price').textContent);

            fetch('<?= base_url('placeorder/' . $table['table_id'] . '/createOrder') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    customer_email: customerEmail,
                    order_items: orderItems,
                    total_price: totalPrice
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message);
                }
            });
        }
    });
</script>

<?= $this->endSection() ?>