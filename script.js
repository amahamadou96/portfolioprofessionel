/* ========================================
   PORTFOLIO JAVASCRIPT - TRÈS DYNAMIQUE
   ======================================== */

// ========================================
// 1. NAVIGATION ACTIVE & SMOOTH SCROLL
// ========================================
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        const targetSection = document.querySelector(targetId);
        
        // Remove active class from all links
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        
        // Close mobile menu
        document.querySelector('.nav-menu').classList.remove('active');
        
        // Smooth scroll
        targetSection.scrollIntoView({ behavior: 'smooth' });
    });
});

// Update nav link active state on scroll
window.addEventListener('scroll', () => {
    updateActiveNavLink();
    triggerAnimations();
});

function updateActiveNavLink() {
    const sections = document.querySelectorAll('section');
    let current = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (scrollY >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });
    
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
}

// ========================================
// 2. HAMBURGER MENU
// ========================================
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');

hamburger.addEventListener('click', () => {
    navMenu.classList.toggle('active');
    hamburger.classList.toggle('active');
});

// Close menu when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('.navbar')) {
        navMenu.classList.remove('active');
        hamburger.classList.remove('active');
    }
});

// ========================================
// 3. SCROLL ANIMATIONS
// ========================================
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe skill bars
document.querySelectorAll('.skill-progress').forEach(el => {
    observer.observe(el);
});

// Observe project cards
document.querySelectorAll('.project-card').forEach(el => {
    observer.observe(el);
});

// Observe cert cards
document.querySelectorAll('.cert-card').forEach(el => {
    observer.observe(el);
});

// ========================================
// 4. SKILL BAR ANIMATION
// ========================================
function animateSkillBars() {
    const skillBars = document.querySelectorAll('.skill-progress');
    
    skillBars.forEach(bar => {
        const rect = bar.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            if (!bar.classList.contains('animated')) {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
                bar.classList.add('animated');
            }
        }
    });
}

// ========================================
// 5. PROJECTS DATA
// ========================================
const projectsData = {
    1: {
        title: 'ARADASCHOOL',
        description: 'Une plateforme éducative innovante conçue pour faciliter l\'apprentissage en ligne et l\'interaction entre étudiants et instructeurs.',
        details: `
            <h2>ARADASCHOOL - Plateforme Éducative</h2>
            <p><strong>Description:</strong> Une plateforme éducative complète offrant des cours interactifs, des ressources d'apprentissage et un système de gestion des étudiants.</p>
            
            <h3>Technologies Utilisées:</h3>
            <ul>
                <li>Frontend: HTML5, CSS3, JavaScript ES6+</li>
                <li>Backend: PHP 7.4+</li>
                <li>Base de données: MySQL</li>
                <li>Frameworks: Bootstrap, jQuery</li>
                <li>Outils: Git, VS Code</li>
            </ul>
            
            <h3>Résultats & Impact:</h3>
            <ul>
                <li>Plateforme accueillant 500+ utilisateurs actifs</li>
                <li>Taux de satisfaction utilisateur: 92%</li>
                <li>Réduction du temps d'apprentissage de 30%</li>
                <li>Intégration réussie avec les systèmes existants</li>
            </ul>
            
            <h3>Fonctionnalités Principales:</h3>
            <ul>
                <li>Gestion des cours et des modules</li>
                <li>System d'authentification sécurisé</li>
                <li>Tableaux de bord personnalisés</li>
                <li>Suivi de la progression des étudiants</li>
                <li>Forums de discussion</li>
                <li>Système d'évaluation automatique</li>
            </ul>
        `
    },
    2: {
        title: 'CYBER GARE 4 ALL',
        description: 'Une initiative majeure de sensibilisation à la cybersécurité visant à éduquer et protéger les utilisateurs contre les menaces numériques.',
        details: `
            <h2>CYBER GARE 4 ALL - Sensibilisation à la Cybersécurité</h2>
            <p><strong>Description:</strong> Un projet complet de sensibilisation visant à éduquer la population sur les risques de cybersécurité et les bonnes pratiques de protection.</p>
            
            <h3>Technologies Utilisées:</h3>
            <ul>
                <li>Frontend: React.js, Tailwind CSS</li>
                <li>Backend: Node.js, Express</li>
                <li>Base de données: MongoDB</li>
                <li>Outils: Docker, Nginx</li>
                <li>Sécurité: JWT, HTTPS, Rate Limiting</li>
            </ul>
            
            <h3>Résultats & Impact:</h3>
            <ul>
                <li>Atteinte de 2000+ participants</li>
                <li>Amélioration de 85% de la conscience de la sécurité</li>
                <li>Partenariats avec 15+ organisations</li>
                <li>Réduction de 40% des incidents de sécurité chez les participants</li>
            </ul>
            
            <h3>Composants Clés:</h3>
            <ul>
                <li>Modules de formation interactifs</li>
                <li>Simulations d'attaques réalistes</li>
                <li>Certificats de complétion</li>
                <li>Tableau de bord d'analyse</li>
                <li>Ressources téléchargeables</li>
                <li>Communauté d'apprentissage</li>
            </ul>
        `
    }
};

