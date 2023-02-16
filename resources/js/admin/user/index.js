import $ from "jquery";
import { SendAction } from "@utilities";

(function () {
    const DeleteAction = new SendAction();

    $(".btn-submit-delete-modal").on("click", function () {
        DeleteAction.set($(this).data("user-id"), $(this).data("user-name"));
        DeleteAction.render();
    });

    $("#save").on("click", () => {
        DeleteAction.send(
            document.getElementById(
                `user-form-delete-${DeleteAction.get("id")}`
            )
        );
    });
})();
