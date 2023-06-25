<!DOCTYPE html>
<html lang="en" data-layout="topnav" data-topbar-color="dark">

    <head>
        <meta charset="utf-8" />
        <title>Dashboard | Hyper - Responsive Bootstrap 5 Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Theme Config Js -->
        <script src="assets/js/hyper-config.js"></script>

        <!-- App css -->
        <link href="assets/css/app-creative.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <!-- Begin page -->
        <div class="wrapper">

            <?php require_once 'navbar.php' ?>

            <?php require_once 'topnav.php' ?>


            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h4 class="header-title">Enkripsi</h4>
                                        <form>
                                            <div class="mb-3">
                                                <label class="form-label">Input File Citra</label>
                                                <input type="file" class="form-control" id="input_citra_asli">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Input File Citra Stego</label>
                                                <input type="file" class="form-control" id="input_citra_enkripsi">
                                            </div>

                                            <div class="d-grid gap-2">
                                                <button class="btn btn-primary" type="button" id="hasil">Hasil</button>
                                            </div>

                                            <div class="mt-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="" class="mb-1">Nilai MSE</label>
                                                            <input type="text" name="" id="output_mse" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="" class="mb-1">Nilai PSNR</label>
                                                            <input type="text" name="" id="output_psnr" class="form-control">
                                                            <label for="">Kategori : <span id="kategori"></span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="" class="mb-1">Histogram Citra Asli</label>
                                                        </div>
                                                        <div id="histogram_asli_r"></div>
                                                        <div id="histogram_asli_g"></div>
                                                        <div id="histogram_asli_b"></div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="" class="mb-1">Histogram Citra Stego</label>
                                                        </div>
                                                        <div id="histogram_enkripsi_r"></div>
                                                        <div id="histogram_enkripsi_g"></div>
                                                        <div id="histogram_enkripsi_b"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <canvas id="citra_enkripsi" width="1024" height="1024" class="d-none"></canvas>
                                                <canvas id="citra_asli" width="1024" height="1024" class="d-none"></canvas>
                                            </div>
                                            
                                        </form>      
                                        
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div><!-- end col -->
                        </div><!-- end row -->

                    </div>
                    <!-- container -->

                </div>
                <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

        <script src="lsb.js"></script>
        <script src="bc.js"></script>
        <script src="https://cdn.plot.ly/plotly-2.2.0.min.js"></script>
        <script src="psnr.js"></script>

        <script> 
        // input
        let input_citra_asli = document.getElementById('input_citra_asli');
        let input_citra_enkripsi = document.getElementById('input_citra_enkripsi');

        // output
        let output_mse = document.getElementById('output_mse')
        let output_psnr = document.getElementById('output_psnr')
        let kategori = document.getElementById('kategori')
        
        // button
        let hasil = document.getElementById('hasil')

        // canvas
        let citra_asli = document.getElementById('citra_asli');
        let citra_enkripsi = document.getElementById('citra_enkripsi');

        // context
        let ctx_asli = citra_asli.getContext('2d');
        let ctx_enkripsi = citra_enkripsi.getContext('2d');

        let clampedArrayAsli = undefined;
        let clampedArrayEnkripsi = undefined;

        const getImageAsli = function () {
            return new Promise(function (resolve, reject) {
                let file = input_citra_asli.files[0];
                let fileReader = new FileReader();

                let loadEndEvent = function (evt) {
                    let img = new Image();
                    img.src = evt.target.result;

                    img.onload = function () {
                        ctx_asli.drawImage(img, 0, 0);
                        clampedArrayAsli = ctx_asli.getImageData(0, 0, citra_asli.width, citra_asli.height);
                    
                        resolve(clampedArrayAsli)
                    }
                }

                fileReader.addEventListener("loadend", loadEndEvent);

                fileReader.readAsDataURL(file);
            });
        }

        const getImageEnkripsi = function () {
            return new Promise(function (resolve, reject) {
                let file = input_citra_enkripsi.files[0];
                let fileReader = new FileReader();

                let loadEndEvent = function (evt) {
                    let img = new Image();
                    img.src = evt.target.result;

                    img.onload = function () {
                        ctx_enkripsi.drawImage(img, 0, 0);
                        clampedArrayEnkripsi = ctx_enkripsi.getImageData(0, 0, citra_enkripsi.width, citra_enkripsi.height);

                        resolve(clampedArrayEnkripsi)
                    }
                }

                fileReader.addEventListener("loadend", loadEndEvent);

                fileReader.readAsDataURL(file);
            });
        }

        const setHistogramAsli = function () {
            return new Promise(function (resolve, reject) {
                let r = [];
                let g = [];
                let b = [];
                for (let i = 0; i < clampedArrayAsli.data.length; i += 4) {
                    r[i] = clampedArrayAsli.data[i];
                    g[i] = clampedArrayAsli.data[i + 1];
                    b[i] = clampedArrayAsli.data[i + 2];
                }

                let traceR = {
                    x: r,
                    type: 'histogram',
                    marker: {
                        color: 'red',
                    },
                };

                let dataR = [traceR];

                let traceB = {
                    x: b,
                    type: 'histogram',
                    marker: {
                        color: 'blue',
                    },
                };

                let dataB = [traceB];

                let traceG = {
                    x: g,
                    type: 'histogram',
                    marker: {
                        color: 'green',
                    },
                };

                let dataG = [traceG];

                Plotly.newPlot('histogram_asli_r', dataR);
                Plotly.newPlot('histogram_asli_g', dataG);
                Plotly.newPlot('histogram_asli_b', dataB);

                resolve()
            });
        }

        const setHistogramEnkripsi = function () {
            return new Promise(function (resolve, reject) {
                let r = [];
                let g = [];
                let b = [];
                for (let i = 0; i < clampedArrayEnkripsi.data.length; i += 4) {
                    r[i] = clampedArrayEnkripsi.data[i];
                    g[i] = clampedArrayEnkripsi.data[i + 1];
                    b[i] = clampedArrayEnkripsi.data[i + 2];
                }

                let traceR = {
                    x: r,
                    type: 'histogram',
                    marker: {
                        color: 'red',
                    },
                };

                let dataR = [traceR];

                let traceB = {
                    x: b,
                    type: 'histogram',
                    marker: {
                        color: 'blue',
                    },
                };

                let dataB = [traceB];

                let traceG = {
                    x: g,
                    type: 'histogram',
                    marker: {
                        color: 'green',
                    },
                };

                let dataG = [traceG];

                Plotly.newPlot('histogram_enkripsi_r', dataR);
                Plotly.newPlot('histogram_enkripsi_g', dataG);
                Plotly.newPlot('histogram_enkripsi_b', dataB);

                resolve()
            })
        }

        hasil.addEventListener('click', async function (e) {
            await getImageAsli()
            await getImageEnkripsi()

            const mseValue = mse(clampedArrayAsli, clampedArrayEnkripsi)
            const psnrValue = psnr(mseValue)
            const kategoriValue = psnrCategory(psnrValue.toFixed(0)) 

            output_mse.value = mseValue.toFixed(6)
            output_psnr.value = psnrValue.toFixed(0)
            kategori.innerHTML = kategoriValue

            setHistogramAsli()
            setHistogramEnkripsi()
        });
        </script>

    </body>
</html> 