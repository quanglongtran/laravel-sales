import $ from "jquery";

$(".redirect").on("click", function () {
    window.location.href = $(this).attr("href");
});
