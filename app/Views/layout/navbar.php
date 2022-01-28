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

                    <?php if (session()->get('role') == 1) : ?>
                        <a class="nav-link <?= ($title == "Data User") ? 'active' : '' ?>" href="/user">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Data User
                        </a>
                    <?php endif; ?>

                    <!-- Data Master -->
                    <?php if (session()->get('role') == 1 || session()->get('role') == 2) : ?>
                        <a class="nav-link collapsed <?= ($title == "Data Barang" || $title == "Data Ruangan" || $title == "Data Gedung" || $title == "Kategori" || $title == "Data Supplier") ? 'active' : ''; ?>" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsMaster" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                            Data Master
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsMaster" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link <?= ($title == "Data Barang") ? 'active' : ''; ?>" href="/barang">Barang</a>
                                <a class="nav-link <?= ($title == "Data Ruangan") ? 'active' : ''; ?>" href="/ruangan">Ruangan</a>
                                <a class="nav-link <?= ($title == "Data Gedung") ? 'active' : ''; ?>" href="/gedung">Gedung</a>
                                <a class="nav-link <?= ($title == "Kategori") ? 'active' : ''; ?>" href="/kategori">Kategori</a>
                                <a class="nav-link <?= ($title == "Data Supplier") ? 'active' : ''; ?>" href="/supplier">Supplier</a>
                            </nav>
                        </div>
                    <?php endif; ?>
                    <!-- End Data Master -->

                    <!-- Aset -->
                    <?php if (session()->get('role') == 1 || session()->get('role') == 2) : ?>
                        <a class="nav-link collapsed  <?= ($title == "Data Aset" || $title == "Aset Masuk" || $title == "Aset Keluar" || $title == "Data Aset Dihapus") ? 'active' : ''; ?>" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsaAset" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-laptop"></i></div>
                            Data Aset
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsaAset" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link <?= ($title == "Data Aset") ? 'active' : ''; ?>" href="/aset">Aset</a>
                                <a class="nav-link <?= ($title == "Aset Masuk") ? 'active' : ''; ?>" href="/asetmasuk">Aset Masuk</a>
                                <a class="nav-link <?= ($title == "Aset Keluar") ? 'active' : ''; ?>" href="/asetkeluar">Aset Keluar</a>
                                <a class="nav-link <?= ($title == "Data Aset Dihapus") ? 'active' : ''; ?>" href="/aset/hapus">Aset Dihapus</a>
                            </nav>
                        </div>
                    <?php endif; ?>
                    <!-- End Aset -->

                    <!-- Data Laporan -->
                    <?php if (session()->get('role') == 1 || session()->get('role') == 2) : ?>
                        <!-- <a class="nav-link collapsed <?= ($title == "Laporan Data Aset") ? 'active' : ''; ?>" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsReport" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-file"></i></div>
                            Laporan
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsReport" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link <?= ($title == "Laporan Data Aset") ? 'active' : ''; ?>" href="/report">Data Aset</a>
                                <a class="nav-link <?= ($title == "") ? 'active' : ''; ?>" href="/report">Aset Masuk</a>
                                <a class="nav-link <?= ($title == "") ? 'active' : ''; ?>" href="/report">Aset Keluar</a>
                                <a class="nav-link <?= ($title == "") ? 'active' : ''; ?>" href="">QR Code</a>
                            </nav>
                        </div> -->
                        <a class="nav-link <?= ($title == "Laporan Data Aset") ? 'active' : ''; ?>" href="/report">
                            <div class=" sb-nav-link-icon"><i class="fas fa-file"></i></div>
                            Laporan
                        </a>
                    <?php endif; ?>
                    <!-- End Data Laporan -->

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