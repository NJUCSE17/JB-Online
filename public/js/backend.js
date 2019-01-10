/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/backend/app.js":
/*!********************************************!*\
  !*** ./resources/assets/js/backend/app.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ../plugins/bootstrap */ "./resources/assets/js/plugins/bootstrap.js");

__webpack_require__(/*! ../plugins/addDeleteForms */ "./resources/assets/js/plugins/addDeleteForms.js");

__webpack_require__(/*! ../../shards-dashboard/scripts/extras.1.1.0.min */ "./resources/assets/shards-dashboard/scripts/extras.1.1.0.min.js");

__webpack_require__(/*! ../../shards-dashboard/scripts/shards-dashboards.1.1.0.min */ "./resources/assets/shards-dashboard/scripts/shards-dashboards.1.1.0.min.js");

/***/ }),

/***/ "./resources/assets/js/plugins/addDeleteForms.js":
/*!*******************************************************!*\
  !*** ./resources/assets/js/plugins/addDeleteForms.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * Import external plugins
 */

/**
 * Allows you to add data-method="METHOD to links to automatically inject a form
 * with the method on click
 *
 * Example: <a href="{{route('customers.destroy', $customer->id)}}"
 * data-method="delete" name="delete_item">Delete</a>
 *
 * Injects a form with that's fired on click of the link with a DELETE request.
 * Good because you don't have to dirty your HTML with delete forms everywhere.
 */
function addDeleteForms() {
  $('[data-method]').append(function () {
    if (!$(this).find('form').length > 0) return "\n" + "<form action='" + $(this).attr('href') + "' method='POST' name='delete_item' style='display:none'>\n" + "<input type='hidden' name='_method' value='" + $(this).attr('data-method') + "'>\n" + "<input type='hidden' name='_token' value='" + $('meta[name="csrf-token"]').attr('content') + "'>\n" + "</form>\n";else return "";
  }).removeAttr('href').attr('style', 'cursor:pointer;').attr('onclick', '$(this).find("form").submit();');
}
/**
 * Place any jQuery/helper plugins in here.
 */


$(function () {
  /**
   * Add the data-method="delete" forms to all delete links
   */
  addDeleteForms();
  /**
   * Disable all submit buttons once clicked
   */

  $('form').submit(function () {
    $(this).find('input[type="submit"]').attr("disabled", true);
    $(this).find('button[type="submit"]').attr("disabled", true);
    return true;
  });
  /**
   * Bind all bootstrap tooltips & popovers
   */

  $("[data-toggle='tooltip']").tooltip();
  /**
   * Generic confirm form delete using JQuery-Confirm v3
   */

  $('body').on('submit', 'form[name=delete_item]', function (e) {
    e.preventDefault();
    var form = this,
        link = $('a[data-method="delete"]'),
        cancel = link.attr('data-trans-button-cancel') ? link.attr('data-trans-button-cancel') : "取消 Cancel",
        confirm = link.attr('data-trans-button-confirm') ? link.attr('data-trans-button-confirm') : "确认 Yes",
        content = link.attr('data-trans-title') ? link.attr('data-trans-title') : "Are you sure you want to delete this item?";
    $.confirm({
      title: 'Are you sure?',
      content: content,
      icon: 'fas fa-exclamation-triangle',
      typeAnimated: true,
      buttons: {
        confirm: {
          text: confirm,
          btnClass: 'btn-green',
          action: function action() {
            form.submit();
          }
        },
        cancel: {
          text: cancel,
          btnClass: 'btn-red'
        }
      }
    });
  }).on('click', 'a[name=confirm_item]', function (e) {
    /**
     * Generic 'are you sure' confirm box
     */
    e.preventDefault();
    var link = $(this),
        content = link.attr('data-trans-title') ? link.attr('data-trans-title') : "你确定你要这么做吗？<br />Are you sure you want to do this?",
        cancel = link.attr('data-trans-button-cancel') ? link.attr('data-trans-button-cancel') : "取消 Cancel",
        confirm = link.attr('data-trans-button-confirm') ? link.attr('data-trans-button-confirm') : "确认 Yes";
    $.confirm({
      title: 'Are you sure?',
      content: content,
      icon: 'fas fa-question-circle',
      typeAnimated: true,
      buttons: {
        confirm: {
          text: confirm,
          btnClass: 'btn-green',
          action: function action() {
            window.location.assign(link.attr('href'));
          }
        },
        cancel: {
          text: cancel,
          btnClass: 'btn-red'
        }
      }
    });
  });
});

