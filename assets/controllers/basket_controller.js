import {Controller} from "@hotwired/stimulus";

export default class extends Controller {

    static targets = ["modal"];

    connect() {
        // récupération des éléments jquery
        this._element = $(this.element);
        this._modal = $(this.modal);

        console.log(this._modal);
        this._modal.modal({
            closable: true,
        });
    }

    show(event) {
        this._modal.modal("show");
    }

    add(event) {

    }

     delete(event) {

     }
}