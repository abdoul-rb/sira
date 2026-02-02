<div x-data="pwaInstallPrompt()" x-init="init()" x-show="showPrompt"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" x-cloak
    class="fixed bottom-20 inset-x-4 lg:bottom-6 lg:right-6 lg:left-auto lg:max-w-sm z-50">

    <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-teal-600 to-emerald-600 px-4 py-3">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-white font-semibold text-sm">{{ __('Installer l\'application') }}</h3>
                    <p class="text-white/80 text-xs">{{ __('Accès rapide depuis votre écran') }}</p>
                </div>
                <button @click="dismiss()" class="flex-shrink-0 text-white/70 hover:text-white p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="px-4 py-4">
            <p class="text-gray-600 text-sm mb-4">
                {{ __("Installez l'application pour un accès plus rapide et une meilleure expérience.") }}
            </p>
            <div class="flex items-center gap-3">
                <button @click="install()"
                    class="flex-1 bg-gradient-to-r from-teal-600 to-emerald-600 text-white px-4 py-2.5 rounded-xl font-medium text-sm hover:from-teal-700 hover:to-emerald-700 transition-all shadow-lg">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        {{ __('Installer') }}
                    </span>
                </button>
                <button @click="dismiss()" class="px-4 py-2.5 text-gray-500 hover:text-gray-700 text-sm font-medium">
                    {{ __('Plus tard') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function pwaInstallPrompt() {
        return {
            showPrompt: false,
            deferredPrompt: null,
            deviceFingerprint: null,

            async init() {
                this.deviceFingerprint = await this.generateFingerprint();

                // Détecter mode standalone (PWA déjà installée)
                const isStandalone = window.matchMedia('(display-mode: standalone)').matches ||
                    window.navigator.standalone === true;

                if (isStandalone) {
                    await this.trackIfNotRegistered();
                    return;
                }

                // Vérifier si prompt déjà refusé récemment
                if (localStorage.getItem('pwa-prompt-dismissed')) {
                    const dismissedAt = parseInt(localStorage.getItem('pwa-prompt-dismissed'));
                    const daysSinceDismissed = (Date.now() - dismissedAt) / (1000 * 60 * 60 * 24);
                    if (daysSinceDismissed < 7) return;
                }

                // Vérifier si déjà enregistré
                const alreadyRegistered = await this.checkIfRegistered();
                if (alreadyRegistered) {
                    localStorage.setItem('pwa-installed', 'true');
                    return;
                }

                if (localStorage.getItem('pwa-installed')) return;

                window.addEventListener('beforeinstallprompt', (e) => {
                    e.preventDefault();
                    this.deferredPrompt = e;
                    setTimeout(() => { this.showPrompt = true; }, 2000);
                });

                window.addEventListener('appinstalled', () => {
                    this.showPrompt = false;
                    this.deferredPrompt = null;
                    this.trackInstallation();
                });
            },

            async install() {
                if (this.deferredPrompt) {
                    this.deferredPrompt.prompt();
                    const { outcome } = await this.deferredPrompt.userChoice;
                    // TODO: remove console
                    console.log(`User response: ${outcome}`);
                    this.deferredPrompt = null;
                    this.showPrompt = false;
                }
            },

            dismiss() {
                this.showPrompt = false;
                localStorage.setItem('pwa-prompt-dismissed', Date.now().toString());
            },

            async generateFingerprint() {
                const components = [
                    navigator.userAgent,
                    navigator.language,
                    screen.width + 'x' + screen.height,
                    screen.colorDepth,
                    new Date().getTimezoneOffset(),
                    navigator.hardwareConcurrency || 'unknown',
                    navigator.platform || 'unknown',
                ];

                const data = components.join('|');
                const encoder = new TextEncoder();
                const dataBuffer = encoder.encode(data);
                const hashBuffer = await crypto.subtle.digest('SHA-256', dataBuffer);
                const hashArray = Array.from(new Uint8Array(hashBuffer));

                return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
            },

            async checkIfRegistered() {
                try {
                    const response = await fetch('/api/pwa-installations/check', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            'Accept': 'application/json',
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({ device_fingerprint: this.deviceFingerprint })
                    });

                    const data = await response.json();
                    return data.registered === true;
                } catch (error) {
                    return false;
                }
            },

            async trackIfNotRegistered() {
                if (localStorage.getItem('pwa-installed')) return;

                const alreadyRegistered = await this.checkIfRegistered();
                if (alreadyRegistered) {
                    localStorage.setItem('pwa-installed', 'true');
                    return;
                }

                await this.trackInstallation();
            },

            async trackInstallation() {
                try {
                    localStorage.setItem('pwa-installed', 'true');

                    await fetch('/api/pwa-installations', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            'Accept': 'application/json',
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({ device_fingerprint: this.deviceFingerprint })
                    });
                } catch (error) {
                    console.error('Failed to track PWA installation:', error);
                }
            }
        }
    }
</script>