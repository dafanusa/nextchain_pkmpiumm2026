<style>
    .user-loading-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            radial-gradient(1100px 520px at 12% 8%, rgba(255, 255, 255, 0.16) 0%, rgba(255, 255, 255, 0) 60%),
            linear-gradient(140deg, #0f3d91 0%, #0a2d6c 55%, #07245a 100%);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 260ms ease, visibility 260ms ease;
        overflow: hidden;
    }

    .user-loading-overlay.is-active {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .user-loading-overlay__glow {
        position: absolute;
        inset: -20%;
        background:
            radial-gradient(600px 300px at 20% 15%, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0) 70%),
            radial-gradient(700px 360px at 80% 0%, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 72%);
        filter: blur(8px);
        opacity: 0.7;
        pointer-events: none;
    }

    .user-loading-overlay__close {
        position: absolute;
        top: 24px;
        right: 28px;
        height: 44px;
        width: 44px;
        border-radius: 9999px;
        border: 1px solid rgba(255, 255, 255, 0.35);
        color: #ffffff;
        background: rgba(255, 255, 255, 0.08);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        line-height: 1;
        cursor: pointer;
        transition: transform 180ms ease, background-color 180ms ease, border-color 180ms ease;
        backdrop-filter: blur(6px);
        box-shadow: 0 18px 40px rgba(7, 36, 90, 0.45);
    }

    .user-loading-overlay__close:hover {
        transform: translateY(-1px);
        background: rgba(255, 255, 255, 0.18);
        border-color: rgba(255, 255, 255, 0.6);
    }

    .user-loading-overlay__content {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.4rem;
        padding: 2.25rem 2.75rem;
        transform: translateY(22px) scale(0.985);
        opacity: 0;
        transition: transform 420ms cubic-bezier(0.2, 0.75, 0.2, 1), opacity 420ms ease;
    }

    .user-loading-overlay.is-active .user-loading-overlay__content {
        transform: translateY(0) scale(1);
        opacity: 1;
    }

    .user-loading-overlay__spinner {
        width: 122px;
        height: 122px;
        border-radius: 9999px;
        border: 7px solid rgba(255, 255, 255, 0.24);
        border-top-color: #ffffff;
        border-right-color: rgba(255, 255, 255, 0.92);
        box-shadow:
            0 0 0 10px rgba(255, 255, 255, 0.08),
            0 30px 70px rgba(7, 36, 90, 0.6);
        animation: user-loading-spin 0.95s linear infinite;
    }

    .user-loading-overlay__text {
        font-size: clamp(3rem, 7vw, 5rem);
        font-weight: 800;
        letter-spacing: 0.32em;
        text-transform: uppercase;
        color: #ffffff;
        text-shadow:
            0 18px 45px rgba(7, 36, 90, 0.7),
            0 0 26px rgba(255, 255, 255, 0.24);
        animation: user-loading-text-enter 780ms cubic-bezier(0.18, 0.72, 0.18, 1) both;
        animation-delay: 120ms;
        padding-left: 0.32em;
    }

    @keyframes user-loading-spin {
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes user-loading-text-enter {
        from {
            transform: translateY(26px) scale(0.95);
            opacity: 0;
            filter: blur(6px);
            letter-spacing: 0.42em;
        }
        to {
            transform: translateY(0) scale(1);
            opacity: 1;
            filter: blur(0);
            letter-spacing: 0.32em;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .user-loading-overlay,
        .user-loading-overlay__content {
            transition: none;
        }

        .user-loading-overlay__spinner,
        .user-loading-overlay__text {
            animation: none;
        }
    }
</style>

<div id="userPageLoadingOverlay" class="user-loading-overlay" role="status" aria-live="polite" aria-label="Loading">
    <div class="user-loading-overlay__glow" aria-hidden="true"></div>
    <button type="button" class="user-loading-overlay__close" data-loading-close aria-label="Tutup loading">
        &times;
    </button>
    <div class="user-loading-overlay__content">
        <div class="user-loading-overlay__spinner" aria-hidden="true"></div>
        <div class="user-loading-overlay__text">NEXTCHAIN</div>
    </div>
</div>

<script>
    (() => {
        const overlay = document.getElementById('userPageLoadingOverlay');
        if (!overlay) {
            return;
        }

        const closeButton = overlay.querySelector('[data-loading-close]');
        const hideDelayMs = 3000;
        const shownKey = 'nextchain:loading-overlay:shown';
        let hideTimeoutId = null;
        let hasShownOverlay = false;

        const showOverlay = () => {
            overlay.classList.add('is-active');
            overlay.setAttribute('aria-hidden', 'false');
        };

        const hideOverlay = () => {
            overlay.classList.remove('is-active');
            overlay.setAttribute('aria-hidden', 'true');
        };

        const scheduleHide = () => {
            if (hideTimeoutId) {
                clearTimeout(hideTimeoutId);
            }
            hideTimeoutId = window.setTimeout(() => {
                hideOverlay();
            }, hideDelayMs);
        };

        const showOverlayIfRequested = () => {
            if (hasShownOverlay || window.sessionStorage.getItem(shownKey) === '1') {
                return;
            }

            hasShownOverlay = true;
            window.sessionStorage.setItem(shownKey, '1');
            showOverlay();
            scheduleHide();
        };

        closeButton?.addEventListener('click', () => {
            if (hideTimeoutId) {
                clearTimeout(hideTimeoutId);
            }
            hideOverlay();
        });

        window.addEventListener('pageshow', () => {
            showOverlayIfRequested();
        });

        window.addEventListener('load', () => {
            showOverlayIfRequested();
        });

        hideOverlay();
        showOverlayIfRequested();
    })();
</script>
