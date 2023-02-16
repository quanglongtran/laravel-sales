import $ from "jquery";
import { SendAction } from "@utilities";

const DeleteAction = new SendAction();

$(".btn-submit-delete-modal").on("click", function () {
    DeleteAction.set($(this).data("coupon-id"), $(this).data("coupon-name"));
    DeleteAction.render();
});

$("#save").on("click", () => {
    DeleteAction.send(
        document.getElementById(`coupon-form-delete-${DeleteAction.get("id")}`)
    );
});
