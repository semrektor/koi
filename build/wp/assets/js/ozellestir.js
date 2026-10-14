/* Ozellestir ekrani: bir sayfanin bolumu acilinca onizleme o sayfaya gider. */
(function (api) {
  api.bind("ready", function () {
    var adresler = window.koiOnizlemeAdresleri || {};
    Object.keys(adresler).forEach(function (kimlik) {
      api.section(kimlik, function (bolum) {
        bolum.expanded.bind(function (acik) {
          if (acik && api.previewer.previewUrl() !== adresler[kimlik]) {
            api.previewer.previewUrl.set(adresler[kimlik]);
          }
        });
      });
    });
  });
})(wp.customize);
