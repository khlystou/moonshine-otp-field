<div x-data="otpField">
    <div class="flex justify-center gap-2" x-ref="inputs">
        <template x-for="(input, index) in length" :key="index">
            <input {{ $attributes->merge([
                    'class' => 'form-input w-10 h-10 text-center'
                ]) }}
                type="{{ $masked ? 'password' : 'tel' }}" 
                maxlength="1"
                x-on:input="handleInput($event, index)"
                x-on:paste="handlePaste($event)"
                x-on:keydown.backspace="$event.target.value || handleBackspace(index)"
            >
        </template>
    </div>
    <input type="hidden" name="{{ $name }}" x-model="value">
</div>
 
<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("otpField", () => ({
            length: @js($length),
            value: '',

            get inputs() {
                return this.$refs.inputs.querySelectorAll('.form-input');
            },

            handleInput(e, index) {
                const inputValues = [...this.inputs].map(input => input.value);
                this.value = inputValues.join('');

                if (e.target.value) {
                    const nextInput = this.inputs[index + 1];
                    if (nextInput) {
                        nextInput.focus();
                        nextInput.select();
                    }
                }
            },

            handlePaste(e) {
                const paste = e.clipboardData.getData('text').slice(0, this.length);
                paste.split('').forEach((char, i) => {
                    if (this.inputs[i]) {
                        this.inputs[i].value = char;
                    }
                });

                this.value = [...this.inputs].map(input => input.value).join('');
            },

            handleBackspace(index) {
                if (index > 0) {
                    const prevInput = this.inputs[index - 1];
                    if (prevInput) {
                        prevInput.focus();
                        prevInput.select();
                    }
                }
            },
        }))
    })
</script>