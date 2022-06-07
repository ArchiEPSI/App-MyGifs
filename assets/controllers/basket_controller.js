import {Controller} from "@hotwired/stimulus";
import Notify  from "simple-notify";

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ["modal", "content", "indicator", "validBtn"];

    connect() {
        // récupération des éléments jquery
        this._element = $(this.element);
        this._modal = $(this.modalTarget);
        this._content = $(this.contentTarget);
        this._indicator = $(this.indicatorTarget);
        this._validBtn = $(this.ValidBtnTarget);

        this._modal.modal({
            closable: true,
        });
    }

    show(event) {
        this._content.html("");
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
                        autotimeout: 5000
                    });
                } else {
                    new Notify({
                        status: 'warning',
                        title: 'ce Gif déjà dans votre panier!',
                        position: 'right bottom',
                        effect: 'slide',
                        autoclose: true,
                        autotimeout: 5000
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
                    autotimeout: 5000
                });
                console.error(error);
            }.bind(this),
        });

    }

     delete(event) {
        let btn = $(event.target);
        let url = event.params.url;
        btn.addClass("loading disabled");
        $.ajax({
            url: url,
            method: "POST",
            success: function (data) {
                btn.removeClass("loading disabled");
                // suppression de la ligne
                let row = btn.parent().parent();
                // mise à jour du nombre d'éléments dans le panier
                this._indicator.html(data.nb);
                // si un contenu est indiqué
                if (data.html) {
                    // remplace le contenu
                    this._content.html(data.html);
                } else {
                    // sinon supprime la ligne
                    row.remove();
                }
                // notification du succes
                new Notify({
                    status: 'success',
                    title: 'Gif supprimé du panier',
                    position: 'right bottom',
                    effect: 'slide',
                    autoclose: true,
                    autotimeout: 5000
                });
            }.bind(this),
            error: function (error) {
                btn.removeClass("loading disabled");
                // notification de l'erreur
                new Notify({
                    status: 'error',
                    title: 'Oups une erreur est survenue',
                    text: 'Impossible de supprimer le gif du panier',
                    position: 'right bottom',
                    effect: 'slide',
                    autoclose: true,
                    autotimeout: 5000
                });
                console.error(error);
            }.bind(this)
        })
     }
}