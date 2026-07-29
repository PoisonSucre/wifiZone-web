import Chart from 'chart.js/auto';
window.Chart = Chart;

(function () {
    const saved = localStorage.getItem('theme') || 'light';

    function setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + days * 86400000);
        document.cookie = name + '=' + value + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
    }

    function updateIcons(t) {
        const isDark = t === 'dark';
        const show = isDark ? '' : 'none';
        const hide = isDark ? 'none' : '';

        const pairs = [
            ['theme-sun', show],
            ['theme-moon', hide],
            ['theme-sun-mobile', show],
            ['theme-moon-mobile', hide],
            ['theme-toggle-dark-icon', hide],
            ['theme-toggle-light-icon', show],
        ];
        for (const [id, display] of pairs) {
            const el = document.getElementById(id);
            if (el) el.style.display = display;
        }
    }

    function applyTheme(t) {
        if (t === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        updateIcons(t);
    }

    applyTheme(saved);

    window.toggleTheme = function () {
        const isDark = document.documentElement.classList.toggle('dark');
        const theme = isDark ? 'dark' : 'light';
        localStorage.setItem('theme', theme);
        setCookie('theme', theme, 365);
        updateIcons(theme);
    };

    window.togglePw = function (inputId, btn) {
        const el = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (el.type === 'password') {
            el.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            el.type = 'password';
            icon.className = 'fas fa-eye';
        }
    };

    window.copyScript = function (elId, btn) {
        const text = document.getElementById(elId).textContent;
        navigator.clipboard.writeText(text).then(function () {
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Copie !';
            setTimeout(function () { btn.innerHTML = orig; }, 2000);
        }).catch(function () {});
    };

document.addEventListener('livewire:navigated', function () {
        const t = localStorage.getItem('theme') || 'light';
        applyTheme(t);
    });

    // Gestion du paiement shop - redirection vers LigdiCash
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (form.action && form.action.includes('/api/payment-process')) {
            e.preventDefault();
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.payment_url) {
                    window.location.href = data.payment_url;
                } else {
                    alert('Erreur: ' + (data.error || data.details?.description || 'Paiement impossible'));
                }
            })
            .catch(() => alert('Erreur de connexion au serveur de paiement'));
        }
    });
})();
