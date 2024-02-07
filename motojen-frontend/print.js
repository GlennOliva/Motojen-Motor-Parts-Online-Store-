let printBtn = document.querySelector("#print");
let saveBtn = document.querySelector("#save");
let backBtn = document.querySelector("#back");

printBtn.addEventListener("click", function () {
  window.print();
});

backBtn.addEventListener("click", function () {
  window.location = "orders.php";
});

saveBtn.addEventListener("click", function () {
  html2canvas(document.querySelector("#save_to_image")).then(function (canvas) {
    var link = document.querySelector("#save_to_image");
    link.setAttribute("download", "123456.png");
    link.setAttribute(
      "href",
      canvas.toDataURL("image/png").replace("image/png", "image/octet-stream")
    );
    link.click();
  });
});
