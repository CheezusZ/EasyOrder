<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyOrder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      .bg-dkgreen {background-color:#014a20; color: #ffffff;}
      .text-dkgreen{color:#014a20}
      .quantity-controls {
        display: flex;
        align-items: center;
      }
      .quantity-controls button {
        width: 30px;
        height: 30px;
        padding: 0;
        background-color:#014a20;
      }
      .quantity-input {
        width: 50px;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dkgreen">
            <div class="container">
                <a class="navbar-brand" href="#">EasyOrder</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                        <a class="nav-link <?= service('router')->getMatchedRoute()[0] == '/' ? 'active' : ''; ?>" href="<?= base_url(); ?>">Home</a>
                        </li>
                      <li class="nav-item">
                      <a class="nav-link <?= service('router')->getMatchedRoute()[0] == 'logout' ? 'active' : ''; ?>" href="<?= base_url('auth'); ?>">Login</a>
                      </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

  <main>
         <?= $this->renderSection('content') ?>
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
