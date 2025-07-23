<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css
" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>




<script>
    document.querySelector('.validate-sale').addEventListener('click', function() {
        const plats = document.querySelectorAll('.plat-checkbox:checked');
        const panier = [];
        let validationEchouee = false;

        plats.forEach((plat) => {
            const platId = plat.value;
            const platNom = plat.nextElementSibling.textContent.trim();
            const platQuantite = parseInt(plat.closest('.form-check').querySelector('.quantityPlat')
                .value);
            const prixPlat = plat.getAttribute('data-price');

            const complements = [];
            const garnitures = [];
            let complementManquant = false;
            let garnitureManquante = false;

            // Compléments
            const complementCheckboxes = plat.closest('.card-body').querySelectorAll(
                '.complement-checkbox');
            let totalQuantiteComplements = 0;
            complementCheckboxes.forEach((complement) => {
                if (complement.checked) {
                    const quantite = parseInt(complement.closest('.form-check').querySelector(
                        '.quantityComplement').value);
                    totalQuantiteComplements += quantite;
                    complements.push({
                        id: complement.value,
                        nom: complement.nextElementSibling.textContent.trim(),
                        quantity: quantite,
                    });
                }
            });

            if (complementCheckboxes.length > 0 && complements.length === 0) {
                complementManquant = true;
            }

            // Garnitures
            const garnitureCheckboxes = plat.closest('.card-body').querySelectorAll(
                '.garniture-checkbox');
            let totalQuantiteGarnitures = 0;
            garnitureCheckboxes.forEach((garniture) => {
                if (garniture.checked) {
                    const quantite = parseInt(garniture.closest('.form-check').querySelector(
                        '.quantityGarniture').value);
                    totalQuantiteGarnitures += quantite;
                    garnitures.push({
                        id: garniture.value,
                        nom: garniture.nextElementSibling.textContent.trim(),
                        quantity: quantite,
                    });
                }
            });

            if (garnitureCheckboxes.length > 0 && garnitures.length === 0) {
                garnitureManquante = true;
            }

            // Vérification des compléments et garnitures manquants
            if (complementManquant || garnitureManquante) {
                validationEchouee = true;
                const message = complementManquant ?
                    'Veuillez sélectionner au moins un complément pour le plat : ' + platNom :
                    'Veuillez sélectionner au moins une garniture pour le plat : ' + platNom;

                Swal.fire({
                    icon: 'error',
                    title: 'Attention',
                    text: message,
                });
                return;
            }

            // Vérification des quantités des compléments et garnitures
            if (complements.length > 0 && totalQuantiteComplements !== platQuantite) {
                validationEchouee = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Quantité invalide',
                    text: `La somme des quantités des compléments doit être égale à ${platQuantite} pour le plat : ${platNom}`,
                });
                return;
            }

            if (garnitures.length > 0 && totalQuantiteGarnitures !== platQuantite) {
                validationEchouee = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Quantité invalide',
                    text: `La somme des quantités des garnitures doit être égale à ${platQuantite} pour le plat : ${platNom}`,
                });
                return;
            }




            // Ajouter au panier
            panier.push({
                plat: {
                    id: platId,
                    nom: platNom,
                    quantity: platQuantite,
                    price: prixPlat
                },
                complements,
                garnitures,

            });
        });

        console.log(panier);




        let montantRecu = parseFloat($('#amountReceived').val() || 0); // Convertir en float
        if (montantRecu <= 0) { // Vérifie si montantRecu a ete saisir
            validationEchouee = true;
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Veuillez entrer le montant reçu .',
            });
            return;
        }

        // Verifier si le montant reçu est inferieur au montant à payer
        // Fonction pour extraire un nombre depuis une chaîne formatée

        function parseFormattedNumber(numberString) {
            return parseFloat(numberString.replace(/\s/g, '').replace(',', '.')) || 0;
        }
        // Total du panier a payer
        const totalText = document.getElementById('totalAmount').textContent;
        const total = parseFormattedNumber(totalText); // Convertir le total formaté


        // Monnaie  rendu
        const changeText = document.getElementById('changeGiven').textContent;
        const montantRendu = parseFormattedNumber(changeText); // 

        if (montantRecu < total) {
            validationEchouee = true;
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Le montant reçu est inférieur au montant à payer.',
            });
            return;
        }

        let modePaiement = $('#payment-method').val();


        if (validationEchouee) {
            return; // Stopper l'exécution si une validation échoue
        }

        if (panier.length > 0) {
            console.log('Panier :', panier);

            // Envoyer les données au backend via AJAX
            $.ajax({
                type: "POST",
                url: "{{ route('vente.menu.store') }}",
                data: {
                    cart: panier,
                    montantRecu: montantRecu,
                    modePaiement: modePaiement,
                    montantRendu: montantRendu,
                    montantAPayer: total,
                    _token: "{{ csrf_token() }}" // Protection CSRF
                },
                dataType: "json",
                success: function(response) {
                    Swal.fire({
                        title: 'Vente validée avec succès !',
                        text: response.message,
                        icon: 'success',
                    }).then(() => {
                        window.location.href = '{{ route('vente.show', ':idVente') }}'
                            .replace(':idVente', response.idVente);
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Erreur',
                        text: xhr.responseJSON.message ||
                            'Une erreur s\'est produite lors de la validation de la vente.',
                        icon: 'error',
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Panier Menu vide',
                text: 'Aucun plat sélectionné pour le panier.',
            });
        }
    });
</script>


<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js
"></script>
