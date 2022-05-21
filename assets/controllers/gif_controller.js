import {Controller} from "@hotwired/stimulus";

export default class extends Controller {

    static targets = ["dropdown"];

    connect() {
        // récupération des éléments jquery
        this._element = $(this.element);
        this._dropdown = $(this.dropdownTarget);

        // initialisation des dropdown
        this._dropdown.dropdown({

        });
    }
}