/***/ }),

/***/ "./resources/assets/js/plugins/bootstrap.js":
/*!**************************************************!*\
  !*** ./resources/assets/js/plugins/bootstrap.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/babel-loader/lib/index.js):\nTypeError: Cannot read property 'bindings' of null\n    at Scope.moveBindingTo (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\scope\\index.js:867:13)\n    at convertBlockScopedToVar (E:\\GitHub\\Class-Forum\\node_modules\\babel-plugin-transform-es2015-block-scoping\\lib\\index.js:139:13)\n    at PluginPass.VariableDeclaration (E:\\GitHub\\Class-Forum\\node_modules\\babel-plugin-transform-es2015-block-scoping\\lib\\index.js:26:9)\n    at newFn (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\visitors.js:193:21)\n    at NodePath._call (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\path\\context.js:53:20)\n    at NodePath.call (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\path\\context.js:40:17)\n    at NodePath.visit (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\path\\context.js:88:12)\n    at TraversalContext.visitQueue (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\context.js:118:16)\n    at TraversalContext.visitMultiple (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\context.js:85:17)\n    at TraversalContext.visit (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\context.js:144:19)\n    at Function.traverse.node (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\index.js:94:17)\n    at NodePath.visit (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\path\\context.js:95:18)\n    at TraversalContext.visitQueue (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\context.js:118:16)\n    at TraversalContext.visitSingle (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\context.js:90:19)\n    at TraversalContext.visit (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\context.js:146:19)\n    at Function.traverse.node (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\index.js:94:17)\n    at traverse (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\traverse\\lib\\index.js:76:12)\n    at transformFile (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\core\\lib\\transformation\\index.js:88:29)\n    at runSync (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\core\\lib\\transformation\\index.js:45:3)\n    at runAsync (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\core\\lib\\transformation\\index.js:35:14)\n    at process.nextTick (E:\\GitHub\\Class-Forum\\node_modules\\@babel\\core\\lib\\transform.js:34:34)\n    at process._tickCallback (internal/process/next_tick.js:61:11)");

/***/ }),

