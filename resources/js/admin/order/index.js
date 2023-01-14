import $ from "jquery";
import Swal from "sweetalert2";
import { ajaxSetup, options } from "@config";
ajaxSetup(options);

$(function () {
    "use strict";
    $(".change-status").on("change", function () {
        $.ajax({
            url: $(this).data("url"),
            type: "PUT",
            data: {
                order_id: $(this).data("order-id"),
                status: $(this).val(),
            },
            success: (response) => {
                if (!response.success) {
                    Swal.fire({
                        title: "Error!",
                        text: response.message + "\ntry reloading the page",
                        icon: "error",
                        // footer: "<span class='hover font-semibold'>Reload</span>",
                        footer: "<a href='#' onclick='window.location.reload()'>Reload</a>",
                    });
                }
            },
        });
    });
});
