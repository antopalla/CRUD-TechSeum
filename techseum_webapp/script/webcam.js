function avviaScansione(){
  const html5QrCode = new Html5Qrcode("contenitore_video");
  const config = { fps: 2, qrbox: 250 };
  const qrCodeSuccessCallback = message => {html5QrCode.stop(), console.log("ID: " + message), getCodiceQRNuovo(message)};
  html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);        
  setTimeout(function(){
	html5QrCode.stop().then(ignore => {
    // QR Code scanning is stopped.
    }).catch(err => {
      // Stop failed, handle it.
      console.log("errore nel fermare il qr scanner: " + err);
      });
    }, 30000);
}

function getCodiceQRNuovo(code){
  visualizzaReperto(code);
}