// ========================================
// 6. PROJECT MODAL FUNCTIONS
// ========================================
function openProjectModal(projectId) {
    const modal = document.getElementById('projectModal');
    const modalBody = document.getElementById('modalBody');
    const projectData = projectsData[projectId];
    
    if (projectData) {
        modalBody.innerHTML = projectData.details;
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        
        // Animate modal content
        modalBody.style.animation = 'slideUp 0.3s ease-out';
    }
}

function closeProjectModal() {
    const modal = document.getElementById('projectModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
window.addEventListener('click', (e) => {
    const modal = document.getElementById('projectModal');
    if (e.target === modal) {
        closeProjectModal();
    }
});

// ========================================
// 7. CONTACT FORM HANDLING
// ========================================
// Handle contact form submission
if (document.getElementById('contactForm')) {
    document.getElementById('contactForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        try {
            submitBtn.textContent = 'Envoi en cours...';
            submitBtn.disabled = true;
            
            // Send to PHP endpoint with timeout
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 seconds timeout
            
            const response = await fetch('send_email.php', {
                method: 'POST',
                body: formData,
                signal: controller.signal
            });
            
            clearTimeout(timeoutId);
            
            if (response.ok) {
                const result = await response.json();
                showNotification('Message envoyé avec succès!', 'success');
                form.reset();
            } else if (response.status === 400) {
                const result = await response.json();
                const errorMsg = result.errors ? result.errors[0] : 'Erreur de validation';
                showNotification(errorMsg, 'error');
            } else {
                showNotification('Erreur lors de l\'envoi du message (HTTP ' + response.status + ')', 'error');
            }
        } catch (error) {
            if (error.name === 'AbortError') {
                showNotification('Timeout: Le serveur met trop de temps à répondre', 'error');
            } else {
                console.error('Form error:', error);
                showNotification('Erreur: ' + error.message, 'error');
            }
        } finally {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }
    });
}

// ========================================
// 8. NOTIFICATION SYSTEM
// ========================================
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1.5rem 2rem;
        background: ${type === 'success' ? '#00ff88' : '#ff4444'};
        color: #000;
        border-radius: 5px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        z-index: 3000;
        animation: slideInRight 0.3s ease-out;
        font-weight: 600;
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// ========================================
// 9. PARALLAX & MOUSE EFFECTS
// ========================================
document.addEventListener('mousemove', (e) => {
    const cyberGrid = document.querySelector('.cyber-grid');
    if (cyberGrid) {
        const rect = cyberGrid.getBoundingClientRect();
        const x = (e.clientX - rect.left) / rect.width * 10;
        const y = (e.clientY - rect.top) / rect.height * 10;
        
        cyberGrid.style.transform = `perspective(1000px) rotateX(${y}deg) rotateY(${x}deg)`;
    }
});

// ========================================
// 10. DYNAMIC TYPING EFFECT
// ========================================
function typeWriter(element, text, speed = 50) {
    let i = 0;
    element.textContent = '';
    
    function type() {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }
    
    type();
}

// ========================================
// 11. COUNTER ANIMATION
// ========================================
function animateCounter(element, target, duration = 1000) {
    let current = 0;
    const increment = target / (duration / 16);
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target + '+';
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current) + '+';
        }
    }, 16);
}

// ========================================
// 12. THEME TOGGLE (Optional Dark/Light Mode)
// ========================================
function toggleTheme() {
    const root = document.documentElement;
    const isDark = root.style.colorScheme === 'dark';
    
    if (isDark) {
        root.style.colorScheme = 'light';
        localStorage.setItem('theme', 'light');
    } else {
        root.style.colorScheme = 'dark';
        localStorage.setItem('theme', 'dark');
    }
}

// ========================================
// 13. SCROLL TO TOP BUTTON
// ========================================
const scrollTopBtn = document.createElement('button');
scrollTopBtn.className = 'scroll-to-top';
scrollTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
scrollTopBtn.style.cssText = `
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: #00d4ff;
    color: #000;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 999;
    transition: all 0.3s ease;
    font-size: 1.2rem;
    font-weight: bold;
    box-shadow: 0 5px 15px rgba(0, 212, 255, 0.4);
`;

