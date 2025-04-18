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