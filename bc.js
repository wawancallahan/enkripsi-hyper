const generateKey = function (key, length = 0) {
    if (length <= 0) {
        throw new Error ("Length Harus Lebih Dari 0")
    }

    if (key <= 0) {
        throw new Error ("Key Harus Lebih Dari 0 Karakter")
    }

    const newKey = [];

    for (let i = 0; ; i++) {
        if (i == key.length) {
            i = 0;
        }

        if (newKey.length == length) {
            break;
        }

        newKey.push(key[i])
    }

    return newKey
}

const formula = function (key, text) {
    const result = key - text

    const charCode = ((result % 256) + 256) % 256

    return charCode
}

const generateText = function (key, text) {
    const newText = []

    for (let i = 0; i < text.length; i++) {
        const resultText = formula(key[i], text[i])

        newText.push(resultText)
    }

    return newText
}

const generateTextToString = function (text) {
    const newText = []

    for (let i = 0; i < text.length; i++) {
        const resultText = String.fromCharCode(text[i])

        newText.push(resultText)
    }

    return newText.join('')
}