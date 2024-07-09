<template>
    <div>
        <template v-if="currentStep === 'selectMethod'">
            <ConfirmationMethodSelect @method-selected="handleMethodSelected" />
        </template>
        <template v-else-if="currentStep === 'inputCode'">
            <ConfirmationCodeInput @code-confirmed="handleCodeConfirmed" @back="handleBack" />
        </template>
        <template v-else-if="currentStep === 'success'">
            <ConfirmationSuccess />
        </template>
    </div>
</template>

<script>
import { ref } from 'vue';
import ConfirmationMethodSelect from './ConfirmationMethodSelect.vue';
import ConfirmationCodeInput from './ConfirmationCodeInput.vue';
import ConfirmationSuccess from './ConfirmationSuccess.vue';

export default {
    components: {
        ConfirmationMethodSelect,
        ConfirmationCodeInput,
        ConfirmationSuccess,
    },
    setup() {
        const currentStep = ref('selectMethod');

        const handleMethodSelected = (method) => {
            currentStep.value = 'inputCode';
        };

        const handleCodeConfirmed = (code) => {
            if (code === 'ваш код подтверждения') {
                currentStep.value = 'success';
            } else {
                currentStep.value = 'error';
            }
        };

        const handleBack = () => {
            currentStep.value = 'selectMethod';
        };

        return {
            currentStep,
            handleMethodSelected,
            handleCodeConfirmed,
            handleBack,
        };
    },
};
</script>

<style scoped>

</style>