/***/ "./resources/assets/shards-dashboard/scripts/extras.1.1.0.min.js":
/*!***********************************************************************!*\
  !*** ./resources/assets/shards-dashboard/scripts/extras.1.1.0.min.js ***!
  \***********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


!function (e) {
  jQuery(document).ready(function () {
    var t = {
      getItem: function getItem(e) {
        return e && decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + encodeURIComponent(e).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || null;
      },
      setItem: function setItem(e, t, o, s, a, n) {
        if (!e || /^(?:expires|max\-age|path|domain|secure)$/i.test(e)) return !1;
        var i = "";
        if (o) switch (o.constructor) {
          case Number:
            i = o === 1 / 0 ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT" : "; max-age=" + o;
            break;

          case String:
            i = "; expires=" + o;
            break;

          case Date:
            i = "; expires=" + o.toUTCString();
        }
        return document.cookie = encodeURIComponent(e) + "=" + encodeURIComponent(t) + i + (a ? "; domain=" + a : "") + (s ? "; path=" + s : "") + (n ? "; secure" : ""), !0;
      },
      removeItem: function removeItem(e, t, o) {
        return !!this.hasItem(e) && (document.cookie = encodeURIComponent(e) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" + (o ? "; domain=" + o : "") + (t ? "; path=" + t : ""), !0);
      },
      hasItem: function hasItem(e) {
        return !(!e || /^(?:expires|max\-age|path|domain|secure)$/i.test(e)) && new RegExp("(?:^|;\\s*)" + encodeURIComponent(e).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=").test(document.cookie);
      },
      keys: function keys() {
        for (var e = document.cookie.replace(/((?:^|\s*;)[^\=]+)(?=;|$)|^\s*|\s*(?:\=[^;]*)?(?:\1|$)/g, "").split(/\s*(?:\=[^;]*)?;\s*/), t = e.length, o = 0; o < t; o++) {
          e[o] = decodeURIComponent(e[o]);
        }

        return e;
      }
    },
        o = "_sd_demo_page_promo",
        s = t.getItem(o),
        a = e(".promo-popup");
    s ? setTimeout(function () {
      a.addClass("hidden slideInUp");
    }, 3e3) : setTimeout(function () {
      a.addClass("bounceIn");
    }, 3e3), a.find(".close").click(function () {
      a.addClass("hidden");
      var e = new Date();
      e.setDate(e.getDate() + 1), t.setItem(o, !0, e);
    }), a.find(".pp-intro-bar").click(function (s) {
      s.target === this && e(this).parent().hasClass("hidden") && (t.removeItem(o), a.removeClass("hidden"));
    }), a.find(".pp-intro-bar .up").click(function () {
      a.removeClass("hidden"), t.removeItem(o);
    }), a.find(".pp-cta").click(function (e) {
      e.preventDefault(), "undefined" !== dataLayer && dataLayer.push({
        event: "sdp-demo-cta-upsell",
        data: {
          category: "product-demo",
          action: "cta-upsell",
          label: "shards-dashboard-pro"
        }
      }), window.location = e.target.href;
    });
    var n,
        i = e(".color-switcher .accent-colors"),
        r = e("#main-stylesheet"),
        c = r.attr("href"),
        d = r.attr("data-version");
    i.on("click", "li", function () {
      var t = e(this).attr("data-color"),
          o = "styles/accents/" + t + "." + d + ".css";
      "primary" == t && (o = c), i.find("li.active").removeClass("active"), e(this).addClass("active"), r.attr("href", o), function (t) {
        var o = e("#main-logo");
        n || (n = o.attr("src"));
        if ("primary" === t) return void o.attr("src", n);
        o.attr("src", "images/shards-dashboards-logo-" + t + ".svg");
      }(t), void 0 !== window.ubdChart && void 0 !== window.BlogOverviewUsers && function (t) {
        t = l[t], ubdChart.data.datasets[0].backgroundColor = [u(t, .9), u(t, .5), u(t, .3)], ubdChart.update(), e(".ubd-stats__legend .ubd-stats__item:nth-child(1) i").attr("style", "color:" + u(t, .9) + ";"), e(".ubd-stats__legend .ubd-stats__item:nth-child(2) i").attr("style", "color:" + u(t, .5) + ";"), e(".ubd-stats__legend .ubd-stats__item:nth-child(3) i").attr("style", "color:" + u(t, .3) + ";");
      }(t);
    });
    var l = {
      primary: "#007bff",
      secondary: "#5A6169",
      success: "#17c671",
      info: "#00b8d8",
      warning: "#ffb400",
      danger: "#c4183c"
    };

    function u(e, t) {
      t = t || 1;
      var o = void 0;
      if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(e)) return 3 == (o = e.substring(1).split("")).length && (o = [o[0], o[0], o[1], o[1], o[2], o[2]]), "rgba(" + [(o = "0x" + o.join("")) >> 16 & 255, o >> 8 & 255, 255 & o].join(",") + "," + t + ")";
    }

    e("#social-share").sharrre({
      share: {
        facebook: !0,
        twitter: !0
      },
      buttons: {
        facebook: {
          layout: "button_count",
          action: "like"
        },
        twitter: {
          count: "horizontal",
          via: "DesignRevision",
          hashtags: "bootstrap,uikit"
        }
      },
      enableTracking: !0,
      enableHover: !1,
      enableCounter: !1
    }), e(".color-switcher-toggle").click(p), e(".color-switcher .close").click(p);
    var m = new Date();

    function p() {
      e(".color-switcher").toggleClass("visible"), e(".color-switcher").hasClass("visible") ? t.setItem("_sd_cs_visible", !0, m) : t.setItem("_sd_cs_visible", !1, m);
    }

    m.setDate(m.getDate() + 1), t.setItem(o, !0, m), null === t.getItem("_sd_cs_visible") && t.setItem("_sd_cs_visible", !0, m), "false" !== t.getItem("_sd_cs_visible") && e(".color-switcher").addClass("visible"), setTimeout(function () {
      e(".loading-overlay").fadeOut(250);
    }, 2e3), e(document).on("click", "a.extra-action", function (t) {
      t.preventDefault(), t.stopPropagation();
      var o = e(this).attr("href");
      !function () {
        try {
          return window.self !== window.top;
        } catch (e) {
          return !0;
        }
      }() ? window.location = o : window.parent.location = o;
    });
  });
}(jQuery);

