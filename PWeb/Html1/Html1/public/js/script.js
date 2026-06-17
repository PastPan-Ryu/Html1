document.addEventListener('DOMContentLoaded', () => {
    // 1. Hamburger Menu
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('navMenu');
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });
    }

    // 2. Search and Filter
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const gameFilters = document.querySelectorAll('.game-filter');
    const rankFilters = document.querySelectorAll('.rank-filter');
    const cardsGrid = document.getElementById('cardsGrid');

    const filterCards = () => {
        if (!cardsGrid) return;
        const query = searchInput ? searchInput.value.toLowerCase() : '';
        const selectedGames = Array.from(gameFilters).filter(cb => cb.checked).map(cb => cb.value);
        const selectedRanks = Array.from(rankFilters).filter(cb => cb.checked).map(cb => cb.value);
        
        const cards = cardsGrid.querySelectorAll('.card');
        cards.forEach(card => {
            const textContent = card.innerText.toLowerCase();
            const gameBadge = card.querySelector('.game-badge').innerText;
            const rankText = card.querySelector('.card-body div:nth-child(2)').innerText;

            const matchesSearch = textContent.includes(query);
            const matchesGame = selectedGames.length === 0 || selectedGames.includes(gameBadge);
            let matchesRank = selectedRanks.length === 0;
            if (selectedRanks.length > 0) {
                matchesRank = selectedRanks.some(rank => rankText.toLowerCase().includes(rank.toLowerCase()));
            }

            card.style.display = (matchesSearch && matchesGame && matchesRank) ? 'block' : 'none';
        });
    };

    if (searchForm) searchForm.addEventListener('submit', (e) => { e.preventDefault(); filterCards(); });
    if (searchInput) searchInput.addEventListener('input', filterCards);
    gameFilters.forEach(cb => cb.addEventListener('change', filterCards));
    rankFilters.forEach(cb => cb.addEventListener('change', filterCards));

    // 4. Smooth Scrolling

    // Smooth Scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#' || href.startsWith('#')) {
                let target = document.querySelector(href);
                if (!target) {
                    if (href === '#beli' || href === '#beranda') target = document.querySelector('.hero');
                }
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
});

// Theme Toggle Logic
const themeToggle = document.getElementById('themeToggle');
const themeLabel = document.getElementById('themeLabel');

function updateThemeLabel() {
    if(themeLabel) {
        themeLabel.textContent = document.body.classList.contains('light-mode') ? 'Light mode' : 'Dark mode';
    }
}

if (themeToggle) {
    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('light-mode');
        const isLight = document.body.classList.contains('light-mode');
        localStorage.setItem('theme', isLight ? 'light' : 'dark');
        updateThemeLabel();
    });
    updateThemeLabel();
}

