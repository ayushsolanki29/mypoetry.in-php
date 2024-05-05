const generateCertificate = async (name, rank , email) => {

  document.querySelector("body").insertAdjacentHTML(
    "beforeend",
    `  <div class="loader-div">
        <div class="bg">
  <div class="loader"></div>
</div>
        </div>
        `
  );

  const { PDFDocument, rgb } = PDFLib;

  try {
    const response = await fetch("source/certificate/Certificate.pdf");
    const font = await fetch("source/certificate/BrittanySignature.ttf");

    const pdfBytes = await response.arrayBuffer();
    const exFont = await font.arrayBuffer();

    const pdfDoc = await PDFDocument.load(pdfBytes);
    pdfDoc.registerFontkit(fontkit);
    const myFont = await pdfDoc.embedFont(exFont);

    const pages = pdfDoc.getPages();
    const firstPg = pages[0];
    firstPg.drawText(name, {
      x: 300,
      y: 320,
      size: 40,
      font: myFont,
      color: rgb(0, 0, 0),
    });

    const uri = await pdfDoc.saveAsBase64({ dataUri: true });

    // const frame = document.getElementById("myframe").src = uri;

    const formData = new FormData();
    formData.append("name", name);
    formData.append("email", email);
    formData.append("pdfUri", uri);
    formData.append("winrank", rank);

    const sendCertificateResponse = await fetch("send-certificate.php", {
      method: "POST",
      body: formData,
    });

    if (sendCertificateResponse.ok) {
      alert("Email sent successfully!");
    } else {
      alert("Failed to send email. Please try again.");
    }
  } catch (error) {
    console.error("Error:", error);
    alert("An error occurred. Please try again later.");
  } finally {
    // Remove loader regardless of success or failure
    const loader = document.querySelector(".loader-div");
    if (loader) {
      loader.remove();
    }
  }
};
