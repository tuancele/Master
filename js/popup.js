function createCookie(e, t, o) {
    var n;
    if (o) {
        var i = new Date;
        i.setTime(i.getTime() + 24 * o * 60 * 60 * 1e3), n = "; expires=" + i.toGMTString()
    } else n = "";
    document.cookie = encodeURIComponent(e) + "=" + encodeURIComponent(t) + n + "; path=/"
}

function readCookie(e) {
    for (var t = encodeURIComponent(e) + "=", o = document.cookie.split(";"), n = 0; n < o.length; n++) {
        for (var i = o[n];
            " " === i.charAt(0);) i = i.substring(1, i.length);
        if (0 === i.indexOf(t)) return decodeURIComponent(i.substring(t.length, i.length))
    }
    return null
}

function eraseCookie(e) {
    createCookie(e, "", -1)
}
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) var isMobile = !0;
else var isMobile = !1;
console.log(isMobile);
var botPattern = "(googlebot/|Googlebot-Mobile|Googlebot-Image|Google favicon|Mediapartners-Google|bingbot|slurp|java|wget|curl|Commons-HttpClient|Python-urllib|libwww|httpunit|nutch|phpcrawl|msnbot|jyxobot|FAST-WebCrawler|FAST Enterprise Crawler|biglotron|teoma|convera|seekbot|gigablast|exabot|ngbot|ia_archiver|GingerCrawler|webmon |httrack|webcrawler|grub.org|UsineNouvelleCrawler|antibot|netresearchserver|speedy|fluffy|bibnum.bnf|findlink|msrbot|panscient|yacybot|AISearchBot|IOI|ips-agent|tagoobot|MJ12bot|dotbot|woriobot|yanga|buzzbot|mlbot|yandexbot|purebot|Linguee Bot|Voyager|CyberPatrol|voilabot|baiduspider|citeseerxbot|spbot|twengabot|postrank|turnitinbot|scribdbot|page2rss|sitebot|linkdex|Adidxbot|blekkobot|ezooms|dotbot|Mail.RU_Bot|discobot|heritrix|findthatfile|europarchive.org|NerdByNature.Bot|sistrix crawler|ahrefsbot|Aboundex|domaincrawler|wbsearchbot|summify|ccbot|edisterbot|seznambot|ec2linkfinder|gslfbot|aihitbot|intelium_bot|facebookexternalhit|yeti|RetrevoPageAnalyzer|lb-spider|sogou|lssbot|careerbot|wotbox|wocbot|ichiro|DuckDuckBot|lssrocketcrawler|drupact|webcompanycrawler|acoonbot|openindexspider|gnam gnam spider|web-archive-net.com.bot|backlinkcrawler|coccoc|integromedb|content crawler spider|toplistbot|seokicks-robot|it2media-domain-crawler|ip-web-crawler.com|siteexplorer.info|elisabot|proximic|changedetection|blexbot|arabot|WeSEE:Search|niki-bot|CrystalSemanticsBot|rogerbot|360Spider|psbot|InterfaxScanBot|Lipperhey SEO Service|CC Metadata Scaper|g00g1e.net|GrapeshotCrawler|urlappendbot|brainobot|fr-crawler|binlar|SimpleCrawler|Livelapbot|Twitterbot|cXensebot|smtbot|bnf.fr_bot|A6-Indexer|ADmantX|Facebot|Twitterbot|OrangeBot|memorybot|AdvBot|MegaIndex|SemanticScholarBot|ltx71|nerdybot|xovibot|BUbiNG|Qwantify|archive.org_bot|Applebot|TweetmemeBot|crawler4j|findxbot|SemrushBot|yoozBot|lipperhey|y!j-asr|Domain Re-Animator Bot|AddThis)",
    re = new RegExp(botPattern, "i"),
    userAgent = navigator.userAgent;
