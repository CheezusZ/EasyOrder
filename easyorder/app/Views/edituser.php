<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<main>
<section class="py-5 bg-light">
          <div class="container">
              <div class="row">
                  <div class="col-lg-6">
                      <h1 class="display-4">Admin Panel</h1>
                  </div>
                  
              </div>
          </div>
      </section>
    <section class="py-5">
        <div class="container">
            <h2>Edit User</h2>
            <form method="post" action="<?= base_url('admin/update/' . $user['user_id']); ?>">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="restaurant_name" class="form-label">Restaurant Name</label>
                    <input type="text" class="form-control" id="restaurant_name" name="restaurant_name" value="<?= esc($user['restaurant_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="<?= esc($user['location']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="<?= esc($user['city']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="owner" <?= $user['role'] === 'owner' ? 'selected' : '' ?>>Owner</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary bg-dkgreen">Update User</button>
            </form>
        </div>
    </section>
</main>

<?= $this->endSection() ?>