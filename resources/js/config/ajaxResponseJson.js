import $ from "jquery";
import Swal from "sweetalert2";

if ($('meta[name="csrf-token"]').length == 0) {
    Swal.fire({
        title: "CSRF token is required!",
        text: `Copy '<meta name="csrf-token" content="{{ csrf_token() }}">' then paste to <head> tag`,
        icon: "error",
    });
}

export const options = {
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        Accept: "application/json",
    },
};

export const ajaxSetup = $.ajaxSetup;
