<?= $this->extend('template') ?>
<?= $this->section('content') ?>

  <main>
  <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="display-4">Welcome back, <br><?= esc($user['restaurant_name']) ?></h1>
                    <p class="lead">Easily manage your business!</p>
                    <a href="#dashboard" class="btn btn-primary bg-dkgreen btn-lg mb-3 mb-lg-0">Dashboard</a>
                </div>
                <div class="col-lg-6">
                    <img src="images/kitchen.jpg" alt="Kitchen" class="img-fluid rounded shadow">
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
    </section>
      <section class="py-5">
        <div class="container" id="dashboard">
            <h2 class="text-left mb-4">Dashboard</h2>
            <div class="row">
              <div class="col-lg-3 mb-4">
                <a href="<?= base_url('orders'); ?>" style="text-decoration: none;">
                <div class="card" style="width: 16rem;">
                  <img src="images/order.png" class="card-img-top" alt="Order">
                  <div class="card-body">
                      <h5 class="card-title text-center"><strong>Orders</strong></h5>
                  </div>
                </div></a>
              </div>
              <div class="col-lg-3 mb-4">
                <a href="<?= base_url('menuedit'); ?>" style="text-decoration: none;">
                <div class="card" style="width: 16rem;">
                  <img src="images/menu.png" class="card-img-top" alt="Menu">
                  <div class="card-body">
                      <h5 class="card-title text-center"><strong>Menu</strong></h5>
                  </div>
                </div></a>
              </div>
              <div class="col-lg-3 mb-4">
                <a href="<?= base_url('qrcodes'); ?>" style="text-decoration: none;">
                <div class="card" style="width: 16rem;">
                  <img src="images/qrcode.png" class="card-img-top" alt="QR Codes">
                  <div class="card-body">
                      <h5 class="card-title text-center"><strong>QR Code</strong></h5>
                  </div>
                </div></a>
              </div>
              <div class="col-lg-3 mb-4">
                <a href="<?= base_url('admin'); ?>" style="text-decoration: none;" onclick="return alert('Only admin can access.')">
                <div class="card" style="width: 16rem;">
                  <img src="images/admin.png" class="card-img-top" alt="QR Codes">
                  <div class="card-body">
                      <h5 class="card-title text-center"><strong>Admin</strong></h5>
                  </div>
                </div></a>
              </div>
            </div>
        </div>
    </section>
  </main>

  <?= $this->endSection() ?>
