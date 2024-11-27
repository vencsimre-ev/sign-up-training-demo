class RegistrationForm {
    constructor(formId, nameInputId, submitBtnId) {
        this.form = document.getElementById(formId);
        this.nameInput = document.getElementById(nameInputId);
        this.submitBtn = document.getElementById(submitBtnId);
        this.submitCooldown = 60000; // 1 perc

        this.init();
    }

    // Inicializálás
    init() {
        this.loadStoredName();
        this.checkSubmitEnabled();
        this.addFormSubmitListener();
    }

    // Mentett név betöltése a localStorage-ból
    loadStoredName() {
        if (typeof(Storage) !== "undefined") {
            const storedName = localStorage.getItem('attendeeName');
            if (storedName) {
                this.nameInput.value = storedName;
            }
        } else {
            console.warn('LocalStorage nem érhető el ebben a böngészőben.');
        }
    }

    // Ellenőrzi, hogy lejárt-e az 1 perces tiltás
    checkSubmitEnabled() {
        const lastSubmitTime = localStorage.getItem('lastSubmitTime');
        const now = Date.now();

        if (lastSubmitTime && now - lastSubmitTime < this.submitCooldown) {
            this.disableSubmitButton();
            const remainingTime = this.submitCooldown - (now - lastSubmitTime);
            setTimeout(() => this.enableSubmitButton(), remainingTime);
        }
    }

    // Beküldés esemény kezelő hozzáadása
    addFormSubmitListener() {
        this.form.addEventListener('submit', (event) => {
            event.preventDefault();  // Az alapértelmezett beküldési viselkedés megakadályozása
            this.handleFormSubmit();
        });
    }

    // Form beküldése
    handleFormSubmit() {
        const name = this.nameInput.value;

        // Név mentése a localStorage-ba, ha van megadva
        if (name) {
            localStorage.setItem('attendeeName', name);
        }

        // Mentse el az aktuális időt, hogy az újraküldést letiltsa
        localStorage.setItem('lastSubmitTime', Date.now());

        // Gomb letiltása az oldal tényleges beküldése után
        this.disableSubmitButton();
        
        // Közvetlen oldal újratöltés helyett aszinkron kérés küldése
        this.submitFormData();
    }

    // Aszinkron adatbeküldés az újraküldés megelőzése érdekében
    submitFormData() {
        const formData = new FormData(this.form);
        const responseMessage = document.getElementById('responseMessage');
        const nameHelp = document.getElementById('nameHelp');
        
        fetch(this.form.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            
            if (data.status === 'success') {
                responseMessage.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                nameHelp.innerHTML = '<div class="alert alert-info">Mostantól 1 percig nem tudsz adatot újra beküldeni, a véletlen duplázódás elkerüléséért.</div>';
                
            } else {
                responseMessage.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
            }
        })
        .catch(error => {
            console.error('Hiba:', error);
            responseMessage.innerHTML = '<div class="alert alert-danger">Hiba történt a beküldés során.</div>';
        });
    }
    

    // Beküldés gomb letiltása
    disableSubmitButton() {
        this.submitBtn.disabled = true;
    }

    // Beküldés gomb újraengedélyezése
    enableSubmitButton() {
        this.submitBtn.disabled = false;
    }
}

// Objektum inicializálása az oldal betöltésekor
document.addEventListener('DOMContentLoaded', () => {
    new RegistrationForm('registerForm', 'name', 'submitBtn');
});
