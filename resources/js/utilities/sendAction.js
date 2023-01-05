class SendAction {
    "use strict";
    /**
     *
     * @param {HTMLElement} showDeleteInput
     */
    constructor(showDeleteInput) {
        this.id = 0;
        this.name = "";
        this.showDeleteInput =
            showDeleteInput ?? document.getElementById("modal-delete-text");
    }

    set(id, name) {
        this.id = id;
        this.name = name;
    }

    get(param) {
        if (param == "id") {
            return this.id;
        } else if (param == "name") {
            return this.name;
        }

        return {
            id: this.id,
            name: this.name,
        };
    }

    render() {
        this.showDeleteInput.innerText = `Delete ${this.get("name")}`;
    }

    send(form) {
        form.submit();
    }
}

export default SendAction;
