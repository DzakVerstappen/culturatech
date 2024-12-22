<?php
session_start();
// Cek if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user data from database
require_once 'config/database.php';
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

function maskEmail($email) {
    $parts = explode('@', $email);
    return substr($parts[0], 0, 2) . str_repeat('*', strlen($parts[0])-2) . '@' . $parts[1];
}

function maskPhone($phone) {
    return substr($phone, 0, 2) . str_repeat('*', strlen($phone)-4) . substr($phone, -2);
}

function maskBirthDate($date) {
    return str_replace(['0','1','2','3','4','5','6','7','8','9'], '*', substr($date, 0, 2)) . substr($date, 2);
}

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="profile-container">
        <h1>Profil Saya</h1>
        <p>Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
        
        <form action="update_profile.php" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
            </div>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
            </div>

            <div class="form-group">
                <label>Email</label>
                <div class="email-group">
                    <span><?php echo maskEmail($user['email']); ?></span>
                    <a href="change_email.php" class="change-link">Ubah</a>
                </div>
            </div>

            <div class="form-group">
                <label>Nomor Telepon</label>
                <div class="phone-group">
                    <span><?php echo maskPhone($user['phone']); ?></span>
                    <a href="change_phone.php" class="change-link">Ubah</a>
                </div>
            </div>

            <div class="form-group">
                <label>Nama Toko</label>
                <input type="text" name="store_name" value="<?php echo htmlspecialchars($user['store_name']); ?>">
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <div class="gender-options">
                    <label>
                        <input type="radio" name="gender" value="Laki-laki" <?php echo $user['gender'] == 'Laki-laki' ? 'checked' : ''; ?>>
                        Laki-laki
                    </label>
                    <label>
                        <input type="radio" name="gender" value="Perempuan" <?php echo $user['gender'] == 'Perempuan' ? 'checked' : ''; ?>>
                        Perempuan
                    </label>
                    <label>
                        <input type="radio" name="gender" value="Lainnya" <?php echo $user['gender'] == 'Lainnya' ? 'checked' : ''; ?>>
                        Lainnya
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="text" value="<?php echo maskBirthDate($user['birth_date']); ?>" readonly>
                <p class="note">Kamu sudah melakukan verifikasi KYC sehingga tidak dapat mengubah tanggal lahir.</p>
            </div>

            <button type="submit" class="save-button">Simpan</button>
        </form>
    </div>
</body>
</html>