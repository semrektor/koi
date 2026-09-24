/* Taslak giris dogrulamasi.
   Yalnizca tanitim amaclidir - gercek kimlik dogrulama sunucu tarafinda
   (WordPress kullanici yonetimi) yapilacaktir. */
(function () {
  var HESAP = { kullanici: "admin", sifre: "admin", ad: "Admin Kullanıcı", bas: "AK" };

  document.getElementById("giris-form").addEventListener("submit", function (e) {
    e.preventDefault();
    var k = document.getElementById("g-kullanici").value.trim().toLowerCase();
    var s = document.getElementById("g-sifre").value;
    var hata = document.getElementById("giris-hata");

    if (k === HESAP.kullanici && s === HESAP.sifre) {
      try {
        var depo = document.getElementById("g-hatirla").checked ? localStorage : sessionStorage;
        depo.setItem("koi-oturum", JSON.stringify({ ad: HESAP.ad, bas: HESAP.bas, giris: Date.now() }));
      } catch (err) {}
      window.location.href = "yonetim.html";
      return;
    }

    hata.textContent = "Kullanıcı adı veya parola hatalı. Örnek hesap: admin / admin";
    hata.style.display = "block";
    document.getElementById("g-sifre").value = "";
    document.getElementById("g-sifre").focus();
  });
})();
