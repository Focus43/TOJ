/* ========================================================================
 * Bootstrap: transition.js v3.1.1
 * http://getbootstrap.com/javascript/#transitions
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // CSS TRANSITION SUPPORT (Shoutout: http://www.modernizr.com/)
  // ============================================================

  function transitionEnd() {
    var el = document.createElement('bootstrap')

    var transEndEventNames = {
      'WebkitTransition' : 'webkitTransitionEnd',
      'MozTransition'    : 'transitionend',
      'OTransition'      : 'oTransitionEnd otransitionend',
      'transition'       : 'transitionend'
    }

    for (var name in transEndEventNames) {
      if (el.style[name] !== undefined) {
        return { end: transEndEventNames[name] }
      }
    }

    return false // explicit for ie8 (  ._.)
  }

  // http://blog.alexmaccaw.com/css-transitions
  $.fn.emulateTransitionEnd = function (duration) {
    var called = false, $el = this
    $(this).one($.support.transition.end, function () { called = true })
    var callback = function () { if (!called) $($el).trigger($.support.transition.end) }
    setTimeout(callback, duration)
    return this
  }

  $(function () {
    $.support.transition = transitionEnd()
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: collapse.js v3.1.1
 * http://getbootstrap.com/javascript/#collapse
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // COLLAPSE PUBLIC CLASS DEFINITION
  // ================================

  var Collapse = function (element, options) {
    this.$element      = $(element)
    this.options       = $.extend({}, Collapse.DEFAULTS, options)
    this.transitioning = null

    if (this.options.parent) this.$parent = $(this.options.parent)
    if (this.options.toggle) this.toggle()
  }

  Collapse.DEFAULTS = {
    toggle: true
  }

  Collapse.prototype.dimension = function () {
    var hasWidth = this.$element.hasClass('width')
    return hasWidth ? 'width' : 'height'
  }

  Collapse.prototype.show = function () {
    if (this.transitioning || this.$element.hasClass('in')) return

    var startEvent = $.Event('show.bs.collapse')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    var actives = this.$parent && this.$parent.find('> .panel > .in')

    if (actives && actives.length) {
      var hasData = actives.data('bs.collapse')
      if (hasData && hasData.transitioning) return
      actives.collapse('hide')
      hasData || actives.data('bs.collapse', null)
    }

    var dimension = this.dimension()

    this.$element
      .removeClass('collapse')
      .addClass('collapsing')
      [dimension](0)

    this.transitioning = 1

    var complete = function () {
      this.$element
        .removeClass('collapsing')
        .addClass('collapse in')
        [dimension]('auto')
      this.transitioning = 0
      this.$element.trigger('shown.bs.collapse')
    }

    if (!$.support.transition) return complete.call(this)

    var scrollSize = $.camelCase(['scroll', dimension].join('-'))

    this.$element
      .one($.support.transition.end, $.proxy(complete, this))
      .emulateTransitionEnd(350)
      [dimension](this.$element[0][scrollSize])
  }

  Collapse.prototype.hide = function () {
    if (this.transitioning || !this.$element.hasClass('in')) return

    var startEvent = $.Event('hide.bs.collapse')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    var dimension = this.dimension()

    this.$element
      [dimension](this.$element[dimension]())
      [0].offsetHeight

    this.$element
      .addClass('collapsing')
      .removeClass('collapse')
      .removeClass('in')

    this.transitioning = 1

    var complete = function () {
      this.transitioning = 0
      this.$element
        .trigger('hidden.bs.collapse')
        .removeClass('collapsing')
        .addClass('collapse')
    }

    if (!$.support.transition) return complete.call(this)

    this.$element
      [dimension](0)
      .one($.support.transition.end, $.proxy(complete, this))
      .emulateTransitionEnd(350)
  }

  Collapse.prototype.toggle = function () {
    this[this.$element.hasClass('in') ? 'hide' : 'show']()
  }


  // COLLAPSE PLUGIN DEFINITION
  // ==========================

  var old = $.fn.collapse

  $.fn.collapse = function (option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.collapse')
      var options = $.extend({}, Collapse.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data && options.toggle && option == 'show') option = !option
      if (!data) $this.data('bs.collapse', (data = new Collapse(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.collapse.Constructor = Collapse


  // COLLAPSE NO CONFLICT
  // ====================

  $.fn.collapse.noConflict = function () {
    $.fn.collapse = old
    return this
  }


  // COLLAPSE DATA-API
  // =================

  $(document).on('click.bs.collapse.data-api', '[data-toggle=collapse]', function (e) {
    var $this   = $(this), href
    var target  = $this.attr('data-target')
        || e.preventDefault()
        || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '') //strip for ie7
    var $target = $(target)
    var data    = $target.data('bs.collapse')
    var option  = data ? 'toggle' : $this.data()
    var parent  = $this.attr('data-parent')
    var $parent = parent && $(parent)

    if (!data || !data.transitioning) {
      if ($parent) $parent.find('[data-toggle=collapse][data-parent="' + parent + '"]').not($this).addClass('collapsed')
      $this[$target.hasClass('in') ? 'addClass' : 'removeClass']('collapsed')
    }

    $target.collapse(option)
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: modal.js v3.1.1
 * http://getbootstrap.com/javascript/#modals
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // MODAL CLASS DEFINITION
  // ======================

  var Modal = function (element, options) {
    this.options   = options
    this.$element  = $(element)
    this.$backdrop =
    this.isShown   = null

    if (this.options.remote) {
      this.$element
        .find('.modal-content')
        .load(this.options.remote, $.proxy(function () {
          this.$element.trigger('loaded.bs.modal')
        }, this))
    }
  }

  Modal.DEFAULTS = {
    backdrop: true,
    keyboard: true,
    show: true
  }

  Modal.prototype.toggle = function (_relatedTarget) {
    return this[!this.isShown ? 'show' : 'hide'](_relatedTarget)
  }

  Modal.prototype.show = function (_relatedTarget) {
    var that = this
    var e    = $.Event('show.bs.modal', { relatedTarget: _relatedTarget })

    this.$element.trigger(e)

    if (this.isShown || e.isDefaultPrevented()) return

    this.isShown = true

    this.escape()

    this.$element.on('click.dismiss.bs.modal', '[data-dismiss="modal"]', $.proxy(this.hide, this))

    this.backdrop(function () {
      var transition = $.support.transition && that.$element.hasClass('fade')

      if (!that.$element.parent().length) {
        that.$element.appendTo(document.body) // don't move modals dom position
      }

      that.$element
        .show()
        .scrollTop(0)

      if (transition) {
        that.$element[0].offsetWidth // force reflow
      }

      that.$element
        .addClass('in')
        .attr('aria-hidden', false)

      that.enforceFocus()

      var e = $.Event('shown.bs.modal', { relatedTarget: _relatedTarget })

      transition ?
        that.$element.find('.modal-dialog') // wait for modal to slide in
          .one($.support.transition.end, function () {
            that.$element.focus().trigger(e)
          })
          .emulateTransitionEnd(300) :
        that.$element.focus().trigger(e)
    })
  }

  Modal.prototype.hide = function (e) {
    if (e) e.preventDefault()

    e = $.Event('hide.bs.modal')

    this.$element.trigger(e)

    if (!this.isShown || e.isDefaultPrevented()) return

    this.isShown = false

    this.escape()

    $(document).off('focusin.bs.modal')

    this.$element
      .removeClass('in')
      .attr('aria-hidden', true)
      .off('click.dismiss.bs.modal')

    $.support.transition && this.$element.hasClass('fade') ?
      this.$element
        .one($.support.transition.end, $.proxy(this.hideModal, this))
        .emulateTransitionEnd(300) :
      this.hideModal()
  }

  Modal.prototype.enforceFocus = function () {
    $(document)
      .off('focusin.bs.modal') // guard against infinite focus loop
      .on('focusin.bs.modal', $.proxy(function (e) {
        if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
          this.$element.focus()
        }
      }, this))
  }

  Modal.prototype.escape = function () {
    if (this.isShown && this.options.keyboard) {
      this.$element.on('keyup.dismiss.bs.modal', $.proxy(function (e) {
        e.which == 27 && this.hide()
      }, this))
    } else if (!this.isShown) {
      this.$element.off('keyup.dismiss.bs.modal')
    }
  }

  Modal.prototype.hideModal = function () {
    var that = this
    this.$element.hide()
    this.backdrop(function () {
      that.removeBackdrop()
      that.$element.trigger('hidden.bs.modal')
    })
  }

  Modal.prototype.removeBackdrop = function () {
    this.$backdrop && this.$backdrop.remove()
    this.$backdrop = null
  }

  Modal.prototype.backdrop = function (callback) {
    var animate = this.$element.hasClass('fade') ? 'fade' : ''

    if (this.isShown && this.options.backdrop) {
      var doAnimate = $.support.transition && animate

      this.$backdrop = $('<div class="modal-backdrop ' + animate + '" />')
        .appendTo(document.body)

      this.$element.on('click.dismiss.bs.modal', $.proxy(function (e) {
        if (e.target !== e.currentTarget) return
        this.options.backdrop == 'static'
          ? this.$element[0].focus.call(this.$element[0])
          : this.hide.call(this)
      }, this))

      if (doAnimate) this.$backdrop[0].offsetWidth // force reflow

      this.$backdrop.addClass('in')

      if (!callback) return

      doAnimate ?
        this.$backdrop
          .one($.support.transition.end, callback)
          .emulateTransitionEnd(150) :
        callback()

    } else if (!this.isShown && this.$backdrop) {
      this.$backdrop.removeClass('in')

      $.support.transition && this.$element.hasClass('fade') ?
        this.$backdrop
          .one($.support.transition.end, callback)
          .emulateTransitionEnd(150) :
        callback()

    } else if (callback) {
      callback()
    }
  }


  // MODAL PLUGIN DEFINITION
  // =======================

  var old = $.fn.modal

  $.fn.modal = function (option, _relatedTarget) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.modal')
      var options = $.extend({}, Modal.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data) $this.data('bs.modal', (data = new Modal(this, options)))
      if (typeof option == 'string') data[option](_relatedTarget)
      else if (options.show) data.show(_relatedTarget)
    })
  }

  $.fn.modal.Constructor = Modal


  // MODAL NO CONFLICT
  // =================

  $.fn.modal.noConflict = function () {
    $.fn.modal = old
    return this
  }


  // MODAL DATA-API
  // ==============

  $(document).on('click.bs.modal.data-api', '[data-toggle="modal"]', function (e) {
    var $this   = $(this)
    var href    = $this.attr('href')
    var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) //strip for ie7
    var option  = $target.data('bs.modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

    if ($this.is('a')) e.preventDefault()

    $target
      .modal(option, this)
      .one('hide', function () {
        $this.is(':visible') && $this.focus()
      })
  })

  $(document)
    .on('show.bs.modal', '.modal', function () { $(document.body).addClass('modal-open') })
    .on('hidden.bs.modal', '.modal', function () { $(document.body).removeClass('modal-open') })

}(jQuery);

/* ========================================================================
 * Bootstrap: tooltip.js v3.1.1
 * http://getbootstrap.com/javascript/#tooltip
 * Inspired by the original jQuery.tipsy by Jason Frame
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // TOOLTIP PUBLIC CLASS DEFINITION
  // ===============================

  var Tooltip = function (element, options) {
    this.type       =
    this.options    =
    this.enabled    =
    this.timeout    =
    this.hoverState =
    this.$element   = null

    this.init('tooltip', element, options)
  }

  Tooltip.DEFAULTS = {
    animation: true,
    placement: 'top',
    selector: false,
    template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
    trigger: 'hover focus',
    title: '',
    delay: 0,
    html: false,
    container: false
  }

  Tooltip.prototype.init = function (type, element, options) {
    this.enabled  = true
    this.type     = type
    this.$element = $(element)
    this.options  = this.getOptions(options)

    var triggers = this.options.trigger.split(' ')

    for (var i = triggers.length; i--;) {
      var trigger = triggers[i]

      if (trigger == 'click') {
        this.$element.on('click.' + this.type, this.options.selector, $.proxy(this.toggle, this))
      } else if (trigger != 'manual') {
        var eventIn  = trigger == 'hover' ? 'mouseenter' : 'focusin'
        var eventOut = trigger == 'hover' ? 'mouseleave' : 'focusout'

        this.$element.on(eventIn  + '.' + this.type, this.options.selector, $.proxy(this.enter, this))
        this.$element.on(eventOut + '.' + this.type, this.options.selector, $.proxy(this.leave, this))
      }
    }

    this.options.selector ?
      (this._options = $.extend({}, this.options, { trigger: 'manual', selector: '' })) :
      this.fixTitle()
  }

  Tooltip.prototype.getDefaults = function () {
    return Tooltip.DEFAULTS
  }

  Tooltip.prototype.getOptions = function (options) {
    options = $.extend({}, this.getDefaults(), this.$element.data(), options)

    if (options.delay && typeof options.delay == 'number') {
      options.delay = {
        show: options.delay,
        hide: options.delay
      }
    }

    return options
  }

  Tooltip.prototype.getDelegateOptions = function () {
    var options  = {}
    var defaults = this.getDefaults()

    this._options && $.each(this._options, function (key, value) {
      if (defaults[key] != value) options[key] = value
    })

    return options
  }

  Tooltip.prototype.enter = function (obj) {
    var self = obj instanceof this.constructor ?
      obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)

    clearTimeout(self.timeout)

    self.hoverState = 'in'

    if (!self.options.delay || !self.options.delay.show) return self.show()

    self.timeout = setTimeout(function () {
      if (self.hoverState == 'in') self.show()
    }, self.options.delay.show)
  }

  Tooltip.prototype.leave = function (obj) {
    var self = obj instanceof this.constructor ?
      obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)

    clearTimeout(self.timeout)

    self.hoverState = 'out'

    if (!self.options.delay || !self.options.delay.hide) return self.hide()

    self.timeout = setTimeout(function () {
      if (self.hoverState == 'out') self.hide()
    }, self.options.delay.hide)
  }

  Tooltip.prototype.show = function () {
    var e = $.Event('show.bs.' + this.type)

    if (this.hasContent() && this.enabled) {
      this.$element.trigger(e)

      if (e.isDefaultPrevented()) return
      var that = this;

      var $tip = this.tip()

      this.setContent()

      if (this.options.animation) $tip.addClass('fade')

      var placement = typeof this.options.placement == 'function' ?
        this.options.placement.call(this, $tip[0], this.$element[0]) :
        this.options.placement

      var autoToken = /\s?auto?\s?/i
      var autoPlace = autoToken.test(placement)
      if (autoPlace) placement = placement.replace(autoToken, '') || 'top'

      $tip
        .detach()
        .css({ top: 0, left: 0, display: 'block' })
        .addClass(placement)

      this.options.container ? $tip.appendTo(this.options.container) : $tip.insertAfter(this.$element)

      var pos          = this.getPosition()
      var actualWidth  = $tip[0].offsetWidth
      var actualHeight = $tip[0].offsetHeight

      if (autoPlace) {
        var $parent = this.$element.parent()

        var orgPlacement = placement
        var docScroll    = document.documentElement.scrollTop || document.body.scrollTop
        var parentWidth  = this.options.container == 'body' ? window.innerWidth  : $parent.outerWidth()
        var parentHeight = this.options.container == 'body' ? window.innerHeight : $parent.outerHeight()
        var parentLeft   = this.options.container == 'body' ? 0 : $parent.offset().left

        placement = placement == 'bottom' && pos.top   + pos.height  + actualHeight - docScroll > parentHeight  ? 'top'    :
                    placement == 'top'    && pos.top   - docScroll   - actualHeight < 0                         ? 'bottom' :
                    placement == 'right'  && pos.right + actualWidth > parentWidth                              ? 'left'   :
                    placement == 'left'   && pos.left  - actualWidth < parentLeft                               ? 'right'  :
                    placement

        $tip
          .removeClass(orgPlacement)
          .addClass(placement)
      }

      var calculatedOffset = this.getCalculatedOffset(placement, pos, actualWidth, actualHeight)

      this.applyPlacement(calculatedOffset, placement)
      this.hoverState = null

      var complete = function() {
        that.$element.trigger('shown.bs.' + that.type)
      }

      $.support.transition && this.$tip.hasClass('fade') ?
        $tip
          .one($.support.transition.end, complete)
          .emulateTransitionEnd(150) :
        complete()
    }
  }

  Tooltip.prototype.applyPlacement = function (offset, placement) {
    var replace
    var $tip   = this.tip()
    var width  = $tip[0].offsetWidth
    var height = $tip[0].offsetHeight

    // manually read margins because getBoundingClientRect includes difference
    var marginTop = parseInt($tip.css('margin-top'), 10)
    var marginLeft = parseInt($tip.css('margin-left'), 10)

    // we must check for NaN for ie 8/9
    if (isNaN(marginTop))  marginTop  = 0
    if (isNaN(marginLeft)) marginLeft = 0

    offset.top  = offset.top  + marginTop
    offset.left = offset.left + marginLeft

    // $.fn.offset doesn't round pixel values
    // so we use setOffset directly with our own function B-0
    $.offset.setOffset($tip[0], $.extend({
      using: function (props) {
        $tip.css({
          top: Math.round(props.top),
          left: Math.round(props.left)
        })
      }
    }, offset), 0)

    $tip.addClass('in')

    // check to see if placing tip in new offset caused the tip to resize itself
    var actualWidth  = $tip[0].offsetWidth
    var actualHeight = $tip[0].offsetHeight

    if (placement == 'top' && actualHeight != height) {
      replace = true
      offset.top = offset.top + height - actualHeight
    }

    if (/bottom|top/.test(placement)) {
      var delta = 0

      if (offset.left < 0) {
        delta       = offset.left * -2
        offset.left = 0

        $tip.offset(offset)

        actualWidth  = $tip[0].offsetWidth
        actualHeight = $tip[0].offsetHeight
      }

      this.replaceArrow(delta - width + actualWidth, actualWidth, 'left')
    } else {
      this.replaceArrow(actualHeight - height, actualHeight, 'top')
    }

    if (replace) $tip.offset(offset)
  }

  Tooltip.prototype.replaceArrow = function (delta, dimension, position) {
    this.arrow().css(position, delta ? (50 * (1 - delta / dimension) + '%') : '')
  }

  Tooltip.prototype.setContent = function () {
    var $tip  = this.tip()
    var title = this.getTitle()

    $tip.find('.tooltip-inner')[this.options.html ? 'html' : 'text'](title)
    $tip.removeClass('fade in top bottom left right')
  }

  Tooltip.prototype.hide = function () {
    var that = this
    var $tip = this.tip()
    var e    = $.Event('hide.bs.' + this.type)

    function complete() {
      if (that.hoverState != 'in') $tip.detach()
      that.$element.trigger('hidden.bs.' + that.type)
    }

    this.$element.trigger(e)

    if (e.isDefaultPrevented()) return

    $tip.removeClass('in')

    $.support.transition && this.$tip.hasClass('fade') ?
      $tip
        .one($.support.transition.end, complete)
        .emulateTransitionEnd(150) :
      complete()

    this.hoverState = null

    return this
  }

  Tooltip.prototype.fixTitle = function () {
    var $e = this.$element
    if ($e.attr('title') || typeof($e.attr('data-original-title')) != 'string') {
      $e.attr('data-original-title', $e.attr('title') || '').attr('title', '')
    }
  }

  Tooltip.prototype.hasContent = function () {
    return this.getTitle()
  }

  Tooltip.prototype.getPosition = function () {
    var el = this.$element[0]
    return $.extend({}, (typeof el.getBoundingClientRect == 'function') ? el.getBoundingClientRect() : {
      width: el.offsetWidth,
      height: el.offsetHeight
    }, this.$element.offset())
  }

  Tooltip.prototype.getCalculatedOffset = function (placement, pos, actualWidth, actualHeight) {
    return placement == 'bottom' ? { top: pos.top + pos.height,   left: pos.left + pos.width / 2 - actualWidth / 2  } :
           placement == 'top'    ? { top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2  } :
           placement == 'left'   ? { top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth } :
        /* placement == 'right' */ { top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width   }
  }

  Tooltip.prototype.getTitle = function () {
    var title
    var $e = this.$element
    var o  = this.options

    title = $e.attr('data-original-title')
      || (typeof o.title == 'function' ? o.title.call($e[0]) :  o.title)

    return title
  }

  Tooltip.prototype.tip = function () {
    return this.$tip = this.$tip || $(this.options.template)
  }

  Tooltip.prototype.arrow = function () {
    return this.$arrow = this.$arrow || this.tip().find('.tooltip-arrow')
  }

  Tooltip.prototype.validate = function () {
    if (!this.$element[0].parentNode) {
      this.hide()
      this.$element = null
      this.options  = null
    }
  }

  Tooltip.prototype.enable = function () {
    this.enabled = true
  }

  Tooltip.prototype.disable = function () {
    this.enabled = false
  }

  Tooltip.prototype.toggleEnabled = function () {
    this.enabled = !this.enabled
  }

  Tooltip.prototype.toggle = function (e) {
    var self = e ? $(e.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type) : this
    self.tip().hasClass('in') ? self.leave(self) : self.enter(self)
  }

  Tooltip.prototype.destroy = function () {
    clearTimeout(this.timeout)
    this.hide().$element.off('.' + this.type).removeData('bs.' + this.type)
  }


  // TOOLTIP PLUGIN DEFINITION
  // =========================

  var old = $.fn.tooltip

  $.fn.tooltip = function (option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.tooltip')
      var options = typeof option == 'object' && option

      if (!data && option == 'destroy') return
      if (!data) $this.data('bs.tooltip', (data = new Tooltip(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.tooltip.Constructor = Tooltip


  // TOOLTIP NO CONFLICT
  // ===================

  $.fn.tooltip.noConflict = function () {
    $.fn.tooltip = old
    return this
  }

}(jQuery);

/* ========================================================================
 * Bootstrap: popover.js v3.1.1
 * http://getbootstrap.com/javascript/#popovers
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // POPOVER PUBLIC CLASS DEFINITION
  // ===============================

  var Popover = function (element, options) {
    this.init('popover', element, options)
  }

  if (!$.fn.tooltip) throw new Error('Popover requires tooltip.js')

  Popover.DEFAULTS = $.extend({}, $.fn.tooltip.Constructor.DEFAULTS, {
    placement: 'right',
    trigger: 'click',
    content: '',
    template: '<div class="popover"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
  })


  // NOTE: POPOVER EXTENDS tooltip.js
  // ================================

  Popover.prototype = $.extend({}, $.fn.tooltip.Constructor.prototype)

  Popover.prototype.constructor = Popover

  Popover.prototype.getDefaults = function () {
    return Popover.DEFAULTS
  }

  Popover.prototype.setContent = function () {
    var $tip    = this.tip()
    var title   = this.getTitle()
    var content = this.getContent()

    $tip.find('.popover-title')[this.options.html ? 'html' : 'text'](title)
    $tip.find('.popover-content')[ // we use append for html objects to maintain js events
      this.options.html ? (typeof content == 'string' ? 'html' : 'append') : 'text'
    ](content)

    $tip.removeClass('fade top bottom left right in')

    // IE8 doesn't accept hiding via the `:empty` pseudo selector, we have to do
    // this manually by checking the contents.
    if (!$tip.find('.popover-title').html()) $tip.find('.popover-title').hide()
  }

  Popover.prototype.hasContent = function () {
    return this.getTitle() || this.getContent()
  }

  Popover.prototype.getContent = function () {
    var $e = this.$element
    var o  = this.options

    return $e.attr('data-content')
      || (typeof o.content == 'function' ?
            o.content.call($e[0]) :
            o.content)
  }

  Popover.prototype.arrow = function () {
    return this.$arrow = this.$arrow || this.tip().find('.arrow')
  }

  Popover.prototype.tip = function () {
    if (!this.$tip) this.$tip = $(this.options.template)
    return this.$tip
  }


  // POPOVER PLUGIN DEFINITION
  // =========================

  var old = $.fn.popover

  $.fn.popover = function (option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.popover')
      var options = typeof option == 'object' && option

      if (!data && option == 'destroy') return
      if (!data) $this.data('bs.popover', (data = new Popover(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.popover.Constructor = Popover


  // POPOVER NO CONFLICT
  // ===================

  $.fn.popover.noConflict = function () {
    $.fn.popover = old
    return this
  }

}(jQuery);

/*
 * simpleWeather
 * http://simpleweatherjs.com
 *
 * A simple jQuery plugin to display the current weather
 * information for any location using Yahoo! Weather.
 *
 * Developed by James Fleeting <@fleetingftw> <http://iwasasuperhero.com>
 * Another project from monkeeCreate <http://monkeecreate.com>
 *
 * Version 2.6.0 - Last updated: February 26 2014
 */
(function($) {
  "use strict";
  $.extend({
    simpleWeather: function(options){
      options = $.extend({
        location: '',
        woeid: '2357536',
        unit: 'f',
        success: function(weather){},
        error: function(message){}
      }, options);

      var now = new Date();

      var weatherUrl = '//query.yahooapis.com/v1/public/yql?format=json&rnd='+now.getFullYear()+now.getMonth()+now.getDay()+now.getHours()+'&diagnostics=true&callback=?&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&q=';
      if(options.location !== '') {
        weatherUrl += 'select * from weather.forecast where woeid in (select woeid from geo.placefinder where text="'+options.location+'" and gflags="R") and u="'+options.unit+'"';
      } else if(options.woeid !== '') {
        weatherUrl += 'select * from weather.forecast where woeid='+options.woeid+' and u="'+options.unit+'"';
      } else {
        options.error("Could not retrieve weather due to an invalid location.");
        return false;
      }

      $.getJSON(
        encodeURI(weatherUrl),
        function(data) {
          if(data !== null && data.query.results !== null && data.query.results.channel.description !== 'Yahoo! Weather Error') {
            $.each(data.query.results, function(i, result) {
              if (result.constructor.toString().indexOf("Array") !== -1) {
                result = result[0];
              }

              var compass = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW', 'N'];
              var windDirection = compass[Math.round(result.wind.direction / 22.5)];

              if(result.item.condition.temp < 80 && result.atmosphere.humidity < 40) {
                var heatIndex = -42.379+2.04901523*result.item.condition.temp+10.14333127*result.atmosphere.humidity-0.22475541*result.item.condition.temp*result.atmosphere.humidity-6.83783*(Math.pow(10, -3))*(Math.pow(result.item.condition.temp, 2))-5.481717*(Math.pow(10, -2))*(Math.pow(result.atmosphere.humidity, 2))+1.22874*(Math.pow(10, -3))*(Math.pow(result.item.condition.temp, 2))*result.atmosphere.humidity+8.5282*(Math.pow(10, -4))*result.item.condition.temp*(Math.pow(result.atmosphere.humidity, 2))-1.99*(Math.pow(10, -6))*(Math.pow(result.item.condition.temp, 2))*(Math.pow(result.atmosphere.humidity,2));
              } else {
                var heatIndex = result.item.condition.temp;
              }

              if(options.unit === "f") {
                var unitAlt = "c";
                var tempAlt = Math.round((5.0/9.0)*(result.item.condition.temp-32.0));
                var highAlt = Math.round((5.0/9.0)*(result.item.forecast[0].high-32.0));
                var lowAlt = Math.round((5.0/9.0)*(result.item.forecast[0].low-32.0));
                var tomorrowHighAlt = Math.round((5.0/9.0)*(result.item.forecast[1].high-32.0));
                var tomorrowLowAlt = Math.round((5.0/9.0)*(result.item.forecast[1].low-32.0));
                var forecastOneHighAlt = Math.round((5.0/9.0)*(result.item.forecast[1].high-32.0));
                var forecastOneLowAlt = Math.round((5.0/9.0)*(result.item.forecast[1].low-32.0));
                var forecastTwoHighAlt = Math.round((5.0/9.0)*(result.item.forecast[2].high-32.0));
                var forecastTwoLowAlt = Math.round((5.0/9.0)*(result.item.forecast[2].low-32.0));
                var forecastThreeHighAlt = Math.round((5.0/9.0)*(result.item.forecast[3].high-32.0));
                var forecastThreeLowAlt = Math.round((5.0/9.0)*(result.item.forecast[3].low-32.0));
                var forecastFourHighAlt = Math.round((5.0/9.0)*(result.item.forecast[4].high-32.0));
                var forecastFourLowAlt = Math.round((5.0/9.0)*(result.item.forecast[4].low-32.0));
              } else {
                var unitAlt = "f";
                var tempAlt = Math.round((9.0/5.0)*result.item.condition.temp+32.0);
                var highAlt = Math.round((9.0/5.0)*result.item.forecast[0].high+32.0);
                var lowAlt = Math.round((9.0/5.0)*result.item.forecast[0].low+32.0);
                var tomorrowHighAlt = Math.round((9.0/5.0)*(result.item.forecast[1].high+32.0));
                var tomorrowLowAlt = Math.round((9.0/5.0)*(result.item.forecast[1].low+32.0));
                var forecastOneHighAlt = Math.round((9.0/5.0)*(result.item.forecast[1].high+32.0));
                var forecastOneLowAlt = Math.round((9.0/5.0)*(result.item.forecast[1].low+32.0));
                var forecastTwoHighAlt = Math.round((9.0/5.0)*(result.item.forecast[2].high+32.0));
                var forecastTwoLowAlt = Math.round((9.0/5.0)*(result.item.forecast[2].low+32.0));
                var forecastThreeHighAlt = Math.round((9.0/5.0)*(result.item.forecast[3].high+32.0));
                var forecastThreeLowAlt = Math.round((9.0/5.0)*(result.item.forecast[3].low+32.0));
                var forecastFourHighAlt = Math.round((9.0/5.0)*(result.item.forecast[4].high+32.0));
                var forecastFourLowAlt = Math.round((9.0/5.0)*(result.item.forecast[4].low+32.0));
              }

              var weather = {
                title: result.item.title,
                temp: result.item.condition.temp,
                tempAlt: tempAlt,
                code: result.item.condition.code,
                todayCode: result.item.forecast[0].code,
                units:{
                  temp: result.units.temperature,
                  distance: result.units.distance,
                  pressure: result.units.pressure,
                  speed: result.units.speed,
                  tempAlt: unitAlt
                },
                currently: result.item.condition.text,
                high: result.item.forecast[0].high,
                highAlt: highAlt,
                low: result.item.forecast[0].low,
                lowAlt: lowAlt,
                forecast: result.item.forecast[0].text,
                wind:{
                  chill: result.wind.chill,
                  direction: windDirection,
                  speed: result.wind.speed
                },
                humidity: result.atmosphere.humidity,
                heatindex: heatIndex,
                pressure: result.atmosphere.pressure,
                rising: result.atmosphere.rising,
                visibility: result.atmosphere.visibility,
                sunrise: result.astronomy.sunrise,
                sunset: result.astronomy.sunset,
                description: result.item.description,
                thumbnail: "//l.yimg.com/a/i/us/nws/weather/gr/"+result.item.condition.code+"ds.png",
                image: "//l.yimg.com/a/i/us/nws/weather/gr/"+result.item.condition.code+"d.png",
                tomorrow:{
                  high: result.item.forecast[1].high,
                  highAlt: tomorrowHighAlt,
                  low: result.item.forecast[1].low,
                  lowAlt: tomorrowLowAlt,
                  forecast: result.item.forecast[1].text,
                  code: result.item.forecast[1].code,
                  date: result.item.forecast[1].date,
                  day: result.item.forecast[1].day,
                  image: "//l.yimg.com/a/i/us/nws/weather/gr/"+result.item.forecast[1].code+"d.png"
                },
                forecasts:{
                  one:{
                    high: result.item.forecast[1].high,
                    highAlt: forecastOneHighAlt,
                    low: result.item.forecast[1].low,
                    lowAlt: forecastOneLowAlt,
                    forecast: result.item.forecast[1].text,
                    code: result.item.forecast[1].code,
                    date: result.item.forecast[1].date,
                    day: result.item.forecast[1].day,
                    image: "//l.yimg.com/a/i/us/nws/weather/gr/"+result.item.forecast[1].code+"d.png"
                  },
                  two:{
                    high: result.item.forecast[2].high,
                    highAlt: forecastTwoHighAlt,
                    low: result.item.forecast[2].low,
                    lowAlt: forecastTwoLowAlt,
                    forecast: result.item.forecast[2].text,
                    code: result.item.forecast[2].code,
                    date: result.item.forecast[2].date,
                    day: result.item.forecast[2].day,
                    image: "//l.yimg.com/a/i/us/nws/weather/gr/"+result.item.forecast[2].code+"d.png"
                  },
                  three:{
                    high: result.item.forecast[3].high,
                    highAlt: forecastThreeHighAlt,
                    low: result.item.forecast[3].low,
                    lowAlt: forecastThreeLowAlt,
                    forecast: result.item.forecast[3].text,
                    code: result.item.forecast[3].code,
                    date: result.item.forecast[3].date,
                    day: result.item.forecast[3].day,
                    image: "//l.yimg.com/a/i/us/nws/weather/gr/"+result.item.forecast[3].code+"d.png"
                  },
                  four:{
                    high: result.item.forecast[4].high,
                    highAlt: forecastFourHighAlt,
                    low: result.item.forecast[4].low,
                    lowAlt: forecastFourLowAlt,
                    forecast: result.item.forecast[4].text,
                    code: result.item.forecast[4].code,
                    date: result.item.forecast[4].date,
                    day: result.item.forecast[4].day,
                    image: "//l.yimg.com/a/i/us/nws/weather/gr/"+result.item.forecast[4].code+"d.png"
                  },
                },
                city: result.location.city,
                country: result.location.country,
                region: result.location.region,
                updated: result.item.pubDate,
                link: result.item.link
              };

              options.success(weather);
            });
          } else {
            if (data.query.results === null) {
              options.error("An invalid WOEID or location was provided.");
            } else {
              options.error("There was an error retrieving the latest weather information. Please try again.");
            }
          }
        }
      );
      return this;
    }
  });
})(jQuery);
/*!
 * Really simple client-side caching of html partials that don't change very often.
 * @author: Jon Hartman
 * @credit: Focus43 (http://focus-43.com)
 */
(function($){

    /**
     * Add hash code prototype to string object.
     * @returns {number}
     */
    String.prototype.hashCode = function(){
        var hash = 0, i, l, char;
        if (this.length === 0){ return hash; }
        for (i = 0, l = this.length; i < l; i++) {
            char  = this.charCodeAt(i);
            hash  = ((hash<<5)-hash)+char;
            hash |= 0; // Convert to 32bit integer
        }
        return hash;
    };


    /**
     * Make a request from local sessionStorage, if available.
     * @param _key
     * @returns {*}
     */
    function getLocal( _key ){
        return (Modernizr.sessionstorage) ? sessionStorage.getItem( _key ) : null;
    }


    /**
     * Set a value in local sessionstorage, if available.
     * @param _key
     * @param data
     * @return bool
     */
    function setLocal( _key, data ){
        if( Modernizr.sessionstorage ){
            sessionStorage.setItem( _key, data );
            return true;
        }
        return false;
    }


    /**
     * Cache the... promise... cache objects. Inception style shit.
     * @type {}
     */
    var promiseCache  = {};


    /**
     * Bind the method to jquery so globally available.
     * @param _key
     * @param _sourceFunction
     * @param _returnType
     * @returns {*}
     */
    $.clientCache = function( _key, _sourceFunction, _returnType ){
            // set the data type, if not defined defaults to html
        var dataType = typeof _returnType !== 'undefined' ? _returnType : 'html',
            // make sure the key is in unique hash form
            cacheKey = _key + '_' + ('c@che' + _key).hashCode() + dataType;

        // does the promise exist already? if not, create it
        if( !promiseCache[cacheKey] ){
            // create the deferred object, and return the promise
            promiseCache[cacheKey] = $.Deferred(function( _task ){
                // query local storage
                var _result = getLocal(cacheKey);

                // cache hit? return as the specified data type
                if( _result ){
                    var _data = (dataType === 'json') ? JSON.parse(_result) : _result;
                    console.log('SessionCache hit on: ' + _key);
                    _task.resolve( _data );
                    return;
                }

                // if we get here, register a callback to *set* the cache data on success
                // from the _sourceFunction
                _task.done(function( data ){
                    var _data = (dataType === 'json') ? JSON.stringify(data) : data;
                    setLocal( cacheKey, _data );
                });

                // original source
                _sourceFunction( _task );
            }).promise();
        }

        // return the promise from the cache key
        return promiseCache[ cacheKey ];
    };


    /**
     * @todo THIS NEEDS TO BE REFACTORED SO WE HAVE A SINGLE LIBRARY WE CAN CALL THIS
     * FROM.
     * @param _key
     */
    $.clientCacheBust = function( _key, _returnType ){
        var dataType = typeof _returnType !== 'undefined' ? _returnType : 'html',
            // make sure the key is in unique hash form
            cacheKey = _key + '_' + ('c@che' + _key).hashCode() + dataType;
        // bust it
        sessionStorage.removeItem(cacheKey);
    };

})(jQuery);
(function( $, Modernizr ){

    // Cache common selectors
    var _self       = this,
        $document   = $(document),
        $body       = $('body'),
        $settings   = $('#siteSettings'),
        $sidebarLeft = $('#sidebarLeft'),
        $sidebarRight = $('#sidebarRight');


    /**
     * Handle large backgrounds. If unsupported natively, Modernizr will take
     * care of. The code below checks if background-size:cover *is* supported,
     * and then adds the background image (acts as a lazy-loader).
     */
    if( typeof(Modernizr) !== 'undefined' && Modernizr.backgroundsize ){
        $('[data-background]').each(function(index, element){
            $(element).css('backgroundImage', 'url('+element.getAttribute('data-background')+')');
        });
    }


    // css transitions
    this.transitionEnd  = 'transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd';


    // lazy-load sidebar content, if visible (auto-triggers on init)
    if( !$body.hasClass('edit-mode') ){
        if( $body.hasClass('cms-admin') ){
            sessionStorage.clear();
        }

        $document.on(_self.transitionEnd, '#cL1', function( _transitionEvent ){
            if( _transitionEvent.target === this ){
                var _bodyWidth = $body.outerWidth();

                if( _bodyWidth >= 1200 ){
                    if( $sidebarLeft.attr('data-load') ){
                        $.clientCache('leftSidebar', function( _task ){
                            $.get($sidebarLeft.attr('data-load'), function( _htmlResponse ){
                                _task.resolve(_htmlResponse);
                            }, 'html');
                        }).done(function( _htmlResults ){
                                $sidebarLeft.append( _htmlResults).removeAttr('data-load');
                                $sidebarLeft.trigger('sidebar_left_open');
                            });
                    }
                }

                if( _bodyWidth >= 1334 ){
                    $.clientCache('rightSidebar', function( _task ){
                        $.get($sidebarRight.attr('data-load'), function( _htmlResponse ){
                            _task.resolve(_htmlResponse);
                        }, 'html');
                    }).done(function( _htmlResults ){
                            $sidebarRight.append( _htmlResults).removeAttr('data-load');
                            $document.off(_self.transitionEnd, '#cL1');
                        });
                }
            }
        });
    }else{
        $('.sidebars').removeAttr('data-load');
    }


    // weather data for sidebars
    $document.on('sidebar_left_open', function(){
        $.clientCache('weatherData', function( _task ){
            $.simpleWeather({zipcode: '83002', unit: 'f', success: function(weather){
                _task.resolve(weather);
            }});
        }, 'json').done(function( weather ){
                $('.panel-body', '#sidebarLeft .weatherWidget').empty().append(function(){
                    return '<img src="'+weather.thumbnail+'" />'+weather.temp+'&deg;'+weather.units.temp+' &nbsp;<span class="badge">'+weather.currently+'</span>';
                });
            });
    });


    // auto-trigger the transition event (load sidebar content) on init
    $('#cL1').trigger('transitionend');


    /**
     * Accessibility settings
     */
    $document.on('click', '#openSettings, #closeSettings', {overlay: $settings}, function(_clickEv){
        var _top = _clickEv.data.overlay.data('toggled') === true ? '-100%' : 0;
        $('#siteSettings').animate({top:_top}, 300, 'easeOutExpo').data('toggled', !_clickEv.data.overlay.data('toggled'));
    });


    /**
     * Toggle the font size
     */
    $settings.on('click', '.setFontSize', function(){
        var _value = $(this).attr('data-zoom');
        if( _value === 'default' ){
            $body.removeAttr('data-zoom');
            return;
        }
        $body.attr('data-zoom', _value);
    });


    /**
     * Modal windows
     */
    $document.on('click', '.modalize', function(_clickEvent){
        _clickEvent.preventDefault();
        var $this = $(this),
            _uri  = $this.attr('href');

        if( _uri.length ){
            $.get(_uri, {modal:true}, function(_html){
                var $modal = $(_html);
                $modal.appendTo($body).modal();
            }, 'html');
            return;
        }

        // if we get here, show error message
        alert('Unable to load requested page.');
    });


    /**
     * Popovers and tooltips
     */
    $document.popover({
        animation: false,
        selector: '.showPopover',
        trigger: 'hover',
        placement: function(){
            return this.$element.attr('data-placement') || 'top';
        },
        container: 'body'
    }).tooltip({
        animation: false,
        selector: '.showTooltip',
        trigger: 'hover focus',
        placement: function(){
            return this.$element.attr('data-placement') || 'top';
        },
        container: 'body'
    });


    // header news & current, set icon class
    $.ajax({
        url: $('#tojAppPaths').attr('data-tools') + '_data/current',
        dataType: 'json',
        cache: false,
        success: function( _resp ){
            var iconColor = (_resp.criticals) ? 'text-danger' : (_resp.warnings) ? 'text-warning' : 'text-success',
                iconClass = (_resp.criticals) ? 'fa-exclamation-triangle' : (_resp.warnings) ? 'fa-exclamation-circle' : 'fa-check-circle';

            // find both icons (mobile and desktop navigation view) to replace
            $('.status-alert-icon', '#primaryNav').find('i.fa').replaceWith('<i class="fa '+iconColor+' '+iconClass+'" />');

            // create alertGroup dom elements
            var $alertGroup = $('<div class="alertGroup" />');

            // append any criticals
            if( _resp.criticals ){
                $.each( _resp.criticals, function(idx, obj){
                    $alertGroup.append('<a class="alert alert-danger" href="'+obj.path+'"><i class="fa fa-exclamation-triangle"></i><span> '+obj.name+'</span></a>');
                });
                $.clientCacheBust('leftSidebar');
            }

            // append any warning
            if( _resp.warnings ){
                $.each( _resp.warnings, function(idx, obj){
                    $alertGroup.append('<a class="alert alert-warning" href="'+obj.path+'"><i class="fa fa-exclamation-circle"></i><span>'+obj.name+'</span></a>');
                });
                $.clientCacheBust('leftSidebar');
            }

            // if theres none of the above, create OK message
            if( ! $('.alert', $alertGroup).length ){
                $alertGroup.append('<a class="alert alert-success no-icon"><span>No warnings or critical alerts are currently issued.</span></a>');
            }

            // replace in desktop hover menu
            $('h5.updating', '#primaryNav').replaceWith($alertGroup);

            // create the popover for mobile
            $('.status-alert-icon', '#primaryNav .navbar-header').popover({
                animation: false,
                html: true,
                placement: 'bottom',
                title: 'Current Alerts',
                content: $alertGroup.clone(),
                trigger: 'click',
                container: '#primaryNav'
            });
        }
    });


    // hook into eventclick.schedulzier custom one
    $document.on('eventclick.schedulizer', function(clickEv, calEv){
        //console.log(clickEv);
        $.get($('#tojAppPaths').attr('data-tools') + 'schedulizer_event_view', {eventID: calEv.id}, function(_html){
            var $modal = $(_html);
            $modal.appendTo($body).modal();
        }, 'html');
    });


    /**
     * Load the apis for twitter and facebook? only if .sociable is visible...
     */
    if( $('.sociable', '#cPageContent').is(':visible') ){
        // facebook
        $body.append('<div id="fb-root"></div>');
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if(d.getElementById(id)){return;}
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&status=0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        // twitter
        (function(d,s,id){
            var js,fjs=d.getElementsByTagName(s)[0];
            if(!d.getElementById(id)){
                js=d.createElement(s);
                js.id=id;
                js.src="https://platform.twitter.com/widgets.js";
                fjs.parentNode.insertBefore(js,fjs);

            }
        }(document,"script","twitter-wjs"));
    }


    /**
     * jQuery Easing Methods
     */
    jQuery.extend( jQuery.easing, {
        easeInSine: function (x, t, b, c, d) {
            return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
        },
        easeInExpo: function (x, t, b, c, d) {
            return (t===0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
        },
        easeOutExpo: function (x, t, b, c, d) {
            return (t===d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
        }
    });

})( jQuery, Modernizr || {} );