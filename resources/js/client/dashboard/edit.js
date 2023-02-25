import { ajaxSetup, options } from "@config";
import { SendAction2 } from "@utilities";
import $ from "jquery";
import _ from "lodash";
import Swal from "sweetalert2";
ajaxSetup(options);

(function () {
    $(".edit-form").each(function (index, item) {
        let input = $(item).find("input").not("[type=hidden]");

        if (input.length > 1) {
            Swal.fire({
                title: "Just one input in every form",
                icon: "error",
            });

            throw new Error("Just one input in every form");
        } else if (input.length < 1) {
            input = $(item).find("textarea");
        }

        const edit = new SendAction2(item, input, $("#url-edit-form").text());

        edit.submit()
            .then((response) => {
                Swal.fire({
                    title: response.message,
                    icon: response.success ? "success" : "error",
                });
            })
            .catch((response) => {
                Swal.fire({
                    title: "The server has an error!",
                    icon: "error",
                });
            });
    });

    $(".preview").on("submit", function (e) {
        // e.preventDefault();
        // console.log($(this).find('[name=avatar]')[0].files[0])
    });

    $(".preview")
        .find("[name=avatar]")
        .on("change", function () {
            var button = document.createElement("button");
            $(button)
                .addClass("btn btn-info")
                .html("Submit")
                .css({
                    display: 'block',
                    margin: '10px auto'
                })
                .appendTo($(".preview"));

            $(".preview").css("marginBottom", "40px");
            // .trigger('submit');
        });

    if ($("#verify-email-btn").length) {
        $("#verify-email-btn").on("click", function (e) {
            e.preventDefault();

            Swal.fire({
                title: "Email verification",
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(this).data("url"),
                        success: (response) => {
                            Swal.fire({
                                title: response.message,
                                icon: response.success ? "success" : "error",
                            });
                        },
                    });
                }
            });
        });
    }
})();
