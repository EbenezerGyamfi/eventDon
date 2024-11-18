import { Html5QrcodeScanner } from "html5-qrcode";

const scannedCode = document.querySelector("#code");

function onScanSuccess(decodedText, decodedResult) {
    // handle the scanned code as you like, for example:

    // console.log(`Code matched = ${decodedText}`, decodedResult);
    html5QrcodeScanner.clear();
    scannedCode.value = decodedText;
    $("#verify-qr-code").submit();
    $("#staticBackdrop").modal("hide");
}

function onScanFailure(error) {
    // handle scan failure, usually better to ignore and keep scanning.
    // for example:
    console.warn(`Code scan error = ${error}`);
    html5QrcodeScanner.pause();
    stream.getTracks().forEach(function (track) {
        track.stop();
    });
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    // { fps: 10, qrbox: { width: 250, height: 250 } },
    /* verbose= */ false
);

html5QrcodeScanner.render(onScanSuccess);
