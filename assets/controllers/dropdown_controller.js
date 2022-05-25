import {Controller} from "@hotwired/stimulus";

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ["dropdown"];

    connect() {
        // récupération des éléments jquery
        this._element = $(this.element);
        this._dropdown = $(this.dropdownTargets);

        // initialisation des dropdown
        this._dropdown.each(function() {
            $(this).dropdown({
                type: 'menu',
            });
        });
    }
}