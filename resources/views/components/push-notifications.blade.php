@auth
    <div x-data="pushNotifications()" x-init="init()" x-cloak>
        <!-- Bouton pour activer les notifications -->
        <template x-if="showButton && !isSubscribed && permission !== 'denied'">
            <div class="fixed bottom-24 right-4 z-40 lg:bottom-6">
                <button @click="subscribe()"
                    class="group flex items-center gap-2 bg-gradient-to-r from-teal-500 to-emerald-600 text-white px-4 py-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="text-sm font-medium">{{ __('Activer les notifications') }}</span>
                </button>
            </div>
        </template>

        <!-- Indicateur de succès -->
        <template x-if="isSubscribed && showSuccess">
            <div class="fixed bottom-24 right-4 z-40 lg:bottom-6">
                <div class="flex items-center gap-2 bg-emerald-100 text-emerald-800 px-4 py-2 rounded-full shadow-md"
                    x-transition>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-sm font-medium">{{ __('Notifications activées') }}</span>
                </div>
            </div>
        </template>
    </div>

    <script>
        function pushNotifications() {
            return {
                showButton: false,
                isSubscribed: false,
                showSuccess: false,
                permission: Notification.permission,
                vapidPublicKey: @json(config('webpush.vapid.public_key')),

                async init() {
                    if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
                        return;
                    }

                    const registration = await navigator.serviceWorker.ready;
                    const subscription = await registration.pushManager.getSubscription();

                    this.isSubscribed = !!subscription;
                    this.showButton = !this.isSubscribed && this.permission !== 'denied';

                    if (this.isSubscribed && subscription) {
                        await this.syncSubscription(subscription);
                    }
                },

                async subscribe() {
                    try {
                        const permission = await Notification.requestPermission();
                        this.permission = permission;

                        if (permission !== 'granted') return;

                        const registration = await navigator.serviceWorker.ready;
                        const subscription = await registration.pushManager.subscribe({
                            userVisibleOnly: true,
                            applicationServerKey: this.urlBase64ToUint8Array(this.vapidPublicKey)
                        });

                        await this.saveSubscription(subscription);

                        this.isSubscribed = true;
                        this.showButton = false;
                        this.showSuccess = true;
                        setTimeout(() => { this.showSuccess = false; }, 3000);
                    } catch (error) {
                        console.error('Error subscribing:', error);
                    }
                },

                async saveSubscription(subscription) {
                    const response = await fetch('/api/push-subscriptions', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify(subscription.toJSON())
                    });

                    if (!response.ok) throw new Error('Failed to save subscription');
                },

                async syncSubscription(subscription) {
                    try {
                        await this.saveSubscription(subscription);
                    } catch (error) {
                        console.log('Subscription sync failed');
                    }
                },

                urlBase64ToUint8Array(base64String) {
                    const padding = '='.repeat((4 - base64String.length % 4) % 4);
                    const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
                    const rawData = window.atob(base64);
                    const outputArray = new Uint8Array(rawData.length);

                    for (let i = 0; i < rawData.length; ++i) {
                        outputArray[i] = rawData.charCodeAt(i);
                    }

                    return outputArray;
                }
            }
        }
    </script>
@endauth