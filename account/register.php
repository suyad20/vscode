<?php
include "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_reg   = mysqli_real_escape_string($koneksi, $_POST['no_reg']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];
    $pelajaran_konsentrasi = mysqli_real_escape_string($koneksi, $_POST['pelajaran_konsentrasi']);

    // Cek konfirmasi password
    if ($password !== $confirm) {
        echo "<script>alert('Password dan Konfirmasi tidak sama!'); window.history.back();</script>";
        exit;
    }

    // Hash password sebelum simpan
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Default role user
    $role = "anggota";

    // Cek apakah username sudah ada
    $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Username sudah digunakan!'); window.history.back();</script>";
        exit;
    }

    // Cek apakah no_reg sudah ada
    $cek_reg = mysqli_query($koneksi, "SELECT * FROM users WHERE no_reg='$no_reg'");
    if (mysqli_num_rows($cek_reg) > 0) {
        echo "<script>alert('No Registrasi sudah digunakan!'); window.history.back();</script>";
        exit;
    }

    // Insert ke database
    $sql = "INSERT INTO users (no_reg, email, username, password, role, pelajaran_konsentrasi) 
            VALUES ('$no_reg', '$email', '$username', '$password_hash', '$role', '$pelajaran_konsentrasi')";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link rel="stylesheet" href="../src/output.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"/>
  </head>
  <body class="bg-blue-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-sm">
      <h2 class="text-2xl font-bold text-center text-blue-500 mb-6">
        Welcome To Absen Track
      </h2>

      <!-- Form Register -->
      <form method="POST" class="space-y-5">

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            <i class="fa-solid fa-envelope mr-1"></i>Email</label>
          <input type="email" name="email" placeholder="you@example.com" required
            class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"/>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            <i class="fa-solid fa-user mr-1"></i>Username</label>
          <input type="text" name="username" placeholder="Masukkan username anda" required
            class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"/>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            <i class="fa-solid fa-lock mr-1"></i>Password</label>
          <input type="password" name="password" placeholder="••••••••" required
            class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"/>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            <i class="fa-solid fa-lock mr-1"></i>Konfirmasi Password</label>
          <input type="password" name="confirm" placeholder="••••••••" required
            class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"/>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            <i class="fa-solid fa-id-card mr-1"></i>No. Registrasi</label>
          <input type="text" name="no_reg" placeholder="Masukkan No. Registrasi" required
            class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"/>
        </div>

        <div>
  <label class="block text-sm font-medium text-gray-700 mb-1">
    <i class="fa-solid fa-book mr-1"></i>Pelajaran Konsentrasi</label>
  <select name="pelajaran_konsentrasi" required
    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
    <option value="">-- Pilih Konsentrasi --</option>
    <option value="Front End">Front End</option>
    <option value="Back End">Back End</option>
    <option value="Mobile">Mobile</option>
    <option value="UI/UX">UI/UX</option>
    <option value="DKV">DKV</option>
  </select>
</div>


        <button type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 cursor-pointer text-white py-2 rounded-xl transition duration-200 font-semibold">
          Sign Up
        </button>
      </form>

      <p class="mt-6 text-sm text-center text-gray-600">
        Sudah punya akun?
        <a href="login.php" class="text-blue-600 hover:underline">Login</a>
      </p>
    </div>
  </body>
</html>
