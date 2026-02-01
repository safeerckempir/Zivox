// Basic JavaScript functionality for Zivox
document.addEventListener('DOMContentLoaded', function() {
    console.log('Zivox application loaded successfully');
    
    // Simple mobile menu toggle (fallback if Alpine.js doesn't load)
    const mobileMenuButton = document.querySelector('[data-mobile-menu-button]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
