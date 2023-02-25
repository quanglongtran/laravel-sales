import $ from "jquery";
import Swal from "sweetalert2";
import _ from "lodash";

class SendAction2 {
    constructor(form, input, url) {
        this.data = {};
        this.form = $(form);
        this.input = input;
        this.url = url;
        this.showSaveBtn(this.input.val());
        this.inputAddEvent();
    }

    inputAddEvent() {
        this.input.on("input changeproperty", (e) => {
            this.setData(
                $(e.target).attr("name"),
                this.showSaveBtn(
                    $(e.target)
                        .val()
                        .replace(/[\n\r]+/g, " ")
                )
            );
        });
    }

    setData(key, value) {
        this.data[key] = value;
    }

    showSaveBtn(newVal) {
        if (newVal.trim() == this.form.data("value").trim()) {
            this.form.find(".btn-submit").remove();
        } else {
            if (this.form.find(".btn-submit").length === 0) {
                this.form.append(
                    `<button class="btn btn-info btn-submit" style="color: aliceblue">Save</button>`
                );
            }
        }

        return newVal;
    }

    submit() {
        return new Promise((resolve, reject) => {
            this.form.on("submit", (e) => {
                e.preventDefault();

                Swal.fire({
                    title: "Info",
                    text: `Do you want to edit this info?`,
                    showCancelButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        const success = (response) => {
                            resolve(response);
                            const key = _.keys(response.data.request)[0];
                            this.setData(key, response.data.request[key]);
                            this.form.data("value", this.data[key]);
                            this.showSaveBtn(this.data[key]);
                        };

                        const error = (response) => {
                            reject(response);
                        };

                        $.ajax({
                            type: "PUT",
                            url: this.url,
                            data: this.data,
                            success,
                            error,
                        });
                    }
                });
            });
        });
    }
}

export default SendAction2;
