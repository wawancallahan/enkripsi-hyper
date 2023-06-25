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
                                        <h4 class="header-title">Dekripsi</h4>
                                        <div class="row">
                                            <div class="col-6">
                                                <form>
                                                    <div class="mb-3">
                                                        <label class="form-label">Input Citra</label>
                                                        <input type="file" class="form-control" id="citra">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Input Keys</label>
                                                        <input type="text" class="form-control" id="key" maxlength="16">
                                                    </div>

                                                    <div class="d-grid gap-2">
                                                        <button class="btn btn-primary" type="button" id="ekstraksi">Dekripsi</button>
                                                    </div>
                                                    
                                                </form>  
                                            </div>
                                            <div class="col-6">
                                                <canvas id="citra_enkripsi" width="1024" height="1024" class="d-none"></canvas>
                                                <button id="download" class="d-none">Download</button>
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
        let citra = document.getElementById('citra');
        let key = document.getElementById('key');

        // button
        let ekstraksi = document.getElementById('ekstraksi');
        
        // canvas
        let citra_enkripsi = document.getElementById('citra_enkripsi');

        // context
        let ctx_enkripsi = citra_enkripsi.getContext('2d');

        let clampedArray = undefined;

        let saveByteArray = (function() {
            let a = document.createElement("a");
            document.body.appendChild(a);
            a.style = "display: none";
            return function(data, name) {
                let blob = new Blob(data, {
                    type: "octet/stream"
                }),
                url = window.URL.createObjectURL(blob);
                a.href = url;
                a.download = name;
                a.click();
                window.URL.revokeObjectURL(url);
            };
        }());

        const downloadString = function (text, fileType, fileName) {
            var blob = new Blob([text], { type: fileType });

            var a = document.createElement('a');
            a.download = fileName;
            a.href = URL.createObjectURL(blob);
            a.dataset.downloadurl = [fileType, a.download, a.href].join(':');
            a.style.display = "none";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            setTimeout(function() { 
                URL.revokeObjectURL(a.href); 
            }, 1500);
        }

        ekstraksi.addEventListener('click', function (e) {
            let file = citra.files[0];
            let fileReader = new FileReader();

            let loadEndEvent = function (evt) {
                let img = new Image();
                img.src = evt.target.result;

                img.onload = function () {
                    ctx_enkripsi.drawImage(img, 0, 0);
                    clampedArray = ctx_enkripsi.getImageData(0, 0, citra_enkripsi.width, citra_enkripsi.height);
                    
                    const imageData = {...clampedArray}

                    const clampedArrayGetKeyLength = readByteLength(imageData, 0, 16, 1);
                    const clampedArrayGetKey = readByte(imageData, clampedArrayGetKeyLength.index, clampedArrayGetKeyLength.bit, clampedArrayGetKeyLength.startIndex);
            
                    if (clampedArrayGetKey.value.localeCompare(key.value) == 0) {
                        const clampedArrayGetTextLength = readByteLength(imageData, clampedArrayGetKey.index, 16, clampedArrayGetKey.startIndex);
                        const clampedArrayGetText = readByte(imageData, clampedArrayGetTextLength.index, clampedArrayGetTextLength.bit, clampedArrayGetTextLength.startIndex);
                        const secretKey = key.value.split('').map(function (it) {
                            return it.charCodeAt(0)
                        });
                        
                        const newSecretKey = generateKey(secretKey, clampedArrayGetText.bit.length);
                        const newText = generateText(newSecretKey, clampedArrayGetText.bit)
                        
                        const textString = generateTextToString(newText)

                        downloadString(textString, "text/plain", Date.now() + '-isi_teks.txt')
                    } else {
                        downloadString("", "text/plain", Date.now() + '-isi_teks.txt')
                    }
                    
                }
            }

            fileReader.addEventListener("loadend", loadEndEvent);

            fileReader.readAsDataURL(file);
        });
        </script>

    </body>
</html> 