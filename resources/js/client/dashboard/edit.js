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

    if ($("#verify-email-btn").length) {
        $("#verify-email-btn").on("click", function (e) {
            e.preventDefault();

            Swal.fire({
                title: "aa",
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