/***/ }),

/***/ "./resources/assets/shards-dashboard/scripts/shards-dashboards.1.1.0.min.js":
/*!**********************************************************************************!*\
  !*** ./resources/assets/shards-dashboard/scripts/shards-dashboards.1.1.0.min.js ***!
  \**********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;function _typeof(obj) { if (typeof Symbol === "function" && _typeof(Symbol.iterator) === "symbol") { _typeof = function (_typeof2) { function _typeof(_x) { return _typeof2.apply(this, arguments); } _typeof.toString = function () { return _typeof2.toString(); }; return _typeof; }(function (obj) { return typeof obj === "undefined" ? "undefined" : _typeof(obj); }); } else { _typeof = function (_typeof3) { function _typeof(_x2) { return _typeof3.apply(this, arguments); } _typeof.toString = function () { return _typeof3.toString(); }; return _typeof; }(function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj === "undefined" ? "undefined" : _typeof(obj); }); } return _typeof(obj); }

!function (t, o) {
  "object" == ( false ? undefined : _typeof(exports)) && "undefined" != typeof module ? o() :  true ? !(__WEBPACK_AMD_DEFINE_FACTORY__ = (o),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
				__WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : undefined;
}(0, function () {
  "use strict";

  if ("undefined" == typeof Chart) throw new Error("Shards Dashboard requires the Chart.js library in order to function properly.");
  window.ShardsDashboards = window.ShardsDashboards ? window.ShardsDashboards : {}, $.extend($.easing, {
    easeOutSine: function easeOutSine(t, o, e, i, n) {
      return i * Math.sin(o / n * (Math.PI / 2)) + e;
    }
  }), Chart.defaults.LineWithLine = Chart.defaults.line, Chart.controllers.LineWithLine = Chart.controllers.line.extend({
    draw: function draw(t) {
      if (Chart.controllers.line.prototype.draw.call(this, t), this.chart.tooltip._active && this.chart.tooltip._active.length) {
        var o = this.chart.tooltip._active[0],
            e = this.chart.ctx,
            i = o.tooltipPosition().x,
            n = this.chart.scales["y-axis-0"].top,
            r = this.chart.scales["y-axis-0"].bottom;
        e.save(), e.beginPath(), e.moveTo(i, n), e.lineTo(i, r), e.lineWidth = .5, e.strokeStyle = "#ddd", e.stroke(), e.restore();
      }
    }
  }), $(document).ready(function () {
    var t = {
      duration: 270,
      easing: "easeOutSine"
    };
    $(":not(.main-sidebar--icons-only) .dropdown").on("show.bs.dropdown", function () {
      $(this).find(".dropdown-menu").first().stop(!0, !0).slideDown(t);
    }), $(":not(.main-sidebar--icons-only) .dropdown").on("hide.bs.dropdown", function () {
      $(this).find(".dropdown-menu").first().stop(!0, !0).slideUp(t);
    }), $(".toggle-sidebar").click(function (t) {
      $(".main-sidebar").toggleClass("open");
    });
  });
});

/***/ }),

/***/ 1:
/*!**************************************************!*\
  !*** multi ./resources/assets/js/backend/app.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! E:\GitHub\Class-Forum\resources\assets\js\backend\app.js */"./resources/assets/js/backend/app.js");


/***/ })

/******/ });