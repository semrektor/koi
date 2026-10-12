/**
 * Sik sorulan sorular (musterinin icerik formundaki metinler).
 * SSS sayfasini, Hizmetler ve Iletisim sayfalarindaki soru bolumlerini uretir;
 * WordPress'te "Sik Sorulan Sorular" olarak panelden yonetilir.
 *
 * hizmetler / iletisim: soru o sayfadaki kisa listede de gosterilir.
 */
module.exports = {
  bolumler: [
    { slug: "merkezimiz", ustYazi: "KOI Hakkında", baslik: "Merkezimiz" },
    { slug: "danismanlik", ustYazi: "Hizmetler ve Süreç", baslik: "Danışmanlık ve İlk Görüşme" },
    { slug: "programlar", ustYazi: "Programlar", baslik: "Oyun Grupları ve Atölyeler" },
    { slug: "basvuru", ustYazi: "Başvuru", baslik: "Bize Nasıl Ulaşırsınız?" },
  ],
  sorular: [
    {
      slug: "koi-nedir",
      bolum: "merkezimiz",
      soru: "KOI nedir?",
      yanit: [
        "KOI; çocukların, ebeveynlerin ve ailelerin ihtiyaçlarını birlikte ele alan; psikolojik danışmanlık, aile ve ebeveyn çalışmaları, oyun, gelişim programları ve atölyeleri aynı çatı altında buluşturan bir Çocuk ve Aile Gelişim Merkezidir.",
      ],
    },
    {
      slug: "koi-neden-kuruldu",
      bolum: "merkezimiz",
      soru: "KOI neden kuruldu?",
      yanit: [
        "KOI, çocuklarla ve ailelerle yürütülen uzun yıllara dayanan çalışmaların sonucunda; çocuğu yalnızca bireysel olarak değil, ailesi, ilişkileri ve gelişimsel çevresiyle birlikte ele alan daha bütüncül bir alan oluşturma fikriyle şekillendi.",
      ],
    },
    {
      slug: "hangi-yas-gruplari",
      bolum: "merkezimiz",
      soru: "Hangi yaş gruplarıyla çalışıyorsunuz?",
      yanit: [
        "KOI'de çocukların gelişim dönemlerine göre farklı çalışmalar planlanmaktadır. Oyun grupları ve gelişim programları yaşa ve gelişimsel ihtiyaçlara göre yapılandırılır.",
        "Bunun yanında çocuk ve ergen danışmanlığı, ebeveyn ve aile danışmanlığı gibi hizmetler de sunulmaktadır.",
        "Her çocuk için uygun hizmet, yaşının yanı sıra gelişimsel ve bireysel ihtiyaçları değerlendirilerek belirlenir.",
      ],
    },
    {
      slug: "oyun-grubu-oyun-terapisi-farki",
      bolum: "danismanlik",
      soru: "Oyun grubu ile oyun terapisi arasındaki fark nedir?",
      hizmetler: true,
      yanit: [
        "Oyun grupları, çocukların yaş ve gelişim özelliklerine uygun bir grup ortamında oyun oynama, keşfetme, iletişim kurma ve sosyal becerilerini destekleme amacı taşır.",
        "Oyun terapisi ise bireysel ihtiyaçlara göre yapılandırılan profesyonel bir danışmanlık/terapi sürecidir. Çocuğun duygusal ve davranışsal ihtiyaçları değerlendirilerek uzman tarafından planlanır.",
        "Kısacası, oyun grubu gelişimi destekleyen grup deneyimi; oyun terapisi ise çocuğun bireysel ihtiyaçlarına yönelik profesyonel bir süreçtir.",
      ],
    },
    {
      slug: "hangisi-uygun",
      bolum: "danismanlik",
      soru: "Çocuğum için danışmanlık mı, oyun grubu mu, atölye mi uygun?",
      hizmetler: true,
      iletisim: true,
      yanit: [
        "Bunu yalnızca yaşa bakarak belirlemek her zaman doğru değildir.",
        "Çocuğun gelişimsel özellikleri, ihtiyaçları, sosyal becerileri, duygusal durumu ve ailenin beklentileri birlikte değerlendirilir. Ön görüşme sonrasında çocuğunuz için danışmanlık, oyun terapisi, oyun grubu veya atölye seçeneklerinden hangisinin daha uygun olduğu konusunda yönlendirme yapılabilir.",
        "Amacımız belirli bir hizmeti sunmak değil, çocuğun ihtiyacına uygun olan alanı belirlemektir.",
      ],
    },
    {
      slug: "ilk-gorusme",
      bolum: "danismanlik",
      soru: "İlk görüşme nasıl ilerliyor?",
      hizmetler: true,
      iletisim: true,
      yanit: [
        "İlk görüşme, öncelikle çocuğunuzun ve ailenizin ihtiyaçlarını anlamaya yönelik bir ön değerlendirme ve tanışma süreci olarak ilerler.",
        "Çocuğun gelişim öyküsü, mevcut ihtiyaçlar, aile ve okul yaşamı gibi konular ele alınır. İhtiyaca göre danışmanlık, oyun terapisi, oyun grubu veya farklı bir çalışma önerilebilir.",
        "Amaç, her aileyi tek bir programa yönlendirmek değil; ihtiyaca uygun yolu birlikte belirlemektir.",
      ],
    },
    {
      slug: "ebeveyn-gorusmeye-katilir-mi",
      bolum: "danismanlik",
      soru: "Ebeveyn görüşmeye katılır mı?",
      hizmetler: true,
      yanit: [
        "Sürecin niteliğine göre ebeveyn katılımı değişebilir.",
        "Özellikle çocukla yürütülen danışmanlık ve oyun terapisi süreçlerinde ebeveyn görüşmeleri, çocuğun gelişimini ve süreci daha bütüncül değerlendirmek açısından önemli bir yer tutar.",
        "Ebeveynle ne sıklıkta ve hangi kapsamda görüşüleceği, çocuğun ihtiyaçlarına ve yürütülen çalışmanın yapısına göre belirlenir.",
      ],
    },
    {
      slug: "oyun-gruplarinda-ebeveynin-rolu",
      bolum: "programlar",
      soru: "Oyun gruplarında ebeveynin rolü nedir?",
      yanit: [
        "Oyun gruplarında ebeveynin rolü, programın yapısına göre değişebilir. Bazı programlarda ebeveyn sürecin aktif bir parçasıyken, bazı grup çalışmalarında çocukların bağımsız olarak grup deneyimi yaşamaları hedeflenebilir.",
        "Ebeveynlere gerektiğinde çocuğun grup içerisindeki deneyimi ve gelişim süreci hakkında geri bildirim verilir.",
        "Buradaki amaç, ebeveyni sürecin dışında bırakmak değil; çocuğun ihtiyacına uygun şekilde sürece dahil etmektir.",
      ],
    },
    {
      slug: "grup-kontenjani",
      bolum: "programlar",
      soru: "Grup kontenjanı kaç kişi?",
      yanit: [
        "KOI oyun grupları küçük grup prensibiyle planlanmaktadır. Mevcut program planlamamızda bir grupta en fazla 6 çocuk yer almaktadır.",
        "Kontenjanların sınırlı tutulmasının amacı, çocukların grup içerisindeki deneyimlerinin daha yakından takip edilebilmesi ve her çocuğa yeterli alan sağlanabilmesidir.",
      ],
    },
    {
      slug: "atolyelere-tek-seferlik-katilim",
      bolum: "programlar",
      soru: "Atölyelere tek seferlik katılım mümkün mü?",
      yanit: [
        "Atölyenin içeriğine ve program yapısına göre değişebilir.",
        "Bazı atölyeler tek oturumluk olarak planlanabilirken, bazı çalışmalar belirli bir programın parçası olarak birden fazla oturum şeklinde düzenlenebilir.",
        "Her atölyenin katılım koşulları ve kayıt bilgileri ilgili etkinliğin duyurusunda belirtilir.",
      ],
    },
    {
      slug: "randevu-ve-on-basvuru",
      bolum: "basvuru",
      soru: "Randevu ve ön başvuru nasıl yapılır?",
      iletisim: true,
      yanit: [
        "KOI'ye web sitesindeki iletişim/ön başvuru formu veya WhatsApp üzerinden ulaşabilirsiniz.",
        "İlk iletişimde çocuğunuzun yaşı, ihtiyaç alanı ve almak istediğiniz hizmet hakkında kısaca bilgi alınır. Ardından uygun uzman, hizmet ve görüşme zamanı konusunda yönlendirme yapılır.",
        "Randevu oluşturulmadan önce ihtiyaç ve süreç hakkında bilgi almak için de bizimle iletişime geçebilirsiniz.",
      ],
    },
    {
      slug: "ucret-bilgisi",
      bolum: "basvuru",
      soru: "Ücret bilgisi nasıl alabilirim?",
      hizmetler: true,
      iletisim: true,
      yanit: [
        "Ücretler hizmete, uzmana ve programa göre değiştiği için sitede sabit fiyat yayınlamıyoruz. Güncel bilgi için iletişim formunu doldurabilir veya bize ulaşabilirsiniz.",
      ],
    },
  ],
};
