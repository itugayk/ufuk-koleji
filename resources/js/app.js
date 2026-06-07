import './bootstrap';

// Görünüme girince 0'dan hedefe sayan sayaç (Alpine bileşeni)
document.addEventListener('alpine:init', () => {
    window.Alpine.data('counter', (target = 0, duration = 1800) => ({
        current: 0,
        init() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        this.run(target, duration);
                        observer.disconnect();
                    }
                });
            }, { threshold: 0.35 });
            observer.observe(this.$el);
        },
        run(to, dur) {
            const start = performance.now();
            const tick = (now) => {
                const progress = Math.min((now - start) / dur, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                this.current = Math.floor(eased * to);
                if (progress < 1) {
                    requestAnimationFrame(tick);
                } else {
                    this.current = to;
                }
            };
            requestAnimationFrame(tick);
        },
        get formatted() {
            return this.current.toLocaleString('tr-TR');
        },
    }));
});
