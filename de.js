// input
let citra = document.getElementById('citra');

// canvas
let canvas = document.createElement('canvas');

// context
let context = canvas.getContext('2d');

citra.addEventListener('change', function (e) {
    let file = e.target.files[0];
    let fileReader = new FileReader();

    let loadEndEvent = function (e) {

        var img = new Image();
        img.src = e.target.result;
        img.onload = function () {
            context.drawImage(img, 0, 0);

            var loadView = context.getImageData(0, 0, 1024, 1024);
            let totalLength = 0;
            let bitLength = null;
            let lastIndex = 0;

            for (let i = 0; i < loadView.data.length; i++) {
                
                if (i % 3 === 0) continue;

                let asciiCode = loadView.data[i];
                let bits = byteString(asciiCode);
                let clamped = bits.substr(bits.length - 1);

                if (bitLength === null) bitLength = clamped;
                else bitLength = `${bitLength}${clamped}`;

                if (bitLength.length == 16) {
                    totalLength = parseInt(bitLength, 2);
                    lastIndex = i + 1;
                    break;
                }
            }

            let newUint8Array = new Uint8Array(totalLength);
            let j = 0;

            let result = null;

            for (let i = lastIndex; i < loadView.data.length; i++) {
                if (i % 3 === 0) continue;

                let asciiCode = loadView.data[i];
                let bits = byteString(asciiCode);
                let clamped = bits.substr(bits.length - 1);

                if (result === null) result = clamped;
                else result = `${result}${clamped}`;

                if (result.length == 8) {
                    newUint8Array[j] = parseInt(result, 2);

                    result = null;
                    j++;

                    return;
                }

                if (j > totalLength) break;
            }

            var hasil = decodeUtf8(newUint8Array);

            saveByteArray(hasil.split(''), 'hasil.txt');
        }

    }

    fileReader.addEventListener( "loadend", loadEndEvent );
    fileReader.readAsDataURL( file );
});

let byteString = function (n) {
    if (n < 0 || n > 255 || n % 1 !== 0) {
        throw new Error(n + " does not fit in a byte");
    }
    return ("000000000" + n.toString(2)).substr(-8)
}

var saveByteArray = (function() {
    var a = document.createElement("a");
    document.body.appendChild(a);
    a.style = "display: none";
    return function(data, name) {
        var blob = new Blob(data, {
                type: "octet/stream"
            }),
            url = window.URL.createObjectURL(blob);
        a.href = url;
        a.download = name;
        a.click();
        window.URL.revokeObjectURL(url);
    };
}());

let decodeUtf8 = function (arrayBuffer) {
    var result = "";
    var i = 0;
    var c = 0;
    var c1 = 0;
    var c2 = 0;

    var data = new Uint8Array(arrayBuffer);

    // If we have a BOM skip it
    if (data.length >= 3 && data[0] === 0xef && data[1] === 0xBB && data[2] === 0xBF) {
        i = 3;
    }

    while (i < data.length) {
        c = data[i];

        if (c < 128) {
            result += String.fromCharCode(c);
            i++;
        } else if (c > 191 && c < 224) {
            if (i + 1 >= data.length) {
                throw "UTF-8 Decode failed. Two byte character was truncated.";
            }
            c2 = data[i + 1];
            result += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
            i += 2;
        } else {
            if (i + 2 >= data.length) {
                throw "UTF-8 Decode failed. Multi byte character was truncated.";
            }
            c2 = data[i + 1];
            c3 = data[i + 2];
            result += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
            i += 3;
        }
    }
    return result;
}