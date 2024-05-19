<?= $this->extend('template') ?>
<?= $this->section('content') ?>

  <main>
      <section class="py-5 bg-light">
          <div class="container">
              <div class="row">
                  <div class="col-lg-6">
                      <h1 class="display-4">Table & QR Code Management</h1>
                  </div>
                  
              </div>
          </div>
      </section>

      <section class="py-5">
        <div class="container">
            <h2 class="text-left mb-4">Table QR Codes (<?= count($tables) ?>)</h2>
            <div class="text-md-end mb-4">
                <button class="btn btn-primary bg-dkgreen" data-bs-toggle="modal" data-bs-target="#addTableModal">Add new table</button>
            </div>
            <div class="row">
                <?php foreach ($tables as $table): ?>
                    <div class="col-lg-3 mb-4">
                        <div class="card" style="width: 18rem;">
                            <img src="<?= $table['qrcode_image'] ?>" class="card-img-top" alt="QR code">
                            <div class="card-body">
                                <h5 class="card-title text-center"><strong>Table <?= $table['table_number'] ?></strong></h5>
                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('qrcodes/delete/' . $table['table_id']) ?>" class="btn btn-primary bg-dkgreen" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Add Table Modal -->
    <div class="modal fade" id="addTableModal" tabindex="-1" aria-labelledby="addTableModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTableModalLabel">Add New Table</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('qrcodes/add') ?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="table_number" class="form-label">Table Number</label>
                            <input type="text" class="form-control" id="table_number" name="table_number" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Table</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </main>

  <?= $this->endSection() ?>
