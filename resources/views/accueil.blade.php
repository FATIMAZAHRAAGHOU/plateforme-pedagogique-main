@extends('layouts.app')

@section('content')

<section class="hero">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-md-7">
                <h1 class="display-5">
                    test test 
                </h1>

                <p class="lead mt-4">
                    Bienvenue sur la plateforme numérique du Centre BTS Guelmim.
                </p>

                <p class="mt-3 text-white-50">
                    Cette application permet d’organiser la gestion pédagogique :
                    étudiants, enseignants, filières, absences, évaluations et notes.
                </p>

                <a href="{{ route('login') }}" class="btn btn-light btn-lg mt-4 px-4">
                    Se connecter
                </a>
            </div>

            <div class="col-md-5 mt-5 mt-md-0">
                <div class="hero-box">
                    <h5 class="fw-bold mb-3">
                        Accès sécurisé
                    </h5>

                    <p class="mb-3">
                        Chaque utilisateur accède à un espace adapté à son rôle.
                    </p>

                    <ul class="mb-0">
                        <li>Administrateur</li>
                        <li>Enseignant</li>
                        <li>Étudiant</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="container my-5">

    <section id="services" class="mb-5">
        <div class="text-center mb-5">
            <h2 class="section-title">
                Services principaux
            </h2>

            <p class="section-subtitle mt-3">
                La plateforme centralise les fonctionnalités essentielles pour faciliter
                le suivi et la gestion de la formation.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="simple-card">
                    <h5 class="fw-bold mb-3">
                        Gestion pédagogique
                    </h5>

                    <p class="text-muted mb-0">
                        Organisation des filières, groupes, modules, étudiants
                        et enseignants dans un seul espace.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="simple-card">
                    <h5 class="fw-bold mb-3">
                        Suivi des absences
                    </h5>

                    <p class="text-muted mb-0">
                        Gestion des présences et absences des étudiants pour
                        améliorer le suivi pédagogique.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="simple-card">
                    <h5 class="fw-bold mb-3">
                        Notes et évaluations
                    </h5>

                    <p class="text-muted mb-0">
                        Saisie et consultation des notes selon les modules,
                        les évaluations et les profils utilisateurs.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <section id="objectif" class="info-section mb-5">
        <div class="row align-items-center">

            <div class="col-md-8">
                <h3 class="section-title">
                    Objectif de la plateforme
                </h3>

                <p class="text-muted mt-3 mb-0">
                    L’objectif est de simplifier la gestion administrative et pédagogique
                    du Centre BTS Guelmim, tout en offrant un accès clair et sécurisé
                    aux administrateurs, enseignants et étudiants.
                </p>
            </div>

            <div class="col-md-4 text-md-end text-center mt-4 mt-md-0">
                <a href="{{ route('login') }}" class="btn btn-main px-4">
                    Accéder à mon espace
                </a>
            </div>

        </div>
    </section>

    <section id="formations" class="mb-5">
        <div class="text-center mb-5">
            <h2 class="section-title">
                Formations disponibles
            </h2>

            <p class="section-subtitle mt-3">
                Le Centre BTS Guelmim propose des formations techniques adaptées
                aux besoins du marché.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-6">
                <div class="simple-card">
                    <h5 class="fw-bold mb-3">
                        Développement d'Application Informatique (DAI)
                    </h5>

                    <p class="text-muted mb-0">
                        La filière DAI (Développement d’Applications Informatiques)
                        est un cursus technologique formant des techniciens supérieurs aptes à concevoir, 
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="simple-card">
                    <h5 class="fw-bold mb-3">
                        Electrotechnique
                    </h5>

                    <p class="text-muted mb-0">
                        La filière Électrotechnique (également appelée génie électrique) est 
                        la discipline qui étudie les applications pratiques de l'électricité. 
                    </p>
                </div>
            </div>

        </div>
    </section>

    <section id="contact" class="info-section">
        <div class="text-center mb-5">
            <h2 class="section-title">
                Contact
            </h2>

            <p class="section-subtitle mt-3">
                Pour plus d’informations, vous pouvez contacter le Centre BTS Guelmim.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-5">
                <div class="contact-box h-100">
                    <h5 class="fw-bold mb-3">
                        Centre BTS Guelmim
                    </h5>

                    <p class="text-muted mb-2">
                        Email : contact@bts-guelmim.ma
                    </p>

                    <p class="text-muted mb-2">
                        Téléphone : +212 661-617339
                    </p>

                    <p class="text-muted mb-0">
                        Adresse : Lycée D'excllence Qualifiant / Guelmim 
                    </p>
                </div>
            </div>

            <div class="col-md-7">
                <form id="contactForm" onsubmit="sendContactMessage(event)">
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Nom complet
                        </label>
                        <input id="name" name="name" type="text" class="form-control" placeholder="Votre nom complet" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Email
                        </label>
                        <input id="email" name="email" type="email" class="form-control" placeholder="Votre email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Message
                        </label>
                        <textarea id="message" name="message" class="form-control" rows="4" placeholder="Votre message" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-main px-4">
                        Envoyer
                    </button>
                </form>
            </div>

        </div>
    </section>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function sendContactMessage(event) {
        event.preventDefault();

        let name = document.getElementById('name').value.trim();
        let email = document.getElementById('email').value.trim();
        let message = document.getElementById('message').value.trim();

        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (name === '' || email === '' || message === '') {
            Swal.fire({
                title: 'Erreur',
                text: 'Veuillez remplir tous les champs.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (!emailRegex.test(email)) {
            Swal.fire({
                title: 'Email invalide',
                text: 'Veuillez saisir une adresse email correcte.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (name.length < 10) {
            Swal.fire({
                title: 'Nom invalide',
                text: 'Le nom complet doit contenir au moins 3 caractères.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (message.length < 3) {
            Swal.fire({
                title: 'Message trop court',
                text: 'Le message doit contenir au moins 10 caractères.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        Swal.fire({
            title: 'Message envoyé',
            text: 'Votre message a été envoyé avec succès.',
            icon: 'success',
            confirmButtonText: 'OK'
        });

        document.getElementById('contactForm').reset();
    }
</script>

@endsection