/**
 * Galeri gorselleri. Galeri sayfasini ve ana sayfadaki galeri seridini uretir;
 * WordPress'te "Galeri" olarak panelden yonetilir.
 *
 * gorsel: temayla gelen temsili gorselin adi. Gercek fotograflar geldiginde
 * panelden yeni kayit eklenip "One cikan gorsel" olarak yuklenir.
 */
module.exports = {
  kategoriler: { mekan: "Mekân", atolye: "Atölyeler", etkinlik: "Etkinlikler" },
  /* Izgaradaki yerlesim ritmi: gorseller bu sinif dizisini sirayla ve donerek alir */
  desen: [
    "media--span2 media--row2",
    "",
    "media--olive",
    "media--olive",
    "",
    "",
    "media--olive media--row2",
    "media--span2",
    "",
    "",
    "media--olive",
    "media--span2",
  ],
  gorseller: [
    { baslik: "Karşılama alanı", cat: "mekan", gorsel: "karsilama" },
    { baslik: "Oyun odası", cat: "mekan", gorsel: "oyun-odasi" },
    { baslik: "Danışmanlık odası", cat: "mekan", gorsel: "danismanlik" },
    { baslik: "Atölye alanı", cat: "atolye", gorsel: "atolye-masa" },
    { baslik: "Bekleme alanı", cat: "mekan", gorsel: "karsilama" },
    { baslik: "Malzeme detayı", cat: "atolye", gorsel: "atolye-masa" },
    { baslik: "Atölye anı", cat: "atolye", gorsel: "atolye-masa" },
    { baslik: "Açılış etkinliği", cat: "etkinlik", gorsel: "hero-kemer" },
    { baslik: "Seminer", cat: "etkinlik", gorsel: "danismanlik" },
    { baslik: "Detay — bitki", cat: "mekan", gorsel: "yaprak" },
    { baslik: "Çocuk-aile buluşması", cat: "etkinlik", gorsel: "oyun-odasi" },
    { baslik: "Mekân genel görünüm", cat: "mekan", gorsel: "karsilama" },
  ],
};
