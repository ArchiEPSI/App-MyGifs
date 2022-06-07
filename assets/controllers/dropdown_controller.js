import {Controller} from "@hotwired/stimulus";

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ["dropdown", "dropdownMenu"];

    connect() {
        // récupération des éléments jquery
        this._element = $(this.element);
        this._dropdown = $(this.dropdownTargets);
        this._dropdownMenu = $(this.dropdownMenuTargets);

        this._dropdownMenu.dropdown({
            type: "menu",
        })
        // initialisation des dropdown
        this._dropdown.each(function() {
            $(this).dropdown();
        });
    }
}