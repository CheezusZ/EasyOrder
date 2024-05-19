<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<main>
    <section class="py-5">
        <div class="container">
            <h1 class="display-4">Order Detail</h1>
            <div class="card my-4">
                <div class="card-body">
                    <h2 class="card-title">Order #<?= $order['order_id'] ?> - Table <?= $table['table_number'] ?></h2>
                    <p class="card-text"><strong>Status:</strong> <?= $order['order_status'] ?></p>
                    <p class="card-text"><strong>Order Time:</strong> <?= $order['created_at'] ?></p>
                    <p class="card-text"><strong>Customer Email:</strong> <?= $order['customer_email'] ?></p>
                    <hr>
                    <h3>Items:</h3>
                    <?php $counter = 1; ?>
                    <?php foreach ($orderItems as $orderItem): ?>
                        <p><?= $counter ?>. <?= $orderItem['menuItem']['item_name'] ?> - $<?= $orderItem['menuItem']['price'] ?></p>
                        <?php $counter++; ?>
                    <?php endforeach; ?>
                    <hr>
                    <h3>Total Price: $<?= $order['total_price'] ?></h3>
                </div>
            </div>
            <!-- Order status edit buttons only display when order is active. -->
            <?php if ($order['order_status'] == 'active'): ?>
                <div class="d-flex justify-content-between">
                    <form action="<?= base_url('orders/updateStatus/' . $order['order_id']) ?>" method="post">
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="btn btn-primary bg-dkgreen" onclick="return confirm('Are you sure you have completed this order?')">Complete</button>
                    </form>
                    <form action="<?= base_url('orders/updateStatus/' . $order['order_id']) ?>" method="post">
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="btn btn-secondary bg-dkgreen" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?= $this->endSection() ?>