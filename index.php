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
                                        <div class="row">
                                            <div class="col-6">
                                                <form>
                                                    <div class="mb-3">
                                                        <label class="form-label">Input Citra</label>
                                                        <input type="file" class="form-control" id="citra">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Input Teks</label>
                                                        <input type="file" class="form-control" id="teks">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Input Keys</label>
                                                        <input type="text" class="form-control" id="key" maxlength="16">
                                                    </div>

                                                    <div class="d-grid gap-2">
                                                        <button class="btn btn-primary" type="button" id="enkripsi">Enkripsi</button>
                                                    </div>
                                                    
                                                </form>  
                                            </div>
                                            <div class="col-6">
                                                <canvas id="citra_asli" width="1024" height="1024" class="d-none"></canvas>
                                                <button id="download" class="d-none">Download</button>
                                                <label for="" class="mb-1">Hasil Citra</label>
                                                <canvas id="citra_enkripsi" width="1024" height="1024" class="form-control"></canvas>
                                            </div>
                                        </div>     
                                        
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

        <script>
        // input
        let teks = document.getElementById('teks');
        let citra = document.getElementById('citra');
        let key = document.getElementById('key');

        // button
        let enkripsi = document.getElementById('enkripsi');
        let download = document.getElementById('download');

        // canvas
        let citra_asli = document.getElementById('citra_asli');
        let citra_enkripsi = document.getElementById('citra_enkripsi');

        // context
        let ctx_asli = citra_asli.getContext('2d');
        let ctx_enkripsi = citra_enkripsi.getContext('2d');

        let clampedArray = undefined;
        let isi_teks = undefined;
        let filename = undefined;

        download.addEventListener('click', function (e) {
            let image = citra_enkripsi.toDataURL('image/png', 1.0);
            let element = document.createElement('a');
            element.setAttribute('href', image);
            element.setAttribute('download', 'result.png');
            element.setAttribute('_blank', '');
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        });

        teks.addEventListener('change', function (e) {
            let file = e.target.files[0];
            let fileReader = new FileReader();

            let loadEvent = function (evt) {
                if (evt.target.readyState == FileReader.DONE) {
                    let arrayBuffer = evt.target.result;

                    console.log(arrayBuffer);

                    isi_teks = new Uint8Array(arrayBuffer)
                }
            }

            fileReader.addEventListener('load', loadEvent);

            fileReader.readAsArrayBuffer(file)
        });

        enkripsi.addEventListener('click', function (e) {
            const secretKey = key.value.split('').map(function (it) {
                return it.charCodeAt(0)
            });
            
            const newSecretKey = generateKey(secretKey, isi_teks.length);
            const newText = generateText(newSecretKey, isi_teks)

            let file = citra.files[0];
            let fileReader = new FileReader();

            let loadEndEvent = function (evt) {
                let img = new Image();
                img.src = evt.target.result;

                img.onload = function () {
                    ctx_asli.drawImage(img, 0, 0);
                    clampedArray = ctx_asli.getImageData(0, 0, citra_asli.width, citra_asli.height);

                    const imageData = {...clampedArray}
                    
                    const clampedArrayAddKeyLength = updateByteLength(secretKey, imageData, 0, 1);
                    const clampedArrayAddKey = updateByte(secretKey, clampedArrayAddKeyLength.imageData, clampedArrayAddKeyLength.index, clampedArrayAddKeyLength.startIndex);
                    const clampedArrayAddTextLength = updateByteLength(newText, clampedArrayAddKey.imageData, clampedArrayAddKey.index, clampedArrayAddKey.startIndex);
                    const clampedArrayAddText = updateByte(newText, clampedArrayAddTextLength.imageData, clampedArrayAddTextLength.index, clampedArrayAddTextLength.startIndex);
                    
                    clampedArray.data = clampedArrayAddText.imageData
                    ctx_enkripsi.putImageData(clampedArray, 0, 0);   
                }
            }

            fileReader.addEventListener("loadend", loadEndEvent);

            fileReader.readAsDataURL(file);
        });
        </script>

    </body>
</html> 