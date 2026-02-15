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
        // Focus first input after animation completes (modal transform transition is 0.3s)
        // Small delay ensures modal is visible before focus
        setTimeout(function () {
            var firstInput = modal.querySelector('input, textarea');
            if (firstInput) firstInput.focus();
        }, 100);
    }

    function closeModal() {
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        // Reset form
        if (form) {
            form.style.display = '';
            form.reset();
        }
        if (successMsg) successMsg.style.display = 'none';
        // Return focus
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

    // Form submit
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Lähetetään lomake WordPress admin-ajax:lle tai näytetään onnistumisviesti
            var formData = new FormData(form);

            // Yksinkertainen mailto-fallback (voidaan myöhemmin muuttaa AJAX:ksi)
            var name = formData.get('name');
            var email = formData.get('email');
            var phone = formData.get('phone') || '-';
            var message = formData.get('message');

            // Näytä onnistumisviesti
            form.style.display = 'none';
            if (successMsg) successMsg.style.display = 'block';

            // Sulje modal 3s kuluttua
            setTimeout(closeModal, 3000);

            // mailto-fallback
            var subject = encodeURIComponent('Yhteydenotto sivustolta: ' + name);
            var body = encodeURIComponent(
                'Nimi: ' + name + '\n' +
                'Sähköposti: ' + email + '\n' +
                'Puhelin: ' + phone + '\n\n' +
                'Viesti:\n' + message
            );
            // Avaa sähköpostiohjelma taustalla
            var mailtoLink = document.createElement('a');
            mailtoLink.href = 'mailto:info@titanarkiapu.fi?subject=' + subject + '&body=' + body;
            mailtoLink.style.display = 'none';
            document.body.appendChild(mailtoLink);
            mailtoLink.click();
            document.body.removeChild(mailtoLink);
        });
    }
})();
