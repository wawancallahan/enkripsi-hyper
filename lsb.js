const byte16String = function (n) {
    if (n < 0 || n > 32767 || n % 1 !== 0) {
        throw new Error(n + " does not fit in a byte");
    }

    return ("00000000000000000" + n.toString(2)).substr(-16)
}

const byteString = function (n) {
    if (n < 0 || n > 255 || n % 1 !== 0) {
        throw new Error(n + " does not fit in a byte");
    }
    return ("000000000" + n.toString(2)).substr(-8)
}

const updateByteLength = function (view, clampedArray, iteration, startIndex) {
    let length = view.length;
    let bits = byte16String(length);

    let newClampedArray = {...clampedArray}

    let index = iteration;
    let indexDigit = startIndex;

    bits.split('').forEach(function (bit) {
        if (indexDigit % 4 === 0) {
            ++index;
            ++indexDigit;
        }

        let clampedBits = byteString(newClampedArray.data[index]);

        let clamped = clampedBits.toString().slice(0, -1);
        let clampedNewBits = `${clamped}${bit}`;
        newClampedArray.data[index] = parseInt(clampedNewBits, 2);
        index++;
        indexDigit++;
    });

    return { 
        imageData: newClampedArray, 
        index,
        startIndex: indexDigit 
    }
}

const updateByte = function (view, clampedArray, iteration, startIndex) {
    let newClampedArray = {...clampedArray}

    let index = iteration;
    let indexDigit = startIndex;

    for (let i = 0; i < view.length; i++) {
        let asciiCode = view[i];
        let bits = byteString(asciiCode);

        bits.split('').forEach(function (bit) {
            if (indexDigit % 4 === 0) {
                ++index;
                ++indexDigit;
            }
            
            let clampedBits = byteString(newClampedArray.data[index], index);

            let clamped = clampedBits.toString().slice(0, -1);
            let clampedNewBits = `${clamped}${bit}`;
            newClampedArray.data[index] = parseInt(clampedNewBits, 2);
            index++;
            indexDigit++;
        });
    }

    return { 
        imageData: newClampedArray, 
        index,
        startIndex: indexDigit
    };
}

const readByteLength = function (clampedArray, iteration, maxLength, startIndex) {
    let newClampedArray = {...clampedArray}
    let index = iteration;
    let indexDigit = startIndex;

    let getByte = 0;
    const getBits = [];

    for (let i = iteration; i < newClampedArray.data.length; i++) {
        if (indexDigit % 4 === 0) {
            ++index;
            ++indexDigit;
            continue;
        }

        let asciiCode = newClampedArray.data[i];
        let bits = byteString(asciiCode);

        getBits.push(bits.charAt(bits.length - 1))
        getByte++;
        index++;
        indexDigit++;

        if (getByte == maxLength) break;
    }

    const bitsKey = getBits.join('') 

    return {
        bit: parseInt(bitsKey, 2),
        value: parseInt(bitsKey, 2),
        index,
        startIndex: indexDigit
    };
}

const readByte = function (clampedArray, iteration, maxLength, startIndex) {
    let newClampedArray = {...clampedArray}
    let index = iteration;
    let indexDigit = startIndex;

    let getByte = 0;
    let getBitsCount = 0;
    const getBits = [];
    
    for (let j = 0; j < maxLength; j++) {
        getBits.push([])
    }

    for (let i = iteration; i < newClampedArray.data.length; i++) {
        if (indexDigit % 4 === 0) {
            ++index;
            ++indexDigit;
            continue;
        }

        let asciiCode = newClampedArray.data[i];
        let bits = byteString(asciiCode);

        getBits[getBitsCount].push(bits.charAt(bits.length - 1))
        getByte++;
        index++;
        indexDigit++;

        if (getByte % 8 == 0) {
            getByte = 0;
            getBitsCount++;
        };

        if (getBitsCount == maxLength) break;
    }

    const bitsKey = getBits.map(it => {
        return parseInt(it.join(''), 2)
    }) 

    const value = bitsKey.map(it => {
        return String.fromCharCode(it)
    }).join('')

    return {
        getBits,
        bit: bitsKey,
        value: value,
        index,
        startIndex: indexDigit
    };
}