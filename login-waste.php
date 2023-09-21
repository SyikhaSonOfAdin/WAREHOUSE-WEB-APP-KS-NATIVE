<?php
session_start() ;

if ( isset($_SESSION["login"]) ) {
  session_destroy() ;
  session_unset() ;
  $_SESSION = [] ;
  // Set the cookie
  setcookie("id", "", time() - 302400, "/");
  setcookie("level", "", time() - 302400, "/");
  header("Location: ./waste/") ;
}

require "./function.php";
$conn = conn();
$display = "hidden";
$false = "Password yang anda masukkan salah!" ;

if (isset($_POST["email"])) {
  $search = $_POST["email"];
  $query = "SELECT * FROM login WHERE email = '$search'";
  $result = mysqli_query($conn, $query);

  if ($result !== false) {
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $password = $row['password'];
      if ($_POST["password"] == $password) {
        $parameter = $row['role'];
        $username = $row['username'] ; // Nilai parameter yang ingin Anda kirim
        
        $_SESSION["login"] = true ;
        $_SESSION["name"] = $row["username"] ;
        $_SESSION["role"] = $row["role"] ;

        if (isset($_POST["remember"])) {
          tryCookie($_SESSION["name"], $_SESSION["role"]) ;
          header("Location: ./waste");
        }
        else {
          header("Location: ./waste/");
        }
        exit();
      } else {
        $display = "flex";
      }
    } else {
      $display = "flex";
      $false = "Email Tidak Terdaftar"; // Menampilkan pesan jika email tidak terdaftar
    }
  } else {
    echo "Query execution failed.";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <section class="bg-white">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div class="flex items-center mb-4 text-3xl font-bold uppercase text-gray-700">
        <img class="w-8 h-8 mr-2" src="./assets/Logo_single.png" alt="logo" />
        Kokoh Semesta
      </div>
      <div class="w-full bg-white rounded-lg shadow-md dark:border md:mt-0 sm:max-w-md xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-700 md:text-2xl">
            Login
          </h1>
          <form class="space-y-4 md:space-y-6" action="" method="POST">
            <div>
              <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
              <input type="email" name="email" id="email"
                class="bg-gray-50 border border-gray-300 text-gray-700 sm:text-sm rounded-lg focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] block w-full p-2.5"
                placeholder="name@gmail.com" required="" />
            </div>
            <div>
              <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
              <input type="password" name="password" id="password" placeholder="••••••••"
                class="bg-gray-50 border border-gray-300 text-gray-700 sm:text-sm rounded-lg focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] block w-full p-2.5"
                required="" />
            </div>
            <div>
              <input type="checkbox" name="remember" id="remember">
              <label for="remember" class="text-sm font-medium text-gray-700">Remember Me?</label>
            </div>
            <input type="submit" value="Login"
              class="py-2 px-5 text-sm font-medium text-white rounded-md bg-[#2E3192] hover:bg-[#5458C8]" />
          </form>
        </div>
        <div
          class="<?php echo $display ?> bg-red-300 w-full h-[80px] mt-5 border-[3px] border-red-500 rounded-lg text-sm font-medium text-red-700 items-center justify-center">
          <?php echo $false ?>
        </div>
      </div>
    </div>
  </section>
</body>

</html>