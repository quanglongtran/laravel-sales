import $ from "jquery";

export const options = {
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        Accept: "application/json",
    },
};

export const ajaxSetup = $.ajaxSetup;
