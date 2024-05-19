<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyOrder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        .cont {font: 16px Montserrat, sans-serif; }
        .bg-dkgreen {background-color:#014a20; color: #ffffff;}
        .text-dkgreen{color:#014a20}
    </style>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dkgreen">
          <div class="container">
              <a class="navbar-brand" href="<?= base_url(); ?>">EasyOrder</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav ms-auto">
                      <li class="nav-item">
                          <a class="nav-link <?= service('router')->getMatchedRoute()[0] == '/' ? 'active' : ''; ?>" href="<?= base_url(); ?>">Home</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link <?= service('router')->getMatchedRoute()[0] == 'orders' ? 'active' : ''; ?>" href="<?= base_url('orders'); ?>">Orders</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link <?= service('router')->getMatchedRoute()[0] == 'menuedit' ? 'active' : ''; ?>" href="<?= base_url('menuedit'); ?>">MenuEdit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= service('router')->getMatchedRoute()[0] == 'qrcodes' ? 'active' : ''; ?>" href="<?= base_url('qrcodes'); ?>">QRCodes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= service('router')->getMatchedRoute()[0] == 'logout' ? 'active' : ''; ?>" href="<?= base_url('logout'); ?>">Logout</a>
                    </li>
                  </ul>
              </div>
          </div>
      </nav>
  </header>

  <main>
         <?= $this->renderSection('content') ?> <!-- Placeholder for page content -->
  </main>

  <footer class="bg-dkgreen text-light py-4">
      <div class="container">
          <div class="row">
              <div class="col-md-6">
                  <p>&copy; 2024 EasyOrder. All rights reserved.</p>
              </div>
              <div class="col-md-6 text-md-end">
                  <a href="#" class="text-light me-3">Privacy Policy</a>
                  <a href="#" class="text-light">Terms of Service</a>
              </div>
          </div>
      </div>
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
