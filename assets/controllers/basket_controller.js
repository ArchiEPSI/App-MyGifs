import {Controller} from "@hotwired/stimulus";

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ["modal", "content"];

    connect() {
        // récupération des éléments jquery
        this._element = $(this.element);
        this._modal = $(this.modalTarget);
        this._content = $(this.contentTarget);

        console.log(this._modal);
        this._modal.modal({
            closable: true,
        });
    }

    show(event) {
        this._modal.modal("show");
    }

    close() {
        this._modal.modal("hide");
    }

    getBasket() {
        this._content.addClass("loading");
    }

    add(event) {
        let btn = $(event.target);
        let url = event.params.url;
        console.log(url, btn);
        btn.addClass("loading disabled");
        // requête ajax
        $.ajax({
            url: url,
            method: "POST",
            success: function(data) {
                // modification du compteur du panier
            },
            error: function (error) {

            },
        }).bind(this);
        btn.removeClass("loading disabled");
    }
     delete(event) {

     }
}