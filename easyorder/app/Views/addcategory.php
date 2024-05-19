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
        <h2><?= isset($category) ? 'Edit Category' : 'Add Category' ?></h2>
            <form method="post" action="<?= base_url('menuedit/attemptSaveCategory'); ?>">
                <?php if (isset($category)): ?>
                    <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" value="<?= isset($category) ? esc($category['category_name']) : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="category_sort" class="form-label">Category Sequence Number</label>
                    <input type="number" class="form-control" id="category_sort" name="category_sort" value="<?= isset($category) ? esc($category['category_sort']) : '' ?>" required>
                </div>
                <button type="submit" class="btn btn-primary bg-dkgreen">Save Category</button>
            </form>
        </div>
    </section>
</main>

<?= $this->endSection() ?>