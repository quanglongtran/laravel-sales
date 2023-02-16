import $ from "jquery";
import Swal from "sweetalert2";
import { ajaxSetup, options } from "@config";

ajaxSetup(options);

(function () {
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
        var finalPrice = price - Number($(".coupon-value").text());
        $(".final-price").text(finalPrice >= 0 ? finalPrice : 0);
    }
    class Main {
        constructor(row) {
            this.quantity = 0;
            this.input = row.find(".show-quantity");
            this.initQuantity(this.input.val());
            this.setQuantity(this.input.val(), this.input.parents("tr"));
        }

        initQuantity(quantity) {
            this.quantity = quantity;
            return this;
        }

        getQuantity() {
            return this.quantity;
        }

        maxQuantity(showOverQuantity) {
            if (this.input.val() >= this.getQuantity()) {
                this.input.val(this.getQuantity());
                showOverQuantity.text(
                    "The quantity you selected has reached the maximum of this product"
                );

                if (this.getQuantity() == 0) {
                    showOverQuantity.text("Out of products");
                }
            } else {
                showOverQuantity.text("");
            }
        }

        renderQuantity(newVal, row) {
            if (newVal != this.getQuantity() && newVal != 0) {
                row.find(".btn-submit-delete").css("display", "none");
                row.find(".btn-submit-save").css("display", "inline-block");
                this.changed = true;
                return true;
            } else {
                row.find(".btn-submit-delete").css("display", "inline-block");
                row.find(".btn-submit-save").css("display", "none");
                this.changed = false;
                return false;
            }
        }

        setQuantity(newVal, row) {
            let btn = row.find(".btn-submit-action");
            let form = btn.parents("form");
            this.url = form.attr("action");
            let totalPrice = row.find(".total-price");
            totalPrice.text(
                this.getQuantity() * totalPrice.data("product-price")
            );

            form.find("input[name=product_quantity]").val(newVal);
            form.off("submit");
            form.on("submit", (e) => e.preventDefault());

            this.renderQuantity(newVal, row);

            btn.off("click");
            btn.on("click", () => {
                this.submit(newVal, row);
            });
            totalPriceFn();
        }

        submit(newVal, row) {
            const text =
                this.changed && newVal != 0
                    ? "Do you want to save changes?"
                    : "Do you want to delete this product?";

            Swal.fire({
                title: "Are you sure?",
                text,
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: this.url,
                        type: "POST",
                        data: {
                            product_quantity: this.changed ? newVal : 0,
                        },
                        success: (response) => {
                            if (response.success) {
                                if (response.data.quantity != 0) {
                                    this.initQuantity(response.data.quantity);
                                    this.setQuantity(
                                        response.data.quantity,
                                        row
                                    );
                                } else {
                                    row.remove();
                                }
                                Swal.fire(response.message, "", "success");
                            }
                        },
                    });
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        }
    }

    $(".quantity-group-btn").each(function (index, item) {
        let row = $(item).parents("tr");

        const main = new Main(row);

        $(item)
            .find("button")
            .on("click", function () {
                var button = $(this);
                var oldValue = button.parent().parent().find("input").val();

                if (button.hasClass("btn-plus")) {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    if (oldValue > 0) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 0;
                    }
                }

                button.parent().parent().find("input").val(newVal);
                main.setQuantity(newVal, row);
            });
    });

    $("[name=coupon_code]").each(function (index, item) {
        $(item)
            .parents("form")
            .find("button")
            .on("click", function () {
                if ($(item).val() != "") {
                    $.ajax({
                        url: $(item).parents("form").attr("action"),
                        type: "post",
                        data: {
                            coupon_code: $(item).val(),
                        },
                        success: (response) => {
                            Swal.fire({
                                text: response.message,
                                icon: response.success ? "success" : "error",
                            });
                            if (response.success) {
                                totalPriceFn(
                                    response.data.discount_amount_price
                                );
                            } else {
                                totalPriceFn(0);
                            }
                        },
                    });
                } else {
                    Swal.fire("Please enter coupon code", "", "info");
                }
            });
    });
    totalPriceFn();
})();
