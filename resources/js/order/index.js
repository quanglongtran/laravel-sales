import $ from "jquery";
import Swal from "sweetalert2";
import { options, ajaxSetup } from "@config";

ajaxSetup(options);

(function () {
    $(".btn-submin-cancel").each(function (index, item) {
        $(item).on("click", function () {
            Swal.fire({
                title: "Info",
                text: `Do you want to cancel this order?`,
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: $(item).data("url"),
                        success: (response) => {
                            if (response.success) {
                                $(item).parents("tr").remove();
                            }
                            Swal.fire({
                                icon: response.success ? "success" : "error",
                                text: response.message,
                            });
                        },
                    });
                }
            });
        });
    });
})();
