import $ from "jquery";
import { SendAction } from "@utilities";

(function () {
    const DeleteAction = new SendAction();

    $(".btn-submit-delete-modal").on("click", function () {
        DeleteAction.set($(this).data("role-id"), $(this).data("role-name"));
        DeleteAction.render();
    });

    $("#save").on("click", () => {
        DeleteAction.send(
            document.getElementById(
                `role-form-delete-${DeleteAction.get("id")}`
            )
        );
    });
})();
