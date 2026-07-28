{{-- Toast Container --}}
<div
    x-data="toastContainer()"
    x-on:toast.window="addToast($event.detail.type, $event.detail.message, $event.detail.duration)"
    style="position:fixed;top:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:10px;pointer-events:none;max-width:400px;width:100%;"
>
    <template x-for="t in toasts" :key="t.id">
        <div
            x-show="t.visible"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-8"
            class="toast-item"
            :class="'toast-' + t.type"
            style="pointer-events:auto;display:flex;align-items:center;gap:10px;position:relative;padding:16px 40px 16px 20px;border-radius:10px;box-shadow:0 10px 30px rgba(0,0,0,0.25);font-size:14px;font-weight:700;line-height:1.4;"
        >
            <i :class="iconClass(t.type)" style="font-size:18px;flex-shrink:0;"></i>
            <span style="flex:1;font-weight:700;" x-text="t.message"></span>
            <button
                @click="removeToast(t.id)"
                style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;opacity:0.7;font-size:14px;padding:0;flex-shrink:0;color:inherit;"
                @mouseover="$el.style.opacity='1'"
                @mouseleave="$el.style.opacity='0.7'"
            >
                <i class="fas fa-times"></i>
            </button>
        </div>
    </template>
</div>

<script>
function toastContainer() {
    return {
        toasts: [],
        addToast(type, message, duration) {
            const id = 'toast-' + Date.now() + '-' + Math.random().toString(36).slice(2, 7);
            const toast = { id, type, message, visible: true, duration: duration || 4000 };
            this.toasts.push(toast);
            if (toast.duration > 0) {
                setTimeout(() => this.removeToast(id), toast.duration);
            }
        },
        removeToast(id) {
            const t = this.toasts.find(t => t.id === id);
            if (t) t.visible = false;
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 300);
        },
        iconClass(type) {
            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-exclamation-circle',
                warning: 'fas fa-exclamation-triangle',
                info: 'fas fa-info-circle',
            };
            return icons[type] || icons.info;
        }
    };
}
</script>

<style>
.toast-success { background: #10b981; color: #ffffff; border: none; }
.toast-error   { background: #ef4444; color: #ffffff; border: none; }
.toast-warning { background: #f59e0b; color: #ffffff; border: none; }
.toast-info    { background: #3b82f6; color: #ffffff; border: none; }

.dark .toast-success { background: #059669; color: #ffffff; border: none; }
.dark .toast-error   { background: #dc2626; color: #ffffff; border: none; }
.dark .toast-warning { background: #d97706; color: #ffffff; border: none; }
.dark .toast-info    { background: #2563eb; color: #ffffff; border: none; }
</style>
