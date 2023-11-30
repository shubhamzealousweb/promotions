define(['jquery',
    'ko',
    'mage/storage',
    'uiComponent',
    'Magento_Checkout/js/model/quote',
    'Magento_SalesRule/js/action/set-coupon-code',
    'Magento_SalesRule/js/action/cancel-coupon',
    'Magento_SalesRule/js/model/coupon',
    'mage/url',
    'Magento_Ui/js/modal/modal',
    'Magento_Customer/js/model/customer',
], function ($, ko, storage, Component, quote, setCouponCodeAction, cancelCouponAction, coupon, url, modal, customer) {
    'use strict';

    var totals = quote.getTotals(),
        couponCode = coupon.getCouponCode(),
        isApplied = coupon.getIsApplied();

    var options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: 'Coupon Codes',
        buttons: [{
            text: 'Cancel',
            class: '',
            click: function () {
                this.closeModal();
            }
        }]
    };

    if (totals()) {
        couponCode(totals()['coupon_code']);
    }
    isApplied(couponCode() != null);

    return Component.extend({
        defaults: {
            template: 'Zealousweb_Promotions/payment/discount'
        },
        couponCode: couponCode,
        isApplied: isApplied,
        coupons: ko.observableArray(),
        isEmpty: ko.observable(1),
        isPopup: window.isPopup,
        isEnableModule: window.isModuleEnable,
        isCustomerLoggedIn: customer.isLoggedIn,
        isGuestCustomerAllowed: window.isGuestCustomerAllowed,

        initialize: function () {
            var linkUrl = url.build('promotions/index/items');
            this._super();
            var self = this;
            $.post(linkUrl).done(
                function (response) {
                    if (response.data.length > 2) {
                        self.coupons(JSON.parse(response.data));
                        self.isEmpty(0);
                    }
                }.bind(this)
            ).fail(
                function (response) {
                }.bind(this)
            );
        },

        apply: function (code) {
            $('.apply-coupon-code-grid-table').hide();
            setCouponCodeAction(code.code, isApplied);
            couponCode(code.code);
        },

        cancel: function () {
            $('.apply-coupon-code-grid-table').hide();
            couponCode('');
            cancelCouponAction(isApplied);
        },

        isSameCoupon: function (code) {
            return (code == couponCode() && isApplied());
        },

        showPopup: function () {
            var popup = modal(options, $('.apply-coupon-code-grid-table'));
            $(".apply-coupon-code-grid-table").modal("openModal");
        },

        showSlider: function () {
            if ($('.apply-coupon-code-grid-table').is(':visible')) {
                $('.apply-coupon-code-grid-table').hide();
            } else {
                $('.apply-coupon-code-grid-table').show();
            }
        },

        showCoupons: function () {
            return (isCustomerLoggedIn || isGuestCustomerAllowed)
        },

        getToDateFormat: function (to_date) {
            return new Date(to_date).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"})
        },

        showInCart: function(show_in_cart) {
            return (show_in_cart == 1) ? true : false;
        },

        disable: function (code) {
            return (code != couponCode() && isApplied());
        },

        appendDiv: function() {
            $('.payment-option-content').append($('.view-promotional-code-content'));
        }
    });
});