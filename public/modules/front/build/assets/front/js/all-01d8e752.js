/*!
 * Bootstrap v3.3.4 (http://getbootstrap.com)
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */
"use strict";

if ("undefined" == typeof jQuery) throw new Error("Bootstrap's JavaScript requires jQuery");+(function (a) {
  "use strict";var b = a.fn.jquery.split(" ")[0].split(".");if (b[0] < 2 && b[1] < 9 || 1 == b[0] && 9 == b[1] && b[2] < 1) throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher");
})(jQuery), +(function (a) {
  "use strict";function b() {
    var a = document.createElement("bootstrap"),
        b = { WebkitTransition: "webkitTransitionEnd", MozTransition: "transitionend", OTransition: "oTransitionEnd otransitionend", transition: "transitionend" };for (var c in b) if (void 0 !== a.style[c]) return { end: b[c] };return !1;
  }a.fn.emulateTransitionEnd = function (b) {
    var c = !1,
        d = this;a(this).one("bsTransitionEnd", function () {
      c = !0;
    });var e = function e() {
      c || a(d).trigger(a.support.transition.end);
    };return (setTimeout(e, b), this);
  }, a(function () {
    a.support.transition = b(), a.support.transition && (a.event.special.bsTransitionEnd = { bindType: a.support.transition.end, delegateType: a.support.transition.end, handle: function handle(b) {
        return a(b.target).is(this) ? b.handleObj.handler.apply(this, arguments) : void 0;
      } });
  });
})(jQuery), +(function (a) {
  "use strict";function b(b) {
    return this.each(function () {
      var c = a(this),
          e = c.data("bs.alert");e || c.data("bs.alert", e = new d(this)), "string" == typeof b && e[b].call(c);
    });
  }var c = "[data-dismiss=\"alert\"]",
      d = function d(b) {
    a(b).on("click", c, this.close);
  };d.VERSION = "3.3.4", d.TRANSITION_DURATION = 150, d.prototype.close = function (b) {
    function c() {
      g.detach().trigger("closed.bs.alert").remove();
    }var e = a(this),
        f = e.attr("data-target");f || (f = e.attr("href"), f = f && f.replace(/.*(?=#[^\s]*$)/, ""));var g = a(f);b && b.preventDefault(), g.length || (g = e.closest(".alert")), g.trigger(b = a.Event("close.bs.alert")), b.isDefaultPrevented() || (g.removeClass("in"), a.support.transition && g.hasClass("fade") ? g.one("bsTransitionEnd", c).emulateTransitionEnd(d.TRANSITION_DURATION) : c());
  };var e = a.fn.alert;a.fn.alert = b, a.fn.alert.Constructor = d, a.fn.alert.noConflict = function () {
    return (a.fn.alert = e, this);
  }, a(document).on("click.bs.alert.data-api", c, d.prototype.close);
})(jQuery), +(function (a) {
  "use strict";function b(b) {
    return this.each(function () {
      var d = a(this),
          e = d.data("bs.button"),
          f = "object" == typeof b && b;e || d.data("bs.button", e = new c(this, f)), "toggle" == b ? e.toggle() : b && e.setState(b);
    });
  }var c = function c(b, d) {
    this.$element = a(b), this.options = a.extend({}, c.DEFAULTS, d), this.isLoading = !1;
  };c.VERSION = "3.3.4", c.DEFAULTS = { loadingText: "loading..." }, c.prototype.setState = function (b) {
    var c = "disabled",
        d = this.$element,
        e = d.is("input") ? "val" : "html",
        f = d.data();b += "Text", null == f.resetText && d.data("resetText", d[e]()), setTimeout(a.proxy(function () {
      d[e](null == f[b] ? this.options[b] : f[b]), "loadingText" == b ? (this.isLoading = !0, d.addClass(c).attr(c, c)) : this.isLoading && (this.isLoading = !1, d.removeClass(c).removeAttr(c));
    }, this), 0);
  }, c.prototype.toggle = function () {
    var a = !0,
        b = this.$element.closest("[data-toggle=\"buttons\"]");if (b.length) {
      var c = this.$element.find("input");"radio" == c.prop("type") && (c.prop("checked") && this.$element.hasClass("active") ? a = !1 : b.find(".active").removeClass("active")), a && c.prop("checked", !this.$element.hasClass("active")).trigger("change");
    } else this.$element.attr("aria-pressed", !this.$element.hasClass("active"));a && this.$element.toggleClass("active");
  };var d = a.fn.button;a.fn.button = b, a.fn.button.Constructor = c, a.fn.button.noConflict = function () {
    return (a.fn.button = d, this);
  }, a(document).on("click.bs.button.data-api", "[data-toggle^=\"button\"]", function (c) {
    var d = a(c.target);d.hasClass("btn") || (d = d.closest(".btn")), b.call(d, "toggle"), c.preventDefault();
  }).on("focus.bs.button.data-api blur.bs.button.data-api", "[data-toggle^=\"button\"]", function (b) {
    a(b.target).closest(".btn").toggleClass("focus", /^focus(in)?$/.test(b.type));
  });
})(jQuery), +(function (a) {
  "use strict";function b(b) {
    return this.each(function () {
      var d = a(this),
          e = d.data("bs.carousel"),
          f = a.extend({}, c.DEFAULTS, d.data(), "object" == typeof b && b),
          g = "string" == typeof b ? b : f.slide;e || d.data("bs.carousel", e = new c(this, f)), "number" == typeof b ? e.to(b) : g ? e[g]() : f.interval && e.pause().cycle();
    });
  }var c = function c(b, _c) {
    this.$element = a(b), this.$indicators = this.$element.find(".carousel-indicators"), this.options = _c, this.paused = null, this.sliding = null, this.interval = null, this.$active = null, this.$items = null, this.options.keyboard && this.$element.on("keydown.bs.carousel", a.proxy(this.keydown, this)), "hover" == this.options.pause && !("ontouchstart" in document.documentElement) && this.$element.on("mouseenter.bs.carousel", a.proxy(this.pause, this)).on("mouseleave.bs.carousel", a.proxy(this.cycle, this));
  };c.VERSION = "3.3.4", c.TRANSITION_DURATION = 600, c.DEFAULTS = { interval: 5000, pause: "hover", wrap: !0, keyboard: !0 }, c.prototype.keydown = function (a) {
    if (!/input|textarea/i.test(a.target.tagName)) {
      switch (a.which) {case 37:
          this.prev();break;case 39:
          this.next();break;default:
          return;}a.preventDefault();
    }
  }, c.prototype.cycle = function (b) {
    return (b || (this.paused = !1), this.interval && clearInterval(this.interval), this.options.interval && !this.paused && (this.interval = setInterval(a.proxy(this.next, this), this.options.interval)), this);
  }, c.prototype.getItemIndex = function (a) {
    return (this.$items = a.parent().children(".item"), this.$items.index(a || this.$active));
  }, c.prototype.getItemForDirection = function (a, b) {
    var c = this.getItemIndex(b),
        d = "prev" == a && 0 === c || "next" == a && c == this.$items.length - 1;if (d && !this.options.wrap) return b;var e = "prev" == a ? -1 : 1,
        f = (c + e) % this.$items.length;return this.$items.eq(f);
  }, c.prototype.to = function (a) {
    var b = this,
        c = this.getItemIndex(this.$active = this.$element.find(".item.active"));return a > this.$items.length - 1 || 0 > a ? void 0 : this.sliding ? this.$element.one("slid.bs.carousel", function () {
      b.to(a);
    }) : c == a ? this.pause().cycle() : this.slide(a > c ? "next" : "prev", this.$items.eq(a));
  }, c.prototype.pause = function (b) {
    return (b || (this.paused = !0), this.$element.find(".next, .prev").length && a.support.transition && (this.$element.trigger(a.support.transition.end), this.cycle(!0)), this.interval = clearInterval(this.interval), this);
  }, c.prototype.next = function () {
    return this.sliding ? void 0 : this.slide("next");
  }, c.prototype.prev = function () {
    return this.sliding ? void 0 : this.slide("prev");
  }, c.prototype.slide = function (b, d) {
    var e = this.$element.find(".item.active"),
        f = d || this.getItemForDirection(b, e),
        g = this.interval,
        h = "next" == b ? "left" : "right",
        i = this;if (f.hasClass("active")) return this.sliding = !1;var j = f[0],
        k = a.Event("slide.bs.carousel", { relatedTarget: j, direction: h });if ((this.$element.trigger(k), !k.isDefaultPrevented())) {
      if ((this.sliding = !0, g && this.pause(), this.$indicators.length)) {
        this.$indicators.find(".active").removeClass("active");var l = a(this.$indicators.children()[this.getItemIndex(f)]);l && l.addClass("active");
      }var m = a.Event("slid.bs.carousel", { relatedTarget: j, direction: h });return (a.support.transition && this.$element.hasClass("slide") ? (f.addClass(b), f[0].offsetWidth, e.addClass(h), f.addClass(h), e.one("bsTransitionEnd", function () {
        f.removeClass([b, h].join(" ")).addClass("active"), e.removeClass(["active", h].join(" ")), i.sliding = !1, setTimeout(function () {
          i.$element.trigger(m);
        }, 0);
      }).emulateTransitionEnd(c.TRANSITION_DURATION)) : (e.removeClass("active"), f.addClass("active"), this.sliding = !1, this.$element.trigger(m)), g && this.cycle(), this);
    }
  };var d = a.fn.carousel;a.fn.carousel = b, a.fn.carousel.Constructor = c, a.fn.carousel.noConflict = function () {
    return (a.fn.carousel = d, this);
  };var e = function e(c) {
    var d,
        e = a(this),
        f = a(e.attr("data-target") || (d = e.attr("href")) && d.replace(/.*(?=#[^\s]+$)/, ""));if (f.hasClass("carousel")) {
      var g = a.extend({}, f.data(), e.data()),
          h = e.attr("data-slide-to");h && (g.interval = !1), b.call(f, g), h && f.data("bs.carousel").to(h), c.preventDefault();
    }
  };a(document).on("click.bs.carousel.data-api", "[data-slide]", e).on("click.bs.carousel.data-api", "[data-slide-to]", e), a(window).on("load", function () {
    a("[data-ride=\"carousel\"]").each(function () {
      var c = a(this);b.call(c, c.data());
    });
  });
})(jQuery), +(function (a) {
  "use strict";function b(b) {
    var c,
        d = b.attr("data-target") || (c = b.attr("href")) && c.replace(/.*(?=#[^\s]+$)/, "");return a(d);
  }function c(b) {
    return this.each(function () {
      var c = a(this),
          e = c.data("bs.collapse"),
          f = a.extend({}, d.DEFAULTS, c.data(), "object" == typeof b && b);!e && f.toggle && /show|hide/.test(b) && (f.toggle = !1), e || c.data("bs.collapse", e = new d(this, f)), "string" == typeof b && e[b]();
    });
  }var d = function d(b, c) {
    this.$element = a(b), this.options = a.extend({}, d.DEFAULTS, c), this.$trigger = a("[data-toggle=\"collapse\"][href=\"#" + b.id + "\"],[data-toggle=\"collapse\"][data-target=\"#" + b.id + "\"]"), this.transitioning = null, this.options.parent ? this.$parent = this.getParent() : this.addAriaAndCollapsedClass(this.$element, this.$trigger), this.options.toggle && this.toggle();
  };d.VERSION = "3.3.4", d.TRANSITION_DURATION = 350, d.DEFAULTS = { toggle: !0 }, d.prototype.dimension = function () {
    var a = this.$element.hasClass("width");return a ? "width" : "height";
  }, d.prototype.show = function () {
    if (!this.transitioning && !this.$element.hasClass("in")) {
      var b,
          e = this.$parent && this.$parent.children(".panel").children(".in, .collapsing");if (!(e && e.length && (b = e.data("bs.collapse"), b && b.transitioning))) {
        var f = a.Event("show.bs.collapse");if ((this.$element.trigger(f), !f.isDefaultPrevented())) {
          e && e.length && (c.call(e, "hide"), b || e.data("bs.collapse", null));var g = this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[g](0).attr("aria-expanded", !0), this.$trigger.removeClass("collapsed").attr("aria-expanded", !0), this.transitioning = 1;var h = function h() {
            this.$element.removeClass("collapsing").addClass("collapse in")[g](""), this.transitioning = 0, this.$element.trigger("shown.bs.collapse");
          };if (!a.support.transition) return h.call(this);var i = a.camelCase(["scroll", g].join("-"));this.$element.one("bsTransitionEnd", a.proxy(h, this)).emulateTransitionEnd(d.TRANSITION_DURATION)[g](this.$element[0][i]);
        }
      }
    }
  }, d.prototype.hide = function () {
    if (!this.transitioning && this.$element.hasClass("in")) {
      var b = a.Event("hide.bs.collapse");if ((this.$element.trigger(b), !b.isDefaultPrevented())) {
        var c = this.dimension();this.$element[c](this.$element[c]())[0].offsetHeight, this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded", !1), this.$trigger.addClass("collapsed").attr("aria-expanded", !1), this.transitioning = 1;var e = function e() {
          this.transitioning = 0, this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse");
        };return a.support.transition ? void this.$element[c](0).one("bsTransitionEnd", a.proxy(e, this)).emulateTransitionEnd(d.TRANSITION_DURATION) : e.call(this);
      }
    }
  }, d.prototype.toggle = function () {
    this[this.$element.hasClass("in") ? "hide" : "show"]();
  }, d.prototype.getParent = function () {
    return a(this.options.parent).find("[data-toggle=\"collapse\"][data-parent=\"" + this.options.parent + "\"]").each(a.proxy(function (c, d) {
      var e = a(d);this.addAriaAndCollapsedClass(b(e), e);
    }, this)).end();
  }, d.prototype.addAriaAndCollapsedClass = function (a, b) {
    var c = a.hasClass("in");a.attr("aria-expanded", c), b.toggleClass("collapsed", !c).attr("aria-expanded", c);
  };var e = a.fn.collapse;a.fn.collapse = c, a.fn.collapse.Constructor = d, a.fn.collapse.noConflict = function () {
    return (a.fn.collapse = e, this);
  }, a(document).on("click.bs.collapse.data-api", "[data-toggle=\"collapse\"]", function (d) {
    var e = a(this);e.attr("data-target") || d.preventDefault();var f = b(e),
        g = f.data("bs.collapse"),
        h = g ? "toggle" : e.data();c.call(f, h);
  });
})(jQuery), +(function (a) {
  "use strict";function b(b) {
    b && 3 === b.which || (a(e).remove(), a(f).each(function () {
      var d = a(this),
          e = c(d),
          f = { relatedTarget: this };e.hasClass("open") && (e.trigger(b = a.Event("hide.bs.dropdown", f)), b.isDefaultPrevented() || (d.attr("aria-expanded", "false"), e.removeClass("open").trigger("hidden.bs.dropdown", f)));
    }));
  }function c(b) {
    var c = b.attr("data-target");c || (c = b.attr("href"), c = c && /#[A-Za-z]/.test(c) && c.replace(/.*(?=#[^\s]*$)/, ""));var d = c && a(c);return d && d.length ? d : b.parent();
  }function d(b) {
    return this.each(function () {
      var c = a(this),
          d = c.data("bs.dropdown");d || c.data("bs.dropdown", d = new g(this)), "string" == typeof b && d[b].call(c);
    });
  }var e = ".dropdown-backdrop",
      f = "[data-toggle=\"dropdown\"]",
      g = function g(b) {
    a(b).on("click.bs.dropdown", this.toggle);
  };g.VERSION = "3.3.4", g.prototype.toggle = function (d) {
    var e = a(this);if (!e.is(".disabled, :disabled")) {
      var f = c(e),
          g = f.hasClass("open");if ((b(), !g)) {
        "ontouchstart" in document.documentElement && !f.closest(".navbar-nav").length && a("<div class=\"dropdown-backdrop\"/>").insertAfter(a(this)).on("click", b);var h = { relatedTarget: this };if ((f.trigger(d = a.Event("show.bs.dropdown", h)), d.isDefaultPrevented())) return;e.trigger("focus").attr("aria-expanded", "true"), f.toggleClass("open").trigger("shown.bs.dropdown", h);
      }return !1;
    }
  }, g.prototype.keydown = function (b) {
    if (/(38|40|27|32)/.test(b.which) && !/input|textarea/i.test(b.target.tagName)) {
      var d = a(this);if ((b.preventDefault(), b.stopPropagation(), !d.is(".disabled, :disabled"))) {
        var e = c(d),
            g = e.hasClass("open");if (!g && 27 != b.which || g && 27 == b.which) return (27 == b.which && e.find(f).trigger("focus"), d.trigger("click"));var h = " li:not(.disabled):visible a",
            i = e.find("[role=\"menu\"]" + h + ", [role=\"listbox\"]" + h);if (i.length) {
          var j = i.index(b.target);38 == b.which && j > 0 && j--, 40 == b.which && j < i.length - 1 && j++, ~j || (j = 0), i.eq(j).trigger("focus");
        }
      }
    }
  };var h = a.fn.dropdown;a.fn.dropdown = d, a.fn.dropdown.Constructor = g, a.fn.dropdown.noConflict = function () {
    return (a.fn.dropdown = h, this);
  }, a(document).on("click.bs.dropdown.data-api", b).on("click.bs.dropdown.data-api", ".dropdown form", function (a) {
    a.stopPropagation();
  }).on("click.bs.dropdown.data-api", f, g.prototype.toggle).on("keydown.bs.dropdown.data-api", f, g.prototype.keydown).on("keydown.bs.dropdown.data-api", "[role=\"menu\"]", g.prototype.keydown).on("keydown.bs.dropdown.data-api", "[role=\"listbox\"]", g.prototype.keydown);
})(jQuery), +(function (a) {
  "use strict";function b(b, d) {
    return this.each(function () {
      var e = a(this),
          f = e.data("bs.modal"),
          g = a.extend({}, c.DEFAULTS, e.data(), "object" == typeof b && b);f || e.data("bs.modal", f = new c(this, g)), "string" == typeof b ? f[b](d) : g.show && f.show(d);
    });
  }var c = function c(b, _c2) {
    this.options = _c2, this.$body = a(document.body), this.$element = a(b), this.$dialog = this.$element.find(".modal-dialog"), this.$backdrop = null, this.isShown = null, this.originalBodyPad = null, this.scrollbarWidth = 0, this.ignoreBackdropClick = !1, this.options.remote && this.$element.find(".modal-content").load(this.options.remote, a.proxy(function () {
      this.$element.trigger("loaded.bs.modal");
    }, this));
  };c.VERSION = "3.3.4", c.TRANSITION_DURATION = 300, c.BACKDROP_TRANSITION_DURATION = 150, c.DEFAULTS = { backdrop: !0, keyboard: !0, show: !0 }, c.prototype.toggle = function (a) {
    return this.isShown ? this.hide() : this.show(a);
  }, c.prototype.show = function (b) {
    var d = this,
        e = a.Event("show.bs.modal", { relatedTarget: b });this.$element.trigger(e), this.isShown || e.isDefaultPrevented() || (this.isShown = !0, this.checkScrollbar(), this.setScrollbar(), this.$body.addClass("modal-open"), this.escape(), this.resize(), this.$element.on("click.dismiss.bs.modal", "[data-dismiss=\"modal\"]", a.proxy(this.hide, this)), this.$dialog.on("mousedown.dismiss.bs.modal", function () {
      d.$element.one("mouseup.dismiss.bs.modal", function (b) {
        a(b.target).is(d.$element) && (d.ignoreBackdropClick = !0);
      });
    }), this.backdrop(function () {
      var e = a.support.transition && d.$element.hasClass("fade");d.$element.parent().length || d.$element.appendTo(d.$body), d.$element.show().scrollTop(0), d.adjustDialog(), e && d.$element[0].offsetWidth, d.$element.addClass("in").attr("aria-hidden", !1), d.enforceFocus();var f = a.Event("shown.bs.modal", { relatedTarget: b });e ? d.$dialog.one("bsTransitionEnd", function () {
        d.$element.trigger("focus").trigger(f);
      }).emulateTransitionEnd(c.TRANSITION_DURATION) : d.$element.trigger("focus").trigger(f);
    }));
  }, c.prototype.hide = function (b) {
    b && b.preventDefault(), b = a.Event("hide.bs.modal"), this.$element.trigger(b), this.isShown && !b.isDefaultPrevented() && (this.isShown = !1, this.escape(), this.resize(), a(document).off("focusin.bs.modal"), this.$element.removeClass("in").attr("aria-hidden", !0).off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"), this.$dialog.off("mousedown.dismiss.bs.modal"), a.support.transition && this.$element.hasClass("fade") ? this.$element.one("bsTransitionEnd", a.proxy(this.hideModal, this)).emulateTransitionEnd(c.TRANSITION_DURATION) : this.hideModal());
  }, c.prototype.enforceFocus = function () {
    a(document).off("focusin.bs.modal").on("focusin.bs.modal", a.proxy(function (a) {
      this.$element[0] === a.target || this.$element.has(a.target).length || this.$element.trigger("focus");
    }, this));
  }, c.prototype.escape = function () {
    this.isShown && this.options.keyboard ? this.$element.on("keydown.dismiss.bs.modal", a.proxy(function (a) {
      27 == a.which && this.hide();
    }, this)) : this.isShown || this.$element.off("keydown.dismiss.bs.modal");
  }, c.prototype.resize = function () {
    this.isShown ? a(window).on("resize.bs.modal", a.proxy(this.handleUpdate, this)) : a(window).off("resize.bs.modal");
  }, c.prototype.hideModal = function () {
    var a = this;this.$element.hide(), this.backdrop(function () {
      a.$body.removeClass("modal-open"), a.resetAdjustments(), a.resetScrollbar(), a.$element.trigger("hidden.bs.modal");
    });
  }, c.prototype.removeBackdrop = function () {
    this.$backdrop && this.$backdrop.remove(), this.$backdrop = null;
  }, c.prototype.backdrop = function (b) {
    var d = this,
        e = this.$element.hasClass("fade") ? "fade" : "";if (this.isShown && this.options.backdrop) {
      var f = a.support.transition && e;if ((this.$backdrop = a("<div class=\"modal-backdrop " + e + "\" />").appendTo(this.$body), this.$element.on("click.dismiss.bs.modal", a.proxy(function (a) {
        return this.ignoreBackdropClick ? void (this.ignoreBackdropClick = !1) : void (a.target === a.currentTarget && ("static" == this.options.backdrop ? this.$element[0].focus() : this.hide()));
      }, this)), f && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), !b)) return;f ? this.$backdrop.one("bsTransitionEnd", b).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION) : b();
    } else if (!this.isShown && this.$backdrop) {
      this.$backdrop.removeClass("in");var g = function g() {
        d.removeBackdrop(), b && b();
      };a.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one("bsTransitionEnd", g).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION) : g();
    } else b && b();
  }, c.prototype.handleUpdate = function () {
    this.adjustDialog();
  }, c.prototype.adjustDialog = function () {
    var a = this.$element[0].scrollHeight > document.documentElement.clientHeight;this.$element.css({ paddingLeft: !this.bodyIsOverflowing && a ? this.scrollbarWidth : "", paddingRight: this.bodyIsOverflowing && !a ? this.scrollbarWidth : "" });
  }, c.prototype.resetAdjustments = function () {
    this.$element.css({ paddingLeft: "", paddingRight: "" });
  }, c.prototype.checkScrollbar = function () {
    var a = window.innerWidth;if (!a) {
      var b = document.documentElement.getBoundingClientRect();a = b.right - Math.abs(b.left);
    }this.bodyIsOverflowing = document.body.clientWidth < a, this.scrollbarWidth = this.measureScrollbar();
  }, c.prototype.setScrollbar = function () {
    var a = parseInt(this.$body.css("padding-right") || 0, 10);this.originalBodyPad = document.body.style.paddingRight || "", this.bodyIsOverflowing && this.$body.css("padding-right", a + this.scrollbarWidth);
  }, c.prototype.resetScrollbar = function () {
    this.$body.css("padding-right", this.originalBodyPad);
  }, c.prototype.measureScrollbar = function () {
    var a = document.createElement("div");a.className = "modal-scrollbar-measure", this.$body.append(a);var b = a.offsetWidth - a.clientWidth;return (this.$body[0].removeChild(a), b);
  };var d = a.fn.modal;a.fn.modal = b, a.fn.modal.Constructor = c, a.fn.modal.noConflict = function () {
    return (a.fn.modal = d, this);
  }, a(document).on("click.bs.modal.data-api", "[data-toggle=\"modal\"]", function (c) {
    var d = a(this),
        e = d.attr("href"),
        f = a(d.attr("data-target") || e && e.replace(/.*(?=#[^\s]+$)/, "")),
        g = f.data("bs.modal") ? "toggle" : a.extend({ remote: !/#/.test(e) && e }, f.data(), d.data());d.is("a") && c.preventDefault(), f.one("show.bs.modal", function (a) {
      a.isDefaultPrevented() || f.one("hidden.bs.modal", function () {
        d.is(":visible") && d.trigger("focus");
      });
    }), b.call(f, g, this);
  });
})(jQuery), +(function (a) {
  "use strict";function b(b) {
    return this.each(function () {
      var d = a(this),
          e = d.data("bs.tooltip"),
          f = "object" == typeof b && b;(e || !/destroy|hide/.test(b)) && (e || d.data("bs.tooltip", e = new c(this, f)), "string" == typeof b && e[b]());
    });
  }var c = function c(a, b) {
    this.type = null, this.options = null, this.enabled = null, this.timeout = null, this.hoverState = null, this.$element = null, this.init("tooltip", a, b);
  };c.VERSION = "3.3.4", c.TRANSITION_DURATION = 150, c.DEFAULTS = { animation: !0, placement: "top", selector: !1, template: "<div class=\"tooltip\" role=\"tooltip\"><div class=\"tooltip-arrow\"></div><div class=\"tooltip-inner\"></div></div>", trigger: "hover focus", title: "", delay: 0, html: !1, container: !1, viewport: { selector: "body", padding: 0 } }, c.prototype.init = function (b, c, d) {
    if ((this.enabled = !0, this.type = b, this.$element = a(c), this.options = this.getOptions(d), this.$viewport = this.options.viewport && a(this.options.viewport.selector || this.options.viewport), this.$element[0] instanceof document.constructor && !this.options.selector)) throw new Error("`selector` option must be specified when initializing " + this.type + " on the window.document object!");for (var e = this.options.trigger.split(" "), f = e.length; f--;) {
      var g = e[f];if ("click" == g) this.$element.on("click." + this.type, this.options.selector, a.proxy(this.toggle, this));else if ("manual" != g) {
        var h = "hover" == g ? "mouseenter" : "focusin",
            i = "hover" == g ? "mouseleave" : "focusout";this.$element.on(h + "." + this.type, this.options.selector, a.proxy(this.enter, this)), this.$element.on(i + "." + this.type, this.options.selector, a.proxy(this.leave, this));
      }
    }this.options.selector ? this._options = a.extend({}, this.options, { trigger: "manual", selector: "" }) : this.fixTitle();
  }, c.prototype.getDefaults = function () {
    return c.DEFAULTS;
  }, c.prototype.getOptions = function (b) {
    return (b = a.extend({}, this.getDefaults(), this.$element.data(), b), b.delay && "number" == typeof b.delay && (b.delay = { show: b.delay, hide: b.delay }), b);
  }, c.prototype.getDelegateOptions = function () {
    var b = {},
        c = this.getDefaults();return (this._options && a.each(this._options, function (a, d) {
      c[a] != d && (b[a] = d);
    }), b);
  }, c.prototype.enter = function (b) {
    var c = b instanceof this.constructor ? b : a(b.currentTarget).data("bs." + this.type);return c && c.$tip && c.$tip.is(":visible") ? void (c.hoverState = "in") : (c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c)), clearTimeout(c.timeout), c.hoverState = "in", c.options.delay && c.options.delay.show ? void (c.timeout = setTimeout(function () {
      "in" == c.hoverState && c.show();
    }, c.options.delay.show)) : c.show());
  }, c.prototype.leave = function (b) {
    var c = b instanceof this.constructor ? b : a(b.currentTarget).data("bs." + this.type);return (c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c)), clearTimeout(c.timeout), c.hoverState = "out", c.options.delay && c.options.delay.hide ? void (c.timeout = setTimeout(function () {
      "out" == c.hoverState && c.hide();
    }, c.options.delay.hide)) : c.hide());
  }, c.prototype.show = function () {
    var b = a.Event("show.bs." + this.type);if (this.hasContent() && this.enabled) {
      this.$element.trigger(b);var d = a.contains(this.$element[0].ownerDocument.documentElement, this.$element[0]);if (b.isDefaultPrevented() || !d) return;var e = this,
          f = this.tip(),
          g = this.getUID(this.type);this.setContent(), f.attr("id", g), this.$element.attr("aria-describedby", g), this.options.animation && f.addClass("fade");var h = "function" == typeof this.options.placement ? this.options.placement.call(this, f[0], this.$element[0]) : this.options.placement,
          i = /\s?auto?\s?/i,
          j = i.test(h);j && (h = h.replace(i, "") || "top"), f.detach().css({ top: 0, left: 0, display: "block" }).addClass(h).data("bs." + this.type, this), this.options.container ? f.appendTo(this.options.container) : f.insertAfter(this.$element);var k = this.getPosition(),
          l = f[0].offsetWidth,
          m = f[0].offsetHeight;if (j) {
        var n = h,
            o = this.options.container ? a(this.options.container) : this.$element.parent(),
            p = this.getPosition(o);h = "bottom" == h && k.bottom + m > p.bottom ? "top" : "top" == h && k.top - m < p.top ? "bottom" : "right" == h && k.right + l > p.width ? "left" : "left" == h && k.left - l < p.left ? "right" : h, f.removeClass(n).addClass(h);
      }var q = this.getCalculatedOffset(h, k, l, m);this.applyPlacement(q, h);var r = function r() {
        var a = e.hoverState;e.$element.trigger("shown.bs." + e.type), e.hoverState = null, "out" == a && e.leave(e);
      };a.support.transition && this.$tip.hasClass("fade") ? f.one("bsTransitionEnd", r).emulateTransitionEnd(c.TRANSITION_DURATION) : r();
    }
  }, c.prototype.applyPlacement = function (b, c) {
    var d = this.tip(),
        e = d[0].offsetWidth,
        f = d[0].offsetHeight,
        g = parseInt(d.css("margin-top"), 10),
        h = parseInt(d.css("margin-left"), 10);isNaN(g) && (g = 0), isNaN(h) && (h = 0), b.top = b.top + g, b.left = b.left + h, a.offset.setOffset(d[0], a.extend({ using: function using(a) {
        d.css({ top: Math.round(a.top), left: Math.round(a.left) });
      } }, b), 0), d.addClass("in");var i = d[0].offsetWidth,
        j = d[0].offsetHeight;"top" == c && j != f && (b.top = b.top + f - j);var k = this.getViewportAdjustedDelta(c, b, i, j);k.left ? b.left += k.left : b.top += k.top;var l = /top|bottom/.test(c),
        m = l ? 2 * k.left - e + i : 2 * k.top - f + j,
        n = l ? "offsetWidth" : "offsetHeight";d.offset(b), this.replaceArrow(m, d[0][n], l);
  }, c.prototype.replaceArrow = function (a, b, c) {
    this.arrow().css(c ? "left" : "top", 50 * (1 - a / b) + "%").css(c ? "top" : "left", "");
  }, c.prototype.setContent = function () {
    var a = this.tip(),
        b = this.getTitle();a.find(".tooltip-inner")[this.options.html ? "html" : "text"](b), a.removeClass("fade in top bottom left right");
  }, c.prototype.hide = function (b) {
    function d() {
      "in" != e.hoverState && f.detach(), e.$element.removeAttr("aria-describedby").trigger("hidden.bs." + e.type), b && b();
    }var e = this,
        f = a(this.$tip),
        g = a.Event("hide.bs." + this.type);return (this.$element.trigger(g), g.isDefaultPrevented() ? void 0 : (f.removeClass("in"), a.support.transition && f.hasClass("fade") ? f.one("bsTransitionEnd", d).emulateTransitionEnd(c.TRANSITION_DURATION) : d(), this.hoverState = null, this));
  }, c.prototype.fixTitle = function () {
    var a = this.$element;(a.attr("title") || "string" != typeof a.attr("data-original-title")) && a.attr("data-original-title", a.attr("title") || "").attr("title", "");
  }, c.prototype.hasContent = function () {
    return this.getTitle();
  }, c.prototype.getPosition = function (b) {
    b = b || this.$element;var c = b[0],
        d = "BODY" == c.tagName,
        e = c.getBoundingClientRect();null == e.width && (e = a.extend({}, e, { width: e.right - e.left, height: e.bottom - e.top }));var f = d ? { top: 0, left: 0 } : b.offset(),
        g = { scroll: d ? document.documentElement.scrollTop || document.body.scrollTop : b.scrollTop() },
        h = d ? { width: a(window).width(), height: a(window).height() } : null;return a.extend({}, e, g, h, f);
  }, c.prototype.getCalculatedOffset = function (a, b, c, d) {
    return "bottom" == a ? { top: b.top + b.height, left: b.left + b.width / 2 - c / 2 } : "top" == a ? { top: b.top - d, left: b.left + b.width / 2 - c / 2 } : "left" == a ? { top: b.top + b.height / 2 - d / 2, left: b.left - c } : { top: b.top + b.height / 2 - d / 2, left: b.left + b.width };
  }, c.prototype.getViewportAdjustedDelta = function (a, b, c, d) {
    var e = { top: 0, left: 0 };if (!this.$viewport) return e;var f = this.options.viewport && this.options.viewport.padding || 0,
        g = this.getPosition(this.$viewport);if (/right|left/.test(a)) {
      var h = b.top - f - g.scroll,
          i = b.top + f - g.scroll + d;h < g.top ? e.top = g.top - h : i > g.top + g.height && (e.top = g.top + g.height - i);
    } else {
      var j = b.left - f,
          k = b.left + f + c;j < g.left ? e.left = g.left - j : k > g.width && (e.left = g.left + g.width - k);
    }return e;
  }, c.prototype.getTitle = function () {
    var a,
        b = this.$element,
        c = this.options;return a = b.attr("data-original-title") || ("function" == typeof c.title ? c.title.call(b[0]) : c.title);
  }, c.prototype.getUID = function (a) {
    do a += ~ ~(1000000 * Math.random()); while (document.getElementById(a));return a;
  }, c.prototype.tip = function () {
    return this.$tip = this.$tip || a(this.options.template);
  }, c.prototype.arrow = function () {
    return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow");
  }, c.prototype.enable = function () {
    this.enabled = !0;
  }, c.prototype.disable = function () {
    this.enabled = !1;
  }, c.prototype.toggleEnabled = function () {
    this.enabled = !this.enabled;
  }, c.prototype.toggle = function (b) {
    var c = this;b && (c = a(b.currentTarget).data("bs." + this.type), c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c))), c.tip().hasClass("in") ? c.leave(c) : c.enter(c);
  }, c.prototype.destroy = function () {
    var a = this;clearTimeout(this.timeout), this.hide(function () {
      a.$element.off("." + a.type).removeData("bs." + a.type);
    });
  };var d = a.fn.tooltip;a.fn.tooltip = b, a.fn.tooltip.Constructor = c, a.fn.tooltip.noConflict = function () {
    return (a.fn.tooltip = d, this);
  };
})(jQuery), +(function (a) {
  "use strict";function b(b) {
    return this.each(function () {
      var d = a(this),
          e = d.data("bs.popover"),
          f = "object" == typeof b && b;(e || !/destroy|hide/.test(b)) && (e || d.data("bs.popover", e = new c(this, f)), "string" == typeof b && e[b]());
    });
  }var c = function c(a, b) {
    this.init("popover", a, b);
  };if (!a.fn.tooltip) throw new Error("Popover requires tooltip.js");c.VERSION = "3.3.4", c.DEFAULTS = a.extend({}, a.fn.tooltip.Constructor.DEFAULTS, { placement: "right", trigger: "click", content: "", template: "<div class=\"popover\" role=\"tooltip\"><div class=\"arrow\"></div><h3 class=\"popover-title\"></h3><div class=\"popover-content\"></div></div>" }), c.prototype = a.extend({}, a.fn.tooltip.Constructor.prototype), c.prototype.constructor = c, c.prototype.getDefaults = function () {
    return c.DEFAULTS;
  }, c.prototype.setContent = function () {
    var a = this.tip(),
        b = this.getTitle(),
        c = this.getContent();a.find(".popover-title")[this.options.html ? "html" : "text"](b), a.find(".popover-content").children().detach().end()[this.options.html ? "string" == typeof c ? "html" : "append" : "text"](c), a.removeClass("fade top bottom left right in"), a.find(".popover-title").html() || a.find(".popover-title").hide();
  }, c.prototype.hasContent = function () {
    return this.getTitle() || this.getContent();
  }, c.prototype.getContent = function () {
    var a = this.$element,
        b = this.options;return a.attr("data-content") || ("function" == typeof b.content ? b.content.call(a[0]) : b.content);
  }, c.prototype.arrow = function () {
    return this.$arrow = this.$arrow || this.tip().find(".arrow");
  };var d = a.fn.popover;a.fn.popover = b, a.fn.popover.Constructor = c, a.fn.popover.noConflict = function () {
    return (a.fn.popover = d, this);
  };
})(jQuery), +(function (a) {
  "use strict";function b(c, d) {
    this.$body = a(document.body), this.$scrollElement = a(a(c).is(document.body) ? window : c), this.options = a.extend({}, b.DEFAULTS, d), this.selector = (this.options.target || "") + " .nav li > a", this.offsets = [], this.targets = [], this.activeTarget = null, this.scrollHeight = 0, this.$scrollElement.on("scroll.bs.scrollspy", a.proxy(this.process, this)), this.refresh(), this.process();
  }function c(c) {
    return this.each(function () {
      var d = a(this),
          e = d.data("bs.scrollspy"),
          f = "object" == typeof c && c;e || d.data("bs.scrollspy", e = new b(this, f)), "string" == typeof c && e[c]();
    });
  }b.VERSION = "3.3.4", b.DEFAULTS = { offset: 10 }, b.prototype.getScrollHeight = function () {
    return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight);
  }, b.prototype.refresh = function () {
    var b = this,
        c = "offset",
        d = 0;this.offsets = [], this.targets = [], this.scrollHeight = this.getScrollHeight(), a.isWindow(this.$scrollElement[0]) || (c = "position", d = this.$scrollElement.scrollTop()), this.$body.find(this.selector).map(function () {
      var b = a(this),
          e = b.data("target") || b.attr("href"),
          f = /^#./.test(e) && a(e);return f && f.length && f.is(":visible") && [[f[c]().top + d, e]] || null;
    }).sort(function (a, b) {
      return a[0] - b[0];
    }).each(function () {
      b.offsets.push(this[0]), b.targets.push(this[1]);
    });
  }, b.prototype.process = function () {
    var a,
        b = this.$scrollElement.scrollTop() + this.options.offset,
        c = this.getScrollHeight(),
        d = this.options.offset + c - this.$scrollElement.height(),
        e = this.offsets,
        f = this.targets,
        g = this.activeTarget;if ((this.scrollHeight != c && this.refresh(), b >= d)) return g != (a = f[f.length - 1]) && this.activate(a);if (g && b < e[0]) return (this.activeTarget = null, this.clear());for (a = e.length; a--;) g != f[a] && b >= e[a] && (void 0 === e[a + 1] || b < e[a + 1]) && this.activate(f[a]);
  }, b.prototype.activate = function (b) {
    this.activeTarget = b, this.clear();var c = this.selector + "[data-target=\"" + b + "\"]," + this.selector + "[href=\"" + b + "\"]",
        d = a(c).parents("li").addClass("active");d.parent(".dropdown-menu").length && (d = d.closest("li.dropdown").addClass("active")), d.trigger("activate.bs.scrollspy");
  }, b.prototype.clear = function () {
    a(this.selector).parentsUntil(this.options.target, ".active").removeClass("active");
  };var d = a.fn.scrollspy;a.fn.scrollspy = c, a.fn.scrollspy.Constructor = b, a.fn.scrollspy.noConflict = function () {
    return (a.fn.scrollspy = d, this);
  }, a(window).on("load.bs.scrollspy.data-api", function () {
    a("[data-spy=\"scroll\"]").each(function () {
      var b = a(this);c.call(b, b.data());
    });
  });
})(jQuery), +(function (a) {
  "use strict";function b(b) {
    return this.each(function () {
      var d = a(this),
          e = d.data("bs.tab");e || d.data("bs.tab", e = new c(this)), "string" == typeof b && e[b]();
    });
  }var c = function c(b) {
    this.element = a(b);
  };c.VERSION = "3.3.4", c.TRANSITION_DURATION = 150, c.prototype.show = function () {
    var b = this.element,
        c = b.closest("ul:not(.dropdown-menu)"),
        d = b.data("target");if ((d || (d = b.attr("href"), d = d && d.replace(/.*(?=#[^\s]*$)/, "")), !b.parent("li").hasClass("active"))) {
      var e = c.find(".active:last a"),
          f = a.Event("hide.bs.tab", { relatedTarget: b[0] }),
          g = a.Event("show.bs.tab", { relatedTarget: e[0] });if ((e.trigger(f), b.trigger(g), !g.isDefaultPrevented() && !f.isDefaultPrevented())) {
        var h = a(d);this.activate(b.closest("li"), c), this.activate(h, h.parent(), function () {
          e.trigger({ type: "hidden.bs.tab", relatedTarget: b[0] }), b.trigger({ type: "shown.bs.tab", relatedTarget: e[0] });
        });
      }
    }
  }, c.prototype.activate = function (b, d, e) {
    function f() {
      g.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find("[data-toggle=\"tab\"]").attr("aria-expanded", !1), b.addClass("active").find("[data-toggle=\"tab\"]").attr("aria-expanded", !0), h ? (b[0].offsetWidth, b.addClass("in")) : b.removeClass("fade"), b.parent(".dropdown-menu").length && b.closest("li.dropdown").addClass("active").end().find("[data-toggle=\"tab\"]").attr("aria-expanded", !0), e && e();
    }var g = d.find("> .active"),
        h = e && a.support.transition && (g.length && g.hasClass("fade") || !!d.find("> .fade").length);g.length && h ? g.one("bsTransitionEnd", f).emulateTransitionEnd(c.TRANSITION_DURATION) : f(), g.removeClass("in");
  };var d = a.fn.tab;a.fn.tab = b, a.fn.tab.Constructor = c, a.fn.tab.noConflict = function () {
    return (a.fn.tab = d, this);
  };var e = function e(c) {
    c.preventDefault(), b.call(a(this), "show");
  };a(document).on("click.bs.tab.data-api", "[data-toggle=\"tab\"]", e).on("click.bs.tab.data-api", "[data-toggle=\"pill\"]", e);
})(jQuery), +(function (a) {
  "use strict";function b(b) {
    return this.each(function () {
      var d = a(this),
          e = d.data("bs.affix"),
          f = "object" == typeof b && b;e || d.data("bs.affix", e = new c(this, f)), "string" == typeof b && e[b]();
    });
  }var c = function c(b, d) {
    this.options = a.extend({}, c.DEFAULTS, d), this.$target = a(this.options.target).on("scroll.bs.affix.data-api", a.proxy(this.checkPosition, this)).on("click.bs.affix.data-api", a.proxy(this.checkPositionWithEventLoop, this)), this.$element = a(b), this.affixed = null, this.unpin = null, this.pinnedOffset = null, this.checkPosition();
  };c.VERSION = "3.3.4", c.RESET = "affix affix-top affix-bottom", c.DEFAULTS = { offset: 0, target: window }, c.prototype.getState = function (a, b, c, d) {
    var e = this.$target.scrollTop(),
        f = this.$element.offset(),
        g = this.$target.height();if (null != c && "top" == this.affixed) return c > e ? "top" : !1;if ("bottom" == this.affixed) return null != c ? e + this.unpin <= f.top ? !1 : "bottom" : a - d >= e + g ? !1 : "bottom";var h = null == this.affixed,
        i = h ? e : f.top,
        j = h ? g : b;return null != c && c >= e ? "top" : null != d && i + j >= a - d ? "bottom" : !1;
  }, c.prototype.getPinnedOffset = function () {
    if (this.pinnedOffset) return this.pinnedOffset;this.$element.removeClass(c.RESET).addClass("affix");var a = this.$target.scrollTop(),
        b = this.$element.offset();return this.pinnedOffset = b.top - a;
  }, c.prototype.checkPositionWithEventLoop = function () {
    setTimeout(a.proxy(this.checkPosition, this), 1);
  }, c.prototype.checkPosition = function () {
    if (this.$element.is(":visible")) {
      var b = this.$element.height(),
          d = this.options.offset,
          e = d.top,
          f = d.bottom,
          g = a(document.body).height();"object" != typeof d && (f = e = d), "function" == typeof e && (e = d.top(this.$element)), "function" == typeof f && (f = d.bottom(this.$element));var h = this.getState(g, b, e, f);if (this.affixed != h) {
        null != this.unpin && this.$element.css("top", "");var i = "affix" + (h ? "-" + h : ""),
            j = a.Event(i + ".bs.affix");if ((this.$element.trigger(j), j.isDefaultPrevented())) return;this.affixed = h, this.unpin = "bottom" == h ? this.getPinnedOffset() : null, this.$element.removeClass(c.RESET).addClass(i).trigger(i.replace("affix", "affixed") + ".bs.affix");
      }"bottom" == h && this.$element.offset({ top: g - b - f });
    }
  };var d = a.fn.affix;a.fn.affix = b, a.fn.affix.Constructor = c, a.fn.affix.noConflict = function () {
    return (a.fn.affix = d, this);
  }, a(window).on("load", function () {
    a("[data-spy=\"affix\"]").each(function () {
      var c = a(this),
          d = c.data();d.offset = d.offset || {}, null != d.offsetBottom && (d.offset.bottom = d.offsetBottom), null != d.offsetTop && (d.offset.top = d.offsetTop), b.call(c, d);
    });
  });
})(jQuery);
!(function (a, b, c, d) {
  function e(b, c) {
    b.owlCarousel = { name: "Owl Carousel", author: "Bartosz Wojciechowski", version: "2.0.0-beta.2.1" }, this.settings = null, this.options = a.extend({}, e.Defaults, c), this.itemData = a.extend({}, l), this.dom = a.extend({}, m), this.width = a.extend({}, n), this.num = a.extend({}, o), this.drag = a.extend({}, q), this.state = a.extend({}, r), this.e = a.extend({}, s), this.plugins = {}, this._supress = {}, this._current = null, this._speed = null, this._coordinates = null, this.dom.el = b, this.dom.$el = a(b);for (var d in e.Plugins) this.plugins[d[0].toLowerCase() + d.slice(1)] = new e.Plugins[d](this);this.init();
  }function f(a) {
    var b,
        d,
        e = c.createElement("div"),
        f = a;for (b in f) if ((d = f[b], "undefined" != typeof e.style[d])) return (e = null, [d, b]);return [!1];
  }function g() {
    return f(["transition", "WebkitTransition", "MozTransition", "OTransition"])[1];
  }function h() {
    return f(["transform", "WebkitTransform", "MozTransform", "OTransform", "msTransform"])[0];
  }function i() {
    return f(["perspective", "webkitPerspective", "MozPerspective", "OPerspective", "MsPerspective"])[0];
  }function j() {
    return "ontouchstart" in b || !!navigator.msMaxTouchPoints;
  }function k() {
    return b.navigator.msPointerEnabled;
  }var l, m, n, o, p, q, r, s;l = { index: !1, indexAbs: !1, posLeft: !1, clone: !1, active: !1, loaded: !1, lazyLoad: !1, current: !1, width: !1, center: !1, page: !1, hasVideo: !1, playVideo: !1 }, m = { el: null, $el: null, stage: null, $stage: null, oStage: null, $oStage: null, $items: null, $oItems: null, $cItems: null, $content: null }, n = { el: 0, stage: 0, item: 0, prevWindow: 0, cloneLast: 0 }, o = { items: 0, oItems: 0, cItems: 0, active: 0, merged: [] }, q = { start: 0, startX: 0, startY: 0, current: 0, currentX: 0, currentY: 0, offsetX: 0, offsetY: 0, distance: null, startTime: 0, endTime: 0, updatedX: 0, targetEl: null }, r = { isTouch: !1, isScrolling: !1, isSwiping: !1, direction: !1, inMotion: !1 }, s = { _onDragStart: null, _onDragMove: null, _onDragEnd: null, _transitionEnd: null, _resizer: null, _responsiveCall: null, _goToLoop: null, _checkVisibile: null }, e.Defaults = { items: 3, loop: !1, center: !1, mouseDrag: !0, touchDrag: !0, pullDrag: !0, freeDrag: !1, margin: 0, stagePadding: 0, merge: !1, mergeFit: !0, autoWidth: !1, startPosition: 0, smartSpeed: 250, fluidSpeed: !1, dragEndSpeed: !1, responsive: {}, responsiveRefreshRate: 200, responsiveBaseElement: b, responsiveClass: !1, fallbackEasing: "swing", info: !1, nestedItemSelector: !1, itemElement: "div", stageElement: "div", themeClass: "owl-theme", baseClass: "owl-carousel", itemClass: "owl-item", centerClass: "center", activeClass: "active" }, e.Plugins = {}, e.prototype.init = function () {
    if ((this.setResponsiveOptions(), this.trigger("initialize"), this.dom.$el.hasClass(this.settings.baseClass) || this.dom.$el.addClass(this.settings.baseClass), this.dom.$el.hasClass(this.settings.themeClass) || this.dom.$el.addClass(this.settings.themeClass), this.settings.rtl && this.dom.$el.addClass("owl-rtl"), this.browserSupport(), this.settings.autoWidth && this.state.imagesLoaded !== !0)) {
      var a, b, c;if ((a = this.dom.$el.find("img"), b = this.settings.nestedItemSelector ? "." + this.settings.nestedItemSelector : d, c = this.dom.$el.children(b).width(), a.length && 0 >= c)) return (this.preloadAutoWidthImages(a), !1);
    }this.width.prevWindow = this.viewport(), this.createStage(), this.fetchContent(), this.eventsCall(), this.internalEvents(), this.dom.$el.addClass("owl-loading"), this.refresh(!0), this.dom.$el.removeClass("owl-loading").addClass("owl-loaded"), this.trigger("initialized"), this.addTriggerableEvents();
  }, e.prototype.setResponsiveOptions = function () {
    if (this.options.responsive) {
      var b = this.viewport(),
          c = this.options.responsive,
          d = -1;a.each(c, function (a) {
        b >= a && a > d && (d = Number(a));
      }), this.settings = a.extend({}, this.options, c[d]), delete this.settings.responsive, this.settings.responsiveClass && this.dom.$el.attr("class", function (a, b) {
        return b.replace(/\b owl-responsive-\S+/g, "");
      }).addClass("owl-responsive-" + d);
    } else this.settings = a.extend({}, this.options);
  }, e.prototype.optionsLogic = function () {
    this.dom.$el.toggleClass("owl-center", this.settings.center), this.settings.loop && this.num.oItems < this.settings.items && (this.settings.loop = !1), this.settings.autoWidth && (this.settings.stagePadding = !1, this.settings.merge = !1);
  }, e.prototype.createStage = function () {
    var b = c.createElement("div"),
        d = c.createElement(this.settings.stageElement);b.className = "owl-stage-outer", d.className = "owl-stage", b.appendChild(d), this.dom.el.appendChild(b), this.dom.oStage = b, this.dom.$oStage = a(b), this.dom.stage = d, this.dom.$stage = a(d), b = null, d = null;
  }, e.prototype.createItemContainer = function () {
    var b = c.createElement(this.settings.itemElement);return (b.className = this.settings.itemClass, a(b));
  }, e.prototype.fetchContent = function (b) {
    this.dom.$content = b ? b instanceof jQuery ? b : a(b) : this.settings.nestedItemSelector ? this.dom.$el.find("." + this.settings.nestedItemSelector).not(".owl-stage-outer") : this.dom.$el.children().not(".owl-stage-outer"), this.num.oItems = this.dom.$content.length, 0 !== this.num.oItems && this.initStructure();
  }, e.prototype.initStructure = function () {
    this.createNormalStructure();
  }, e.prototype.createNormalStructure = function () {
    var a, b;for (a = 0; a < this.num.oItems; a++) b = this.createItemContainer(), this.initializeItemContainer(b, this.dom.$content[a]), this.dom.$stage.append(b);this.dom.$content = null;
  }, e.prototype.createCustomStructure = function (a) {
    var b, c;for (b = 0; a > b; b++) c = this.createItemContainer(), this.createItemContainerData(c), this.dom.$stage.append(c);
  }, e.prototype.initializeItemContainer = function (a, b) {
    this.trigger("change", { property: { name: "item", value: a } }), this.createItemContainerData(a), a.append(b), this.trigger("changed", { property: { name: "item", value: a } });
  }, e.prototype.createItemContainerData = function (b, c) {
    var d = a.extend({}, this.itemData);c && a.extend(d, c.data("owl-item")), b.data("owl-item", d);
  }, e.prototype.cloneItemContainer = function (a) {
    var b = a.clone(!0, !0).addClass("cloned");return (this.createItemContainerData(b, b), b.data("owl-item").clone = !0, b);
  }, e.prototype.updateLocalContent = function () {
    var b, c;for (this.dom.$oItems = this.dom.$stage.find("." + this.settings.itemClass).filter(function () {
      return a(this).data("owl-item").clone === !1;
    }), this.num.oItems = this.dom.$oItems.length, b = 0; b < this.num.oItems; b++) c = this.dom.$oItems.eq(b), c.data("owl-item").index = b;
  }, e.prototype.loopClone = function () {
    if (!this.settings.loop || this.num.oItems < this.settings.items) return !1;var b,
        c,
        d,
        e = this.settings.items,
        f = this.num.oItems - 1;for (this.settings.stagePadding && 1 === this.settings.items && (e += 1), this.num.cItems = 2 * e, d = 0; e > d; d++) b = this.cloneItemContainer(this.dom.$oItems.eq(d)), c = this.cloneItemContainer(this.dom.$oItems.eq(f - d)), this.dom.$stage.append(b), this.dom.$stage.prepend(c);this.dom.$cItems = this.dom.$stage.find("." + this.settings.itemClass).filter(function () {
      return a(this).data("owl-item").clone === !0;
    });
  }, e.prototype.reClone = function () {
    null !== this.dom.$cItems && (this.dom.$cItems.remove(), this.dom.$cItems = null, this.num.cItems = 0), this.settings.loop && this.loopClone();
  }, e.prototype.calculate = function () {
    var a,
        b,
        c,
        d,
        e,
        f,
        g,
        h = 0,
        i = 0;for (this.width.el = this.dom.$el.width() - 2 * this.settings.stagePadding, this.width.view = this.dom.$el.width(), c = this.width.el - this.settings.margin * (1 === this.settings.items ? 0 : this.settings.items - 1), this.width.el = this.width.el + this.settings.margin, this.width.item = (c / this.settings.items + this.settings.margin).toFixed(3), this.dom.$items = this.dom.$stage.find(".owl-item"), this.num.items = this.dom.$items.length, this.settings.autoWidth && this.dom.$items.css("width", ""), this._coordinates = [], this.num.merged = [], d = this.settings.rtl ? this.settings.center ? -(this.width.el / 2) : 0 : this.settings.center ? this.width.el / 2 : 0, this.width.mergeStage = 0, a = 0; a < this.num.items; a++) this.settings.merge ? (g = this.dom.$items.eq(a).find("[data-merge]").attr("data-merge") || 1, this.settings.mergeFit && g > this.settings.items && (g = this.settings.items), this.num.merged.push(parseInt(g)), this.width.mergeStage += this.width.item * this.num.merged[a]) : this.num.merged.push(1), f = this.width.item * this.num.merged[a], this.settings.autoWidth && (f = this.dom.$items.eq(a).width() + this.settings.margin, this.settings.rtl ? this.dom.$items[a].style.marginLeft = this.settings.margin + "px" : this.dom.$items[a].style.marginRight = this.settings.margin + "px"), this._coordinates.push(d), this.dom.$items.eq(a).data("owl-item").posLeft = h, this.dom.$items.eq(a).data("owl-item").width = f, this.settings.rtl ? (d += f, h += f) : (d -= f, h -= f), i -= Math.abs(f), this.settings.center && (this._coordinates[a] = this.settings.rtl ? this._coordinates[a] + f / 2 : this._coordinates[a] - f / 2);for (this.width.stage = Math.abs(this.settings.autoWidth ? this.settings.center ? i : d : i), e = this.num.oItems + this.num.cItems, b = 0; e > b; b++) this.dom.$items.eq(b).data("owl-item").indexAbs = b;this.setSizes();
  }, e.prototype.setSizes = function () {
    this.settings.stagePadding !== !1 && (this.dom.oStage.style.paddingLeft = this.settings.stagePadding + "px", this.dom.oStage.style.paddingRight = this.settings.stagePadding + "px"), this.settings.rtl ? b.setTimeout(a.proxy(function () {
      this.dom.stage.style.width = this.width.stage + "px";
    }, this), 0) : this.dom.stage.style.width = this.width.stage + "px";for (var c = 0; c < this.num.items; c++) this.settings.autoWidth || (this.dom.$items[c].style.width = this.width.item - this.settings.margin + "px"), this.settings.rtl ? this.dom.$items[c].style.marginLeft = this.settings.margin + "px" : this.dom.$items[c].style.marginRight = this.settings.margin + "px", 1 === this.num.merged[c] || this.settings.autoWidth || (this.dom.$items[c].style.width = this.width.item * this.num.merged[c] - this.settings.margin + "px");this.width.stagePrev = this.width.stage;
  }, e.prototype.responsive = function () {
    if (!this.num.oItems) return !1;var a = this.isElWidthChanged();return a ? this.trigger("resize").isDefaultPrevented() ? !1 : (this.state.responsive = !0, this.refresh(), this.state.responsive = !1, void this.trigger("resized")) : !1;
  }, e.prototype.refresh = function () {
    var a = this.dom.$oItems && this.dom.$oItems.eq(this.normalize(this.current(), !0));return (this.trigger("refresh"), this.setResponsiveOptions(), this.updateLocalContent(), this.optionsLogic(), 0 === this.num.oItems ? !1 : (this.dom.$stage.addClass("owl-refresh"), this.reClone(), this.calculate(), this.dom.$stage.removeClass("owl-refresh"), a ? this.reset(a.data("owl-item").indexAbs) : (this.dom.oStage.scrollLeft = 0, this.reset(this.dom.$oItems.eq(0).data("owl-item").indexAbs)), this.state.orientation = b.orientation, this.watchVisibility(), void this.trigger("refreshed")));
  }, e.prototype.updateActiveItems = function () {
    this.trigger("change", { property: { name: "items", value: this.dom.$items } });var a, b, c, d, e, f;for (a = 0; a < this.num.items; a++) this.dom.$items.eq(a).data("owl-item").active = !1, this.dom.$items.eq(a).data("owl-item").current = !1, this.dom.$items.eq(a).removeClass(this.settings.activeClass).removeClass(this.settings.centerClass);for (this.num.active = 0, padding = 2 * this.settings.stagePadding, stageX = this.coordinates(this.current()) + padding, view = this.settings.rtl ? this.width.view : -this.width.view, b = 0; b < this.num.items; b++) c = this.dom.$items.eq(b), d = c.data("owl-item").posLeft, e = c.data("owl-item").width, f = this.settings.rtl ? d - e - padding : d - e + padding, (this.op(d, "<=", stageX) && this.op(d, ">", stageX + view) || this.op(f, "<", stageX) && this.op(f, ">", stageX + view)) && (this.num.active++, c.data("owl-item").active = !0, c.data("owl-item").current = !0, c.addClass(this.settings.activeClass), this.settings.lazyLoad || (c.data("owl-item").loaded = !0), this.settings.loop && this.updateClonedItemsState(c.data("owl-item").index));this.settings.center && (this.dom.$items.eq(this.current()).addClass(this.settings.centerClass).data("owl-item").center = !0), this.trigger("changed", { property: { name: "items", value: this.dom.$items } });
  }, e.prototype.updateClonedItemsState = function (a) {
    var b, c, d;for (this.settings.center && (b = this.dom.$items.eq(this.current()).data("owl-item").index), d = 0; d < this.num.items; d++) c = this.dom.$items.eq(d), c.data("owl-item").index === a && (c.data("owl-item").current = !0, c.data("owl-item").index === b && c.addClass(this.settings.centerClass));
  }, e.prototype.eventsCall = function () {
    this.e._onDragStart = a.proxy(function (a) {
      this.onDragStart(a);
    }, this), this.e._onDragMove = a.proxy(function (a) {
      this.onDragMove(a);
    }, this), this.e._onDragEnd = a.proxy(function (a) {
      this.onDragEnd(a);
    }, this), this.e._transitionEnd = a.proxy(function (a) {
      this.transitionEnd(a);
    }, this), this.e._resizer = a.proxy(function () {
      this.responsiveTimer();
    }, this), this.e._responsiveCall = a.proxy(function () {
      this.responsive();
    }, this), this.e._preventClick = a.proxy(function (a) {
      this.preventClick(a);
    }, this);
  }, e.prototype.responsiveTimer = function () {
    return this.viewport() === this.width.prevWindow ? !1 : (b.clearTimeout(this.resizeTimer), this.resizeTimer = b.setTimeout(this.e._responsiveCall, this.settings.responsiveRefreshRate), void (this.width.prevWindow = this.viewport()));
  }, e.prototype.internalEvents = function () {
    var a = j(),
        d = k();this.dragType = a && !d ? ["touchstart", "touchmove", "touchend", "touchcancel"] : a && d ? ["MSPointerDown", "MSPointerMove", "MSPointerUp", "MSPointerCancel"] : ["mousedown", "mousemove", "mouseup"], (a || d) && this.settings.touchDrag ? this.on(c, this.dragType[3], this.e._onDragEnd) : (this.dom.$stage.on("dragstart", function () {
      return !1;
    }), this.settings.mouseDrag ? this.dom.stage.onselectstart = function () {
      return !1;
    } : this.dom.$el.addClass("owl-text-select-on")), this.transitionEndVendor && this.on(this.dom.stage, this.transitionEndVendor, this.e._transitionEnd, !1), this.settings.responsive !== !1 && this.on(b, "resize", this.e._resizer, !1), this.dragEvents();
  }, e.prototype.dragEvents = function () {
    !this.settings.touchDrag || "touchstart" !== this.dragType[0] && "MSPointerDown" !== this.dragType[0] ? this.settings.mouseDrag && "mousedown" === this.dragType[0] ? this.on(this.dom.stage, this.dragType[0], this.e._onDragStart, !1) : this.off(this.dom.stage, this.dragType[0], this.e._onDragStart) : this.on(this.dom.stage, this.dragType[0], this.e._onDragStart, !1);
  }, e.prototype.onDragStart = function (a) {
    var d, e, f, g, h;if ((d = a.originalEvent || a || b.event, 3 === d.which)) return !1;if (("mousedown" === this.dragType[0] && this.dom.$stage.addClass("owl-grab"), this.trigger("drag"), this.drag.startTime = new Date().getTime(), this.speed(0), this.state.isTouch = !0, this.state.isScrolling = !1, this.state.isSwiping = !1, this.drag.distance = 0, e = "touchstart" === d.type, f = e ? a.targetTouches[0].pageX : d.pageX || d.clientX, g = e ? a.targetTouches[0].pageY : d.pageY || d.clientY, this.drag.offsetX = this.dom.$stage.position().left - this.settings.stagePadding, this.drag.offsetY = this.dom.$stage.position().top, this.settings.rtl && (this.drag.offsetX = this.dom.$stage.position().left + this.width.stage - this.width.el + this.settings.margin), this.state.inMotion && this.support3d)) h = this.getTransformProperty(), this.drag.offsetX = h, this.animate(h), this.state.inMotion = !0;else if (this.state.inMotion && !this.support3d) return (this.state.inMotion = !1, !1);this.drag.startX = f - this.drag.offsetX, this.drag.startY = g - this.drag.offsetY, this.drag.start = f - this.drag.startX, this.drag.targetEl = d.target || d.srcElement, this.drag.updatedX = this.drag.start, ("IMG" === this.drag.targetEl.tagName || "A" === this.drag.targetEl.tagName) && (this.drag.targetEl.draggable = !1), this.on(c, this.dragType[1], this.e._onDragMove, !1), this.on(c, this.dragType[2], this.e._onDragEnd, !1);
  }, e.prototype.onDragMove = function (a) {
    var c, e, f, g, h, i, j;this.state.isTouch && (this.state.isScrolling || (c = a.originalEvent || a || b.event, e = "touchmove" == c.type, f = e ? c.targetTouches[0].pageX : c.pageX || c.clientX, g = e ? c.targetTouches[0].pageY : c.pageY || c.clientY, this.drag.currentX = f - this.drag.startX, this.drag.currentY = g - this.drag.startY, this.drag.distance = this.drag.currentX - this.drag.offsetX, this.drag.distance < 0 ? this.state.direction = this.settings.rtl ? "right" : "left" : this.drag.distance > 0 && (this.state.direction = this.settings.rtl ? "left" : "right"), this.settings.loop ? this.op(this.drag.currentX, ">", this.coordinates(this.minimum())) && "right" === this.state.direction ? this.drag.currentX -= (this.settings.center && this.coordinates(0)) - this.coordinates(this.num.oItems) : this.op(this.drag.currentX, "<", this.coordinates(this.maximum())) && "left" === this.state.direction && (this.drag.currentX += (this.settings.center && this.coordinates(0)) - this.coordinates(this.num.oItems)) : (h = this.coordinates(this.settings.rtl ? this.maximum() : this.minimum()), i = this.coordinates(this.settings.rtl ? this.minimum() : this.maximum()), j = this.settings.pullDrag ? this.drag.distance / 5 : 0, this.drag.currentX = Math.max(Math.min(this.drag.currentX, h + j), i + j)), (this.drag.distance > 8 || this.drag.distance < -8) && (c.preventDefault !== d ? c.preventDefault() : c.returnValue = !1, this.state.isSwiping = !0), this.drag.updatedX = this.drag.currentX, (this.drag.currentY > 16 || this.drag.currentY < -16) && this.state.isSwiping === !1 && (this.state.isScrolling = !0, this.drag.updatedX = this.drag.start), this.animate(this.drag.updatedX)));
  }, e.prototype.onDragEnd = function () {
    var a, b, d;if (this.state.isTouch) {
      if (("mousedown" === this.dragType[0] && this.dom.$stage.removeClass("owl-grab"), this.trigger("dragged"), this.drag.targetEl.removeAttribute("draggable"), this.state.isTouch = !1, this.state.isScrolling = !1, this.state.isSwiping = !1, 0 === this.drag.distance && this.state.inMotion !== !0)) return (this.state.inMotion = !1, !1);this.drag.endTime = new Date().getTime(), a = this.drag.endTime - this.drag.startTime, b = Math.abs(this.drag.distance), (b > 3 || a > 300) && this.removeClick(this.drag.targetEl), d = this.closest(this.drag.updatedX), this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed), this.current(d), this.settings.pullDrag || this.drag.updatedX !== this.coordinates(d) || this.transitionEnd(), this.drag.distance = 0, this.off(c, this.dragType[1], this.e._onDragMove), this.off(c, this.dragType[2], this.e._onDragEnd);
    }
  }, e.prototype.removeClick = function (c) {
    this.drag.targetEl = c, a(c).on("click.preventClick", this.e._preventClick), b.setTimeout(function () {
      a(c).off("click.preventClick");
    }, 300);
  }, e.prototype.preventClick = function (b) {
    b.preventDefault ? b.preventDefault() : b.returnValue = !1, b.stopPropagation && b.stopPropagation(), a(b.target).off("click.preventClick");
  }, e.prototype.getTransformProperty = function () {
    var a, c;return (a = b.getComputedStyle(this.dom.stage, null).getPropertyValue(this.vendorName + "transform"), a = a.replace(/matrix(3d)?\(|\)/g, "").split(","), c = 16 === a.length, c !== !0 ? a[4] : a[12]);
  }, e.prototype.closest = function (b) {
    var c = 0,
        d = 30;return (this.settings.freeDrag || a.each(this.coordinates(), a.proxy(function (a, e) {
      b > e - d && e + d > b ? c = a : this.op(b, "<", e) && this.op(b, ">", this.coordinates(a + 1) || e - this.width.el) && (c = "left" === this.state.direction ? a + 1 : a);
    }, this)), this.settings.loop || (this.op(b, ">", this.coordinates(this.minimum())) ? c = b = this.minimum() : this.op(b, "<", this.coordinates(this.maximum())) && (c = b = this.maximum())), c);
  }, e.prototype.animate = function (b) {
    this.trigger("translate"), this.state.inMotion = this.speed() > 0, this.support3d ? this.dom.$stage.css({ transform: "translate3d(" + b + "px,0px, 0px)", transition: this.speed() / 1000 + "s" }) : this.state.isTouch ? this.dom.$stage.css({ left: b + "px" }) : this.dom.$stage.animate({ left: b }, this.speed() / 1000, this.settings.fallbackEasing, a.proxy(function () {
      this.state.inMotion && this.transitionEnd();
    }, this));
  }, e.prototype.current = function (a) {
    if (a === d) return this._current;if (0 === this.num.oItems) return d;if ((a = this.normalize(a), this._current === a)) this.animate(this.coordinates(this._current));else {
      var b = this.trigger("change", { property: { name: "position", value: a } });b.data !== d && (a = this.normalize(b.data)), this._current = a, this.animate(this.coordinates(this._current)), this.updateActiveItems(), this.trigger("changed", { property: { name: "position", value: this._current } });
    }return this._current;
  }, e.prototype.reset = function (a) {
    this.suppress(["change", "changed"]), this.speed(0), this.current(a), this.release(["change", "changed"]);
  }, e.prototype.normalize = function (a, b) {
    if (a === d || !this.dom.$items) return d;if (this.settings.loop) {
      var c = this.dom.$items.length;a = (a % c + c) % c;
    } else a = Math.max(this.minimum(), Math.min(this.maximum(), a));return b ? this.dom.$items.eq(a).data("owl-item").index : a;
  }, e.prototype.maximum = function () {
    var b,
        c,
        d = this.settings;if (!d.loop && d.center) b = this.num.oItems - 1;else if (d.loop || d.center) if (d.loop || d.center) b = this.num.oItems + d.items;else {
      if (!d.autoWidth && !d.merge) throw "Can not detect maximum absolute position.";revert = d.rtl ? 1 : -1, c = this.dom.$stage.width() - this.$el.width(), a.each(this.coordinates(), function (a, d) {
        return d * revert >= c ? !1 : void (b = a + 1);
      });
    } else b = this.num.oItems - d.items;return b;
  }, e.prototype.minimum = function () {
    return this.dom.$oItems.eq(0).data("owl-item").indexAbs;
  }, e.prototype.speed = function (a) {
    return (a !== d && (this._speed = a), this._speed);
  }, e.prototype.coordinates = function (a) {
    return a !== d ? this._coordinates[a] : this._coordinates;
  }, e.prototype.duration = function (a, b, c) {
    return Math.min(Math.max(Math.abs(b - a), 1), 6) * Math.abs(c || this.settings.smartSpeed);
  }, e.prototype.to = function (c, d) {
    if (this.settings.loop) {
      var e = c - this.normalize(this.current(), !0),
          f = this.current(),
          g = this.current(),
          h = this.current() + e,
          i = 0 > g - h ? !0 : !1;h < this.settings.items && i === !1 ? (f = this.num.items - (this.settings.items - g) - this.settings.items, this.reset(f)) : h >= this.num.items - this.settings.items && i === !0 && (f = g - this.num.oItems, this.reset(f)), b.clearTimeout(this.e._goToLoop), this.e._goToLoop = b.setTimeout(a.proxy(function () {
        this.speed(this.duration(this.current(), f + e, d)), this.current(f + e);
      }, this), 30);
    } else this.speed(this.duration(this.current(), c, d)), this.current(c);
  }, e.prototype.next = function (a) {
    a = a || !1, this.to(this.normalize(this.current(), !0) + 1, a);
  }, e.prototype.prev = function (a) {
    a = a || !1, this.to(this.normalize(this.current(), !0) - 1, a);
  }, e.prototype.transitionEnd = function (a) {
    if (a !== d) {
      a.stopPropagation();var b = a.target || a.srcElement || a.originalTarget;if (b !== this.dom.stage) return !1;
    }this.state.inMotion = !1, this.trigger("translated");
  }, e.prototype.isElWidthChanged = function () {
    var a = this.dom.$el.width() - this.settings.stagePadding,
        b = this.width.el + this.settings.margin;return a !== b;
  }, e.prototype.viewport = function () {
    var d;if (this.options.responsiveBaseElement !== b) d = a(this.options.responsiveBaseElement).width();else if (b.innerWidth) d = b.innerWidth;else {
      if (!c.documentElement || !c.documentElement.clientWidth) throw "Can not detect viewport width.";d = c.documentElement.clientWidth;
    }return d;
  }, e.prototype.insertContent = function (a) {
    this.dom.$stage.empty(), this.fetchContent(a), this.refresh();
  }, e.prototype.addItem = function (a, b) {
    var c = this.createItemContainer();b = b || 0, this.initializeItemContainer(c, a), 0 === this.dom.$oItems.length ? this.dom.$stage.append(c) : -1 !== p ? this.dom.$oItems.eq(b).before(c) : this.dom.$oItems.eq(b).after(c), this.refresh();
  }, e.prototype.removeItem = function (a) {
    this.dom.$oItems.eq(a).remove(), this.refresh();
  }, e.prototype.addTriggerableEvents = function () {
    var b = a.proxy(function (b, c) {
      return a.proxy(function (a) {
        a.relatedTarget !== this && (this.suppress([c]), b.apply(this, [].slice.call(arguments, 1)), this.release([c]));
      }, this);
    }, this);a.each({ next: this.next, prev: this.prev, to: this.to, destroy: this.destroy, refresh: this.refresh, replace: this.insertContent, add: this.addItem, remove: this.removeItem }, a.proxy(function (a, c) {
      this.dom.$el.on(a + ".owl.carousel", b(c, a + ".owl.carousel"));
    }, this));
  }, e.prototype.watchVisibility = function () {
    function c(a) {
      return a.offsetWidth > 0 && a.offsetHeight > 0;
    }function d() {
      c(this.dom.el) && (this.dom.$el.removeClass("owl-hidden"), this.refresh(), b.clearInterval(this.e._checkVisibile));
    }c(this.dom.el) || (this.dom.$el.addClass("owl-hidden"), b.clearInterval(this.e._checkVisibile), this.e._checkVisibile = b.setInterval(a.proxy(d, this), 500));
  }, e.prototype.preloadAutoWidthImages = function (b) {
    var c, d, e, f;c = 0, d = this, b.each(function (g, h) {
      e = a(h), f = new Image(), f.onload = function () {
        c++, e.attr("src", f.src), e.css("opacity", 1), c >= b.length && (d.state.imagesLoaded = !0, d.init());
      }, f.src = e.attr("src") || e.attr("data-src") || e.attr("data-src-retina");
    });
  }, e.prototype.destroy = function () {
    this.dom.$el.hasClass(this.settings.themeClass) && this.dom.$el.removeClass(this.settings.themeClass), this.settings.responsive !== !1 && this.off(b, "resize", this.e._resizer), this.transitionEndVendor && this.off(this.dom.stage, this.transitionEndVendor, this.e._transitionEnd);for (var a in this.plugins) this.plugins[a].destroy();(this.settings.mouseDrag || this.settings.touchDrag) && (this.off(this.dom.stage, this.dragType[0], this.e._onDragStart), this.settings.mouseDrag && this.off(c, this.dragType[3], this.e._onDragStart), this.settings.mouseDrag && (this.dom.$stage.off("dragstart", function () {
      return !1;
    }), this.dom.stage.onselectstart = function () {})), this.dom.$el.off(".owl"), null !== this.dom.$cItems && this.dom.$cItems.remove(), this.e = null, this.dom.$el.data("owlCarousel", null), delete this.dom.el.owlCarousel, this.dom.$stage.unwrap(), this.dom.$items.unwrap(), this.dom.$items.contents().unwrap(), this.dom = null;
  }, e.prototype.op = function (a, b, c) {
    var d = this.settings.rtl;switch (b) {case "<":
        return d ? a > c : c > a;case ">":
        return d ? c > a : a > c;case ">=":
        return d ? c >= a : a >= c;case "<=":
        return d ? a >= c : c >= a;}
  }, e.prototype.on = function (a, b, c, d) {
    a.addEventListener ? a.addEventListener(b, c, d) : a.attachEvent && a.attachEvent("on" + b, c);
  }, e.prototype.off = function (a, b, c, d) {
    a.removeEventListener ? a.removeEventListener(b, c, d) : a.detachEvent && a.detachEvent("on" + b, c);
  }, e.prototype.trigger = function (b, c, d) {
    var e = { item: { count: this.num.oItems, index: this.current() } },
        f = a.camelCase(a.grep(["on", b, d], function (a) {
      return a;
    }).join("-").toLowerCase()),
        g = a.Event([b, "owl", d || "carousel"].join(".").toLowerCase(), a.extend({ relatedTarget: this }, e, c));return (this._supress[g.type] || (a.each(this.plugins, function (a, b) {
      b.onTrigger && b.onTrigger(g);
    }), this.dom.$el.trigger(g), "function" == typeof this.settings[f] && this.settings[f].apply(this, g)), g);
  }, e.prototype.suppress = function (b) {
    a.each(b, a.proxy(function (a, b) {
      this._supress[b] = !0;
    }, this));
  }, e.prototype.release = function (b) {
    a.each(b, a.proxy(function (a, b) {
      delete this._supress[b];
    }, this));
  }, e.prototype.browserSupport = function () {
    if ((this.support3d = i(), this.support3d)) {
      this.transformVendor = h();var a = ["transitionend", "webkitTransitionEnd", "transitionend", "oTransitionEnd"];this.transitionEndVendor = a[g()], this.vendorName = this.transformVendor.replace(/Transform/i, ""), this.vendorName = "" !== this.vendorName ? "-" + this.vendorName.toLowerCase() + "-" : "";
    }this.state.orientation = b.orientation;
  }, a.fn.owlCarousel = function (b) {
    return this.each(function () {
      a(this).data("owlCarousel") || a(this).data("owlCarousel", new e(this, b));
    });
  }, a.fn.owlCarousel.Constructor = e;
})(window.Zepto || window.jQuery, window, document), (function (a, b) {
  LazyLoad = function (b) {
    this.owl = b, this.owl.options = a.extend({}, LazyLoad.Defaults, this.owl.options), this.handlers = { "changed.owl.carousel": a.proxy(function (a) {
        "items" == a.property.name && a.property.value && !a.property.value.is(":empty") && this.check();
      }, this) }, this.owl.dom.$el.on(this.handlers);
  }, LazyLoad.Defaults = { lazyLoad: !1 }, LazyLoad.prototype.check = function () {
    var a,
        c,
        d,
        e,
        f = b.devicePixelRatio > 1 ? "data-src-retina" : "data-src";for (d = 0; d < this.owl.num.items; d++) e = this.owl.dom.$items.eq(d), e.data("owl-item").current === !0 && e.data("owl-item").loaded === !1 && (c = e.find(".owl-lazy"), a = c.attr(f), a = a || c.attr("data-src"), a && (c.css("opacity", "0"), this.preload(c, e)));
  }, LazyLoad.prototype.preload = function (c, d) {
    var e, f, g;c.each(a.proxy(function (c, h) {
      this.owl.trigger("load", null, "lazy"), e = a(h), f = new Image(), g = e.attr(b.devicePixelRatio > 1 ? "data-src-retina" : "data-src"), g = g || e.attr("data-src"), f.onload = a.proxy(function () {
        d.data("owl-item").loaded = !0, e.is("img") ? e.attr("src", f.src) : e.css("background-image", "url(" + f.src + ")"), e.css("opacity", 1), this.owl.trigger("loaded", null, "lazy");
      }, this), f.src = g;
    }, this));
  }, LazyLoad.prototype.destroy = function () {
    var a, b;for (a in this.handlers) this.owl.dom.$el.off(a, this.handlers[a]);for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null);
  }, a.fn.owlCarousel.Constructor.Plugins.lazyLoad = LazyLoad;
})(window.Zepto || window.jQuery, window, document), (function (a, b) {
  AutoHeight = function (b) {
    this.owl = b, this.owl.options = a.extend({}, AutoHeight.Defaults, this.owl.options), this.handlers = { "changed.owl.carousel": a.proxy(function (a) {
        "position" == a.property.name && this.owl.settings.autoHeight && this.setHeight();
      }, this) }, this.owl.dom.$el.on(this.handlers);
  }, AutoHeight.Defaults = { autoHeight: !1, autoHeightClass: "owl-height" }, AutoHeight.prototype.setHeight = function () {
    var a,
        c = this.owl.dom.$items.eq(this.owl.current()),
        d = this.owl.dom.$oStage,
        e = 0;this.owl.dom.$oStage.hasClass(this.owl.settings.autoHeightClass) || this.owl.dom.$oStage.addClass(this.owl.settings.autoHeightClass), a = b.setInterval(function () {
      e += 1, c.data("owl-item").loaded ? (d.height(c.height() + "px"), clearInterval(a)) : 500 === e && clearInterval(a);
    }, 100);
  }, AutoHeight.prototype.destroy = function () {
    var a, b;for (a in this.handlers) this.owl.dom.$el.off(a, this.handlers[a]);for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null);
  }, a.fn.owlCarousel.Constructor.Plugins.autoHeight = AutoHeight;
})(window.Zepto || window.jQuery, window, document), (function (a, b, c) {
  Video = function (b) {
    this.owl = b, this.owl.options = a.extend({}, Video.Defaults, this.owl.options), this.handlers = { "resize.owl.carousel": a.proxy(function (a) {
        this.owl.settings.video && !this.isInFullScreen() && a.preventDefault();
      }, this), "refresh.owl.carousel changed.owl.carousel": a.proxy(function () {
        this.owl.state.videoPlay && this.stopVideo();
      }, this), "refresh.owl.carousel refreshed.owl.carousel": a.proxy(function (a) {
        return this.owl.settings.video ? void (this.refreshing = "refresh" == a.type) : !1;
      }, this), "changed.owl.carousel": a.proxy(function (a) {
        this.refreshing && "items" == a.property.name && a.property.value && !a.property.value.is(":empty") && this.checkVideoLinks();
      }, this) }, this.owl.dom.$el.on(this.handlers), this.owl.dom.$el.on("click.owl.video", ".owl-video-play-icon", a.proxy(function (a) {
      this.playVideo(a);
    }, this));
  }, Video.Defaults = { video: !1, videoHeight: !1, videoWidth: !1 }, Video.prototype.checkVideoLinks = function () {
    var a, b, c;for (c = 0; c < this.owl.num.items; c++) b = this.owl.dom.$items.eq(c), b.data("owl-item").hasVideo || (a = b.find(".owl-video"), a.length && (this.owl.state.hasVideos = !0, this.owl.dom.$items.eq(c).data("owl-item").hasVideo = !0, a.css("display", "none"), this.getVideoInfo(a, b)));
  }, Video.prototype.getVideoInfo = function (a, b) {
    var c,
        d,
        e,
        f,
        g = a.data("vimeo-id"),
        h = a.data("youtube-id"),
        i = a.data("width") || this.owl.settings.videoWidth,
        j = a.data("height") || this.owl.settings.videoHeight,
        k = a.attr("href");if (g) d = "vimeo", e = g;else if (h) d = "youtube", e = h;else {
      if (!k) throw new Error("Missing video link.");e = k.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/), e[3].indexOf("youtu") > -1 ? d = "youtube" : e[3].indexOf("vimeo") > -1 && (d = "vimeo"), e = e[6];
    }b.data("owl-item").videoType = d, b.data("owl-item").videoId = e, b.data("owl-item").videoWidth = i, b.data("owl-item").videoHeight = j, c = { type: d, id: e }, f = i && j ? "style=\"width:" + i + "px;height:" + j + "px;\"" : "", a.wrap("<div class=\"owl-video-wrapper\"" + f + "></div>"), this.createVideoTn(a, c);
  }, Video.prototype.createVideoTn = function (b, c) {
    function d(a) {
      f = "<div class=\"owl-video-play-icon\"></div>", e = k.settings.lazyLoad ? "<div class=\"owl-video-tn " + j + "\" " + i + "=\"" + a + "\"></div>" : "<div class=\"owl-video-tn\" style=\"opacity:1;background-image:url(" + a + ")\"></div>", b.after(e), b.after(f);
    }var e,
        f,
        g,
        h = b.find("img"),
        i = "src",
        j = "",
        k = this.owl;return (this.owl.settings.lazyLoad && (i = "data-src", j = "owl-lazy"), h.length ? (d(h.attr(i)), h.remove(), !1) : void ("youtube" === c.type ? (g = "http://img.youtube.com/vi/" + c.id + "/hqdefault.jpg", d(g)) : "vimeo" === c.type && a.ajax({ type: "GET", url: "http://vimeo.com/api/v2/video/" + c.id + ".json", jsonp: "callback", dataType: "jsonp", success: function success(a) {
        g = a[0].thumbnail_large, d(g), k.settings.loop && k.updateActiveItems();
      } })));
  }, Video.prototype.stopVideo = function () {
    this.owl.trigger("stop", null, "video");var a = this.owl.dom.$items.eq(this.owl.state.videoPlayIndex);a.find(".owl-video-frame").remove(), a.removeClass("owl-video-playing"), this.owl.state.videoPlay = !1;
  }, Video.prototype.playVideo = function (b) {
    this.owl.trigger("play", null, "video"), this.owl.state.videoPlay && this.stopVideo();var c,
        d,
        e,
        f = a(b.target || b.srcElement),
        g = f.closest("." + this.owl.settings.itemClass);e = g.data("owl-item").videoType, id = g.data("owl-item").videoId, width = g.data("owl-item").videoWidth || Math.floor(g.data("owl-item").width - this.owl.settings.margin), height = g.data("owl-item").videoHeight || this.owl.dom.$stage.height(), "youtube" === e ? c = "<iframe width=\"" + width + "\" height=\"" + height + "\" src=\"http://www.youtube.com/embed/" + id + "?autoplay=1&v=" + id + "\" frameborder=\"0\" allowfullscreen></iframe>" : "vimeo" === e && (c = "<iframe src=\"http://player.vimeo.com/video/" + id + "?autoplay=1\" width=\"" + width + "\" height=\"" + height + "\" frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>"), g.addClass("owl-video-playing"), this.owl.state.videoPlay = !0, this.owl.state.videoPlayIndex = g.data("owl-item").indexAbs, d = a("<div style=\"height:" + height + "px; width:" + width + "px\" class=\"owl-video-frame\">" + c + "</div>"), f.after(d);
  }, Video.prototype.isInFullScreen = function () {
    var d = c.fullscreenElement || c.mozFullScreenElement || c.webkitFullscreenElement;return (d && a(d.parentNode).hasClass("owl-video-frame") && (this.owl.speed(0), this.owl.state.isFullScreen = !0), d && this.owl.state.isFullScreen && this.owl.state.videoPlay ? !1 : this.owl.state.isFullScreen ? (this.owl.state.isFullScreen = !1, !1) : this.owl.state.videoPlay && this.owl.state.orientation !== b.orientation ? (this.owl.state.orientation = b.orientation, !1) : !0);
  }, Video.prototype.destroy = function () {
    var a, b;this.owl.dom.$el.off("click.owl.video");for (a in this.handlers) this.owl.dom.$el.off(a, this.handlers[a]);for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null);
  }, a.fn.owlCarousel.Constructor.Plugins.video = Video;
})(window.Zepto || window.jQuery, window, document), (function (a, b, c, d) {
  Animate = function (b) {
    this.core = b, this.core.options = a.extend({}, Animate.Defaults, this.core.options), this.swapping = !0, this.previous = d, this.next = d, this.handlers = { "change.owl.carousel": a.proxy(function (a) {
        "position" == a.property.name && (this.previous = this.core.current(), this.next = a.property.value);
      }, this), "drag.owl.carousel dragged.owl.carousel translated.owl.carousel": a.proxy(function (a) {
        this.swapping = "translated" == a.type;
      }, this), "translate.owl.carousel": a.proxy(function () {
        this.swapping && (this.core.options.animateOut || this.core.options.animateIn) && this.swap();
      }, this) }, this.core.dom.$el.on(this.handlers);
  }, Animate.Defaults = { animateOut: !1, animateIn: !1 }, Animate.prototype.swap = function () {
    if (1 === this.core.settings.items && this.core.support3d) {
      this.core.speed(0);var b,
          c = a.proxy(this.clear, this),
          d = this.core.dom.$items.eq(this.previous),
          e = this.core.dom.$items.eq(this.next),
          f = this.core.settings.animateIn,
          g = this.core.settings.animateOut;this.core.current() !== this.previous && (g && (b = this.core.coordinates(this.previous) - this.core.coordinates(this.next), d.css({ left: b + "px" }).addClass("animated owl-animated-out").addClass(g).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", c)), f && e.addClass("animated owl-animated-in").addClass(f).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", c));
    }
  }, Animate.prototype.clear = function (b) {
    a(b.target).css({ left: "" }).removeClass("animated owl-animated-out owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut), this.core.transitionEnd();
  }, Animate.prototype.destroy = function () {
    var a, b;for (a in this.handlers) this.core.dom.$el.off(a, this.handlers[a]);for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null);
  }, a.fn.owlCarousel.Constructor.Plugins.Animate = Animate;
})(window.Zepto || window.jQuery, window, document), (function (a, b, c) {
  Autoplay = function (b) {
    this.core = b, this.core.options = a.extend({}, Autoplay.Defaults, this.core.options), this.handlers = { "translated.owl.carousel refreshed.owl.carousel": a.proxy(function () {
        this.autoplay();
      }, this), "play.owl.autoplay": a.proxy(function (a, b, c) {
        this.play(b, c);
      }, this), "stop.owl.autoplay": a.proxy(function () {
        this.stop();
      }, this), "mouseover.owl.autoplay": a.proxy(function () {
        this.core.settings.autoplayHoverPause && this.pause();
      }, this), "mouseleave.owl.autoplay": a.proxy(function () {
        this.core.settings.autoplayHoverPause && this.autoplay();
      }, this) }, this.core.dom.$el.on(this.handlers);
  }, Autoplay.Defaults = { autoplay: !1, autoplayTimeout: 5000, autoplayHoverPause: !1, autoplaySpeed: !1 }, Autoplay.prototype.autoplay = function () {
    this.core.settings.autoplay && !this.core.state.videoPlay ? (b.clearInterval(this.interval), this.interval = b.setInterval(a.proxy(function () {
      this.play();
    }, this), this.core.settings.autoplayTimeout)) : b.clearInterval(this.interval);
  }, Autoplay.prototype.play = function () {
    return c.hidden === !0 || this.core.state.isTouch || this.core.state.isScrolling || this.core.state.isSwiping || this.core.state.inMotion ? void 0 : this.core.settings.autoplay === !1 ? void b.clearInterval(this.interval) : void this.core.next(this.core.settings.autoplaySpeed);
  }, Autoplay.prototype.stop = function () {
    b.clearInterval(this.interval);
  }, Autoplay.prototype.pause = function () {
    b.clearInterval(this.interval);
  }, Autoplay.prototype.destroy = function () {
    var a, c;b.clearInterval(this.interval);for (a in this.handlers) this.core.dom.$el.off(a, this.handlers[a]);for (c in Object.getOwnPropertyNames(this)) "function" != typeof this[c] && (this[c] = null);
  }, a.fn.owlCarousel.Constructor.Plugins.autoplay = Autoplay;
})(window.Zepto || window.jQuery, window, document), (function (a) {
  "use strict";var b = function b(c) {
    this.core = c, this.initialized = !1, this.pages = [], this.controls = {}, this.template = null, this.$element = this.core.dom.$el, this.overrides = { next: this.core.next, prev: this.core.prev, to: this.core.to }, this.handlers = { "changed.owl.carousel": a.proxy(function (b) {
        "items" == b.property.name && (this.initialized || (this.initialize(), this.initialized = !0), this.update(), this.draw()), this.filling && (b.property.value.data("owl-item").dot = a(":first-child", b.property.value).find("[data-dot]").andSelf().data("dot"));
      }, this), "change.owl.carousel": a.proxy(function (a) {
        if ("position" == a.property.name && !this.core.state.revert && !this.core.settings.loop && this.core.settings.navRewind) {
          var b = this.core.current(),
              c = this.core.maximum(),
              d = this.core.minimum();a.data = a.property.value > c ? b >= c ? d : c : a.property.value < d ? c : a.property.value;
        }this.filling = this.core.settings.dotsData && "item" == a.property.name && a.property.value && a.property.value.is(":empty");
      }, this), "refreshed.owl.carousel": a.proxy(function () {
        this.initialized && (this.update(), this.draw());
      }, this) }, this.core.options = a.extend({}, b.Defaults, this.core.options), this.$element.on(this.handlers);
  };b.Defaults = { nav: !1, navRewind: !0, navText: ["prev", "next"], navSpeed: !1, navElement: "div", navContainer: !1, navContainerClass: "owl-nav", navClass: ["owl-prev", "owl-next"], slideBy: 1, dotClass: "owl-dot", dotsClass: "owl-dots", dots: !0, dotsEach: !1, dotData: !1, dotsSpeed: !1, dotsContainer: !1, controlsClass: "owl-controls" }, b.prototype.initialize = function () {
    var b,
        c,
        d = this.core.settings;d.dotsData || (this.template = a("<div>").addClass(d.dotClass).append(a("<span>")).prop("outerHTML")), d.navContainer && d.dotsContainer || (this.controls.$container = a("<div>").addClass(d.controlsClass).appendTo(this.$element)), this.controls.$indicators = d.dotsContainer ? a(d.dotsContainer) : a("<div>").hide().addClass(d.dotsClass).appendTo(this.controls.$container), this.controls.$indicators.on(this.core.dragType[2], "div", a.proxy(function (b) {
      var c = a(b.target).parent().is(this.controls.$indicators) ? a(b.target).index() : a(b.target).parent().index();b.preventDefault(), this.to(c, d.dotsSpeed);
    }, this)), b = d.navContainer ? a(d.navContainer) : a("<div>").addClass(d.navContainerClass).prependTo(this.controls.$container), this.controls.$next = a("<" + d.navElement + ">"), this.controls.$previous = this.controls.$next.clone(), this.controls.$previous.addClass(d.navClass[0]).html(d.navText[0]).hide().prependTo(b).on(this.core.dragType[2], a.proxy(function () {
      this.prev();
    }, this)), this.controls.$next.addClass(d.navClass[1]).html(d.navText[1]).hide().appendTo(b).on(this.core.dragType[2], a.proxy(function () {
      this.next();
    }, this));for (c in this.overrides) this.core[c] = a.proxy(this[c], this);
  }, b.prototype.destroy = function () {
    var a, b, c, d;for (a in this.handlers) this.$element.off(a, this.handlers[a]);for (b in this.controls) this.controls[b].remove();for (d in this.overides) this.core[d] = this.overrides[d];for (c in Object.getOwnPropertyNames(this)) "function" != typeof this[c] && (this[c] = null);
  }, b.prototype.update = function () {
    var a,
        b,
        c,
        d = this.core.settings,
        e = this.core.num.cItems / 2,
        f = this.core.num.items - e,
        g = d.center || d.autoWidth || d.dotData ? 1 : d.dotsEach || d.items;if (("page" !== d.slideBy && (d.slideBy = Math.min(d.slideBy, d.items)), d.dots)) for (this.pages = [], a = e, b = 0, c = 0; f > a; a++) (b >= g || 0 === b) && (this.pages.push({ start: a - e, end: a - e + g - 1 }), b = 0, ++c), b += this.core.num.merged[a];
  }, b.prototype.draw = function () {
    var b,
        c,
        d = "",
        e = this.core.settings,
        f = this.core.dom.$oItems,
        g = this.core.normalize(this.core.current(), !0);if ((!e.nav || e.loop || e.navRewind || (this.controls.$previous.toggleClass("disabled", 0 >= g), this.controls.$next.toggleClass("disabled", g >= this.core.maximum())), this.controls.$previous.toggle(e.nav), this.controls.$next.toggle(e.nav), e.dots)) {
      if ((b = this.pages.length - this.controls.$indicators.children().length, b > 0)) {
        for (c = 0; c < Math.abs(b); c++) d += e.dotData ? f.eq(c).data("owl-item").dot : this.template;this.controls.$indicators.append(d);
      } else 0 > b && this.controls.$indicators.children().slice(b).remove();this.controls.$indicators.find(".active").removeClass("active"), this.controls.$indicators.children().eq(a.inArray(this.current(), this.pages)).addClass("active");
    }this.controls.$indicators.toggle(e.dots);
  }, b.prototype.onTrigger = function (b) {
    var c = this.core.settings;b.page = { index: a.inArray(this.current(), this.pages), count: this.pages.length, size: c.center || c.autoWidth || c.dotData ? 1 : c.dotsEach || c.items };
  }, b.prototype.current = function () {
    var b = this.core.normalize(this.core.current(), !0);return a.grep(this.pages, function (a) {
      return a.start <= b && a.end >= b;
    }).pop();
  }, b.prototype.getPosition = function (b) {
    var c,
        d,
        e = this.core.settings;return ("page" == e.slideBy ? (c = a.inArray(this.current(), this.pages), d = this.pages.length, b ? ++c : --c, c = this.pages[(c % d + d) % d].start) : (c = this.core.normalize(this.core.current(), !0), d = this.core.num.oItems, b ? c += e.slideBy : c -= e.slideBy), c);
  }, b.prototype.next = function (b) {
    a.proxy(this.overrides.to, this.core)(this.getPosition(!0), b);
  }, b.prototype.prev = function (b) {
    a.proxy(this.overrides.to, this.core)(this.getPosition(!1), b);
  }, b.prototype.to = function (b, c, d) {
    var e;d ? a.proxy(this.overrides.to, this.core)(b, c) : (e = this.pages.length, a.proxy(this.overrides.to, this.core)(this.pages[(b % e + e) % e].start, c));
  }, a.fn.owlCarousel.Constructor.Plugins.Navigation = b;
})(window.Zepto || window.jQuery, window, document), (function (a, b, c, d) {
  "use strict";var e = function e(c) {
    this.core = c, this.hashes = {}, this.$element = this.core.dom.$el, this.handlers = { "initialized.owl.carousel": a.proxy(function () {
        b.location.hash.substring(1) && a(b).trigger("hashchange.owl.navigation");
      }, this), "changed.owl.carousel": a.proxy(function (b) {
        this.filling && (b.property.value.data("owl-item").hash = a(":first-child", b.property.value).find("[data-hash]").andSelf().data("hash"), this.hashes[b.property.value.data("owl-item").hash] = b.property.value);
      }, this), "change.owl.carousel": a.proxy(function (a) {
        "position" == a.property.name && this.core.current() === d && "URLHash" == this.core.settings.startPosition && (a.data = this.hashes[b.location.hash.substring(1)]), this.filling = "item" == a.property.name && a.property.value && a.property.value.is(":empty");
      }, this) }, this.core.options = a.extend({}, e.Defaults, this.core.options), this.$element.on(this.handlers), a(b).on("hashchange.owl.navigation", a.proxy(function () {
      var a = b.location.hash.substring(1),
          c = this.core.dom.$oItems,
          d = this.hashes[a] && c.index(this.hashes[a]) || 0;return a ? (this.core.dom.oStage.scrollLeft = 0, void this.core.to(d, !1, !0)) : !1;
    }, this));
  };e.Defaults = { URLhashListener: !1 }, e.prototype.destroy = function () {
    var c, d;a(b).off("hashchange.owl.navigation");for (c in this.handlers) this.owl.dom.$el.off(c, this.handlers[c]);for (d in Object.getOwnPropertyNames(this)) "function" != typeof this[d] && (this[d] = null);
  }, a.fn.owlCarousel.Constructor.Plugins.Hash = e;
})(window.Zepto || window.jQuery, window, document);
/**
* jquery.matchHeight-min.js master
* http://brm.io/jquery-match-height/
* License: MIT
*/
(function (c) {
  var n = -1,
      f = -1,
      g = function g(a) {
    return parseFloat(a) || 0;
  },
      r = function r(a) {
    var b = null,
        d = [];c(a).each(function () {
      var a = c(this),
          k = a.offset().top - g(a.css("margin-top")),
          l = 0 < d.length ? d[d.length - 1] : null;null === l ? d.push(a) : 1 >= Math.floor(Math.abs(b - k)) ? d[d.length - 1] = l.add(a) : d.push(a);b = k;
    });return d;
  },
      p = function p(a) {
    var b = { byRow: !0, property: "height", target: null, remove: !1 };if ("object" === typeof a) return c.extend(b, a);"boolean" === typeof a ? b.byRow = a : "remove" === a && (b.remove = !0);return b;
  },
      b = c.fn.matchHeight = function (a) {
    a = p(a);if (a.remove) {
      var e = this;this.css(a.property, "");c.each(b._groups, function (a, b) {
        b.elements = b.elements.not(e);
      });return this;
    }if (1 >= this.length && !a.target) return this;b._groups.push({ elements: this, options: a });b._apply(this, a);return this;
  };b._groups = [];b._throttle = 80;b._maintainScroll = !1;b._beforeUpdate = null;b._afterUpdate = null;b._apply = function (a, e) {
    var d = p(e),
        h = c(a),
        k = [h],
        l = c(window).scrollTop(),
        f = c("html").outerHeight(!0),
        m = h.parents().filter(":hidden");m.each(function () {
      var a = c(this);
      a.data("style-cache", a.attr("style"));
    });m.css("display", "block");d.byRow && !d.target && (h.each(function () {
      var a = c(this),
          b = "inline-block" === a.css("display") ? "inline-block" : "block";a.data("style-cache", a.attr("style"));a.css({ display: b, "padding-top": "0", "padding-bottom": "0", "margin-top": "0", "margin-bottom": "0", "border-top-width": "0", "border-bottom-width": "0", height: "100px" });
    }), k = r(h), h.each(function () {
      var a = c(this);a.attr("style", a.data("style-cache") || "");
    }));c.each(k, function (a, b) {
      var e = c(b),
          f = 0;if (d.target) f = d.target.outerHeight(!1);else {
        if (d.byRow && 1 >= e.length) {
          e.css(d.property, "");return;
        }e.each(function () {
          var a = c(this),
              b = { display: "inline-block" === a.css("display") ? "inline-block" : "block" };b[d.property] = "";a.css(b);a.outerHeight(!1) > f && (f = a.outerHeight(!1));a.css("display", "");
        });
      }e.each(function () {
        var a = c(this),
            b = 0;d.target && a.is(d.target) || ("border-box" !== a.css("box-sizing") && (b += g(a.css("border-top-width")) + g(a.css("border-bottom-width")), b += g(a.css("padding-top")) + g(a.css("padding-bottom"))), a.css(d.property, f - b));
      });
    });m.each(function () {
      var a = c(this);a.attr("style", a.data("style-cache") || null);
    });b._maintainScroll && c(window).scrollTop(l / f * c("html").outerHeight(!0));return this;
  };b._applyDataApi = function () {
    var a = {};c("[data-match-height], [data-mh]").each(function () {
      var b = c(this),
          d = b.attr("data-mh") || b.attr("data-match-height");a[d] = d in a ? a[d].add(b) : b;
    });c.each(a, function () {
      this.matchHeight(!0);
    });
  };var q = function q(a) {
    b._beforeUpdate && b._beforeUpdate(a, b._groups);c.each(b._groups, function () {
      b._apply(this.elements, this.options);
    });b._afterUpdate && b._afterUpdate(a, b._groups);
  };b._update = function (a, e) {
    if (e && "resize" === e.type) {
      var d = c(window).width();if (d === n) return;n = d;
    }a ? -1 === f && (f = setTimeout(function () {
      q(e);f = -1;
    }, b._throttle)) : q(e);
  };c(b._applyDataApi);c(window).bind("load", function (a) {
    b._update(!1, a);
  });c(window).bind("resize orientationchange", function (a) {
    b._update(!0, a);
  });
})(jQuery);
//# sourceMappingURL=all.js.map