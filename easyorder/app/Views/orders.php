<?= $this->extend('template') ?>
<?= $this->section('content') ?>

  <main>
      <section class="py-5 bg-light">
          <div class="container">
              <div class="row">
                  <div class="col-lg-6">
                      <h1 class="display-4">Order Management</h1>
                  </div>
                  
              </div>
          </div>
      </section>

      <section class="py-5">
        <div class="container">
            <h2 class="text-left mb-4">On-going orders (<?= count($activeOrders) ?>)</h2>
            <div class="row">
                <?php foreach ($activeOrders as $order): ?>
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">#<?= $order['order_id'] ?> Table <?= $order['table']['table_number'] ?></h4>
                                <p class="card-text"><?= $order['first_item'] ?><br>...</p>
                                <a href="<?= base_url('orders/' . $order['order_id']) ?>" class="btn btn-primary bg-dkgreen">View</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="container">
            <h2 class="text-left mb-3">Archived orders (<?= count($archivedOrders) ?>)</h2>
            <!-- <div class="text-md-end mb-1">
                <a href="<?= base_url('orders/clear') ?>" class="btn btn-primary bg-dkgreen" onclick="return confirm('Are you sure you want to clear archived orders?')">Clear</a>
            </div> -->
            <div class="row cont">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Table</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($archivedOrders as $order): ?>
                            <tr>
                                <td><?= $order['order_id'] ?></td>
                                <td><?= $order['table']['table_number'] ?></td>
                                <td><?= $order['created_at'] ?></td>
                                <td><?= $order['order_status'] ?></td>
                                <td><a href="<?= base_url('orders/' . $order['order_id']) ?>" class="btn btn-sm btn-primary bg-dkgreen me-2 mb-1"><i class="bi bi-eye-fill"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
  </main>

  <?= $this->endSection() ?>
