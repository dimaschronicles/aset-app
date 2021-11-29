<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <?php if (session()->get('role') == 1) : ?>
                        <div class="sb-sidenav-menu-heading">Super Admin</div>
                    <?php elseif (session()->get('role') == 2) : ?>
                        <div class="sb-sidenav-menu-heading">Admin</div>
                    <?php elseif (session()->get('role') == 3) : ?>
                        <div class="sb-sidenav-menu-heading">User</div>
                    <?php endif; ?>

                    <!-- Dashboard -->
                    <a class="nav-link <?= ($title == "Dashboard") ? 'active' : ''; ?>" href="/home">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <!-- End Dashboard -->

                    <!-- Data Master -->
                    <div class="sb-sidenav-menu-heading">Master Data</div>
                    <?php if (session()->get('role') == 1 || session()->get('role') == 2) : ?>
                        <a class="nav-link <?= ($title == "Data User") ? 'active' : ''; ?>" href="/user">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            User
                        </a>

                        <a class="nav-link <?= ($title == "Data Barang") ? 'active' : '' ?>" href="/barang">
                            <div class="sb-nav-link-icon"><i class="fas fa-desktop"></i></div>
                            Barang
                        </a>

                        <a class="nav-link <?= ($title ==  "Data Ruangan") ? 'active' : ''; ?>" href="/ruang">
                            <div class="sb-nav-link-icon"><i class="fas fa-door-open"></i></div>
                            Ruangan
                        </a>

                        <a class="nav-link <?= ($title == "Data Gedung") ? 'active' : ''; ?>" href="/gedung">
                            <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                            Gedung
                        </a>

                        <a class="nav-link <?= ($title == "Data Kategori") ? 'active' : ''; ?>" href="/gedung">
                            <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                            Kategori
                        </a>

                        <a class="nav-link <?= ($title == "Data Kategori") ? 'active' : ''; ?>" href="/gedung">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Satuan
                        </a>
                    <?php endif; ?>
                    <!-- End Data Master -->

                    <!-- Aset -->
                    <div class="sb-sidenav-menu-heading">Data Aset</div>
                    <a class="nav-link <?= ($title == "Data Aset") ? 'active' : '' ?>" href="/aset">
                        <div class="sb-nav-link-icon"><i class="fas fa-laptop"></i></div>
                        Aset
                    </a>
                    <!-- End Aset -->

                    <!-- Report -->
                    <div class="sb-sidenav-menu-heading">Laporan</div>
                    <a class="nav-link <?= ($title == "Laporan Aset") ? 'active' : ''; ?>" href="/laporan">
                        <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                        Laporan Aset
                    </a>
                    <!-- End Report -->

                    <!-- My Profile -->
                    <div class="sb-sidenav-menu-heading">Profil</div>
                    <a class="nav-link <?= ($title == "Edit Profil") ? 'active' : ''; ?>" href="/profile">
                        <div class=" sb-nav-link-icon"><i class="fas fa-user-edit"></i></div>
                        Edit Profil
                    </a>
                    <!-- End My Profile -->

                    <!-- Ganti Password -->
                    <a class="nav-link <?= ($title == "Ganti Password") ? 'active' : ''; ?>" href="/profile/changepassword">
                        <div class="sb-nav-link-icon"><i class="fas fa-key"></i></div>
                        Ganti Password
                    </a>
                    <!-- End My Profile -->

                    <!-- Reset Password -->
                    <?php if (session()->get('role') == 1) : ?>
                        <a class="nav-link <?= ($title == "Reset Password") ? 'active' : ''; ?>" href="<?= base_url('profile/resetpassword'); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-sync-alt"></i></div>
                            Reset Password
                        </a>
                    <?php endif; ?>
                    <!-- End Reset Password -->

                    <hr style="height:1px; border-width:0; color:gray; background-color:gray; margin-left: 15px; margin-right: 25px;">

                    <a class="nav-link" href="/auth/logout">
                        <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                        Keluar
                    </a>

                </div>

            </div>
        </nav>
    </div>
</div>