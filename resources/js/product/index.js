import jQuery from "jquery";
const $ = jQuery;

$(".redirect").on("click", function () {
    window.location.href = $(this).attr("href");
});
