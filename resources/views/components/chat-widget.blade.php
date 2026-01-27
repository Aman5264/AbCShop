<div x-data="chatWidget()" 
     class="fixed bottom-6 right-26 z-[9999]"
     @keydown.escape.window="isOpen = false">
    
    <!-- Chat Bubble -->
    <button @click="toggleChat()" 
            class="w-16 h-16 bg-gradient-to-tr from-indigo-600 to-indigo-500 text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition-transform duration-300 relative group overflow-hidden">
        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
        
        <!-- Open Icon -->
        <svg x-show="!isOpen" x-transition:enter="transition duration-300" x-transition:enter-start="rotate-90 opacity-0" 
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
        </svg>

        <!-- Close Icon -->
        <svg x-show="isOpen" x-transition:enter="transition duration-300" x-transition:enter-start="-rotate-90 opacity-0"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7" style="display: none;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Chat Window -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         class="absolute bottom-20 right-0 w-[380px] h-[550px] bg-white rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-gray-100"
         style="display: none;">
        
        <!-- Header -->
        <div class="p-6 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md">
                    <span class="text-xl font-black italic">ABC</span>
                </div>
                <div>
                    <h3 class="font-bold text-lg leading-none">ABC Assistant</h3>
                    <p class="text-indigo-300 text-xs mt-1 flex items-center">
                        <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                        Always here to help
                    </p>
                </div>
            </div>
        </div>

        <!-- Messages Area -->
        <div id="chat-messages" class="flex-1 overflow-y-auto p-6 space-y-4 scroll-smooth bg-gray-50/50">
            <!-- Welcome Message -->
            <div class="flex items-start">
                <div class="bg-white border border-gray-100 p-4 rounded-2xl rounded-tl-none shadow-sm max-w-[85%] text-sm text-gray-700">
                    Hello! I'm your **ABC Shop Assistant**. How can I help you find the perfect product today? 🛍️
                </div>
            </div>

            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.role === 'user' 
                        ? 'bg-indigo-600 text-white rounded-2xl rounded-tr-none shadow-lg' 
                        : 'bg-white border border-gray-100 rounded-2xl rounded-tl-none shadow-sm text-gray-700'"
                        class="p-4 max-w-[85%] text-sm leading-relaxed"
                        x-html="formatMessage(msg.content)">
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isTyping" class="flex items-start" style="display: none;">
                <div class="bg-white border border-gray-100 p-4 rounded-2xl rounded-tl-none shadow-sm flex gap-1">
                    <div class="w-1.5 h-1.5 bg-gray-300 rounded-full animate-bounce"></div>
                    <div class="w-1.5 h-1.5 bg-gray-300 rounded-full animate-bounce delay-100"></div>
                    <div class="w-1.5 h-1.5 bg-gray-300 rounded-full animate-bounce delay-200"></div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white border-t border-gray-100">
            <form @submit.prevent="sendMessage()" class="relative flex items-center gap-2">
                <input x-model="userInput" 
                       type="text" 
                       placeholder="Type your question..." 
                       class="flex-1 bg-gray-50 border-none focus:ring-2 focus:ring-[#111827]/10 rounded-2xl py-3 px-4 text-sm placeholder-gray-400 transition-all"
                       :disabled="isTyping">
                
                <button type="submit" 
                        class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center hover:scale-105 active:scale-95 transition-all disabled:opacity-50"
                        :disabled="!userInput.trim() || isTyping">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                </button>
            </form>
            <p class="text-[10px] text-gray-400 text-center mt-3 font-medium uppercase tracking-widest">Powered by ABC AI</p>
        </div>
    </div>
</div>

<script>
    function chatWidget() {
        return {
            isOpen: false,
            userInput: '',
            isTyping: false,
            messages: [],

            toggleChat() {
                this.isOpen = !this.isOpen;
                if (this.isOpen) {
                    setTimeout(() => this.scrollToBottom(), 100);
                }
            },

            async sendMessage() {
                if (!this.userInput.trim()) return;

                const userMsg = this.userInput;
                this.messages.push({ role: 'user', content: userMsg });
                this.userInput = '';
                this.isTyping = true;
                
                this.scrollToBottom();

                try {
                    const response = await fetch('{{ route('api.chat') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ message: userMsg })
                    });

                    const data = await response.json();
                    
                    if (response.ok && data.message) {
                        this.messages.push({ role: 'assistant', content: data.message });
                    } else {
                        let errorMsg = "I'm having a bit of trouble thinking right now. 🔌";
                        if (data.error_details) {
                            const details = typeof data.error_details === 'object' 
                                ? JSON.stringify(data.error_details, null, 2) 
                                : data.error_details;
                            errorMsg += `<br><br><div class="bg-red-50 p-2 rounded text-[10px] font-mono text-red-600 overflow-x-auto">DEBUG INFO:<br>${details}</div>`;
                        }
                        this.messages.push({ role: 'assistant', content: errorMsg });
                    }
                } catch (error) {
                    this.messages.push({ 
                        role: 'assistant', 
                        content: "I'm having a connection issue. Please try again later! 🔌" 
                    });
                } finally {
                    this.isTyping = false;
                    this.scrollToBottom();
                }
            },

            formatMessage(text) {
                // Simple bold markdown support
                return text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                           .replace(/\n/g, '<br>');
            },

            scrollToBottom() {
                setTimeout(() => {
                    const el = document.getElementById('chat-messages');
                    if (el) el.scrollTop = el.scrollHeight;
                }, 50);
            }
        }
    }
</script>
