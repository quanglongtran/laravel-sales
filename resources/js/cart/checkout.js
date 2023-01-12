import $ from "jquery";

(function () {
    "use strict";
    // document.querySelector('.final-price').innerText = document.querySelector('.total-price').innerText - document
    //         .querySelector('.coupon-value').innerText + +document.querySelector('.shipping-price').innerText

    function totalPriceFn(couponVal) {
        if (couponVal) {
            $(".coupon-value")
                .text(couponVal)
                .parents(".d-none")
                .addClass("d-flex");
        }

        let price = 0;
        $(".total-price").each(function (index, item) {
            price += Number($(item).text());
        });
        $(".sub-total-price").text(price);
        $(".final-price").text(price - Number($(".coupon-value").text()));
    }

    totalPriceFn();

    var form = $(".order-form");
    $(".btn-submit-order").on("click", function () {
        form.append(`
            <input type="hidden" name="total" value="${Number(
                $(".final-price").text()
            )}"/>
            <input type="hidden" name="ship" value="20000"/>
        `);
        form.trigger("submit");
    });
})();
