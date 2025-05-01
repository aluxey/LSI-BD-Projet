import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

document.addEventListener('DOMContentLoaded', function() {
    // Header scroll effect
    const header = document.getElementById('main-header');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.classList.add('bg-black/50', 'backdrop-blur-md');
        } else {
            header.classList.remove('bg-black/50', 'backdrop-blur-md');
        }
    });
    
    // Mobile menu toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    // Smooth scroll for buttons with data-target
    const scrollButtons = document.querySelectorAll('.scroll-to');
    
    scrollButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
    
    // Video player functionality
    const videoTrigger = document.querySelector('.video-trigger');
    const videoContainer = document.querySelector('.video-container');
    
    if (videoTrigger && videoContainer) {
        videoTrigger.addEventListener('click', function() {
            videoTrigger.classList.add('hidden');
            videoContainer.classList.remove('hidden');
            
            // Get the iframe and update src to autoplay
            const iframe = videoContainer.querySelector('iframe');
            if (iframe) {
                let src = iframe.getAttribute('src');
                if (src.indexOf('autoplay=') === -1) {
                    src += (src.indexOf('?') === -1 ? '?' : '&') + 'autoplay=1';
                    iframe.setAttribute('src', src);
                }
            }
        });
    }
    
    // Add animation classes when elements come into view
    const observeElements = document.querySelectorAll('.fade-in, .fade-in-up');
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        observeElements.forEach(element => {
            element.style.animationPlayState = 'paused';
            observer.observe(element);
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const tabs = document.querySelectorAll('.auth-tab');
    const forms = document.querySelectorAll('.auth-form');
    const toggleButtons = document.querySelectorAll('.auth-toggle');
    
    function showForm(formId) {
        // Hide all forms
        forms.forEach(form => {
            form.classList.add('hidden');
        });
        
        // Show the target form
        const targetForm = document.getElementById(formId);
        if (targetForm) {
            targetForm.classList.remove('hidden');
        }
        
        // Update active tab
        tabs.forEach(tab => {
            if (tab.dataset.target === formId) {
                tab.classList.add('active');
            } else {
                tab.classList.remove('active');
            }
        });
    }
    
    // Tab click handlers
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            showForm(this.dataset.target);
        });
    });
    
    // Toggle button handlers
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            showForm(this.dataset.show);
        });
    });
    
    // Form validation
    const registerForm = document.querySelector('#register-form form');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const password = document.getElementById('register-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            
            // Check password length
            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long');
                return;
            }
            
            // Check if passwords match
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match');
                return;
            }
        });
    }
});
