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
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-lg-0">
                    <form method="get" action="<?= base_url('admin'); ?>">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search users..." name="search" value="<?= isset($search) ? esc($search) : '' ?>">
                            <button class="btn btn-primary bg-dkgreen" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>Restaurant Name</th>
                        <th>Location</th>
                        <th>City</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= esc($user['user_id']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td><?= esc($user['restaurant_name']) ?></td>
                            <td><?= esc($user['location']) ?></td>
                            <td><?= esc($user['city']) ?></td>
                            <td><?= esc($user['role']) ?></td>
                            <td>
                                <a href="<?= base_url('admin/edit/' . $user['user_id']) ?>" class="btn btn-sm btn-info bg-dkgreen me-2 mb-1"><i class="bi bi-pencil-fill"></i></a>
                                <a href="<?= base_url('admin/delete/' . $user['user_id']) ?>" class="btn btn-sm btn-warning bg-dkgreen mb-1" onclick="return confirm('Are you sure you want to delete this user?')"><i class="bi bi-dash-circle-fill"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?= $this->endSection() ?>