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
                                <div class="mt-3"></div>
                            </div>
                            <div class="col-12">
                                <div id="alert-block"></div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Input Citra</label>
                                    <input type="file" class="form-control" id="citra">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body px-0 pb-0">
                                        <ul class="conversation-list px-3" data-simplebar style="max-height: 554px" id="conversation-list-first">
                                        </ul>
                                    </div> <!-- end card-body -->
                                    <div class="card-body p-0">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mt-2 bg-light p-3">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col mb-2 mb-sm-0">
                                                                <input type="text" class="form-control border-0 chat-form-text" placeholder="Enter your text">
                                                                <div class="invalid-feedback">
                                                                    Please enter your messsage
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-auto">
                                                                <div class="btn-group">
                                                                    <div class="d-grid">
                                                                        <button type="button" class="btn btn-success chat-send" id="chat-send-1"><i class='uil uil-message'></i></button>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end col -->
                                                        </div> <!-- end row-->
                                                    </form>
                                                </div> 
                                            </div> <!-- end col-->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                </div> <!-- end card -->
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body px-0 pb-0">
                                        <ul class="conversation-list px-3" data-simplebar style="max-height: 554px" id="conversation-list-second">
                                        </ul>
                                    </div> <!-- end card-body -->
                                    <div class="card-body p-0">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mt-2 bg-light p-3">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col mb-2 mb-sm-0">
                                                                <input type="text" class="form-control border-0 chat-form-text" placeholder="Enter your text">
                                                                <div class="invalid-feedback">
                                                                    Please enter your messsage
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-auto">
                                                                <div class="btn-group">
                                                                    <div class="d-grid">
                                                                        <button type="button" class="btn btn-success chat-send" id="chat-send-2"><i class='uil uil-message'></i></button>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end col -->
                                                        </div> <!-- end row-->
                                                    </form>
                                                </div> 
                                            </div> <!-- end col-->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                </div> <!-- end card -->
                            </div>
                        </div>
                        
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

        <canvas id="citra_asli" width="1024" height="1024" class="d-none"></canvas>
        <canvas id="citra_enkripsi" width="1024" height="1024" class="d-none"></canvas>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

        <script src="lsb.js"></script>
        <script src="bc.js"></script>

        <script type="text/template" id="template-receive-chat">
            <li class="clearfix">
                <div class="chat-avatar">
                    <img src="{{avatar}}" class="rounded" alt="{{name}}" />
                </div>
                <div class="conversation-text">
                    <div class="ctext-wrap">
                        <i>{{name}}</i>
                        <p class="conversation-paragraf"> 
                            {{text}}
                        </p>
                    </div>
                </div>
            </li>
        </script>

        <script type="text/template" id="template-send-chat">
            <li class="clearfix odd">
                <div class="chat-avatar">
                    <img src="{{avatar}}" class="rounded" alt="{{name}}" />
                </div>
                <div class="conversation-text">
                    <div class="ctext-wrap">
                        <i>{{name}}</i>
                        <p class="conversation-paragraf">
                            {{text}}
                        </p>
                    </div>
                </div>
            </li>
        </script>

        <script>
            let citra = $('#citra');
            let chatSend1 = $('#chat-send-1');
            let chatSend2 = $('#chat-send-2');
            let alertBlock = $('#alert-block');
            let conversationListFirst = $('#conversation-list-first');
            let conversationListSecond = $('#conversation-list-second');

            let imageAvatarA = "assets/images/users/avatar-5.jpg";
            let imageAvatarB = "assets/images/users/avatar-1.jpg";

            // canvas
            let citra_asli = document.getElementById('citra_asli');
            let citra_enkripsi = document.getElementById('citra_enkripsi');

            // context
            let ctx_asli = citra_asli.getContext('2d', { willReadFrequently: true });
            let ctx_enkripsi = citra_enkripsi.getContext('2d', { willReadFrequently: true });

            const generateMakeId = function (length) {
                let result = '';
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                const charactersLength = characters.length;
                let counter = 0;
                while (counter < length) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
                counter += 1;
                }
                return result;
            }


            const sendAlert = function (html) {
                alertBlock.html(html);
            }

            const sendChat = function (text, from, elementTextArea) {
                if (citra.get(0).files.length === 0) {
                    sendAlert(
                        `<div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            <i class="ri-close-circle-line me-1 align-middle font-16"></i> Input Citra Tidak Boleh Kosong
                        </div>`
                    );

                    return;
                }

                let templateSendChat = $('#template-send-chat').html();
                let templateReceiveChat = $('#template-receive-chat').html();

                const uuid = generateMakeId(10);

                const textEnkripsi = enkripsiChat(text, uuid).then(function () {
                    const [status, textDekripsi] = dekripsiChat(uuid);

                    if ( ! status) return;
                    
                    templateSendChat = templateSendChat.replace(/{{text}}/g, textDekripsi);
                    templateReceiveChat = templateReceiveChat.replace(/{{text}}/g, textDekripsi);

                    switch (from) {
                        case 'first':
                            templateSendChat = templateSendChat.replace(/{{avatar}}/g, imageAvatarA);
                            templateSendChat = templateSendChat.replace(/{{name}}/g, "Avatar A");
                            conversationListFirst.append(templateSendChat);

                            templateReceiveChat = templateReceiveChat.replace(/{{avatar}}/g, imageAvatarA);
                            templateReceiveChat = templateReceiveChat.replace(/{{name}}/g, "Avatar A");
                            conversationListSecond.append(templateReceiveChat);
                            break;
                        case 'second':
                            templateSendChat = templateSendChat.replace(/{{avatar}}/g, imageAvatarB);
                            templateSendChat = templateSendChat.replace(/{{name}}/g, "Avatar B");
                            conversationListSecond.append(templateSendChat);

                            templateReceiveChat = templateReceiveChat.replace(/{{avatar}}/g, imageAvatarB);
                            templateReceiveChat = templateReceiveChat.replace(/{{name}}/g, "Avatar B");
                            conversationListFirst.append(templateReceiveChat);
                            break;
                    }

                    elementTextArea.val('');
                });

            }

            const enkripsiChat = function (text, uuid) {
                return new Promise((resolve, reject) => {
                    const secretKey = uuid.split('').map(function (it) {
                        return it.charCodeAt(0)
                    });

                    const textEncoderToUInt8Array = new TextEncoder();

                    const textConverted = textEncoderToUInt8Array.encode(text);

                    const newSecretKey = generateKey(secretKey, textConverted.length);
                    const newText = generateText(newSecretKey, textConverted)

                    const clampedArrayImageData = ctx_asli.getImageData(0, 0, citra_asli.width, citra_asli.height);

                    const imageData = {...clampedArrayImageData}
                    
                    const clampedArrayAddKeyLength = updateByteLength(secretKey, imageData, 0, 1);
                    const clampedArrayAddKey = updateByte(secretKey, clampedArrayAddKeyLength.imageData, clampedArrayAddKeyLength.index, clampedArrayAddKeyLength.startIndex);
                    const clampedArrayAddTextLength = updateByteLength(newText, clampedArrayAddKey.imageData, clampedArrayAddKey.index, clampedArrayAddKey.startIndex);
                    const clampedArrayAddText = updateByte(newText, clampedArrayAddTextLength.imageData, clampedArrayAddTextLength.index, clampedArrayAddTextLength.startIndex);
                    
                    clampedArrayImageData.data = clampedArrayAddText.imageData
                    ctx_enkripsi.putImageData(clampedArrayImageData, 0, 0);   

                    resolve();
                });
            }

            const dekripsiChat = function (uuid) {
                const clampedArrayImageData = ctx_enkripsi.getImageData(0, 0, citra_enkripsi.width, citra_enkripsi.height);
                        
                const imageData = {...clampedArrayImageData}

                const clampedArrayGetKeyLength = readByteLength(imageData, 0, 16, 1);
                const clampedArrayGetKey = readByte(imageData, clampedArrayGetKeyLength.index, clampedArrayGetKeyLength.bit, clampedArrayGetKeyLength.startIndex);
        
                if (clampedArrayGetKey.value.localeCompare(uuid) == 0) {
                    const clampedArrayGetTextLength = readByteLength(imageData, clampedArrayGetKey.index, 16, clampedArrayGetKey.startIndex);
                    const clampedArrayGetText = readByte(imageData, clampedArrayGetTextLength.index, clampedArrayGetTextLength.bit, clampedArrayGetTextLength.startIndex);
                    const secretKey = uuid.split('').map(function (it) {
                        return it.charCodeAt(0)
                    });
                    
                    const newSecretKey = generateKey(secretKey, clampedArrayGetText.bit.length);
                    const newText = generateText(newSecretKey, clampedArrayGetText.bit)
                    
                    const textString = generateTextToString(newText)

                    return [true, textString];

                }

                sendAlert(
                    `<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        <i class="ri-close-circle-line me-1 align-middle font-16"></i> Gagal membaca citra enkripsi
                    </div>`
                );

                return [false, null];
            }

            citra.on('change', function () {
                let file = citra.get(0).files[0];
                let fileReader = new FileReader();

                let loadEndEvent = function (evt) {
                    let img = new Image();
                    img.src = evt.target.result;

                    img.onload = function () {
                        ctx_asli.drawImage(img, 0, 0);
                    }
                }

                fileReader.addEventListener("loadend", loadEndEvent);
                fileReader.readAsDataURL(file);
            });

            chatSend1.on('click', function (e) {
                e.preventDefault();

                const chatFormText = $(this).closest('form').find('.chat-form-text')

                sendChat(chatFormText.val(), 'first', chatFormText)
            });

            chatSend2.on('click', function (e) {
                e.preventDefault();

                const chatFormText = $(this).closest('form').find('.chat-form-text')

                sendChat(chatFormText.val(), 'second', chatFormText)
            });
        </script>
    </body> 
</html> 