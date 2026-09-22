/**
 * Hizmet detay sayfalarinin icerigi.
 * Her kayit kendi sayfasini ve liste kartini uretir.
 */
module.exports = [
  {
    slug: "hizmet-cocuk-ergen-danismanligi",
    kategori: "Çocuk ve Ergen",
    cat: "cocuk",
    baslik: "Çocuk ve Ergen Danışmanlığı",
    kisa: "Duygu düzenleme, kaygı, akran ilişkileri, okul uyumu ve davranış süreçlerinde çocuk ve ergenlere yönelik psikolojik danışmanlık.",
    lead: "Çocuğun ve ergenin kendi hızında ilerleyebileceği, yargılanmadan konuşabileceği güvenli bir alan. Süreç aileyle birlikte planlanır, birlikte değerlendirilir.",
    gorsel: "danismanlik",
    bilgi: [
      ["Yaş aralığı", "6 – 18 yaş"],
      ["Seans süresi", "45 – 50 dakika"],
      ["Sıklık", "Haftada 1 seans (planlamaya göre)"],
      ["Katılım", "Bireysel + düzenli ebeveyn görüşmeleri"],
      ["Konum", "Yüz yüze / Ümraniye"],
    ],
    bolumler: [
      {
        h: "Nasıl Bir Süreç?",
        p: [
          "Çocuklar ve ergenler zorlandıklarını her zaman doğrudan söylemez. Bunu bazen davranışla, bazen sessizlikle, bazen de bedenlerinde hissettikleri sıkıntıyla anlatırlar. Danışmanlık süreci, bu anlatımın karşılık bulduğu bir ilişki kurmakla başlar.",
          "İlk görüşmeler ailenin gözünden başvuru nedenini anlamaya ayrılır. Ardından çocuk ya da ergenle tanışma seansları planlanır. Güven kurulduğunda süreç kendi ritmini bulur.",
        ],
      },
      {
        h: "Hangi Durumlarda Destek Olur?",
        liste: [
          "Kaygı, korku ve kendini güvende hissetmeme",
          "Öfke patlamaları ve duygu düzenleme güçlükleri",
          "Akran ilişkilerinde zorlanma, dışlanma, arkadaş edinememe",
          "Okula uyum, motivasyon ve performans kaygısı",
          "Kardeş ilişkileri ve aile içi çatışmalar",
          "Ergenlikte kimlik, sınır ve iletişim konuları",
        ],
      },
      {
        h: "Ailenin Rolü",
        p: [
          "Çocukla yürütülen süreç aileden bağımsız ilerlemez. Belirli aralıklarla ebeveyn görüşmeleri yapılır; evde uygulanabilecek yaklaşımlar birlikte konuşulur.",
          "Ergenlerle çalışırken gizlilik ilkesi özellikle önemlidir. Aileyle paylaşılacak konular, ergenin bilgisi dâhilinde ve güven ilişkisini zedelemeyecek biçimde ele alınır.",
        ],
      },
    ],
    alinti: "Çocuk, anlaşıldığını hissettiği anda anlatmaya başlar.",
    ilgili: ["hizmet-oyun-terapisi", "hizmet-aile-ebeveyn-danismanligi", "hizmet-akademik-gelisim"],
  },
  {
    slug: "hizmet-oyun-terapisi",
    kategori: "Çocuk ve Ergen",
    cat: "cocuk",
    baslik: "Oyun Terapisi",
    kisa: "Çocuk merkezli yaklaşımla, çocuğun kendi dili olan oyun üzerinden duygularını ifade etmesini ve düzenlemesini destekleyen süreç.",
    lead: "Çocuğun kendi dili olan oyun üzerinden duygularını ifade etmesini, anlamlandırmasını ve düzenlemesini destekleyen çocuk merkezli bir süreç.",
    gorsel: "oyun-odasi",
    bilgi: [
      ["Yaş aralığı", "3 – 12 yaş"],
      ["Seans süresi", "45 – 50 dakika"],
      ["Sıklık", "Haftada 1 seans (planlamaya göre)"],
      ["Katılım", "Bireysel + ebeveyn görüşmeleri"],
      ["Konum", "Yüz yüze / Ümraniye"],
    ],
    bolumler: [
      {
        h: "Oyun Terapisi Nedir?",
        p: [
          "Çocuklar duygularını her zaman kelimelerle anlatamaz. Oyun; çocuğun düşüncelerini, kaygılarını ve ihtiyaçlarını en doğal biçimde dışa vurduğu alandır. Oyun terapisi, bu doğal dili bir çalışma zemini olarak kullanır.",
          "Çocuk merkezli yaklaşımda uzman, çocuğu yönlendirmek yerine ona güvenli ve sınırları belli bir alan açar. Çocuk bu alanda kendi temposunda ilerlerken; duygu düzenleme, ilişki kurma ve baş etme becerileri desteklenir.",
        ],
      },
      {
        h: "Hangi Durumlarda Destek Olur?",
        liste: [
          "Kaygı, korku ve ayrılık zorlukları",
          "Öfke ve duygu düzenleme güçlükleri",
          "Kardeş gelişi, taşınma, okul değişimi gibi uyum süreçleri",
          "Akran ilişkilerinde yaşanan zorluklar",
          "İçe kapanma ya da kendini ifade etmekte zorlanma",
          "Aile içi değişimlere verilen davranışsal tepkiler",
        ],
      },
      {
        h: "Süreç Nasıl İlerler?",
        p: [
          "Süreç, ebeveynlerle yapılan bir ön görüşmeyle başlar. Çocuğun gelişim öyküsü, günlük yaşamı ve başvuru nedeni birlikte değerlendirilir. Ardından çocukla tanışma seansları planlanır.",
          "Belirli aralıklarla ebeveyn görüşmeleri yapılır; evde uygulanabilecek yaklaşımlar paylaşılır. Süreç, çocuğun ihtiyacına göre planlanır ve düzenli olarak yeniden değerlendirilir.",
        ],
      },
    ],
    alinti: "Oyun, çocuğun kelimeleri; oyuncaklar ise cümleleridir.",
    ilgili: ["hizmet-cocuk-ergen-danismanligi", "hizmet-aile-ebeveyn-danismanligi", "oyun-gruplari"],
  },
  {
    slug: "hizmet-aile-ebeveyn-danismanligi",
    kategori: "Aile ve Ebeveyn",
    cat: "aile",
    baslik: "Aile ve Ebeveyn Danışmanlığı",
    kisa: "Ebeveynlik süreçleri, aile içi iletişim, sınır koyma ve güvenli bağ kurma üzerine yürütülen danışmanlık görüşmeleri.",
    lead: "Çocuğun içinde büyüdüğü ilişki ortamı değiştiğinde, çocuk da değişir. Bu nedenle bazı süreçler doğrudan ebeveynle çalışılarak ilerler.",
    gorsel: "danismanlik",
    bilgi: [
      ["Katılım", "Anne, baba veya her ikisi"],
      ["Seans süresi", "50 – 60 dakika"],
      ["Sıklık", "Haftada 1 veya iki haftada 1"],
      ["Kapsam", "Ebeveynlik, iletişim, sınırlar"],
      ["Konum", "Yüz yüze / Ümraniye"],
    ],
    bolumler: [
      {
        h: "Neden Ebeveynle Çalışıyoruz?",
        p: [
          "Çocuğun davranışı, çoğu zaman içinde bulunduğu ilişki sisteminin bir yansımasıdır. Evdeki iletişim dili, ebeveyn tutumlarındaki tutarlılık ve ailenin kendi yükü, çocuğun günlük deneyimini doğrudan belirler.",
          "Bu nedenle bazı başvurularda en etkili yol, çocukla değil; ebeveynle çalışmaktan geçer. Ebeveyn kendi tepkilerini anladığında, çocuğun davranışı da çoğu kez kendiliğinden yumuşar.",
        ],
      },
      {
        h: "Görüşmelerde Neler Konuşulur?",
        liste: [
          "Sınır koyma, kural ve sonuç arasındaki fark",
          "Öfke anında ebeveynin kendi düzenlenmesi",
          "Kardeş ilişkileri ve adalet duygusu",
          "Ekran süresi, uyku ve günlük rutinler",
          "Eşler arası ebeveynlik tutumu farkları",
          "Boşanma, kayıp ve ailedeki geçiş dönemleri",
        ],
      },
      {
        h: "Çift Görüşmeleri",
        p: [
          "Ebeveynlik, çoğu zaman eşler arasındaki ilişkiden ayrı düşünülemez. Gerektiğinde görüşmeler çift olarak planlanır; ortak bir ebeveynlik dili kurmak üzerine çalışılır.",
          "Amaç kimin haklı olduğunu belirlemek değil; çocuğun iki ebeveyninden de tutarlı bir çerçeve görmesini sağlamaktır.",
        ],
      },
    ],
    alinti: "Ebeveyn sakinleştiğinde, çocuk da çoğu zaman sakinleşir.",
    ilgili: ["hizmet-anne-yenidogan", "hizmet-oyun-terapisi", "atolye-sinirlar-guvenli-bag"],
  },
  {
    slug: "hizmet-anne-yenidogan",
    kategori: "Aile ve Ebeveyn",
    cat: "aile",
    baslik: "Anne, Hamilelik ve Yenidoğan Danışmanlığı",
    kisa: "Hamilelik dönemi, doğum sonrası uyum ve yenidoğanla kurulan ilk bağ süreçlerinde annelere ve ailelere destek.",
    lead: "Bir bebeğin doğumu, aynı zamanda bir annenin ve bir ailenin de yeniden kurulmasıdır. Bu geçiş dönemi desteklenmeyi hak eder.",
    gorsel: "karsilama",
    bilgi: [
      ["Dönem", "Hamilelik – doğum sonrası ilk yıl"],
      ["Seans süresi", "50 dakika"],
      ["Katılım", "Anne, gerektiğinde eş ile birlikte"],
      ["Kapsam", "Uyum, bağlanma, iyi olma hali"],
      ["Konum", "Yüz yüze / Ümraniye"],
    ],
    bolumler: [
      {
        h: "Bu Dönemde Ne Oluyor?",
        p: [
          "Hamilelik ve doğum sonrası dönem, yaşamın en yoğun geçişlerinden biridir. Beden değişir, roller değişir, uyku düzeni bozulur; bununla birlikte duygular da hızlı dalgalanır.",
          "Bu dönemde yaşanan zorlanma bir yetersizlik göstergesi değildir. Aksine, desteklendiğinde çok daha kolay geçilen doğal bir uyum sürecidir.",
        ],
      },
      {
        h: "Hangi Konularda Çalışılır?",
        liste: [
          "Hamilelik döneminde kaygı ve doğuma hazırlık",
          "Doğum sonrası duygu değişimleri ve tükenmişlik",
          "Bebekle kurulan ilk bağ ve bağlanma süreci",
          "Emzirme, uyku ve beslenme etrafındaki gerilim",
          "Eş ilişkisinde değişen denge",
          "Büyük kardeşin yeni düzene uyumu",
        ],
      },
      {
        h: "Ne Zaman Destek Almalı?",
        p: [
          "Duygudurumdaki dalgalanma birkaç haftayı aşıyor, günlük işleyişi zorlaştırıyor ya da anne kendini sürekli yetersiz hissediyorsa bir uzmanla konuşmak süreci belirgin biçimde kolaylaştırır.",
          "Erken destek, hem annenin iyi olma halini hem de bebekle kurulan ilişkiyi doğrudan güçlendirir.",
        ],
      },
    ],
    alinti: "Anne desteklendiğinde, bebek de desteklenmiş olur.",
    ilgili: ["hizmet-aile-ebeveyn-danismanligi", "atolye-yenidogan-ilk-yil", "hizmet-oyun-terapisi"],
  },
  {
    slug: "hizmet-akademik-gelisim",
    kategori: "Danışmanlık",
    cat: "danismanlik",
    baslik: "Eğitim ve Akademik Gelişim Desteği",
    kisa: "Öğrenme süreçleri, çalışma alışkanlıkları, motivasyon ve okul-aile iş birliği konularında yönlendirme ve destek.",
    lead: "Akademik zorlanma çoğu zaman yalnızca ders çalışmayla ilgili değildir. Motivasyon, dikkat, kaygı ve özgüven bu resmin içindedir.",
    gorsel: "blog-masa",
    bilgi: [
      ["Yaş aralığı", "7 – 18 yaş"],
      ["Görüşme süresi", "45 – 50 dakika"],
      ["Sıklık", "İhtiyaca göre planlanır"],
      ["Katılım", "Öğrenci + ebeveyn görüşmeleri"],
      ["Konum", "Yüz yüze / Ümraniye"],
    ],
    bolumler: [
      {
        h: "Nasıl Yaklaşıyoruz?",
        p: [
          "Bir çocuğun ders başında zorlanması pek çok farklı nedenden kaynaklanabilir: dikkatini toplamakta güçlük, sınav kaygısı, konuya duyduğu yabancılık ya da sürekli kıyaslanmanın yarattığı yılgınlık.",
          "Bu nedenle çalışma programı hazırlamadan önce, zorlanmanın nereden geldiğini birlikte anlamaya çalışırız. Uygun destek ancak doğru resimden sonra planlanır.",
        ],
      },
      {
        h: "Çalışılan Başlıklar",
        liste: [
          "Çalışma alışkanlıkları ve zaman planlama",
          "Sınav kaygısı ve performans baskısı",
          "Dikkat ve odaklanma güçlükleri",
          "İçsel motivasyon ve sorumluluk duygusu",
          "Okul-aile iletişimi ve iş birliği",
          "Ergenlerde gelecek ve tercih kaygısı",
        ],
      },
      {
        h: "Okulla İş Birliği",
        p: [
          "Gerektiğinde ve ailenin onayıyla, okul rehberlik servisiyle iş birliği kurulur. Çocuğun okulda ve evde tutarlı bir destek görmesi sürecin etkisini belirgin biçimde artırır.",
        ],
      },
    ],
    alinti: "Ders başındaki zorlanma, çoğu zaman derse dair değildir.",
    ilgili: ["hizmet-cocuk-ergen-danismanligi", "hizmet-kurum-okul", "hizmet-seminer-workshop"],
  },
  {
    slug: "hizmet-seminer-workshop",
    kategori: "Grup Programları",
    cat: "grup",
    baslik: "Seminer ve Workshoplar",
    kisa: "Hafta sonlarında düzenlenen, ebeveynlere ve eğitimcilere yönelik seminer ve uygulamalı workshop programları.",
    lead: "Bilgiyi paylaşmak kadar, o bilgiyi günlük hayatta uygulanabilir hale getirmek önemlidir. Programlarımız bu yüzden uygulamalı ilerler.",
    gorsel: "atolye-masa",
    bilgi: [
      ["Katılımcı", "Ebeveynler ve eğitimciler"],
      ["Süre", "90 dakika – 2 saat"],
      ["Zaman", "Hafta sonları"],
      ["Kontenjan", "Sınırlı — ön kayıtlı"],
      ["Konum", "Yüz yüze / Ümraniye"],
    ],
    bolumler: [
      {
        h: "Nasıl İşliyor?",
        p: [
          "Seminerlerimiz tek oturumluk, belirli bir konuya odaklanan buluşmalardır. Workshoplar ise daha küçük gruplarla, katılımcıların kendi örnekleri üzerinden çalıştığı uygulamalı oturumlardır.",
          "Her iki formatta da amaç aynı: katılımcının ertesi gün evde ya da sınıfta deneyebileceği somut bir şeyle ayrılması.",
        ],
      },
      {
        h: "Örnek Program Başlıkları",
        liste: [
          "Okula uyum ve ayrılık kaygısı",
          "Ekran süresi ve dijital sınırlar",
          "Çocukta öfke: davranışın altındaki ihtiyaç",
          "Kardeş ilişkilerinde adalet ve rekabet",
          "Eğitimciler için sınıf içi duygu düzenleme",
          "Ergenle iletişim: ne zaman konuşmalı, ne zaman susmalı",
        ],
      },
      {
        h: "Kurumlara Özel Programlar",
        p: [
          "Okullar, kreşler ve kurumlar için programlar içerik ve süre olarak yeniden düzenlenebilir. Kurumunuzun ihtiyacına göre bir program planlamak için bizimle iletişime geçebilirsiniz.",
        ],
      },
    ],
    alinti: "İyi bir seminer, salondan çıkarken değil; ertesi sabah işe yarar.",
    ilgili: ["hizmet-kurum-okul", "atolyeler", "hizmet-akademik-gelisim"],
  },
  {
    slug: "hizmet-kurum-okul",
    kategori: "Danışmanlık",
    cat: "danismanlik",
    baslik: "Kurum ve Okul İş Birlikleri",
    kisa: "Okullar ve kurumlar için seminer, eğitmen atölyesi ve gelişim odaklı iş birliği programları.",
    lead: "Bir çocuğun gelişimi yalnızca evde değil; okulda, sınıfta ve akran grubunda da şekillenir. Kurumlarla kurulan iş birliği bu nedenle önemlidir.",
    gorsel: "karsilama",
    bilgi: [
      ["Kapsam", "Okul, kreş, kurum"],
      ["Format", "Seminer, atölye, süpervizyon"],
      ["Süre", "Programa göre planlanır"],
      ["Katılımcı", "Eğitimci, yönetici, veli"],
      ["Planlama", "Kurumla birlikte"],
    ],
    bolumler: [
      {
        h: "Neler Sunuyoruz?",
        p: [
          "Kurumların ihtiyacına göre; veli seminerleri, eğitimci atölyeleri ve vaka temelli paylaşım oturumları planlıyoruz. İçerik, kurumun yaş grubuna ve önceliklerine göre birlikte belirleniyor.",
        ],
      },
      {
        h: "İş Birliği Başlıkları",
        liste: [
          "Veli seminerleri ve bilgilendirme oturumları",
          "Eğitimciler için sınıf içi davranış yönetimi atölyeleri",
          "Okul rehberlik ekibiyle vaka paylaşım oturumları",
          "Uyum dönemi ve okula geçiş programları",
          "Kurum içi iletişim ve ekip çalışması oturumları",
        ],
      },
      {
        h: "Nasıl Başlıyoruz?",
        p: [
          "Kısa bir ön görüşmeyle kurumun ihtiyacını dinliyor, ardından içerik ve takvim önerisi hazırlıyoruz. Program başlamadan önce kapsam, süre ve katılımcı sayısı netleştiriliyor.",
        ],
      },
    ],
    alinti: "Çocuğun etrafındaki yetişkinler aynı dili konuştuğunda, çocuk rahatlar.",
    ilgili: ["hizmet-seminer-workshop", "hizmet-akademik-gelisim", "iletisim"],
  },
];
