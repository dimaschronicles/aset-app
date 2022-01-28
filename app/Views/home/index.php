<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h1>
        <hr>

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        Aset
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        Jumlah : <?= $aset; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        Aset Masuk
                        <i class="fas fa-door-open"></i>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        Jumlah : <?= $asetMasuk; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        Aset Keluar
                        <i class="fas fa-door-closed"></i>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        Jumlah : <?= $asetKeluar; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        Aset Dihapus
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        Jumlah : <?= $asetDihapus; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        User
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        Jumlah : <?= $user; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        Total Jumlah Aset Masuk
                        <i class="fas fa-reply"></i>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        Jumlah : <?= $jmlhAsetMasuk; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-dark text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        Total Jumlah Aset Keluar
                        <i class="fas fa-share"></i>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        Jumlah : <?= $jmlhAsetKeluar; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-light text-dark mb-4">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        Supplier
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        Jumlah : <?= $supplier; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Satuan Aset
                    </div>
                    <div class="card-body"><canvas id="myDoughnutChart" width="100%" height="50"></canvas></div>
                    <script>
                        var xValues = ["Unit", "Buah", "Set", "Paket"];
                        var yValues = [
                            <?= $asetUnit; ?>,
                            <?= $asetBuah; ?>,
                            <?= $asetSet; ?>,
                            <?= $asetPaket; ?>,
                        ];
                        var barColors = [
                            "#00FFFF",
                            "#DC143C",
                            "#00008B",
                            "#FF8C00"
                        ];

                        new Chart("myDoughnutChart", {
                            type: "doughnut",
                            data: {
                                labels: xValues,
                                datasets: [{
                                    backgroundColor: barColors,
                                    data: yValues
                                }]
                            }
                        });
                    </script>

                    <div class="card-footer small text-muted">Terakhir diperbaharui : <?= ($lastUpdated != null) ? $lastUpdated : '' ?></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Kondisi Aset
                    </div>
                    <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                    <script>
                        var xValues = ["Baik", "Kurang", "Rusak"];
                        var yValues = [
                            <?= $asetBaik; ?>,
                            <?= $asetKurang; ?>,
                            <?= $asetRusak; ?>,
                        ];
                        var barColors = [
                            "#0000FF",
                            "#FFFF00",
                            "#FF0000",
                        ];

                        new Chart("myPieChart", {
                            type: "pie",
                            data: {
                                labels: xValues,
                                datasets: [{
                                    backgroundColor: barColors,
                                    data: yValues
                                }]
                            },
                        });
                    </script>
                    <div class="card-footer small text-muted">Terakhir diperbaharui : <?= $lastUpdated; ?></div>
                </div>
            </div>
        </div>

</div>
<?= $this->endSection(); ?>