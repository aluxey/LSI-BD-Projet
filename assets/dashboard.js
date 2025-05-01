
document.addEventListener("DOMContentLoaded", () => {
    // Alpine.js est déjà inclus dans le template de base

    // Gestion de la modal de création de projet
    const createProjectModal = document.getElementById("createProjectModal")
    const openCreateProjectBtn = document.getElementById("openCreateProjectModal")
    const closeModalBtns = document.querySelectorAll("[data-close-modal]")

    // Ouvrir la modal
    if (openCreateProjectBtn && createProjectModal) {
        openCreateProjectBtn.addEventListener("click", () => {
            createProjectModal.classList.remove("hidden")
        })
    }

    // Fermer la modal
    closeModalBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            createProjectModal.classList.add("hidden")
        })
    })

    // Fermer la modal en cliquant à l'extérieur
    window.addEventListener("click", (e) => {
        if (e.target === createProjectModal) {
            createProjectModal.classList.add("hidden")
        }
    })

    // Gestion du formulaire de création de projet
    const createProjectForm = document.getElementById("createProjectForm")
    if (createProjectForm) {
        createProjectForm.addEventListener("submit", (e) => {
            e.preventDefault()

            // Récupérer les données du formulaire
            const formData = new FormData(createProjectForm)
            const projectData = {
                name: formData.get("projectName"),
                description: formData.get("projectDescription"),
                startDate: formData.get("startDate"),
                endDate: formData.get("endDate"),
                members: Array.from(formData.getAll("projectMembers[]")),
                status: formData.get("projectStatus"),
                budget: formData.get("projectBudget"),
            }

            // Ici, vous pourriez envoyer les données à votre backend via une requête AJAX
            console.log("Données du projet à créer:", projectData)

            // Simuler une création réussie
            alert("Projet créé avec succès!")
            createProjectModal.classList.add("hidden")
            createProjectForm.reset()
        })
    }

    // Initialisation des tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    if (typeof bootstrap !== "undefined") {
        tooltipTriggerList.forEach((tooltipTriggerEl) => {
            new bootstrap.Tooltip(tooltipTriggerEl)
        })
    } else {
        console.warn("Bootstrap is not defined. Ensure Bootstrap is properly loaded.")
    }

    // Gestion des modales pour la création d'événements
    const modalTriggers = document.querySelectorAll("[data-modal-target]")
    modalTriggers.forEach((trigger) => {
        trigger.addEventListener("click", () => {
            const modalId = trigger.getAttribute("data-modal-target")
            const modal = document.getElementById(modalId)
            if (modal) {
                // Logique pour afficher la modale
                modal.classList.remove("hidden")
                modal.setAttribute("aria-hidden", "false")

                // Fermeture de la modale
                const closeButtons = modal.querySelectorAll("[data-close-modal]")
                closeButtons.forEach((button) => {
                    button.addEventListener("click", () => {
                        modal.classList.add("hidden")
                        modal.setAttribute("aria-hidden", "true")
                    })
                })
            }
        })
    })

    // Simulation d'une mise à jour en temps réel des membres actifs
    function updateActiveStatus() {
        const statuses = ["En ligne", "Il y a 1 min", "Il y a 5 min", "Il y a 10 min"]
        const memberElements = document.querySelectorAll(".member-status")

        memberElements.forEach((element) => {
            const randomStatus = statuses[Math.floor(Math.random() * statuses.length)]
            element.textContent = randomStatus
        })
    }

    // Mise à jour toutes les 30 secondes
    setInterval(updateActiveStatus, 30000)

    // Gestion des notifications
    const notificationButton = document.querySelector(".notification-button")
    if (notificationButton) {
        notificationButton.addEventListener("click", () => {
            // Logique pour afficher les notifications
            console.log("Affichage des notifications")
        })
    }

    // Gestion de la recherche
    const searchInput = document.querySelector(".search-input")
    if (searchInput) {
        searchInput.addEventListener("input", (e) => {
            const searchTerm = e.target.value.toLowerCase()
            // Logique de recherche
            console.log("Recherche:", searchTerm)
        })
    }

    const simpleModal = document.getElementById("simpleModal")
    const openSimpleModalBtn = document.getElementById("openSimpleModal")
    const closeSimpleModalBtns = document.querySelectorAll("[data-close-simple-modal]")

    // Ouvrir la modal simple
    if (openSimpleModalBtn && simpleModal) {
        openSimpleModalBtn.addEventListener("click", () => {
            simpleModal.classList.remove("hidden")
            // Focus sur le champ de saisie
            setTimeout(() => {
                document.getElementById("taskName").focus()
            }, 100)
        })
    }

    // Fermer la modal simple
    closeSimpleModalBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            simpleModal.classList.add("hidden")
        })
    })

    // Fermer la modal simple en cliquant à l'extérieur
    window.addEventListener("click", (e) => {
        if (e.target === simpleModal) {
            simpleModal.classList.add("hidden")
        }
    })

    // Gestion du formulaire simple
    const simpleForm = document.getElementById("simpleForm")
    if (simpleForm) {
        simpleForm.addEventListener("submit", (e) => {
            e.preventDefault()

            // Récupérer la valeur du champ
            const taskName = document.getElementById("taskName").value

            // Ici, vous pourriez envoyer les données à votre backend via une requête AJAX
            console.log("Tâche à créer:", taskName)

            // Simuler une création réussie
            alert("Tâche ajoutée avec succès!")
            simpleModal.classList.add("hidden")
            simpleForm.reset()
        })
    }
})


function toggleModal(modalName) {
    const modal = document.getElementById(modalName);
    modal.classList.toggle('hidden');
    modal.classList.toggle('flex');
}