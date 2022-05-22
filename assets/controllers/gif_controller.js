import {Controller} from "@hotwired/stimulus";

export default class extends Controller {

    static targets = ["card"];

    connect() {
        // récupération des éléments jquery
        this._element = $(this.element);
        this._card = $(this.cardTargets);

        this._card.each(function () {
            $(this).dimmer({
                on: 'hover'
            });
        })
    }
}