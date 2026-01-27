@props(['expires'])

<div x-data="countdown('{{ $expires }}')"
     x-init="start()"
     class="flex items-center space-x-2 text-sm font-medium">
    <div class="flex items-center space-x-1 text-red-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
        </svg>
        <span>Ends in:</span>
    </div>
    <div class="flex space-x-1">
        <div class="flex flex-col items-center bg-gray-100 rounded px-2 py-1">
            <span x-text="days" class="font-bold text-gray-800"></span>
            <span class="text-xs text-gray-500">Days</span>
        </div>
        <div class="flex flex-col items-center bg-gray-100 rounded px-2 py-1">
            <span x-text="hours" class="font-bold text-gray-800"></span>
            <span class="text-xs text-gray-500">Hrs</span>
        </div>
        <div class="flex flex-col items-center bg-gray-100 rounded px-2 py-1">
            <span x-text="minutes" class="font-bold text-gray-800"></span>
            <span class="text-xs text-gray-500">Mins</span>
        </div>
        <div class="flex flex-col items-center bg-gray-100 rounded px-2 py-1">
            <span x-text="seconds" class="font-bold text-gray-800"></span>
            <span class="text-xs text-gray-500">Secs</span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('countdown', (expiry) => ({
            expiry: new Date(expiry).getTime(),
            remaining: 0,
            days: '00',
            hours: '00',
            minutes: '00',
            seconds: '00',
            interval: null,

            start() {
                this.update();
                this.interval = setInterval(() => {
                    this.update();
                }, 1000);
            },

            update() {
                const now = new Date().getTime();
                this.remaining = this.expiry - now;

                if (this.remaining < 0) {
                    this.remaining = 0;
                    clearInterval(this.interval);
                }

                this.days = String(Math.floor(this.remaining / (1000 * 60 * 60 * 24))).padStart(2, '0');
                this.hours = String(Math.floor((this.remaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                this.minutes = String(Math.floor((this.remaining % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                this.seconds = String(Math.floor((this.remaining % (1000 * 60)) / 1000)).padStart(2, '0');
            }
        }));
    });
</script>
