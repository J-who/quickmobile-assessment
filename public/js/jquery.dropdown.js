/*
 * jQuery dropdown: A simple dropdown plugin
 *
 * Inspired by Bootstrap: http://twitter.github.com/bootstrap/javascript.html#dropdowns
 *
 * Copyright 2013 Cory LaViska for A Beautiful Site, LLC. (http://abeautifulsite.net/)
 *
 * Dual licensed under the MIT / GPL Version 2 licenses
 *
 */
if (jQuery) (function ($) {

    $.extend($.fn, {
        dropdown: function (method, data) {

            switch (method) {
                case 'show':
                    show(null, $(this));
                    return $(this);
                case 'hide':
                    hide();
                    return $(this);
                case 'attach':
                    return $(this).attr('data-dropdown', data);
                case 'detach':
                    hide();
                    return $(this).removeAttr('data-dropdown');
                case 'disable':
                    return $(this).addClass('dropdown2-disabled');
                case 'enable':
                    hide();
                    return $(this).removeClass('dropdown2-disabled');
            }

        }
    });

    function show(event, object) {

        var trigger = event ? $(this) : object,
            dropdown = $(trigger.attr('data-dropdown')),
            isOpen = trigger.hasClass('dropdown2-open');

        // In some cases we don't want to show it
        if (event) {
            if ($(event.target).hasClass('dropdown2-ignore')) return;

            event.preventDefault();
            event.stopPropagation();
        } else {
            if (trigger !== object.target && $(object.target).hasClass('dropdown2-ignore')) return;
        }
        hide();

        if (isOpen || trigger.hasClass('dropdown2-disabled')) return;

        // Show it
        trigger.addClass('dropdown2-open');
        dropdown
            .data('dropdown2-trigger', trigger)
            .show();

        // Position it
        position();

        // Trigger the show callback
        dropdown
            .trigger('show', {
                dropdown: dropdown,
                trigger: trigger
            });

    }

    function hide(event) {

        // In some cases we don't hide them
        var target = event ? $(event.target) : null;
        var targetGroup = event ? target.parents().addBack() : null;

        // Are we clicking anywhere in a dropdown?
        if (targetGroup && targetGroup.is('.dropdown2')) {
            // Is it a dropdown menu or select object?
            if (targetGroup.is('.dropdown2-menu')) {
                // Did we click on an option? If so close it.
                if (!targetGroup.is('A')) return;
            } else if (targetGroup.is('.dropdown2-select')) {
                // Did we click on an option? If so close it.
                if (!targetGroup.is('A')) return;
                //Set text of trigger to selected option
                $("[data-dropdown=#" + target.closest(".dropdown2").attr("id") + "]").text(target.text());
                target.closest("li").addClass("dropdown2-selected").siblings().removeClass("dropdown2-selected");
            } else {
                // Nope, it's a panel. Leave it open.
                return;
            }
        }

        // Hide any dropdown that may be showing
        $(document).find('.dropdown2:visible').each(function () {
            var dropdown = $(this);5
            dropdown
                .hide()
                .removeData('dropdown2-trigger')
                .trigger('hide', { dropdown: dropdown });
        });

        // Remove all dropdown2-open classes
        $(document).find('.dropdown2-open').removeClass('dropdown2-open');

    }

    function position() {

        var dropdown = $('.dropdown2:visible').eq(0),
            trigger = dropdown.data('dropdown2-trigger'),
            hOffset = trigger ? parseInt(trigger.attr('data-horizontal-offset') || 0, 10) : null,
            vOffset = trigger ? parseInt(trigger.attr('data-vertical-offset') || 0, 10) : null;

        if (dropdown.length === 0 || !trigger) return;

        // Position the dropdown relative-to-parent...
        if (dropdown.hasClass('dropdown2-relative')) {
            dropdown.css({
                left: dropdown.hasClass('dropdown2-anchor-right') ?
                    trigger.position().left - (dropdown.outerWidth(true) - trigger.outerWidth(true)) - parseInt(trigger.css('margin-right')) + hOffset :
                    trigger.position().left + parseInt(trigger.css('margin-left')) + hOffset,
                top: trigger.position().top + trigger.outerHeight(true) - parseInt(trigger.css('margin-top')) + vOffset
            });
        } else {
            // ...or relative to document
            dropdown.css({
                left: dropdown.hasClass('dropdown2-anchor-right') ?
					trigger.offset().left - (dropdown.outerWidth() - trigger.outerWidth()) + hOffset : trigger.offset().left + hOffset,
                top: trigger.offset().top + trigger.outerHeight() + vOffset
            });
        }
    }

    $(document).on('click.dropdown2', '[data-dropdown]', show);
    $(document).on('click.dropdown2', hide);
    $(window).on('resize', position);
    $(function () {
        setTimeout(function () {
            $(".dropdown2-select").each(function () {
                if ($(this).find(".dropdown2-selected").length == 0) return;
                $("[data-dropdown=#" + $(this).closest(".dropdown2").attr("id") + "]").text($(this).find(".dropdown2-selected").text());
            });
        }, 1);
    });

})(jQuery);
