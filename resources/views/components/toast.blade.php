<div x-data="{ 
    messages: [],
    remove(id) {
        this.messages = this.messages.filter(m => m.id !== id)
    },
    add(message, type = 'success') {
        const id = Date.now()
        this.messages.push({ id, text: message, type })
        setTimeout(() => this.remove(id), 5000)
    }
}"
@notify.window="add($event.detail.message, $event.detail.type)"
x-init="
    @if(session('success')) add('{{ session('success') }}', 'success'); @endif
    @if(session('error')) add('{{ session('error') }}', 'error'); @endif
"
class="fixed top-20 right-4 z-[9999] flex flex-col gap-3 w-full max-w-sm pointer-events-none">
    
    <template x-for="message in messages" :key="message.id">
        <div x-show="true" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-x-8"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-x-0"
             x-transition:leave-end="opacity-0 transform translate-x-8"
             class="pointer-events-auto bg-white rounded-lg shadow-xl border-l-4 p-4 flex items-center justify-between"
             :class="{
                'border-green-500': message.type === 'success',
                'border-red-500': message.type === 'error',
                'border-blue-500': message.type === 'info'
             }">
            
            <div class="flex items-center gap-3">
                <template x-if="message.type === 'success'">
                    <div class="bg-green-100 p-1.5 rounded-full">
                        <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </template>
                <template x-if="message.type === 'error'">
                    <div class="bg-red-100 p-1.5 rounded-full">
                        <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                </template>
                <p class="text-sm font-medium text-gray-800" x-text="message.text"></p>
            </div>

            <button @click="remove(message.id)" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </template>
</div>

