import $ from "jquery";
import SendAction from "@utilities";

(function () {
    const DeleteAction = new SendAction();

    $(".btn-submit-delete-modal").on("click", function () {
        DeleteAction.set(
            $(this).data("category-id"),
            $(this).data("category-name")
        );
        DeleteAction.render();
    });

    $("#save").on("click", () => {
        DeleteAction.send(
            document.getElementById(
                `category-form-delete-${DeleteAction.get("id")}`
            )
        );
    });
})();
