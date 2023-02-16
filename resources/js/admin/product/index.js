import $ from "jquery";
import { SendAction } from "@utilities";

(function () {
    const DeleteAction = new SendAction();

    $(".btn-submit-delete-modal").on("click", function () {
        DeleteAction.set(
            $(this).data("product-id"),
            $(this).data("product-name")
        );
        DeleteAction.render();
    });

    $("#save").on("click", () => {
        DeleteAction.send(
            document.getElementById(
                `product-form-delete-${DeleteAction.get("id")}`
            )
        );
    });

    $(".redirect").on("click", function () {
        window.location.href = $(this).attr("href");
    });
})();
