import {Controller} from "@hotwired/stimulus";
import Notify  from "simple-notify";

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ["modal", "content", "indicator"];

    connect() {
        // récupération des éléments jquery
        this._element = $(this.element);
        this._modal = $(this.modalTarget);
        this._content = $(this.contentTarget);
        this._indicator = $(this.indicatorTarget);

        console.log(this._modal);
        this._modal.modal({
            closable: true,
        });
    }

    show(event) {
        this._modal.modal("show");
        this.getCart(event);
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
        event.preventDefault();
        // requête ajax
        $.ajax({
            url: url,
            method: "POST",
            success: function(data) {
                btn.removeClass("loading disabled");
                if (data.nb) {
                   // modifie le compteur du panier
                    this._indicator.html(data.nb);
                    new Notify({
                        status: 'success',
                        title: 'Gif ajouté',
                        text: 'Panier mis à jour',
                        position: 'right bottom',
                        effect: 'slide',
                        autoclose: true,
                        autotimeout: 3000
                    });
                } else {
                    new Notify({
                        status: 'warning',
                        title: 'ce Gif déjà dans votre panier!',
                        position: 'right bottom',
                        effect: 'slide',
                        autoclose: true,
                        autotimeout: 3000
                    });
                }
            }.bind(this),
            error: function (error) {
                btn.removeClass("loading disabled");
                console.error(error);
            }.bind(this),
        });
    }

    getCart(event) {
        let url = event.params.url;
        this._content.addClass("ui large loader");
        // requête ajax
        $.ajax({
            url: url,
            method: "GET",
            success: function(data) {
                this._content.removeClass("ui large loader");
                // affiche le contenur du panier
                this._content.html(data.html);
            }.bind(this),
            error: function (error) {
                this._content.removeClass("ui large loader");
                new Notify({
                    status: 'error',
                    title: 'Une erreur est survenue',
                    text: 'Impossible de récupérer le panier',
                    position: 'right bottom',
                    effect: 'slide',
                    autoclose: true,
                    autotimeout: 3000
                });
                console.error(error);
            }.bind(this),
        });

    }

     delete(event) {

     }
}