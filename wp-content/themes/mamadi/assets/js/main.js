
/**
 * Main JavaScript file
 *
 * Contains functionality for page title interaction and popup management
 */

(function() {
    'use strict';

    const popupContent = `<div class="overlay">
            <div id="popup" class="popup">
                <div class="popup-content">
                    <span class="close">&times;</span>
                    <h2>Das ist der Seitentitel.</h2>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', popupContent);

    const overlay = document.querySelector('.overlay');
    const popup = document.getElementById('popup');
    const closePopupIcon = popup.querySelector('.close');


    /**
     * Page Title Click Handler
     * Shows an alert when the page title is clicked
     */
    const initTitleClickHandler = () => {
        const h1 = document.querySelector('h1');

        if (h1) {
            h1.addEventListener('click', () => {
                console.log('Das ist der Seitentitel');
                alert('Das ist der Seitentitel.');
                openPopup();
            });
        }

        if (popup && popupContent) {
            closePopupIcon.addEventListener('click', () => {
                closePopup();
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                closePopup();
            });
        }
    };

    /**
     * Opens the popup and changes the background color
     */
    window.openPopup = function() {
        if (popup) {
            popup.style.display = 'block';
            overlay.style.display = 'block';
        }
    };

    /**
     * Closes the popup and resets the background color
     */
    window.closePopup = function() {
        if (popup) {
            popup.style.display = 'none';
            document.body.style.background = 'white';
            overlay.style.display = 'none';
        }
    };

    initTitleClickHandler()
})();
