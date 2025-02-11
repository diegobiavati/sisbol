<!-- Original:  Jonathan Feaster (http://www.archreality.com/) -->

<!-- Web Site:  http://www.archreality.com/jcap/ -->

<!-- Version: 2.0 -->

<!-- Based on: Gimpy CAPTCHA Project at Carnegie Mellon University (http://www.captcha.net/) -->

<!-- Begin

var imgdir = "./imagens/cimg/"; // identify directory where captcha images are located
var jfldid = "uword"; // identify word field id name
var jfldsz = 20; // identify word field size

function sjcap(jfldcls){
    imgdir = encodeURIComponent(imgdir);
    if (jfldcls == null){
        jfldcls = "";
    }
    anum = (Math.floor(Math.random()*191))+1;
    imgid = parseInt(anum);
    cword =
    ["60ee0bc62638fccf2d37ac27a634a9e9", "68e2d83709f317938b51e53f7552ed04", "f4c9385f1902f7334b00b9b4ecd164de",
    "df491a4de50739fa9cffdbd4e3f4b4bb", "ef56b0b0ddb93c2885892c06be830c68", "fe4c0f30aa359c41d9f9a5f69c8c4192",
    "cbf4e0b7971051760907c327e975f4e5", "ea9e801b0d806f2398bd0c7fe3f3f0cd", "609a8f6f218fdfe6f955e19f818ec050",
    "cbf4e0b7971051760907c327e975f4e5", "8cb554127837a4002338c10a299289fb", "28f9b1cae5ae23caa8471696342f6f0c",
    "74e04ddb55ce3825f65ebec374ef8f0d", "567904efe9e64d9faf3e41ef402cb568", "7edabf994b76a00cbc60c95af337db8f",
    "639849f6b368019778991b32434354fc", "7edabf994b76a00cbc60c95af337db8f", "dd8fc45d87f91c6f9a9f43a3f355a94a",
    "eb5c1399a871211c7e7ed732d15e3a8b", "8cb554127837a4002338c10a299289fb", "0b8263d341de01f741e4deadfb18f9eb",
    "87fa4eaaf3698e1b1e2caadabbc8ca60", "327a6c4304ad5938eaf0efb6cc3e53dc", "841a2d689ad86bd1611447453c22c6fc",
    "ceb20772e0c9d240c75eb26b0e37abee", "a3e2a6cbf4437e50816a60a64375490e", "bc8fba5b68a7babc05ec51771bf6be21",
    "68934a3e9455fa72420237eb05902327", "c9fab33e9458412c527c3fe8a13ee37d", "2fc01ec765ec0cb3dcc559126de20b30",
    "fcc790c72a86190de1b549d0ddc6f55c", "918b81db5e91d031548b963c93845e5b", "9dfc8dce7280fd49fc6e7bf0436ed325",
    "ea82410c7a9991816b5eeeebe195e20a", "fb81c91eb92d6cb64aeb64c3f37ef2c4", "8d45c85b51b27a04ad7fdfc3f126f9f8",
    "70dda5dfb8053dc6d1c492574bce9bfd", "b9b83bad6bd2b4f7c40109304cf580e1", "981c1e7b3795da18687613fbd66d4954",
    "e170e3a15923188224c1c2bd1477d451", "fb81c91eb92d6cb64aeb64c3f37ef2c4", "cb15e32f389b7af9b285a63ca1044651",
    "632a2406bbcbcd553eec45ac14b40a0a", "e7b95b49658278100801c88833a52522", "6d4db5ff0c117864a02827bad3c361b9",
    "8b373710bcf876edd91f281e50ed58ab", "508c75c8507a2ae5223dfd2faeb98122", "97f014516561ef487ec368d6158eb3f4",
    "23678db5efde9ab46bce8c23a6d91b50", "2d6b0cefb06fd579a62bf56f02b6c2b3", "f1bdf5ed1d7ad7ede4e3809bd35644b0",
    "3ddaeb82fbba964fb3461d4e4f1342eb", "c9507f538a6e79c9bd6229981d6e05a3", "9e925e9341b490bfd3b4c4ca3b0c1ef2",
    "125097a929a62998c06340ea9ef43d77", "a557264a7d6c783f6fb57fb7d0b9d6b0", "eba478647c77836e50de44b323564bdb",
    "45fe7e5529d283851d93b74536e095a0", "56609ab6ba04048adc2cbfafbe745e10", "d938ad5cbe68bec494fbbf4463ad031d",
    "9bbd993d9da7df60b3fd4a4ed721b082", "a6ab62e9da89b20d720c70602624bfc2", "51037a4a37730f52c8732586d3aaa316",
    "7c4f29407893c334a6cb7a87bf045c0d", "3b7770f7743e8f01f0fd807f304a21d0", "29d233ae0b83eff6e5fbd67134b88717",
    "8d45c85b51b27a04ad7fdfc3f126f9f8", "9aa91f81de7610b371dd0e6fe4168b01", "9f27410725ab8cc8854a2769c7a516b8",
    "6ee6a213cb02554a63b1867143572e70", "918b81db5e91d031548b963c93845e5b", "3767b450824877f2b8f284f7a5625440",
    "81513effdf5790b79549208838404407", "7aea2552dfe7eb84b9443b6fc9ba6e01", "d8735f7489c94f42f508d7eb1c249584",
    "fde27e470207e146b29b8906826589cb", "2a2d595e6ed9a0b24f027f2b63b134d6", "99e0d947e01bbc0a507a1127dc2135b1",
    "6758fcdc0da017540d11889c22bb5a6e", "ab1991b4286f7e79720fe0d4011789c8", "28f9b1cae5ae23caa8471696342f6f0c",
    "f5b75010ea8a54b96f8fe7dafac65c18", "2570c919f5ef1d7091f0f66d54dac974", "ada15bd1a5ddf0b790ae1dcfd05a1e70",
    "eb88d7636980738cd0522ea69e212905", "83ab982dd08483187289a75163dc50fe", "8ac20bf5803e6067a65165d9df51a8e7",
    "7c4f29407893c334a6cb7a87bf045c0d", "67942503875c1ae74e4b5b80a0dade01", "d74fdde2944f475adc4a85e349d4ee7b",
    "163ccb6353c3b5f4f03cda0f1c5225ba", "6b1628b016dff46e6fa35684be6acc96", "de1b2a7baf7850243db71c4abd4e5a39",
    "5eda0ea98768e91b815fa6667e4f0178", "23ec24c5ca59000543cee1dfded0cbea", "ea9e801b0d806f2398bd0c7fe3f3f0cd",
    "35393c24384b8862798716628f7bc6f4", "28b26be59c986170c572133aaace31c2", "c2bfd01762cfbe4e34cc97b9769b4238",
    "22811dd94d65037ef86535740b98dec8", "acaa16770db76c1ffb9cee51c3cabfcf", "7516c3b35580b3490248629cff5e498c",
    "b04ab37e571600800864f7a311e2a386", "7e25b972e192b01004b62346ee9975a5", "2764ca9d34e90313978d044f27ae433b",
    "660cb6fe7437d4b40e4a04b706b93f70", "87a429872c7faee7e8bc9268d5bf548e", "31c13f47ad87dd7baa2d558a91e0fbb9",
    "e6ec529ba185279aa0adcf93e645c7cd", "21a361d96e3e13f5f109748c2a9d2434", "85814ce7d88361ec8eb8e07294043bc3",
    "a5fdad9de7faf3a0492812b9cb818d85", "0b8263d341de01f741e4deadfb18f9eb", "0cb47aeb6e5f9323f0969e628c4e59f5",
    "23a58bf9274bedb19375e527a0744fa9", "7e25b972e192b01004b62346ee9975a5", "b9d27d6b3d1915aacd5226b9d702bdbb",
    "6758fcdc0da017540d11889c22bb5a6e", "e2704f30f596dbe4e22d1d443b10e004", "da4f0053a5c13882268852ae2da2e466",
    "1562eb3f6d9c5ac7e159c04a96ff4dfe", "a94aa000f9a94cc51775bd5eac97c926", "1e4483e833025ac10e6184e75cb2d19d",
    "a957a3153eb7126b1c5f8b6aac35de53", "731b886d80d2ea138da54d30f43b2005", "a850c17cba5eb16b0d3d40a106333bd5",
    "7516c3b35580b3490248629cff5e498c", "d508fe45cecaf653904a0e774084bb5c", "18ccf61d533b600bbf5a963359223fe4",
    "f4d3b5a1116ded3facefb8353d0bd5ba", "28b26be59c986170c572133aaace31c2", "d5ca322453f2986b752e58b11af83d96",
    "37b19816109a32106d109e83bbb3c97d", "0423fa423baf1ea8139f6662869faf2f", "8ab8a4dfab57b4618331ffc958ebb4ec",
    "85814ce7d88361ec8eb8e07294043bc3", "273b9ae535de53399c86a9b83148a8ed", "4c9184f37cff01bcdc32dc486ec36961",
    "8ee2027983915ec78acc45027d874316", "1cba77c39b4d0a81024a7aada3655a28", "de1b2a7baf7850243db71c4abd4e5a39",
    "608f0b988db4a96066af7dd8870de96c", "06a224da9e61bee19ec9eef88b95f934", "df55340f75b5da454e1c189d56d7f31b",
    "8c728e685ddde9f7fbbc452155e29639", "2570c919f5ef1d7091f0f66d54dac974", "dce7c4174ce9323904a934a486c41288",
    "573ce5969e9884d49d4fab77b09a306a", "d5ca322453f2986b752e58b11af83d96", "eb88d7636980738cd0522ea69e212905",
    "e7e94d9ef1edaf2c6c55e9966b551295", "762f8817ab6af0971fe330dbf46a359a", "d8a48e3f0e1322d53d401e3dcb3360db",
    "c1940aeeb9693a02e28c52eb85ce261c", "d74fdde2944f475adc4a85e349d4ee7b", "b6a5d96a4e99b63723ab54ddb471baad",
    "6b157916b43b09df5a22f658ccb92b64", "bec670e5a55424d840db8636ecc28828", "4a6cbcd66d270792b89f50771604d093",
    "07202a7e6cbfbabe27abba87989f807e", "d60db28d94d538bbb249dcc7f2273ab1", "123402c04dcfb6625f688f771a5fc05d",
    "cd69b4957f06cd818d7bf3d61980e291", "be1ab1632e4285edc3733b142935c60b", "2bda2998d9b0ee197da142a0447f6725",
    "ba535ef5a9f7b8bc875812bb081286bb", "e9f40e1f1d1658681dad2dac4ae0971e", "eabe04e738cfb621f819e4e8f9489234",
    "aa2d6e4f578eb0cfaba23beef76c2194", "126ac4b07f93bc4f7bed426f5e978c16", "f43dff9a0dc54f0643d0c6d7971635f0",
    "ccaaac957ec37bde4c9993a26a064730", "2feaaf89c21770ea5c21196bc33848dd", "07cf4f8f5d8b76282917320715dda2ad",
    "1ffd9e753c8054cc61456ac7fac1ac89", "6050ce63e4bce6764cb34cac51fb44d1", "327a6c4304ad5938eaf0efb6cc3e53dc",
    "b82c91e2103d0a495c099f0a12f66363", "41d1de28e96dc1cde568d3b068fa17bb", "cad1c068cb62b0681fe4c33d1db1bad6",
    "de1b2a7baf7850243db71c4abd4e5a39", "75e52a0ecfafeda17a34fc60111c1f0b", "fc7e987f23de5bd6562b7c0063cad659",
    "126ac4b07f93bc4f7bed426f5e978c16", "fcc790c72a86190de1b549d0ddc6f55c", "72792fa10d4ca61295194377da0bcc05",
    "821f03288846297c2cf43c34766a38f7", "faec47e96bfb066b7c4b8c502dc3f649", "78b6367af86e03f19809449e2c365ff5",
    "015f28b9df1bdd36427dd976fb73b29d", "755f85c2723bb39381c7379a604160d8"];

// PARREIRA 13-06-13 - JCAP alterado para login 2.5
    document.write("<img src=\"" + decodeURIComponent(imgdir) + imgid + ".jpg\" width=\"200\" height=\"30\" alt=\"\"");
    document.write("<br><br><input type=\"text\" id=\"cod2\" name=\"validador\" class=\"campos_input2" + jfldcls + "\" size=16\"" +  jfldsz + "\"><br>Digite os caracteres exibidos");
    cword = cword[anum-1];
    document.write("<input type=\"hidden\" name=\"cod1\" value=\""+cword+"\">");
}


//  End -->


/*
 //document.write("<p><img src=\"" + decodeURIComponent(imgdir) + imgid + ".jpg\" width=\"200\" height=\"30\" alt=\"\"");
 //   document.write("<br><br>Caracteres: <input type=\"text\" id=\"cod2\" name=\"validador\" class=\"" + jfldcls + "\" size=16\"" +  jfldsz + "\"><br>Digite os caracteres exibidos");
 //   cword = cword[anum-1];
 //   document.write("<input type=\"hidden\" name=\"cod1\" value=\""+cword+"\">");*/