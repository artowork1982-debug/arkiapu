/**
 * Moderni Teal - Ota yhteyttä Modal
 * @package Moderni_Teal
 */
(function () {
    'use strict';

    const modal = document.getElementById('contact-modal');
    const openBtn = document.getElementById('open-contact-modal');
    const closeBtn = document.getElementById('close-contact-modal');
    const overlay = document.getElementById('contact-modal-overlay');
    const form = document.getElementById('contact-modal-form');
    const successMsg = document.getElementById('contact-modal-success');

    if (!modal || !openBtn) return;

    function openModal(e) {
        if (e) e.preventDefault();
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        setTimeout(function () {
            var firstInput = modal.querySelector('input, textarea');
            if (firstInput) firstInput.focus();
        }, 100);
    }

    function closeModal() {
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        if (form) {
            form.style.display = '';
            form.reset();
        }
        if (successMsg) successMsg.style.display = 'none';
        if (openBtn) openBtn.focus();
    }

    openBtn.addEventListener('click', openModal);

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (overlay) overlay.addEventListener('click', closeModal);

    // Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') {
            closeModal();
        }
    });

    // Form submit — AJAX-lähetys palvelimelle
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Tarkista että AJAX-konfiguraatio on saatavilla
            if (typeof moderniTealContact === 'undefined') {
                alert('Konfigurointivirhe. Päivitä sivu ja yritä uudelleen.');
                return;
            }

            var submitBtn = form.querySelector('.contact-modal__submit');
            var originalText = submitBtn.textContent;

            // Estä kaksoisklikki
            submitBtn.disabled = true;
            submitBtn.textContent = 'Lähetetään...';

            // Funktio joka lähettää lomakkeen
            function submitForm(recaptchaToken) {
                var formData = new FormData(form);
                formData.append('action', 'moderni_teal_contact');
                
                // Lisää reCAPTCHA-token jos saatavilla
                if (recaptchaToken) {
                    formData.append('recaptcha_token', recaptchaToken);
                }

                fetch(moderniTealContact.ajaxUrl, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                })
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    if (data.success) {
                        // Onnistui — näytä kiitos-viesti
                        form.style.display = 'none';
                        if (successMsg) successMsg.style.display = 'block';
                        setTimeout(closeModal, 3000);
                    } else {
                        // Virhe — näytä virheilmoitus
                        var errorMsg = (data && data.data && data.data.message) ? data.data.message : 'Viestin lähetys epäonnistui.';
                        alert(errorMsg);
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                })
                .catch(function () {
                    alert('Yhteysvirhe. Tarkista internet-yhteys ja yritä uudelleen.');
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            }

            // Jos reCAPTCHA on käytössä, hae token ensin
            if (typeof moderniTealRecaptcha !== 'undefined' && typeof grecaptcha !== 'undefined') {
                grecaptcha.ready(function() {
                    grecaptcha.execute(moderniTealRecaptcha.siteKey, { action: 'contact_form' })
                        .then(function(token) {
                            submitForm(token);
                        })
                        .catch(function() {
                            // reCAPTCHA epäonnistui, lähetä ilman tokenia
                            submitForm(null);
                        });
                });
            } else {
                // reCAPTCHA ei käytössä, lähetä suoraan
                submitForm(null);
            }
        });
    }

    // Open modal from shortcode button
    var shortcodeBtn = document.getElementById('contact-btn-shortcode');
    if (shortcodeBtn) {
        shortcodeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openModal(e);
        });
    }
})();