<?php
session_start();
include "../koneksi.php"; // Pastikan path benar

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // Query ke database
    $query = "SELECT * FROM users WHERE username='$username' AND role='$role'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Cek password
        if (password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user;

    if ($role == 'admin') {
        header("Location: " . BASE_URL . "admin/dashboard.php");
    } else {
        header("Location: " . BASE_URL . "user/dashboard.php");
    }
    exit();
} else {
    echo "Password salah!";
}

    } else {
        echo "Username atau role tidak ditemukan!";
    }
    exit(); // pastikan berhenti setelah response
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="../src/output.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" />
</head>

<body class="bg-blue-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-sm">
    <h2 class="text-2xl font-bold text-center text-blue-500 mb-6">
      Welcome To Absen Track
    </h2>

    <form id="loginForm" class="space-y-5" method="POST">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          <i class="fa-solid fa-user mr-1"></i>Username
        </label>
        <input id="username" name="username" type="text" placeholder="Masukkan username anda" required
          class="w-full px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          <i class="fa-solid fa-lock mr-1"></i>Password
        </label>
        <input id="password" name="password" type="password" placeholder="••••••••" required
          class="w-full px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
        <div class="rounded px-4 border border-gray-300">
          <select id="role" name="role" class="pr-50 py-2 border-none cursor-pointer">
            <option value="admin">Admin</option>
            <option value="anggota">Anggota</option>
          </select>
        </div>
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center text-sm text-gray-600">
          <input type="checkbox" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-400" />
          Remember me
        </label>
        <a href="#" class="text-sm text-blue-600 hover:underline">Forgot?</a>
      </div>

      <button type="submit"
        class="w-full bg-blue-500 hover:bg-blue-600 cursor-pointer text-white py-2 rounded-xl transition duration-200 font-semibold">
        Sign In
      </button>
    </form>

    <div id="errorMsg" class="text-red-500 text-sm mt-3 text-center"></div>

    <p class="mt-6 text-sm text-center text-gray-600">
      Don't have an account?
      <a href="./register.php" class="text-blue-600 hover:underline">Sign up</a>
    </p>
  </div>

  <script>
    document.getElementById("loginForm").addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(this);

      fetch('login.php', {
        method: 'POST',
        body: formData
      })
        .then(response => {
          if (response.redirected) {
            window.location.href = response.url; // sukses → redirect
          } else {
            return response.text(); // gagal → kirim pesan
          }
        })
        .then(data => {
          if (data) {
            document.getElementById("errorMsg").innerText = data;
          }
        })
        .catch(error => {
          console.error('Error:', error);
          document.getElementById("errorMsg").innerText = 'Terjadi kesalahan saat login';
        });
    });
  </script>
</body>

</html>