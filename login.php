<?php
session_start();

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_template"; // Ganti dengan nama database Anda

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = ""; // Variabel untuk menyimpan pesan error

// Cek apakah method request adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dengan sanitasi input
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Cek apakah username ada di database
    $sql = "SELECT * FROM users WHERE username = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Jika username ditemukan
            $user = $result->fetch_assoc();
            
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Set session untuk user yang berhasil login
                $_SESSION['username'] = htmlspecialchars($user['username']);
                echo "Login berhasil!";
                // Redirect ke halaman "/template"
                header("Location: /template");
                exit();
            } else {
                $error_message = "Password salah!";
            }
        } else {
            $error_message = "Username tidak ditemukan!";
        }
    } else {
        $error_message = "Terjadi kesalahan pada server. Silakan coba lagi nanti.";
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="login/fonts/icomoon/style.css">

    <link rel="stylesheet" href="login/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="login/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="login/css/style.css">

    <title>Login #9</title>
  </head>
  <body>
  
  <div class="content">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-12">
              <div class="form-block">
                  <div class="mb-4">
                  <h3>Sign In to <strong></strong></h3>
                  <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="form-group first">
                  <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
               </div>
                  <div class="form-group last mb-4">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>

                  <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                      <?php echo $error_message; ?>
                    </div>
                  <?php endif; ?>
                  
                  <div class="d-flex mb-5 align-items-center">
                    <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                      <input type="checkbox" checked="checked"/>
                      <div class="control__indicator"></div>
                    </label>
                    <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> 
                  </div>

                  <input type="submit" value="Log In" class="btn btn-pill text-white btn-block btn-primary">

                  <span class="d-block text-center my-4 text-muted"> <a href="register.php">Register</a></span>
                  
                  <div class="social-login text-center">
                    <a href="#" class="facebook">
                      <span class="icon-facebook mr-3"></span> 
                    </a>
                    <a href="#" class="twitter">
                      <span class="icon-twitter mr-3"></span> 
                    </a>
                    <a href="#" class="google">
                      <span class="icon-google mr-3"></span> 
                    </a>
                  </div>
                </form>
              </div>
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
  </div>

  
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
