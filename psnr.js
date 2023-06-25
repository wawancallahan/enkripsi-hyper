const mse = function (image1, image2) {
    let sum = 0;
    let l = image1.data.length;
    let a1 = undefined;
    let a2 = undefined;
    
    for (let i = 0; i < l; i += 4) {
        a1 = image1.data[i + 3] / 255; // Alpha
        a2 = image2.data[i + 3] / 255; // Alpha
        sum += Math.pow(image1.data[i] * a1 - image2.data[i] * a2, 2); // Red
        sum += Math.pow(image1.data[i + 1] * a1 - image2.data[i + 1] * a2, 2); // Green
        sum += Math.pow(image1.data[i + 2] * a1 - image2.data[i + 2] * a2, 2); // Blue
    }

    const finalMse = (sum / 3);
    
    return finalMse / (image1.width * image1.height);
}

const psnr = function (mse) {
    const max = 255;

    return 10 * log10((max * max) / mse);
}

const log10 = function (value) {
    return Math.log(value) / Math.LN10;
}

const psnrCategory = function (value) {
    if (value >= 60) {
        return "Excellent";
    } else if (value >= 50) {
        return "Good";
    } else if (value >= 40) {
        return "Reasonable";
    } else if (value >= 30) {
        return "Poor";
    } else {
        return "Unusable";
    }
}