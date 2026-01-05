/*! * UAParser.js v0.7.23 * Lightweight JavaScript-based User-Agent string parser * https://github.com/faisalman/ua-parser-js * * Copyright © 2012-2019 Faisal Salman <f@faisalman.com> * Licensed under MIT License */
!function(r, u) {
    "use strict";
    function a(i, s) {
        var e, o;
        return "object" == typeof i && (s = i,
        i = u),
        this instanceof a ? (e = i || (r && r.navigator && r.navigator.userAgent ? r.navigator.userAgent : ""),
        o = s ? f.extend(k, s) : k,
        this.getBrowser = function() {
            var i = {
                name: u,
                version: u
            };
            return v.rgx.call(i, e, o.browser),
            i.major = f.major(i.version),
            i
        }
        ,
        this.getCPU = function() {
            var i = {
                architecture: u
            };
            return v.rgx.call(i, e, o.cpu),
            i
        }
        ,
        this.getDevice = function() {
            var i = {
                vendor: u,
                model: u,
                type: u
            };
            return v.rgx.call(i, e, o.device),
            i
        }
        ,
        this.getEngine = function() {
            var i = {
                name: u,
                version: u
            };
            return v.rgx.call(i, e, o.engine),
            i
        }
        ,
        this.getOS = function() {
            var i = {
                name: u,
                version: u
            };
            return v.rgx.call(i, e, o.os),
            i
        }
        ,
        this.getResult = function() {
            return {
                ua: this.getUA(),
                browser: this.getBrowser(),
                engine: this.getEngine(),
                os: this.getOS(),
                device: this.getDevice(),
                cpu: this.getCPU()
            }
        }
        ,
        this.getUA = function() {
            return e
        }
        ,
        this.setUA = function(i) {
            return e = i,
            this
        }
        ,
        this) : new a(i,s).getResult()
    }
    var o, c = "function", i = "undefined", b = "object", s = "model", e = "name", n = "type", d = "vendor", t = "version", w = "architecture", l = "console", p = "mobile", m = "tablet", g = "smarttv", h = "wearable", f = {
        extend: function(i, s) {
            var e, o = {};
            for (e in i)
                s[e] && s[e].length % 2 == 0 ? o[e] = s[e].concat(i[e]) : o[e] = i[e];
            return o
        },
        has: function(i, s) {
            return "string" == typeof i && -1 !== s.toLowerCase().indexOf(i.toLowerCase())
        },
        lowerize: function(i) {
            return i.toLowerCase()
        },
        major: function(i) {
            return "string" == typeof i ? i.replace(/[^\d\.]/g, "").split(".")[0] : u
        },
        trim: function(i) {
            return i.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, "")
        }
    }, v = {
        rgx: function(i, s) {
            for (var e, o, r, a, n, d = 0; d < s.length && !a; ) {
                for (var t = s[d], w = s[d + 1], l = e = 0; l < t.length && !a; )
                    if (a = t[l++].exec(i))
                        for (o = 0; o < w.length; o++)
                            n = a[++e],
                            typeof (r = w[o]) == b && 0 < r.length ? 2 == r.length ? this[r[0]] = typeof r[1] == c ? r[1].call(this, n) : r[1] : 3 == r.length ? typeof r[1] != c || r[1].exec && r[1].test ? this[r[0]] = n ? n.replace(r[1], r[2]) : u : this[r[0]] = n ? r[1].call(this, n, r[2]) : u : 4 == r.length && (this[r[0]] = n ? r[3].call(this, n.replace(r[1], r[2])) : u) : this[r] = n || u;
                d += 2
            }
        },
        str: function(i, s) {
            for (var e in s)
                if (typeof s[e] == b && 0 < s[e].length) {
                    for (var o = 0; o < s[e].length; o++)
                        if (f.has(s[e][o], i))
                            return "?" === e ? u : e
                } else if (f.has(s[e], i))
                    return "?" === e ? u : e;
            return i
        }
    }, x = {
        browser: {
            oldsafari: {
                version: {
                    "1.0": "/8",
                    1.2: "/1",
                    1.3: "/3",
                    "2.0": "/412",
                    "2.0.2": "/416",
                    "2.0.3": "/417",
                    "2.0.4": "/419",
                    "?": "/"
                }
            }
        },
        device: {
            amazon: {
                model: {
                    "Fire Phone": ["SD", "KF"]
                }
            },
            sprint: {
                model: {
                    "Evo Shift 4G": "7373KT"
                },
                vendor: {
                    HTC: "APA",
                    Sprint: "Sprint"
                }
            }
        },
        os: {
            windows: {
                version: {
                    ME: "4.90",
                    "NT 3.11": "NT3.51",
                    "NT 4.0": "NT4.0",
                    2e3: "NT 5.0",
                    XP: ["NT 5.1", "NT 5.2"],
                    Vista: "NT 6.0",
                    7: "NT 6.1",
                    8: "NT 6.2",
                    8.1: "NT 6.3",
                    10: ["NT 6.4", "NT 10.0"],
                    RT: "ARM"
                }
            }
        }
    }, k = {
        browser: [[/(opera\smini)\/([\w\.-]+)/i, /(opera\s[mobiletab]{3,6}).+version\/([\w\.-]+)/i, /(opera).+version\/([\w\.]+)/i, /(opera)[\/\s]+([\w\.]+)/i], [e, t], [/(opios)[\/\s]+([\w\.]+)/i], [[e, "Opera Mini"], t], [/\s(opr)\/([\w\.]+)/i], [[e, "Opera"], t], [/(kindle)\/([\w\.]+)/i, /(lunascape|maxthon|netfront|jasmine|blazer)[\/\s]?([\w\.]*)/i, /(avant\s|iemobile|slim)(?:browser)?[\/\s]?([\w\.]*)/i, /(bidubrowser|baidubrowser)[\/\s]?([\w\.]+)/i, /(?:ms|\()(ie)\s([\w\.]+)/i, /(rekonq)\/([\w\.]*)/i, /(chromium|flock|rockmelt|midori|epiphany|silk|skyfire|ovibrowser|bolt|iron|vivaldi|iridium|phantomjs|bowser|quark|qupzilla|falkon)\/([\w\.-]+)/i], [e, t], [/(konqueror)\/([\w\.]+)/i], [[e, "Konqueror"], t], [/(trident).+rv[:\s]([\w\.]{1,9}).+like\sgecko/i], [[e, "IE"], t], [/(edge|edgios|edga|edg)\/((\d+)?[\w\.]+)/i], [[e, "Edge"], t], [/(yabrowser)\/([\w\.]+)/i], [[e, "Yandex"], t], [/(Avast)\/([\w\.]+)/i], [[e, "Avast Secure Browser"], t], [/(AVG)\/([\w\.]+)/i], [[e, "AVG Secure Browser"], t], [/(puffin)\/([\w\.]+)/i], [[e, "Puffin"], t], [/(focus)\/([\w\.]+)/i], [[e, "Firefox Focus"], t], [/(opt)\/([\w\.]+)/i], [[e, "Opera Touch"], t], [/((?:[\s\/])uc?\s?browser|(?:juc.+)ucweb)[\/\s]?([\w\.]+)/i], [[e, "UCBrowser"], t], [/(comodo_dragon)\/([\w\.]+)/i], [[e, /_/g, " "], t], [/(windowswechat qbcore)\/([\w\.]+)/i], [[e, "WeChat(Win) Desktop"], t], [/(micromessenger)\/([\w\.]+)/i], [[e, "WeChat"], t], [/(brave)\/([\w\.]+)/i], [[e, "Brave"], t], [/(whale)\/([\w\.]+)/i], [[e, "Whale"], t], [/(qqbrowserlite)\/([\w\.]+)/i], [e, t], [/(QQ)\/([\d\.]+)/i], [e, t], [/m?(qqbrowser)[\/\s]?([\w\.]+)/i], [e, t], [/(baiduboxapp)[\/\s]?([\w\.]+)/i], [e, t], [/(2345Explorer)[\/\s]?([\w\.]+)/i], [e, t], [/(MetaSr)[\/\s]?([\w\.]+)/i], [e], [/(LBBROWSER)/i], [e], [/xiaomi\/miuibrowser\/([\w\.]+)/i], [t, [e, "MIUI Browser"]], [/;fbav\/([\w\.]+);/i], [t, [e, "Facebook"]], [/FBAN\/FBIOS|FB_IAB\/FB4A/i], [[e, "Facebook"]], [/safari\s(line)\/([\w\.]+)/i, /android.+(line)\/([\w\.]+)\/iab/i], [e, t], [/headlesschrome(?:\/([\w\.]+)|\s)/i], [t, [e, "Chrome Headless"]], [/\swv\).+(chrome)\/([\w\.]+)/i], [[e, /(.+)/, "$1 WebView"], t], [/((?:oculus|samsung)browser)\/([\w\.]+)/i], [[e, /(.+(?:g|us))(.+)/, "$1 $2"], t], [/android.+version\/([\w\.]+)\s+(?:mobile\s?safari|safari)*/i], [t, [e, "Android Browser"]], [/(sailfishbrowser)\/([\w\.]+)/i], [[e, "Sailfish Browser"], t], [/(chrome|omniweb|arora|[tizenoka]{5}\s?browser)\/v?([\w\.]+)/i], [e, t], [/(dolfin)\/([\w\.]+)/i], [[e, "Dolphin"], t], [/(qihu|qhbrowser|qihoobrowser|360browser)/i], [[e, "360 Browser"]], [/((?:android.+)crmo|crios)\/([\w\.]+)/i], [[e, "Chrome"], t], [/(coast)\/([\w\.]+)/i], [[e, "Opera Coast"], t], [/fxios\/([\w\.-]+)/i], [t, [e, "Firefox"]], [/version\/([\w\.]+)\s.*mobile\/\w+\s(safari)/i], [t, [e, "Mobile Safari"]], [/version\/([\w\.]+)\s.*(mobile\s?safari|safari)/i], [t, e], [/webkit.+?(gsa)\/([\w\.]+)\s.*(mobile\s?safari|safari)(\/[\w\.]+)/i], [[e, "GSA"], t], [/webkit.+?(mobile\s?safari|safari)(\/[\w\.]+)/i], [e, [t, v.str, x.browser.oldsafari.version]], [/(webkit|khtml)\/([\w\.]+)/i], [e, t], [/(navigator|netscape)\/([\w\.-]+)/i], [[e, "Netscape"], t], [/(swiftfox)/i, /(icedragon|iceweasel|camino|chimera|fennec|maemo\sbrowser|minimo|conkeror)[\/\s]?([\w\.\+]+)/i, /(firefox|seamonkey|k-meleon|icecat|iceape|firebird|phoenix|palemoon|basilisk|waterfox)\/([\w\.-]+)$/i, /(firefox)\/([\w\.]+)\s[\w\s\-]+\/[\w\.]+$/i, /(mozilla)\/([\w\.]+)\s.+rv\:.+gecko\/\d+/i, /(polaris|lynx|dillo|icab|doris|amaya|w3m|netsurf|sleipnir)[\/\s]?([\w\.]+)/i, /(links)\s\(([\w\.]+)/i, /(gobrowser)\/?([\w\.]*)/i, /(ice\s?browser)\/v?([\w\._]+)/i, /(mosaic)[\/\s]([\w\.]+)/i], [e, t]],
        cpu: [[/(?:(amd|x(?:(?:86|64)[_-])?|wow|win)64)[;\)]/i], [[w, "amd64"]], [/(ia32(?=;))/i], [[w, f.lowerize]], [/((?:i[346]|x)86)[;\)]/i], [[w, "ia32"]], [/windows\s(ce|mobile);\sppc;/i], [[w, "arm"]], [/((?:ppc|powerpc)(?:64)?)(?:\smac|;|\))/i], [[w, /ower/, "", f.lowerize]], [/(sun4\w)[;\)]/i], [[w, "sparc"]], [/((?:avr32|ia64(?=;))|68k(?=\))|arm(?:64|(?=v\d+[;l]))|(?=atmel\s)avr|(?:irix|mips|sparc)(?:64)?(?=;)|pa-risc)/i], [[w, f.lowerize]]],
        device: [[/\((ipad|playbook);[\w\s\),;-]+(rim|apple)/i], [s, d, [n, m]], [/applecoremedia\/[\w\.]+ \((ipad)/], [s, [d, "Apple"], [n, m]], [/(apple\s{0,1}tv)/i], [[s, "Apple TV"], [d, "Apple"], [n, g]], [/(archos)\s(gamepad2?)/i, /(hp).+(touchpad)/i, /(hp).+(tablet)/i, /(kindle)\/([\w\.]+)/i, /\s(nook)[\w\s]+build\/(\w+)/i, /(dell)\s(strea[kpr\s\d]*[\dko])/i], [d, s, [n, m]], [/(kf[A-z]+)(\sbuild\/|\)).+silk\//i], [s, [d, "Amazon"], [n, m]], [/(sd|kf)[0349hijorstuw]+(\sbuild\/|\)).+silk\//i], [[s, v.str, x.device.amazon.model], [d, "Amazon"], [n, p]], [/android.+aft([bms])\sbuild/i], [s, [d, "Amazon"], [n, g]], [/\((ip[honed|\s\w*]+);.+(apple)/i], [s, d, [n, p]], [/\((ip[honed|\s\w*]+);/i], [s, [d, "Apple"], [n, p]], [/(blackberry)[\s-]?(\w+)/i, /(blackberry|benq|palm(?=\-)|sonyericsson|acer|asus|dell|meizu|motorola|polytron)[\s_-]?([\w-]*)/i, /(hp)\s([\w\s]+\w)/i, /(asus)-?(\w+)/i], [d, s, [n, p]], [/\(bb10;\s(\w+)/i], [s, [d, "BlackBerry"], [n, p]], [/android.+(transfo[prime\s]{4,10}\s\w+|eeepc|slider\s\w+|nexus 7|padfone|p00c)/i], [s, [d, "Asus"], [n, m]], [/(sony)\s(tablet\s[ps])\sbuild\//i, /(sony)?(?:sgp.+)\sbuild\//i], [[d, "Sony"], [s, "Xperia Tablet"], [n, m]], [/android.+\s([c-g]\d{4}|so[-l]\w+)(?=\sbuild\/|\).+chrome\/(?![1-6]{0,1}\d\.))/i], [s, [d, "Sony"], [n, p]], [/\s(ouya)\s/i, /(nintendo)\s([wids3u]+)/i], [d, s, [n, l]], [/android.+;\s(shield)\sbuild/i], [s, [d, "Nvidia"], [n, l]], [/(playstation\s[34portablevi]+)/i], [s, [d, "Sony"], [n, l]], [/(sprint\s(\w+))/i], [[d, v.str, x.device.sprint.vendor], [s, v.str, x.device.sprint.model], [n, p]], [/(htc)[;_\s-]{1,2}([\w\s]+(?=\)|\sbuild)|\w+)/i, /(zte)-(\w*)/i, /(alcatel|geeksphone|nexian|panasonic|(?=;\s)sony)[_\s-]?([\w-]*)/i], [d, [s, /_/g, " "], [n, p]], [/(nexus\s9)/i], [s, [d, "HTC"], [n, m]], [/d\/huawei([\w\s-]+)[;\)]/i, /android.+\s(nexus\s6p|vog-[at]?l\d\d|ane-[at]?l[x\d]\d|eml-a?l\d\da?|lya-[at]?l\d[\dc]|clt-a?l\d\di?)/i], [s, [d, "Huawei"], [n, p]], [/android.+(bah2?-a?[lw]\d{2})/i], [s, [d, "Huawei"], [n, m]], [/(microsoft);\s(lumia[\s\w]+)/i], [d, s, [n, p]], [/[\s\(;](xbox(?:\sone)?)[\s\);]/i], [s, [d, "Microsoft"], [n, l]], [/(kin\.[onetw]{3})/i], [[s, /\./g, " "], [d, "Microsoft"], [n, p]], [/\s(milestone|droid(?:[2-4x]|\s(?:bionic|x2|pro|razr))?:?(\s4g)?)[\w\s]+build\//i, /mot[\s-]?(\w*)/i, /(XT\d{3,4}) build\//i, /(nexus\s6)/i], [s, [d, "Motorola"], [n, p]], [/android.+\s(mz60\d|xoom[\s2]{0,2})\sbuild\//i], [s, [d, "Motorola"], [n, m]], [/hbbtv\/\d+\.\d+\.\d+\s+\([\w\s]*;\s*(\w[^;]*);([^;]*)/i], [[d, f.trim], [s, f.trim], [n, g]], [/hbbtv.+maple;(\d+)/i], [[s, /^/, "SmartTV"], [d, "Samsung"], [n, g]], [/\(dtv[\);].+(aquos)/i], [s, [d, "Sharp"], [n, g]], [/android.+((sch-i[89]0\d|shw-m380s|SM-P605|SM-P610|gt-p\d{4}|gt-n\d+|sgh-t8[56]9|nexus 10))/i, /((SM-T\w+))/i], [[d, "Samsung"], s, [n, m]], [/smart-tv.+(samsung)/i], [d, [n, g], s], [/((s[cgp]h-\w+|gt-\w+|galaxy\snexus|sm-\w[\w\d]+))/i, /(sam[sung]*)[\s-]*(\w+-?[\w-]*)/i, /sec-((sgh\w+))/i], [[d, "Samsung"], s, [n, p]], [/sie-(\w*)/i], [s, [d, "Siemens"], [n, p]], [/(maemo|nokia).*(n900|lumia\s\d+)/i, /(nokia)[\s_-]?([\w-]*)/i], [[d, "Nokia"], s, [n, p]], [/android[x\d\.\s;]+\s([ab][1-7]\-?[0178a]\d\d?)/i], [s, [d, "Acer"], [n, m]], [/android.+([vl]k\-?\d{3})\s+build/i], [s, [d, "LG"], [n, m]], [/android\s3\.[\s\w;-]{10}(lg?)-([06cv9]{3,4})/i], [[d, "LG"], s, [n, m]], [/linux;\snetcast.+smarttv/i, /lg\snetcast\.tv-201\d/i], [[d, "LG"], s, [n, g]], [/(nexus\s[45])/i, /lg[e;\s\/-]+(\w*)/i, /android.+lg(\-?[\d\w]+)\s+build/i], [s, [d, "LG"], [n, p]], [/(lenovo)\s?(s(?:5000|6000)(?:[\w-]+)|tab(?:[\s\w]+))/i], [d, s, [n, m]], [/android.+(ideatab[a-z0-9\-\s]+)/i], [s, [d, "Lenovo"], [n, m]], [/(lenovo)[_\s-]?([\w-]+)/i], [d, s, [n, p]], [/linux;.+((jolla));/i], [d, s, [n, p]], [/((pebble))app\/[\d\.]+\s/i], [d, s, [n, h]], [/android.+;\s(oppo)\s?([\w\s]+)\sbuild/i], [d, s, [n, p]], [/crkey/i], [[s, "Chromecast"], [d, "Google"], [n, g]], [/android.+;\s(glass)\s\d/i], [s, [d, "Google"], [n, h]], [/android.+;\s(pixel c)[\s)]/i], [s, [d, "Google"], [n, m]], [/android.+;\s(pixel( [2-9]a?)?( xl)?)[\s)]/i], [s, [d, "Google"], [n, p]], [/android.+;\s(\w+)\s+build\/hm\1/i, /android.+(hm[\s\-_]?note?[\s_]?(?:\d\w)?)\sbuild/i, /android.+(redmi[\s\-_]?(?:note|k)?(?:[\s_]?[\w\s]+))(?:\sbuild|\))/i, /android.+(mi[\s\-_]?(?:a\d|one|one[\s_]plus|note lte)?[\s_]?(?:\d?\w?)[\s_]?(?:plus)?)\sbuild/i], [[s, /_/g, " "], [d, "Xiaomi"], [n, p]], [/android.+(mi[\s\-_]?(?:pad)(?:[\s_]?[\w\s]+))(?:\sbuild|\))/i], [[s, /_/g, " "], [d, "Xiaomi"], [n, m]], [/android.+;\s(m[1-5]\snote)\sbuild/i], [s, [d, "Meizu"], [n, p]], [/(mz)-([\w-]{2,})/i], [[d, "Meizu"], s, [n, p]], [/android.+a000(1)\s+build/i, /android.+oneplus\s(a\d{4})[\s)]/i], [s, [d, "OnePlus"], [n, p]], [/android.+[;\/]\s*(RCT[\d\w]+)\s+build/i], [s, [d, "RCA"], [n, m]], [/android.+[;\/\s](Venue[\d\s]{2,7})\s+build/i], [s, [d, "Dell"], [n, m]], [/android.+[;\/]\s*(Q[T|M][\d\w]+)\s+build/i], [s, [d, "Verizon"], [n, m]], [/android.+[;\/]\s+(Barnes[&\s]+Noble\s+|BN[RT])(V?.*)\s+build/i], [[d, "Barnes & Noble"], s, [n, m]], [/android.+[;\/]\s+(TM\d{3}.*\b)\s+build/i], [s, [d, "NuVision"], [n, m]], [/android.+;\s(k88)\sbuild/i], [s, [d, "ZTE"], [n, m]], [/android.+[;\/]\s*(gen\d{3})\s+build.*49h/i], [s, [d, "Swiss"], [n, p]], [/android.+[;\/]\s*(zur\d{3})\s+build/i], [s, [d, "Swiss"], [n, m]], [/android.+[;\/]\s*((Zeki)?TB.*\b)\s+build/i], [s, [d, "Zeki"], [n, m]], [/(android).+[;\/]\s+([YR]\d{2})\s+build/i, /android.+[;\/]\s+(Dragon[\-\s]+Touch\s+|DT)(\w{5})\sbuild/i], [[d, "Dragon Touch"], s, [n, m]], [/android.+[;\/]\s*(NS-?\w{0,9})\sbuild/i], [s, [d, "Insignia"], [n, m]], [/android.+[;\/]\s*((NX|Next)-?\w{0,9})\s+build/i], [s, [d, "NextBook"], [n, m]], [/android.+[;\/]\s*(Xtreme\_)?(V(1[045]|2[015]|30|40|60|7[05]|90))\s+build/i], [[d, "Voice"], s, [n, p]], [/android.+[;\/]\s*(LVTEL\-)?(V1[12])\s+build/i], [[d, "LvTel"], s, [n, p]], [/android.+;\s(PH-1)\s/i], [s, [d, "Essential"], [n, p]], [/android.+[;\/]\s*(V(100MD|700NA|7011|917G).*\b)\s+build/i], [s, [d, "Envizen"], [n, m]], [/android.+[;\/]\s*(Le[\s\-]+Pan)[\s\-]+(\w{1,9})\s+build/i], [d, s, [n, m]], [/android.+[;\/]\s*(Trio[\s\w\-\.]+)\s+build/i], [s, [d, "MachSpeed"], [n, m]], [/android.+[;\/]\s*(Trinity)[\-\s]*(T\d{3})\s+build/i], [d, s, [n, m]], [/android.+[;\/]\s*TU_(1491)\s+build/i], [s, [d, "Rotor"], [n, m]], [/android.+(Gigaset)[\s\-]+(Q\w{1,9})\s+build/i], [d, s, [n, m]], [/android .+?; ([^;]+?)(?: build|\) applewebkit).+? mobile safari/i], [s, [n, p]], [/android .+?;\s([^;]+?)(?: build|\) applewebkit).+?(?! mobile) safari/i], [s, [n, m]], [/\s(tablet|tab)[;\/]/i, /\s(mobile)(?:[;\/]|\ssafari)/i], [[n, f.lowerize], d, s], [/[\s\/\(](smart-?tv)[;\)]/i], [[n, g]], [/(android[\w\.\s\-]{0,9});.+build/i], [s, [d, "Generic"]]],
        engine: [[/windows.+\sedge\/([\w\.]+)/i], [t, [e, "EdgeHTML"]], [/webkit\/537\.36.+chrome\/(?!27)([\w\.]+)/i], [t, [e, "Blink"]], [/(presto)\/([\w\.]+)/i, /(webkit|trident|netfront|netsurf|amaya|lynx|w3m|goanna)\/([\w\.]+)/i, /(khtml|tasman|links)[\/\s]\(?([\w\.]+)/i, /(icab)[\/\s]([23]\.[\d\.]+)/i], [e, t], [/rv\:([\w\.]{1,9}).+(gecko)/i], [t, e]],
        os: [[/microsoft\s(windows)\s(vista|xp)/i], [e, t], [/(windows)\snt\s6\.2;\s(arm)/i, /(windows\sphone(?:\sos)*)[\s\/]?([\d\.\s\w]*)/i, /(windows\smobile|windows)[\s\/]?([ntce\d\.\s]+\w)/i], [e, [t, v.str, x.os.windows.version]], [/(win(?=3|9|n)|win\s9x\s)([nt\d\.]+)/i], [[e, "Windows"], [t, v.str, x.os.windows.version]], [/\((bb)(10);/i], [[e, "BlackBerry"], t], [/(blackberry)\w*\/?([\w\.]*)/i, /(tizen|kaios)[\/\s]([\w\.]+)/i, /(android|webos|palm\sos|qnx|bada|rim\stablet\sos|meego|sailfish|contiki)[\/\s-]?([\w\.]*)/i], [e, t], [/(symbian\s?os|symbos|s60(?=;))[\/\s-]?([\w\.]*)/i], [[e, "Symbian"], t], [/\((series40);/i], [e], [/mozilla.+\(mobile;.+gecko.+firefox/i], [[e, "Firefox OS"], t], [/crkey\/([\d\.]+)/i], [t, [e, "Chromecast"]], [/(nintendo|playstation)\s([wids34portablevu]+)/i, /(mint)[\/\s\(]?(\w*)/i, /(mageia|vectorlinux)[;\s]/i, /(joli|[kxln]?ubuntu|debian|suse|opensuse|gentoo|(?=\s)arch|slackware|fedora|mandriva|centos|pclinuxos|redhat|zenwalk|linpus)[\/\s-]?(?!chrom)([\w\.-]*)/i, /(hurd|linux)\s?([\w\.]*)/i, /(gnu)\s?([\w\.]*)/i], [e, t], [/(cros)\s[\w]+\s([\w\.]+\w)/i], [[e, "Chromium OS"], t], [/(sunos)\s?([\w\.\d]*)/i], [[e, "Solaris"], t], [/\s([frentopc-]{0,4}bsd|dragonfly)\s?([\w\.]*)/i], [e, t], [/(haiku)\s(\w+)/i], [e, t], [/cfnetwork\/.+darwin/i, /ip[honead]{2,4}(?:.*os\s([\w]+)\slike\smac|;\sopera)/i], [[t, /_/g, "."], [e, "iOS"]], [/(mac\sos\sx)\s?([\w\s\.]*)/i, /(macintosh|mac(?=_powerpc)\s)/i], [[e, "Mac OS"], [t, /_/g, "."]], [/((?:open)?solaris)[\/\s-]?([\w\.]*)/i, /(aix)\s((\d)(?=\.|\)|\s)[\w\.])*/i, /(plan\s9|minix|beos|os\/2|amigaos|morphos|risc\sos|openvms|fuchsia)/i, /(unix)\s?([\w\.]*)/i], [e, t]]
    }, y = (a.VERSION = "0.7.23",
    a.BROWSER = {
        NAME: e,
        MAJOR: "major",
        VERSION: t
    },
    a.CPU = {
        ARCHITECTURE: w
    },
    a.DEVICE = {
        MODEL: s,
        VENDOR: d,
        TYPE: n,
        CONSOLE: l,
        MOBILE: p,
        SMARTTV: g,
        TABLET: m,
        WEARABLE: h,
        EMBEDDED: "embedded"
    },
    a.ENGINE = {
        NAME: e,
        VERSION: t
    },
    a.OS = {
        NAME: e,
        VERSION: t
    },
    typeof exports != i ? (exports = typeof module != i && module.exports ? module.exports = a : exports).UAParser = a : "function" == typeof define && define.amd ? define(function() {
        return a
    }) : r && (r.UAParser = a),
    r && (r.jQuery || r.Zepto));
    y && !y.ua && (o = new a,
    y.ua = o.getResult(),
    y.ua.get = function() {
        return o.getUA()
    }
    ,
    y.ua.set = function(i) {
        o.setUA(i);
        var s, e = o.getResult();
        for (s in e)
            y.ua[s] = e[s]
    }
    )
}("object" == typeof window ? window : this);
var ua_parser = (new UAParser).getResult();
function send_stats_data(i) {
   
}
!function(i) {
    var s = {
        browser: ua_parser.browser.name + "-" + ua_parser.browser.version,
        os: ua_parser.os.name + "-" + ua_parser.os.version
    }
      , i = (ua_parser.device.vendor && (s.device_vendor = ua_parser.device.vendor),
    i.navigator.language && (s.language = i.navigator.language),
    "");
    screen.width && (width = screen.width || "",
    height = screen.height || "",
    i += width + "x" + height),
    s.refferer = Document.referrer || "direct",
    s.screen_size = i,
    s && send_stats_data(s)
}(this);
