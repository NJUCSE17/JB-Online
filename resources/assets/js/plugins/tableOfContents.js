/*!
 * Bootstrap Table of Contents v<%= version %> (http://afeld.github.io/bootstrap-toc/)
 * Copyright 2015 Aidan Feldman
 * Licensed under MIT (https://github.com/afeld/bootstrap-toc/blob/gh-pages/LICENSE.md) */
(function($) {
    'use strict';

    window.Toc = {
        helpers: {
            // return all matching elements in the set, or their descendants
            findOrFilter: function($el, selector) {
                // http://danielnouri.org/notes/2011/03/14/a-jquery-find-that-also-finds-the-root-element/
                // http://stackoverflow.com/a/12731439/358804
                var $descendants = $el.find(selector);
                return $el.filter(selector).add($descendants).filter(':not([data-toc-skip])');
            },

            generateUniqueIdBase: function(el) {
                var text = $(el).text();
                // https://stackoverflow.com/questions/21109011/javascript-unicode-string-chinese-character-but-no-punctuation
                // https://stackoverflow.com/questions/20306204/using-queryselector-with-ids-that-are-numbers
                var anchor = text.trim().toLowerCase()
                    .replace(/[^A-Za-z0-9\u4E00-\u9FCC]+/g, '-');
                return anchor || el.tagName.toLowerCase();
            },

            generateUniqueId: function(el) {
                var anchorBase = (el.id) ? el.id : this.generateUniqueIdBase(el);
                for (var i = 0; ; i++) {
                    // add prefix
                    var anchor = 'feed-' + el.tagName + '-' + anchorBase;
                    if (i > 0) {
                        // add suffix
                        anchor += '-' + i;
                    }
                    // check if ID already exists
                    if (!document.getElementById(anchor)) {
                        return anchor;
                    }
                }
            },

            generateAnchor: function(el) {
                var anchor = this.generateUniqueId(el);
                el.id = anchor;
                return anchor;
            },

            createNavList: function() {
                return $('<ul class="nav nav-toc"></ul>');
            },

            createChildNavList: function($parent) {
                var $childList = this.createNavList();
                $parent.append($childList);
                return $childList;
            },

            generateNavEl: function(anchor, text) {
                var $a = $('<a class="nav-link"></a>');
                $a.attr('href', '#' + anchor);
                $a.text(text);
                var $li = $('<li></li>');
                $li.append($a);
                return $li;
            },

            generateNavItem: function(headingEl) {
                var anchor = this.generateAnchor(headingEl);
                var $heading = $(headingEl);
                var text = $heading.data('toc-text') || $heading.text();
                return this.generateNavEl(anchor, text);
            },

            // returns the elements for the top level, and the next below it
            getHeadings: function($scope) {
                var topSelector = '.card-header';

                return this.findOrFilter($scope, topSelector + ', h1, h2');
            },

            getNavLevel: function(el) {
                if (el.tagName.charAt(0) !== 'H') return 0; // card-header
                return parseInt(el.tagName.charAt(1), 10);
            },

            populateNav: function($topContext, $headings) {
                var $curContext = null;
                var $cardItem = null;
                var $h1Item   = null;
                var $h1ListEl = null;
                var $h2ListEl = null;

                var helpers = this;
                $headings.each(function(i, el) {
                    var $newNav = helpers.generateNavItem(el);
                    var navLevel = helpers.getNavLevel(el);

                    // determine the proper $context
                    if (navLevel === 0) {
                        $topContext.append($newNav);
                        $h1ListEl = $h1Item = $h2ListEl = null;
                        $cardItem = $newNav;
                    } else if (navLevel === 1 || (navLevel === 2 && !$h1Item)) {
                        if (!$h1ListEl) {
                            $curContext = $h1ListEl = helpers.createChildNavList($cardItem);
                        }
                        $h1ListEl.append($newNav);
                        if (navLevel === 1) {
                            $h1Item = $newNav;
                            $h2ListEl = null;
                        }
                    } else {
                        if (!$h2ListEl) {
                            $curContext = $h2ListEl = helpers.createChildNavList($h1Item);
                        }
                        $h2ListEl.append($newNav);
                    }
                });
            },

            parseOps: function(arg) {
                var opts;
                if (arg.jquery) {
                    opts = {
                        $nav: arg
                    };
                } else {
                    opts = arg;
                }
                opts.$scope = opts.$scope || $(document.body);
                return opts;
            }
        },

        // accepts a jQuery object, or an options object
        init: function(opts) {
            opts = this.helpers.parseOps(opts);

            // ensure that the data attribute is in place for styling
            opts.$nav.attr('data-toggle', 'toc');

            var $topContext = this.helpers.createChildNavList(opts.$nav);
            var $headings = this.helpers.getHeadings(opts.$scope);
            this.helpers.populateNav($topContext, $headings);
        }
    };

    $(function() {
        $('nav[data-toggle="toc"]').each(function(i, el) {
            var $nav = $(el);
            Toc.init($nav);
        });
    });
})(jQuery);