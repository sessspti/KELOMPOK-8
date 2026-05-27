function setText(id, value) {
    const el = document.getElementById(id);
    if (el) {
        el.textContent = value;
    }
}

function formatKg(number) {
    return Number(number || 0).toFixed(1);
}

function formatMoney(number) {
    return 'Rp ' + Number(number || 0).toLocaleString('id-ID');
}

async function loadUserImpact() {
    const card = document.getElementById('impact-tracker-card');
    if (!card) return;

    try {
        const res = await fetch('/impact/me', { headers: { Accept: 'application/json' } });
        if (!res.ok) return;
        const data = await res.json();

        setText('impact-food', formatKg(data.food_saved_kg));
        setText('impact-co2', formatKg(data.co2_reduced_kg));
        setText('impact-rescues', String(data.total_rescues || 0));

        if (card.dataset.userRole === 'konsumen') {
            setText('impact-money', formatMoney(data.money_saved));
        }
    } catch (error) {
        console.error('Failed to load impact data', error);
    }
}

async function loadAdminImpact() {
    if (!document.getElementById('admin-impact-dashboard')) return;

    try {
        const res = await fetch('/admin/impact/stats', { headers: { Accept: 'application/json' } });
        if (!res.ok) return;
        const data = await res.json();

        setText('admin-food', formatKg(data.total_food_kg));
        setText('admin-co2', formatKg(data.total_co2));
        setText('admin-rescues', String(data.total_rescues || 0));
        setText('admin-users', String(data.total_users || 0));
    } catch (error) {
        console.error('Failed to load admin impact data', error);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    loadUserImpact();
    loadAdminImpact();

    setInterval(loadUserImpact, 15000);
    setInterval(loadAdminImpact, 15000);
});