if (re.test(userAgent)) var isBot = !0;
else var isBot = !1;
if (!isBot) {
    if ("undefined" != typeof lang_geo && !readCookie("lang_dont_redirect") && lang_geo != lang) {
        "br" == lang_geo && (lang_geo = "pt-br");
        var redirect = document.querySelectorAll('[hreflang="' + lang_geo + '"]')[0];
        void 0 === redirect && "en" != lang && (redirect = document.querySelectorAll('[hreflang="en"]')[0]), void 0 !== redirect && (redirect_url = redirect.getAttribute("href"), window.location.replace(redirect_url))
    }
    for (var lang_list = document.querySelectorAll(".site-logo .sub-menu a"), i = 0; i < lang_list.length; i++) lang_list[i].addEventListener("click", function(e) {
        createCookie("lang_dont_redirect", "1", "365")
    })
}! function(e) {
    e.fn.niceSelect = function(t) {
        function o(t) {
            t.after(e("<div></div>").addClass("nice-select").addClass(t.attr("class") || "").addClass(t.attr("disabled") ? "disabled" : "").attr("tabindex", t.attr("disabled") ? null : "0").html('<span class="current"></span><ul class="list"></ul>'));
            var o = t.next(),
                n = t.find("option"),
                i = t.find("option:selected");
            o.find(".current").html(i.data("display") || i.text()), n.each(function(t) {
                var n = e(this),
                    i = n.data("display");
                o.find("ul").append(e("<li></li>").attr("data-value", n.val()).attr("data-display", i || null).addClass("option" + (n.is(":selected") ? " selected" : "") + (n.is(":disabled") ? " disabled" : "")).html(n.text()))
            })
        }
        if ("string" == typeof t) return "update" == t ? this.each(function() {
            var t = e(this),
                n = e(this).next(".nice-select"),
                i = n.hasClass("open");
            n.length && (n.remove(), o(t), i && t.next().trigger("click"))
        }) : "destroy" == t ? (this.each(function() {
            var t = e(this),
                o = e(this).next(".nice-select");
            o.length && (o.remove(), t.css("display", ""))
        }), 0 == e(".nice-select").length && e(document).off(".nice_select")) : console.log('Method "' + t + '" does not exist.'), this;
        this.hide(), this.each(function() {
            var t = e(this);
            t.next().hasClass("nice-select") || o(t)
        }), e(document).off(".nice_select"), e(document).on("click.nice_select", ".nice-select", function(t) {
            var o = e(this);
            e(".nice-select").not(o).removeClass("open"), o.toggleClass("open"), o.hasClass("open") ? (o.find(".option"), o.find(".focus").removeClass("focus"), o.find(".selected").addClass("focus")) : o.focus()
        }), e(document).on("click.nice_select", function(t) {
            0 === e(t.target).closest(".nice-select").length && e(".nice-select").removeClass("open").find(".option")
        }), e(document).on("click.nice_select", ".nice-select .option:not(.disabled)", function(t) {
            var o = e(this),
                n = o.closest(".nice-select");
            n.find(".selected").removeClass("selected"), o.addClass("selected");
            var i = o.data("display") || o.text();
            n.find(".current").text(i), n.prev("select").val(o.data("value")).trigger("change")
        }), e(document).on("keydown.nice_select", ".nice-select", function(t) {
            var o = e(this),
                n = e(o.find(".focus") || o.find(".list .option.selected"));
            if (32 == t.keyCode || 13 == t.keyCode) return o.hasClass("open") ? n.trigger("click") : o.trigger("click"), !1;
            if (40 == t.keyCode) {
                if (o.hasClass("open")) {
                    var i = n.nextAll(".option:not(.disabled)").first();
                    i.length > 0 && (o.find(".focus").removeClass("focus"), i.addClass("focus"))
                } else o.trigger("click");
                return !1
            }
            if (38 == t.keyCode) {
                if (o.hasClass("open")) {
                    var s = n.prevAll(".option:not(.disabled)").first();
                    s.length > 0 && (o.find(".focus").removeClass("focus"), s.addClass("focus"))
                } else o.trigger("click");
                return !1
            }
            if (27 == t.keyCode) o.hasClass("open") && o.trigger("click");
            else if (9 == t.keyCode && o.hasClass("open")) return !1
        });
        var n = document.createElement("a").style;
        return n.cssText = "pointer-events:auto", "auto" !== n.pointerEvents && e("html").addClass("no-csspointerevents"), this
    }
}(jQuery),
function(e, t, o, n) {
    "use strict";

    function i(e) {
        var o = e.charAt(0).toUpperCase() + e.slice(1),
            i = t.createElement("test"),
            s = [e, "Webkit" + o];
        for (var r in s)
            if (i.style[s[r]] !== n) return s[r];
        return ""
    }

    function s(e, t, o) {
        var n = e.className.split(/\s+/),
            i = n.indexOf(t);
        o ? ~i || n.push(t) : ~i && n.splice(i, 1), e.className = n.join(" ")
    }

    function r(e, t, o) {
        for (var i in t) !t.hasOwnProperty(i) || e[i] !== n && o || (e[i] = t[i]);
        return e
    }

    function a(e, t, o) {
        var n, i;
        if (e.length)
            for (n = 0, i = e.length; n < i; n++) e[n][t].apply(e[n], o);
        else
            for (n in e) e[n][t].apply(e[n], o)
    }

    function l(e, t) {
        var o, n;
        return function() {
            var i = this,
                s = Date.now(),
                r = arguments;
            o && s < o + t ? (clearTimeout(n), n = setTimeout(function() {
                o = s, e.apply(i, r)
            }, t)) : (o = s, e.apply(i, r))
        }
    }
    var c = function e(t, o) {
            return new e.Instance(t, o || {})
        },
        p = c.globalSettings = {
            scrollMinUpdateInterval: 25,
            checkFrequency: 1e3,
            pauseCheck: !1
        };
    c.defaults = {
        preventParentScroll: !1,
        forceScrollbars: !1,
        scrollStopDelay: 300,
        maxTrackSize: 95,
        minTrackSize: 5,
        draggableTracks: !0,
        autoUpdate: !0,
        classPrefix: "optiscroll-",
        wrapContent: !0,
        rtl: !1
    }, (c.Instance = function(t, o) {
        this.element = t, this.settings = r(r({}, c.defaults), o || {}), "boolean" != typeof o.rtl && (this.settings.rtl = "rtl" === e.getComputedStyle(t).direction), this.cache = {}, this.init()
    }).prototype = {
        init: function() {
            var e = this.element,
                t = this.settings,
                o = !1,
                n = this.scrollEl = t.wrapContent ? f.createWrapper(e) : e.firstElementChild;
            s(n, t.classPrefix + "content", !0), s(e, "is-enabled" + (t.rtl ? " is-rtl" : ""), !0), this.scrollbars = {
                v: u("v", this),
                h: u("h", this)
            }, (m.scrollbarSpec.width || t.forceScrollbars) && (o = f.hideNativeScrollbars(n, t.rtl)), o && a(this.scrollbars, "create"), m.isTouch && t.preventParentScroll && s(e, t.classPrefix + "prevent", !0), this.update(), this.bind(), t.autoUpdate && m.instances.push(this), t.autoUpdate && !m.checkTimer && f.checkLoop()
        },
        bind: function() {
            var e = this.listeners = {},
                t = this.scrollEl;
            e.scroll = l(d.scroll.bind(this), p.scrollMinUpdateInterval), m.isTouch && (e.touchstart = d.touchstart.bind(this), e.touchend = d.touchend.bind(this)), e.mousewheel = e.wheel = d.wheel.bind(this);
            for (var o in e) t.addEventListener(o, e[o], m.passiveEvent)
        },
        update: function() {
            var e = this.scrollEl,
                o = this.cache,
                i = o.clientH,
                s = e.scrollHeight,
                r = e.clientHeight,
                l = e.scrollWidth,
                c = e.clientWidth;
            if (s !== o.scrollH || r !== o.clientH || l !== o.scrollW || c !== o.clientW) {
                if (o.scrollH = s, o.clientH = r, o.scrollW = l, o.clientW = c, i !== n) {
                    if (0 === s && 0 === r && !t.body.contains(this.element)) return this.destroy(), !1;
                    this.fireCustomEvent("sizechange")
                }
                a(this.scrollbars, "update")
            }
        },
        scrollTo: function(e, t, o) {
            var n, i, s, r, a = this.cache;
            m.pauseCheck = !0, this.update(), n = this.scrollEl.scrollLeft, i = this.scrollEl.scrollTop, s = +e, "left" === e && (s = 0), "right" === e && (s = a.scrollW - a.clientW), !1 === e && (s = n), r = +t, "top" === t && (r = 0), "bottom" === t && (r = a.scrollH - a.clientH), !1 === t && (r = i), this.animateScroll(n, s, i, r, +o)
        },
        scrollIntoView: function(e, t, o) {
            var n, i, s, r, a, l, c, p, d, u, f, h, g = this.scrollEl;
            m.pauseCheck = !0, this.update(), "string" == typeof e ? e = g.querySelector(e) : e.length && e.jquery && (e = e[0]), "number" == typeof o && (o = {
                top: o,
                right: o,
                bottom: o,
                left: o
            }), o = o || {}, n = e.getBoundingClientRect(), i = g.getBoundingClientRect(), d = f = g.scrollLeft, u = h = g.scrollTop, c = d + n.left - i.left, p = u + n.top - i.top, s = c - (o.left || 0), r = p - (o.top || 0), a = c + n.width - this.cache.clientW + (o.right || 0), l = p + n.height - this.cache.clientH + (o.bottom || 0), s < d && (f = s), a > d && (f = a), r < u && (h = r), l > u && (h = l), this.animateScroll(d, f, u, h, +t)
        },
        animateScroll: function(t, n, i, s, r) {
            var a = this,
                l = this.scrollEl,
                c = Date.now();
            if (n !== t || s !== i) {
                if (0 === r) return l.scrollLeft = n, void(l.scrollTop = s);
                isNaN(r) && (r = 15 * o.pow(o.max(o.abs(n - t), o.abs(s - i)), .54)),
                    function p() {
                        var d = o.min(1, (Date.now() - c) / r),
                            u = f.easingFunction(d);
                        s !== i && (l.scrollTop = ~~(u * (s - i)) + i), n !== t && (l.scrollLeft = ~~(u * (n - t)) + t), a.scrollAnimation = d < 1 ? e.requestAnimationFrame(p) : null
                    }()
            }
        },
        destroy: function() {
            var t, o = this,
                n = this.element,
                i = this.scrollEl,
                r = this.listeners;
            if (this.scrollEl) {
                for (var l in r) i.removeEventListener(l, r[l]);
                if (a(this.scrollbars, "remove"), !this.settings.contentElement) {
                    for (; t = i.childNodes[0];) n.insertBefore(t, i);
                    n.removeChild(i), this.scrollEl = null
                }
                s(n, this.settings.classPrefix + "prevent", !1), s(n, "is-enabled", !1), e.requestAnimationFrame(function() {
                    var e = m.instances.indexOf(o);
                    e > -1 && m.instances.splice(e, 1)
                })
            }
        },
        fireCustomEvent: function(e) {
            var o, n = this.cache,
                i = n.scrollH,
                s = n.scrollW;
            o = {
                scrollbarV: r({}, n.v),
                scrollbarH: r({}, n.h),
                scrollTop: n.v.position * i,
                scrollLeft: n.h.position * s,
                scrollBottom: (1 - n.v.position - n.v.size) * i,
                scrollRight: (1 - n.h.position - n.h.size) * s,
                scrollWidth: s,
                scrollHeight: i,
                clientWidth: n.clientW,
                clientHeight: n.clientH
            };
            var a;
            "function" == typeof CustomEvent ? a = new CustomEvent(e, {
                detail: o
            }) : (a = t.createEvent("CustomEvent")).initCustomEvent(e, !1, !1, o), this.element.dispatchEvent(a)
        }
    };
    var d = {
            scroll: function(e) {
                m.pauseCheck || this.fireCustomEvent("scrollstart"), m.pauseCheck = !0, this.scrollbars.v.update(), this.scrollbars.h.update(), this.fireCustomEvent("scroll"), clearTimeout(this.cache.timerStop), this.cache.timerStop = setTimeout(d.scrollStop.bind(this), this.settings.scrollStopDelay)
            },
            touchstart: function(e) {
                m.pauseCheck = !1, this.scrollbars.v.update(), this.scrollbars.h.update(), d.wheel.call(this, e)
            },
            touchend: function(e) {
                clearTimeout(this.cache.timerStop)
            },
            scrollStop: function() {
                this.fireCustomEvent("scrollstop"), m.pauseCheck = !1
            },
            wheel: function(t) {
                var o = this.cache,
                    n = o.v,
                    i = o.h,
                    s = this.settings.preventParentScroll && m.isTouch;
                e.cancelAnimationFrame(this.scrollAnimation), s && n.enabled && n.percent % 100 == 0 && (this.scrollEl.scrollTop = n.percent ? o.scrollH - o.clientH - 1 : 1), s && i.enabled && i.percent % 100 == 0 && (this.scrollEl.scrollLeft = i.percent ? o.scrollW - o.clientW - 1 : 1)
            }
        },
        u = function(n, i) {
            var a = "v" === n,
                l = i.element,
                c = i.scrollEl,
                p = i.settings,
                d = i.cache,
                u = d[n] = {},
                f = a ? "H" : "W",
                h = "client" + f,
                g = "scroll" + f,
                v = a ? "scrollTop" : "scrollLeft",
                b = a ? ["top", "bottom"] : ["left", "right"],
                y = /^(mouse|touch|pointer)/,
                C = m.scrollbarSpec.rtl,
                w = !1,
                k = null,
                x = null,
                _ = {
                    dragData: null,
                    dragStart: function(e) {
                        e.preventDefault();
                        var t = e.touches ? e.touches[0] : e;
                        _.dragData = {
                            x: t.pageX,
                            y: t.pageY,
                            scroll: c[v]
                        }, _.bind(!0, e.type.match(y)[1])
                    },
                    dragMove: function(e) {
                        var t, o = e.touches ? e.touches[0] : e,
                            n = p.rtl && 1 === C && !a ? -1 : 1;
                        e.preventDefault(), t = (a ? o.pageY - _.dragData.y : o.pageX - _.dragData.x) / d[h], c[v] = _.dragData.scroll + t * d[g] * n
                    },
                    dragEnd: function(e) {
                        _.dragData = null, _.bind(!1, e.type.match(y)[1])
                    },
                    bind: function(e, o) {
                        var n = (e ? "add" : "remove") + "EventListener",
                            i = o + "move",
                            s = o + ("touch" === o ? "end" : "up");
                        t[n](i, _.dragMove), t[n](s, _.dragEnd), t[n](o + "cancel", _.dragEnd)
                    }
                };
            return {
                toggle: function(e) {
                    w = e, x && s(l, "has-" + n + "track", w), u.enabled = w
                },
                create: function() {
                    k = t.createElement("div"), x = t.createElement("b"), k.className = p.classPrefix + n, x.className = p.classPrefix + n + "track", k.appendChild(x), l.appendChild(k), p.draggableTracks && (e.PointerEvent ? ["pointerdown"] : ["touchstart", "mousedown"]).forEach(function(e) {
                        x.addEventListener(e, _.dragStart)
                    })
                },
                update: function() {
                    var e, t, n, i, s;
                    (w || d[h] !== d[g]) && (n = this.calc(), e = n.size, t = u.size, i = 1 / e * n.position * 100, s = o.abs(n.position - (u.position || 0)) * d[h], 1 === e && w && this.toggle(!1), e < 1 && !w && this.toggle(!0), x && w && this.style(i, s, e, t), u = r(u, n), w && this.fireEdgeEv())
                },
                style: function(e, t, o, n) {
                    o !== n && (x.style[a ? "height" : "width"] = 100 * o + "%", p.rtl && !a && (x.style.marginRight = 100 * (1 - o) + "%")), x.style[m.cssTransform] = "translate(" + (a ? "0%," + e + "%" : e + "%,0%") + ")"
                },
                calc: function() {
                    var e, t, n = c[v],
                        i = d[h],
                        s = d[g],
                        r = i / s,
                        l = s - i;
                    return r >= 1 || !s ? {
                        position: 0,
                        size: 1,
                        percent: 0
                    } : (!a && p.rtl && C && (n = l - n * C), t = 100 * n / l, n <= 1 && (t = 0), n >= l - 1 && (t = 100), r = o.max(r, p.minTrackSize / 100), r = o.min(r, p.maxTrackSize / 100), e = t / 100 * (1 - r), {
                        position: e,
                        size: r,
                        percent: t
                    })
                },
                fireEdgeEv: function() {
                    var e = u.percent;
                    u.was !== e && e % 100 == 0 && (i.fireCustomEvent("scrollreachedge"), i.fireCustomEvent("scrollreach" + b[e / 100])), u.was = e
                },
                remove: function() {
                    this.toggle(!1), k && (k.parentNode.removeChild(k), k = null)
                }
            }
        },
        f = {
            hideNativeScrollbars: function(e, t) {
                var o = m.scrollbarSpec.width,
                    n = e.style;
                if (0 === o) {
                    var i = Date.now();
                    return e.setAttribute("data-scroll", i), f.addCssRule('[data-scroll="' + i + '"]::-webkit-scrollbar', "display:none;width:0;height:0;")
                }
                return n[t ? "left" : "right"] = -o + "px", n.bottom = -o + "px", !0
            },
            addCssRule: function(e, o) {
                var n = t.getElementById("scroll-sheet");
                n || (n = t.createElement("style"), n.id = "scroll-sheet", n.appendChild(t.createTextNode("")), t.head.appendChild(n));
                try {
                    return n.sheet.insertRule(e + " {" + o + "}", 0), !0
                } catch (e) {
                    return
                }
            },
            createWrapper: function(e, o) {
                for (var n, i = t.createElement("div"); n = e.childNodes[0];) i.appendChild(n);
                return e.appendChild(i)
            },
            checkLoop: function() {
                m.instances.length ? (m.pauseCheck || a(m.instances, "update"), p.checkFrequency && (m.checkTimer = setTimeout(function() {
                    f.checkLoop()
                }, p.checkFrequency))) : m.checkTimer = null
            },
            easingFunction: function(e) {
                return --e * e * e + 1
            }
        },
        m = c.G = {
            isTouch: "ontouchstart" in e,
            cssTransition: i("transition"),
            cssTransform: i("transform"),
            scrollbarSpec: function() {
                var e, o, n = t.documentElement,
                    i = 0,
                    s = 1;
                return e = t.createElement("div"), e.style.cssText = "overflow:scroll;width:50px;height:50px;position:absolute;left:-100px;direction:rtl", o = t.createElement("div"), o.style.cssText = "width:100px;height:100px", e.appendChild(o), n.appendChild(e), i = e.offsetWidth - e.clientWidth, e.scrollLeft > 0 ? s = 0 : (e.scrollLeft = 1, 0 === e.scrollLeft && (s = -1)), n.removeChild(e), {
                    width: i,
                    rtl: s
                }
            }(),
            passiveEvent: function() {
                var t = !1,
                    o = Object.defineProperty({}, "passive", {
                        get: function() {
                            t = !0
                        }
                    });
                return e.addEventListener("test", null, o), !!t && {
                    capture: !1,
                    passive: !0
                }
            }(),
            instances: [],
            checkTimer: null,
            pauseCheck: !1
        };
    "function" == typeof define && define.amd && define(function() {
        return c
    }), "undefined" != typeof module && module.exports && (module.exports = c), e.Optiscroll = c
}(window, document, Math),
function(e) {
    var t = "optiscroll";
    e.fn[t] = function(o) {
        var n, i;
        return "string" == typeof o && (i = Array.prototype.slice.call(arguments), n = i.shift()), this.each(function() {
            var s = e(this),
                r = s.data(t);
            r ? r && "string" == typeof n && (r[n].apply(r, i), "destroy" === n && s.removeData(t)) : (r = new window.Optiscroll(this, o || {}), s.data(t, r))
        })
    }
}(jQuery || Zepto),
function(e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : e("object" == typeof exports ? require("jquery") : window.jQuery || window.Zepto)
}(function(e) {
    var t, o, n, i, s, r, a = function() {},
        l = !!window.jQuery,
        c = e(window),
        p = function(e, o) {
            t.ev.on("mfp" + e + ".mfp", o)
        },
        d = function(t, o, n, i) {
            var s = document.createElement("div");
            return s.className = "mfp-" + t, n && (s.innerHTML = n), i ? o && o.appendChild(s) : (s = e(s), o && s.appendTo(o)), s
        },
        u = function(o, n) {
            t.ev.triggerHandler("mfp" + o, n), t.st.callbacks && (o = o.charAt(0).toLowerCase() + o.slice(1), t.st.callbacks[o] && t.st.callbacks[o].apply(t, e.isArray(n) ? n : [n]))
        },
        f = function(o) {
            return o === r && t.currTemplate.closeBtn || (t.currTemplate.closeBtn = e(t.st.closeMarkup.replace("%title%", t.st.tClose)), r = o), t.currTemplate.closeBtn
        },
        m = function() {
            e.magnificPopup.instance || ((t = new a).init(), e.magnificPopup.instance = t)
        },
        h = function() {
            var e = document.createElement("p").style,
                t = ["ms", "O", "Moz", "Webkit"];
            if (void 0 !== e.transition) return !0;
            for (; t.length;)
                if (t.pop() + "Transition" in e) return !0;
            return !1
        };
    a.prototype = {
        constructor: a,
        init: function() {
            var o = navigator.appVersion;
            t.isLowIE = t.isIE8 = document.all && !document.addEventListener, t.isAndroid = /android/gi.test(o), t.isIOS = /iphone|ipad|ipod/gi.test(o), t.supportsTransition = h(), t.probablyMobile = t.isAndroid || t.isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent), n = e(document), t.popupsCache = {}
        },
        open: function(o) {
            var i;
            if (!1 === o.isObj) {
                t.items = o.items.toArray(), t.index = 0;
                var r, a = o.items;
                for (i = 0; i < a.length; i++)
                    if ((r = a[i]).parsed && (r = r.el[0]), r === o.el[0]) {
                        t.index = i;
                        break
                    }
            } else t.items = e.isArray(o.items) ? o.items : [o.items], t.index = o.index || 0; {
                if (!t.isOpen) {
                    t.types = [], s = "", o.mainEl && o.mainEl.length ? t.ev = o.mainEl.eq(0) : t.ev = n, o.key ? (t.popupsCache[o.key] || (t.popupsCache[o.key] = {}), t.currTemplate = t.popupsCache[o.key]) : t.currTemplate = {}, t.st = e.extend(!0, {}, e.magnificPopup.defaults, o), t.fixedContentPos = "auto" === t.st.fixedContentPos ? !t.probablyMobile : t.st.fixedContentPos, t.st.modal && (t.st.closeOnContentClick = !1, t.st.closeOnBgClick = !1, t.st.showCloseBtn = !1, t.st.enableEscapeKey = !1), t.bgOverlay || (t.bgOverlay = d("bg").on("click.mfp", function() {
                        t.close()
                    }), t.wrap = d("wrap").attr("tabindex", -1).on("click.mfp", function(e) {
                        t._checkIfClose(e.target) && t.close()
                    }), t.container = d("container", t.wrap)), t.contentContainer = d("content"), t.st.preloader && (t.preloader = d("preloader", t.container, t.st.tLoading));
                    var l = e.magnificPopup.modules;
                    for (i = 0; i < l.length; i++) {
                        var m = l[i];
                        m = m.charAt(0).toUpperCase() + m.slice(1), t["init" + m].call(t)
                    }
                    u("BeforeOpen"), t.st.showCloseBtn && (t.st.closeBtnInside ? (p("MarkupParse", function(e, t, o, n) {
                        o.close_replaceWith = f(n.type)
                    }), s += " mfp-close-btn-in") : t.wrap.append(f())), t.st.alignTop && (s += " mfp-align-top"), t.fixedContentPos ? t.wrap.css({
                        overflow: t.st.overflowY,
                        overflowX: "hidden",
                        overflowY: t.st.overflowY
                    }) : t.wrap.css({
                        top: c.scrollTop(),
                        position: "absolute"
                    }), (!1 === t.st.fixedBgPos || "auto" === t.st.fixedBgPos && !t.fixedContentPos) && t.bgOverlay.css({
                        height: n.height(),
                        position: "absolute"
                    }), t.st.enableEscapeKey && n.on("keyup.mfp", function(e) {
                        27 === e.keyCode && t.close()
                    }), c.on("resize.mfp", function() {
                        t.updateSize()
                    }), t.st.closeOnContentClick || (s += " mfp-auto-cursor"), s && t.wrap.addClass(s);
                    var h = t.wH = c.height(),
                        g = {};
                    if (t.fixedContentPos && t._hasScrollBar(h)) {
                        var v = t._getScrollbarSize();
                        v && (g.marginRight = v)
                    }
                    t.fixedContentPos && (t.isIE7 ? e("body, html").css("overflow", "hidden") : g.overflow = "hidden");
                    var b = t.st.mainClass;
                    return t.isIE7 && (b += " mfp-ie7"), b && t._addClassToMFP(b), t.updateItemHTML(), u("BuildControls"), e("html").css(g), t.bgOverlay.add(t.wrap).prependTo(t.st.prependTo || e(document.body)), t._lastFocusedEl = document.activeElement, setTimeout(function() {
                        t.content ? (t._addClassToMFP("mfp-ready"), t._setFocus()) : t.bgOverlay.addClass("mfp-ready"), n.on("focusin.mfp", t._onFocusIn)
                    }, 16), t.isOpen = !0, t.updateSize(h), u("Open"), o
                }
                t.updateItemHTML()
            }
        },
        close: function() {
            t.isOpen && (u("BeforeClose"), t.isOpen = !1, t.st.removalDelay && !t.isLowIE && t.supportsTransition ? (t._addClassToMFP("mfp-removing"), setTimeout(function() {
                t._close()
            }, t.st.removalDelay)) : t._close())
        },
        _close: function() {
            u("Close");
            var o = "mfp-removing mfp-ready ";
            if (t.bgOverlay.detach(), t.wrap.detach(), t.container.empty(), t.st.mainClass && (o += t.st.mainClass + " "), t._removeClassFromMFP(o), t.fixedContentPos) {
                var i = {
                    marginRight: ""
                };
                t.isIE7 ? e("body, html").css("overflow", "") : i.overflow = "", e("html").css(i)
            }
            n.off("keyup.mfp focusin.mfp"), t.ev.off(".mfp"), t.wrap.attr("class", "mfp-wrap").removeAttr("style"), t.bgOverlay.attr("class", "mfp-bg"), t.container.attr("class", "mfp-container"), !t.st.showCloseBtn || t.st.closeBtnInside && !0 !== t.currTemplate[t.currItem.type] || t.currTemplate.closeBtn && t.currTemplate.closeBtn.detach(), t.st.autoFocusLast && t._lastFocusedEl && e(t._lastFocusedEl).focus(), t.currItem = null, t.content = null, t.currTemplate = null, t.prevHeight = 0, u("AfterClose")
        },
        updateSize: function(e) {
            if (t.isIOS) {
                var o = document.documentElement.clientWidth / window.innerWidth,
                    n = window.innerHeight * o;
                t.wrap.css("height", n), t.wH = n
            } else t.wH = e || c.height();
            t.fixedContentPos || t.wrap.css("height", t.wH), u("Resize")
        },
        updateItemHTML: function() {
            var o = t.items[t.index];
            t.contentContainer.detach(), t.content && t.content.detach(), o.parsed || (o = t.parseEl(t.index));
            var n = o.type;
            if (u("BeforeChange", [t.currItem ? t.currItem.type : "", n]), t.currItem = o, !t.currTemplate[n]) {
                var s = !!t.st[n] && t.st[n].markup;
                u("FirstMarkupParse", s), t.currTemplate[n] = !s || e(s)
            }
            i && i !== o.type && t.container.removeClass("mfp-" + i + "-holder");
            var r = t["get" + n.charAt(0).toUpperCase() + n.slice(1)](o, t.currTemplate[n]);
            t.appendContent(r, n), o.preloaded = !0, u("Change", o), i = o.type, t.container.prepend(t.contentContainer), u("AfterChange")
        },
        appendContent: function(e, o) {
            t.content = e, e ? t.st.showCloseBtn && t.st.closeBtnInside && !0 === t.currTemplate[o] ? t.content.find(".mfp-close").length || t.content.append(f()) : t.content = e : t.content = "", u("BeforeAppend"), t.container.addClass("mfp-" + o + "-holder"), t.contentContainer.append(t.content)
        },
        parseEl: function(o) {
            var n, i = t.items[o];
            if (i.tagName ? i = {
                    el: e(i)
                } : (n = i.type, i = {
                    data: i,
                    src: i.src
                }), i.el) {
                for (var s = t.types, r = 0; r < s.length; r++)
                    if (i.el.hasClass("mfp-" + s[r])) {
                        n = s[r];
                        break
                    }
                i.src = i.el.attr("data-mfp-src"), i.src || (i.src = i.el.attr("href"))
            }
            return i.type = n || t.st.type || "inline", i.index = o, i.parsed = !0, t.items[o] = i, u("ElementParse", i), t.items[o]
        },
        addGroup: function(e, o) {
            var n = function(n) {
                n.mfpEl = this, t._openClick(n, e, o)
            };
            o || (o = {});
            var i = "click.magnificPopup";
            o.mainEl = e, o.items ? (o.isObj = !0, e.off(i).on(i, n)) : (o.isObj = !1, o.delegate ? e.off(i).on(i, o.delegate, n) : (o.items = e, e.off(i).on(i, n)))
        },
        _openClick: function(o, n, i) {
            if ((void 0 !== i.midClick ? i.midClick : e.magnificPopup.defaults.midClick) || !(2 === o.which || o.ctrlKey || o.metaKey || o.altKey || o.shiftKey)) {
                var s = void 0 !== i.disableOn ? i.disableOn : e.magnificPopup.defaults.disableOn;
                if (s)
                    if (e.isFunction(s)) {
                        if (!s.call(t)) return !0
                    } else if (c.width() < s) return !0;
                o.type && (o.preventDefault(), t.isOpen && o.stopPropagation()), i.el = e(o.mfpEl), i.delegate && (i.items = n.find(i.delegate)), t.open(i)
            }
        },
        updateStatus: function(e, n) {
            if (t.preloader) {
                o !== e && t.container.removeClass("mfp-s-" + o), n || "loading" !== e || (n = t.st.tLoading);
                var i = {
                    status: e,
                    text: n
                };
                u("UpdateStatus", i), e = i.status, n = i.text, t.preloader.html(n), t.preloader.find("a").on("click", function(e) {
                    e.stopImmediatePropagation()
                }), t.container.addClass("mfp-s-" + e), o = e
            }
        },
        _checkIfClose: function(o) {
            if (!e(o).hasClass("mfp-prevent-close")) {
                var n = t.st.closeOnContentClick,
                    i = t.st.closeOnBgClick;
                if (n && i) return !0;
                if (!t.content || e(o).hasClass("mfp-close") || t.preloader && o === t.preloader[0]) return !0;
                if (o === t.content[0] || e.contains(t.content[0], o)) {
                    if (n) return !0
                } else if (i && e.contains(document, o)) return !0;
                return !1
            }
        },
        _addClassToMFP: function(e) {
            t.bgOverlay.addClass(e), t.wrap.addClass(e)
        },
        _removeClassFromMFP: function(e) {
            this.bgOverlay.removeClass(e), t.wrap.removeClass(e)
        },
        _hasScrollBar: function(e) {
            return (t.isIE7 ? n.height() : document.body.scrollHeight) > (e || c.height())
        },
        _setFocus: function() {
            (t.st.focus ? t.content.find(t.st.focus).eq(0) : t.wrap).focus()
        },
        _onFocusIn: function(o) {
            if (o.target !== t.wrap[0] && !e.contains(t.wrap[0], o.target)) return t._setFocus(), !1
        },
        _parseMarkup: function(t, o, n) {
            var i;
            n.data && (o = e.extend(n.data, o)), u("MarkupParse", [t, o, n]), e.each(o, function(o, n) {
                if (void 0 === n || !1 === n) return !0;
                if ((i = o.split("_")).length > 1) {
                    var s = t.find(".mfp-" + i[0]);
                    if (s.length > 0) {
                        var r = i[1];
                        "replaceWith" === r ? s[0] !== n[0] && s.replaceWith(n) : "img" === r ? s.is("img") ? s.attr("src", n) : s.replaceWith(e("<img>").attr("src", n).attr("class", s.attr("class"))) : s.attr(i[1], n)
                    }
                } else t.find(".mfp-" + o).html(n)
            })
        },
        _getScrollbarSize: function() {
            if (void 0 === t.scrollbarSize) {
                var e = document.createElement("div");
                e.style.cssText = "width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;", document.body.appendChild(e), t.scrollbarSize = e.offsetWidth - e.clientWidth, document.body.removeChild(e)
            }
            return t.scrollbarSize
        }
    }, e.magnificPopup = {
        instance: null,
        proto: a.prototype,
        modules: [],
        open: function(t, o) {
            return m(), t = t ? e.extend(!0, {}, t) : {}, t.isObj = !0, t.index = o || 0, this.instance.open(t)
        },
        close: function() {
            return e.magnificPopup.instance && e.magnificPopup.instance.close()
        },
        registerModule: function(t, o) {
            o.options && (e.magnificPopup.defaults[t] = o.options), e.extend(this.proto, o.proto), this.modules.push(t)
        },
        defaults: {
            disableOn: 0,
            key: null,
            midClick: !1,
            mainClass: "",
            preloader: !0,
            focus: "",
            closeOnContentClick: !1,
            closeOnBgClick: !0,
            closeBtnInside: !0,
            showCloseBtn: !0,
            enableEscapeKey: !0,
            modal: !1,
            alignTop: !1,
            removalDelay: 0,
            prependTo: null,
            fixedContentPos: "auto",
            fixedBgPos: "auto",
            overflowY: "auto",
            closeMarkup: '<button title="%title%" type="button" class="mfp-close">&#215;</button>',
            tClose: "Close (Esc)",
            tLoading: "Loading...",
            autoFocusLast: !0
        }
    }, e.fn.magnificPopup = function(o) {
        m();
        var n = e(this);
        if ("string" == typeof o)
            if ("open" === o) {
                var i, s = l ? n.data("magnificPopup") : n[0].magnificPopup,
                    r = parseInt(arguments[1], 10) || 0;
                s.items ? i = s.items[r] : (i = n, s.delegate && (i = i.find(s.delegate)), i = i.eq(r)), t._openClick({
                    mfpEl: i
                }, n, s)
            } else t.isOpen && t[o].apply(t, Array.prototype.slice.call(arguments, 1));
        else o = e.extend(!0, {}, o), l ? n.data("magnificPopup", o) : n[0].magnificPopup = o, t.addGroup(n, o);
        return n
    };
    var g, v, b, y = function() {
        b && (v.after(b.addClass(g)).detach(), b = null)
    };
    e.magnificPopup.registerModule("inline", {
        options: {
            hiddenClass: "hide",
            markup: "",
            tNotFound: "Content not found"
        },
        proto: {
            initInline: function() {
                t.types.push("inline"), p("Close.inline", function() {
                    y()
                })
            },
            getInline: function(o, n) {
                if (y(), o.src) {
                    var i = t.st.inline,
                        s = e(o.src);
                    if (s.length) {
                        var r = s[0].parentNode;
                        r && r.tagName && (v || (g = i.hiddenClass, v = d(g), g = "mfp-" + g), b = s.after(v).detach().removeClass(g)), t.updateStatus("ready")
                    } else t.updateStatus("error", i.tNotFound), s = e("<div>");
                    return o.inlineElement = s, s
                }
                return t.updateStatus("ready"), t._parseMarkup(n, {}, o), n
            }
        }
    });
    var C, w = function() {
        return void 0 === C && (C = void 0 !== document.createElement("p").style.MozTransform), C
    };
    e.magnificPopup.registerModule("zoom", {
        options: {
            enabled: !1,
            easing: "ease-in-out",
            duration: 300,
            opener: function(e) {
                return e.is("img") ? e : e.find("img")
            }
        },
        proto: {
            initZoom: function() {
                var e, o = t.st.zoom,
                    n = ".zoom";
                if (o.enabled && t.supportsTransition) {
                    var i, s, r = o.duration,
                        a = function(e) {
                            var t = e.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),
                                n = "all " + o.duration / 1e3 + "s " + o.easing,
                                i = {
                                    position: "fixed",
                                    zIndex: 9999,
                                    left: 0,
                                    top: 0,
                                    "-webkit-backface-visibility": "hidden"
                                },
                                s = "transition";
                            return i["-webkit-" + s] = i["-moz-" + s] = i["-o-" + s] = i[s] = n, t.css(i), t
                        },
                        l = function() {
                            t.content.css("visibility", "visible")
                        };
                    p("BuildControls" + n, function() {
                        if (t._allowZoom()) {
                            if (clearTimeout(i), t.content.css("visibility", "hidden"), !(e = t._getItemToZoom())) return void l();
                            (s = a(e)).css(t._getOffset()), t.wrap.append(s), i = setTimeout(function() {
                                s.css(t._getOffset(!0)), i = setTimeout(function() {
                                    l(), setTimeout(function() {
                                        s.remove(), e = s = null, u("ZoomAnimationEnded")
                                    }, 16)
                                }, r)
                            }, 16)
                        }
                    }), p("BeforeClose" + n, function() {
                        if (t._allowZoom()) {
                            if (clearTimeout(i), t.st.removalDelay = r, !e) {
                                if (!(e = t._getItemToZoom())) return;
                                s = a(e)
                            }
                            s.css(t._getOffset(!0)), t.wrap.append(s), t.content.css("visibility", "hidden"), setTimeout(function() {
                                s.css(t._getOffset())
                            }, 16)
                        }
                    }), p("Close" + n, function() {
                        t._allowZoom() && (l(), s && s.remove(), e = null)
                    })
                }
            },
            _allowZoom: function() {
                return "image" === t.currItem.type
            },
            _getItemToZoom: function() {
                return !!t.currItem.hasSize && t.currItem.img
            },
            _getOffset: function(o) {
                var n, i = (n = o ? t.currItem.img : t.st.zoom.opener(t.currItem.el || t.currItem)).offset(),
                    s = parseInt(n.css("padding-top"), 10),
                    r = parseInt(n.css("padding-bottom"), 10);
                i.top -= e(window).scrollTop() - s;
                var a = {
                    width: n.width(),
                    height: (l ? n.innerHeight() : n[0].offsetHeight) - r - s
                };
                return w() ? a["-moz-transform"] = a.transform = "translate(" + i.left + "px," + i.top + "px)" : (a.left = i.left, a.top = i.top), a
            }
        }
    });
    var k = function(e) {
        if (t.currTemplate.iframe) {
            var o = t.currTemplate.iframe.find("iframe");
            o.length && (e || (o[0].src = "//about:blank"), t.isIE8 && o.css("display", e ? "block" : "none"))
        }
    };
    e.magnificPopup.registerModule("iframe", {
        options: {
            markup: '<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe></div>',
            srcAction: "iframe_src",
            patterns: {
                youtube: {
                    index: "youtube.com",
                    id: "v=",
                    src: "//www.youtube.com/embed/%id%?autoplay=1"
                },
                vimeo: {
                    index: "vimeo.com/",
                    id: "/",
                    src: "//player.vimeo.com/video/%id%?autoplay=1"
                },
                gmaps: {
                    index: "//maps.google.",
                    src: "%id%&output=embed"
                }
            }
        },
        proto: {
            initIframe: function() {
                t.types.push("iframe"), p("BeforeChange", function(e, t, o) {
                    t !== o && ("iframe" === t ? k() : "iframe" === o && k(!0))
                }), p("Close.iframe", function() {
                    k()
                })
            },
            getIframe: function(o, n) {
                var i = o.src,
                    s = t.st.iframe;
                e.each(s.patterns, function() {
                    if (i.indexOf(this.index) > -1) return this.id && (i = "string" == typeof this.id ? i.substr(i.lastIndexOf(this.id) + this.id.length, i.length) : this.id.call(this, i)), i = this.src.replace("%id%", i), !1
                });
                var r = {};
                return s.srcAction && (r[s.srcAction] = i), t._parseMarkup(n, r, o), t.updateStatus("ready"), n
            }
        }
    }), m()
}),
function(e) {
    if (!isMobile && !readCookie("popup_exit_closed")) {
		console.log('ko phai moblie 1');
        var t = 0,
            o = '<div id="popup-exit"><p class="size-56 medium title">' + cele_form.popup_exit_title + '</p><p class="description">' + cele_form.popup_exit_description + '</p><form class="form" action="https://crm.zoho.com/crm/WebToLeadForm" method="POST"><input id="human" name="human" value="' + cele_form.human + '" type="hidden"><input name="Cele" value="mastergf-modal-header" type="hidden"><input type="hidden"  name="xnQsjsdp" value="0869bfcdc841d22b11056a01a5da5637e4e8db2bc08f85c424203d0cef452600"/><input type="hidden" name="xmIwtLD" value="3aa5421eef8a37948d2901c21c5e182f3605e34f37664b817c432e5d864d7d6a"/><input type="hidden" name="actionType" value="TGVhZHM="/><input type="hidden" name="returnURL" value="' + cele_form.return_url + '" /><input name="Company" value="' + cele_form.company + '" type="hidden"><input name="Website" value="' + cele_form.website + '" type="hidden"><div class="name-email"><p class="name"><input type="text" name="Last Name" placeholder="Tên của bạn"></p><p class="number"><input type="number" name="Mobile" placeholder="Số điện thoại" required></p><p class="email"><input type="email" name="Email" placeholder="Email của bạn" required></p></div><p class="btn-wrap"><input type="submit" class="btn btn-wrw form-submit" value="' + cele_form.popup_exit_submit + '"></p></form><p class="size-22 closed">' + cele_form.popup_exit_close + "</p></div>";
        e(document).mouseleave(function() {
			console.log('ko phai moblie 2');
            0 == t && (createCookie("popup_exit_closed", "1", "365"), t = 1, e.magnificPopup.open({
                enableEscapeKey: !1,
                closeOnBgClick: !1,
                items: {
                    src: o,
                    type: "inline",
                    midClick: !0
                },
                callbacks: {
                    open: function() {
                        e("body").addClass("mfp-popup-exit"), e("#popup-exit .closed").click(function() {
                            e.magnificPopup.close()
                        })
                    },
                    close: function() {
                        e("body").removeClass("mfp-popup-exit")
                    }
                }
            }))
        })
    }
}(jQuery),
function(e) {
    function t() {
        var t = n.outerHeight();
        e("body").css("padding-top", t)
    }
    if (e("#topbar").length) {
        var o, n = e("#topbar");
        e(window).width();
        e(window).resize(function() {
            clearTimeout(o), o = setTimeout(t, 250)
        }), t(), n.css("position", "fixed").css("top", "0")
    }
}(jQuery),
function(e) {
    e(".menu-item-has-children > a").on("click", function(e) {
        e.preventDefault()
    }), e(".nice-select").niceSelect(), setTimeout(function() {
        e(".nice-select .list").wrap('<div class="list optiscroll"><ul></ul></div>').contents().unwrap(), e(".optiscroll").optiscroll({
            forceScrollbars: !0,
            preventParentScroll: !0,
            wrapContent: !1
        })
    }, 1e3), e(".form select.extend").change(function() {
        e(this).parentsUntil(".form").find(".part").removeClass("hidden")
    }), "undefined" != typeof lang_geo && e('input[name="cf-lang-geo"]').val(lang_geo)
}(jQuery);