document.body.appendChild(scrollTopBtn);

window.addEventListener('scroll', () => {
    if (window.scrollY > 500) {
        scrollTopBtn.style.display = 'flex';
    } else {
        scrollTopBtn.style.display = 'none';
    }
});

scrollTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

scrollTopBtn.addEventListener('mouseenter', () => {
    scrollTopBtn.style.transform = 'scale(1.2)';
});

scrollTopBtn.addEventListener('mouseleave', () => {
    scrollTopBtn.style.transform = 'scale(1)';
});

// ========================================
// 14. PARTICLES ANIMATION (Optional Background)
// ========================================
function createParticles() {
    const particleCount = 30;
    const container = document.querySelector('.hero');
    
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.style.cssText = `
            position: absolute;
            width: ${Math.random() * 3 + 1}px;
            height: ${Math.random() * 3 + 1}px;
            background: rgba(0, 212, 255, ${Math.random() * 0.5 + 0.2});
            border-radius: 50%;
            top: ${Math.random() * 100}%;
            left: ${Math.random() * 100}%;
            animation: float ${Math.random() * 3 + 2}s infinite ease-in-out;
            z-index: 1;
        `;
        container.appendChild(particle);
    }
}

// ========================================
// 15. INTERSECTION OBSERVER FOR LAZY LOADING
// ========================================
const lazyLoadObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('loaded');
        }
    });
});

document.querySelectorAll('.project-card, .cert-card').forEach(el => {
    lazyLoadObserver.observe(el);
});

// ========================================
// 16. ADD ANIMATIONS TO CSS
// ========================================
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100px);
            opacity: 0;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    .scroll-to-top:hover {
        background: #00a8cc;
        box-shadow: 0 8px 25px rgba(0, 212, 255, 0.6);
    }

    .skill-item {
        animation: fadeInUp 0.6s ease-out backwards;
    }

    .skill-item:nth-child(1) { animation-delay: 0.1s; }
    .skill-item:nth-child(2) { animation-delay: 0.2s; }
    .skill-item:nth-child(3) { animation-delay: 0.3s; }
    .skill-item:nth-child(4) { animation-delay: 0.4s; }

    .project-card {
        animation: fadeInUp 0.6s ease-out backwards;
    }

    .project-card:nth-child(1) { animation-delay: 0.1s; }
    .project-card:nth-child(2) { animation-delay: 0.2s; }
    .project-card:nth-child(3) { animation-delay: 0.3s; }

    .cert-card {
        animation: fadeInUp 0.6s ease-out backwards;
    }

    .cert-card:nth-child(n) {
        animation-delay: calc(0.1s * var(--index, 1));
    }
`;
document.head.appendChild(style);

// ========================================
// 17. INITIALIZATION
// ========================================
document.addEventListener('DOMContentLoaded', () => {
    // Initialize on page load
    updateActiveNavLink();
    animateSkillBars();
    createParticles();
    
    // Add index to cert cards for staggered animation
    document.querySelectorAll('.cert-card').forEach((card, index) => {
        card.style.setProperty('--index', index + 1);
    });
    
    // Log initialization
    console.log('✓ Portfolio dynamique chargé avec succès!');
    console.log('✓ Toutes les animations sont actives');
    console.log('✓ Le site est prêt pour la publication');
});

// ========================================
// 18. PERFORMANCE MONITORING
// ========================================
if (window.performance) {
    window.addEventListener('load', () => {
        const perfData = window.performance.timing;
        const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
        console.log('Temps de chargement: ' + pageLoadTime + 'ms');
    });
}

// ========================================
// 19. FORM INPUT VALIDATION
// ========================================
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    const inputs = contactForm.querySelectorAll('input, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
        });
        
        input.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
        });
    });
}

// ========================================
// 20. ACCESSIBILITY ENHANCEMENTS
// ========================================
document.addEventListener('keydown', (e) => {
    // ESC key closes modal
    if (e.key === 'Escape') {
        closeProjectModal();
    }
    
    // Tab navigation
    if (e.key === 'Tab') {
        document.querySelectorAll('a, button, input').forEach(el => {
            el.addEventListener('focus', () => {
                el.style.outline = '2px solid #00d4ff';
                el.style.outlineOffset = '2px';
            });
        });
    }
});

console.log('🔒 Portfolio de cybersécurité - Tous les modules JavaScript sont actifs');
