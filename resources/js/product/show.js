import $ from "jquery";
import Swal from "sweetalert2";

$(function () {
    class Quantity {
        constructor() {
            this.quantity = 0;
        }

        setQuantity(quantity) {
            this.quantity = quantity;
        }

        getQuantity() {
            return this.quantity;
        }

        maxQuantity() {
            const input = $("#show-quantity");
            if (input.val() >= this.getQuantity()) {
                input.val(this.getQuantity());
                $(".over-quantity").text(
                    "The quantity you selected has reached the maximum of this product"
                );

                if (this.getQuantity() == 0) {
                    $(".over-quantity").text("Out of products");
                }
            } else {
                $(".over-quantity").text("");
            }
        }
    }

    class SendActionCustom {
        constructor() {
            this.form = document.createElement("form");
            this.form.setAttribute("method", "post");
            this.form.innerHTML += `<input type="hidden" name="_token" value="${$(
                'meta[name="csrf-token"]'
            ).attr("content")}"/>`;
            document.body.appendChild(this.form);
            this.details = {};
            this.setSize();
        }

        setSize() {
            $(".custom-control-input-size").each((index, item) => {
                if (item.checked) {
                    this.details.size = item.value;
                    this.details.product_id = $(item).data("product-id");
                }
            });
        }

        get() {
            return {
                size: this.details.size,
                product_id: this.details.product_id,
                quantity: this.details.quantity,
            };
        }

        send(url) {
            const form = this.form;
            $(form).attr("action", url);
            for (let i in this.get()) {
                $(form).append(
                    `<input type="hidden" name="${i}" value="${this.get()[i]}">`
                );
            }

            form.submit();
        }
    }

    const quantity = new Quantity();

    $(".set-quantity[data-quantity]").each(function (item, index) {
        const setNewQuantity = () => {
            if ($(this).children("[name=size]").is(":checked")) {
                quantity.setQuantity($(this).data("quantity"));
                $("#remaining-quantity").text(
                    `Quantity: ${quantity.getQuantity()}`
                );

                const inputShow = $("#show-quantity");
                inputShow.attr("max", quantity.getQuantity());
                quantity.maxQuantity();
                inputShow.on("input changeproperty", () =>
                    quantity.maxQuantity()
                );
            }
        };

        setNewQuantity();

        $(this).on("click", () => {
            setNewQuantity();
        });
    });

    // Product Quantity
    $(".quantity button").on("click", function () {
        var button = $(this);
        var oldValue = button.parent().parent().find("input").val();
        if (button.hasClass("btn-plus")) {
            if (quantity.getQuantity() > Number(oldValue)) {
                var newVal = parseFloat(oldValue) + 1;
            } else {
                newVal = quantity.getQuantity();
            }
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        quantity.maxQuantity();
        button.parent().parent().find("input").val(newVal);
    });

    $(".set-quantity").on("click", function () {
        quantity.setQuantity($(this).data("quantity"));
    });

    const addToCart = new SendActionCustom();

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    });

    $(".custom-control-input-size").on("click", function () {
        addToCart.setSize();
    });

    $(".add-to-cart-btn").on("click", function (e) {
        addToCart.details.quantity = $("#show-quantity").val();

        swalWithBootstrapButtons
            .fire({
                title: "Add this to your cart",
                text: "Size: M, Quantity: 1",
                imageUrl: $("#product-img").attr("src"),
                showCancelButton: true,
                imageAlt: "Custom image",
                confirmButtonText: "Add to card",
            })
            .then((result) => {
                if (result.isConfirmed) {
                    addToCart.send("http://127.0.0.1:8000/cart");

                    // swalWithBootstrapButtons.fire(
                    //     "Successfully!",
                    //     "The product has been added to your cart.",
                    //     "success"
                    // );
                }
            });
    });
});
