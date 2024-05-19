<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<main>
      <section class="py-5 bg-light">
          <div class="container">
              <div class="row">
                  <div class="col-lg-6">
                      <h1 class="display-4">Edit Menu</h1>
                  </div>
                  
              </div>
          </div>
      </section>
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
      <section class="py-5">
          <div class="container">
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-lg-0">
                <form method="get" action="<?= base_url('menuedit/'); ?>">
                    <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search menu item..." name="search" value="<?= isset($search) ? esc($search) : '' ?>">
                    <button class="btn btn-primary bg-dkgreen" type="submit">Search</button>
                    </div>
                </form>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?= base_url('menuedit/addeditcategory');?>" class="btn btn-primary bg-dkgreen">Add Category</a>
                    <a href="<?= base_url('menuedit/addedititem');?>" class="btn btn-primary bg-dkgreen">Add Item</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-sm w-auto">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= esc($category['category_sort']) ?></td>
                                <td><?= esc($category['category_name']) ?></td>
                                <td>
                                <button class="btn btn-sm btn-info bg-dkgreen me-2 mb-1" onclick="location.href='<?= base_url('menuedit/addeditcategory/'.$category['category_id']);?>'"><i class="bi bi-pencil-fill"></i></button>
                                <a href="<?= base_url('menuedit/deleteCategory/' . $category['category_id']) ?>" class="btn btn-sm btn-warning bg-dkgreen mb-1" onclick="return confirm('Are you sure you want to delete this category?')"><i class="bi bi-dash-circle-fill"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Available</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menuitems as $menuitem): ?>
                    <tr>
                        <td><?= esc($menuitem['menu_item_id']) ?></td>
                        <td><?= esc($menuitem['item_name']) ?></td>
                        <td><?= esc($menuitem['category_name']) ?></td>
                        <td><?= esc($menuitem['price']) ?></td>
                        <td><?= esc($menuitem['description']) ?></td>
                        <td><?= esc($menuitem['is_active']) ? 'Yes' : 'No' ?></td>
                        <td>
                            <a href="<?= base_url('menuedit/addeditItem/'.$menuitem['menu_item_id']);?>" class="btn btn-sm btn-info bg-dkgreen me-2 mb-1"><i class="bi bi-pencil-fill"></i></a>
                            <a href="<?= base_url('menuedit/deleteItem/' . $menuitem['menu_item_id']) ?>" class="btn btn-sm btn-warning bg-dkgreen mb-1" onclick="return confirm('Are you sure you want to delete this item?')"><i class="bi bi-dash-circle-fill"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
      </section>
  </main>

  <?= $this->endSection() ?>