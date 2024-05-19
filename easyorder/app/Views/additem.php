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
    <section class="py-5">
        <div class="container">
            <!-- Change the title correspondingly -->
            <h2><?= isset($item) ? 'Edit Item' : 'Add Item' ?></h2>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <form method="post" action="<?= base_url('menuedit/attemptSaveItem'); ?>">
                <?php if (isset($item)): ?>
                    <input type="hidden" name="item_id" value="<?= $item['menu_item_id'] ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label for="item_name" class="form-label">Item Name</label>
                    <input type="text" class="form-control" id="item_name" name="item_name" value="<?= isset($item) ? esc($item['item_name']) : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" required><?= isset($item) ? esc($item['description']) : '' ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= isset($item) ? esc($item['price']) : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= esc($category['category_id']) ?>" <?= isset($item) && $item['category_id'] == $category['category_id'] ? 'selected' : '' ?>><?= esc($category['category_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" <?= isset($item) ? ($item['is_active'] ? 'checked' : '') : 'checked' ?>>
                        <label class="form-check-label" for="is_active">
                            Available
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary bg-dkgreen"><?= isset($item) ? 'Update Item' : 'Add Item' ?></button>
            </form>
        </div>
    </section>
</main>

<?= $this->endSection() ?>