<?php
include '../koneksi.php';
session_start();

// Periksa apakah pengguna memiliki level 1 (admin)
if ($_SESSION['status'] != "administrator_logedin" ) {
    header("location:../index.php?alert=tidak_diizinkan");
}

// Logika untuk menampilkan dan mengubah level user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $new_level = $_POST['level'];

    $query = "UPDATE user SET level='$new_level' WHERE user_id='$user_id'";

    if (mysqli_query($koneksi, $query)) {
        header("location:edit_user.php?alert=edit_success");
    } else {
        header("location:edit_user.php?alert=edit_failed");
    }
}

// Ambil semua user kecuali user dengan level 1 (supaya admin tidak bisa mengedit dirinya sendiri)
$users = mysqli_query($koneksi, "SELECT * FROM user WHERE level != 1");
?>

<?php include 'header.php'; ?>

<div class="container mt-4">

    <div class="mt-2 border-bottom">
        <h2 class="fw-semibold fs-3">Edit User Level</h2>
    </div>

    <section class="content">
        <div class="row justify-content-center">
            <section class="col-lg-8">

                <?php if (isset($_GET['alert'])): ?>
                    <?php if ($_GET['alert'] == 'edit_success'): ?>
                        <div class="alert alert-success">User level updated successfully!</div>
                    <?php elseif ($_GET['alert'] == 'edit_failed'): ?>
                        <div class="alert alert-danger">Failed to update user level!</div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="card card-info">
                    <div class="card-header">
                        <span class="card-title fw-semibold">Update User Level</span>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group mb-3">
                                <label for="user_id" class="form-label">Select User</label>
                                <select class="form-control" name="user_id" id="user_id" required>
                                    <?php while ($user = mysqli_fetch_assoc($users)): ?>
                                        <option value="<?php echo $user['user_id']; ?>">
                                            <?php echo $user['user_nama']; ?> (Level: <?php echo $user['level']; ?>)
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="level" class="form-label">Set New Level</label>
                                <select class="form-control" name="level" id="level" required>
                                    <option value="1">Level 1 (Admin)</option>
                                    <option value="2">Level 2 (User)</option>
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <input type="submit" class="btn btn-primary" value="Update Level">
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>
