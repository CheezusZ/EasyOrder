<?= $this->extend('templatelogin') ?>
<?= $this->section('content') ?>

  <main>
  <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card" style="width: 24rem;">
            <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Login</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="signup-tab" data-bs-toggle="tab" data-bs-target="#signup" type="button" role="tab" aria-controls="signup" aria-selected="false">Sign Up</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <h4 class="text-center mt-3">Login</h4>
                        <form action="<?= site_url('attemptAuth') ?>" method="post" class="px-3">
                            <input type="hidden" name="action" value="login">
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary bg-dkgreen">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                        <h4 class="text-center mt-3">Sign Up</h4>
                        <form action="<?= site_url('attemptAuth') ?>" method="post" class="px-3">
                            <input type="hidden" name="action" value="signup">
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="restaurant_name" class="form-control" placeholder="Restaurant Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="location" class="form-control" placeholder="Location" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="city" class="form-control" placeholder="City" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary bg-dkgreen">Signup</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </main>

<?= $this->endSection() ?>
