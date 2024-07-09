<template>
    <div class="container">
        <div class="confirmation-method-select" v-if="!showCodeInput">
            <h2 class="card-header">Выберите метод подтверждения:</h2>
            <div class="radio-option">
                <input type="radio" id="sms" name="confirmationMethod" value="sms" v-model="selectedMethod">
                <label for="sms">SMS</label>
            </div>
            <div class="radio-option">
                <input type="radio" id="email" name="confirmationMethod" value="email" v-model="selectedMethod">
                <label for="email">Email</label>
            </div>
            <div class="radio-option">
                <input type="radio" id="telegram" name="confirmationMethod" value="telegram" v-model="selectedMethod">
                <label for="telegram">Telegram</label>
            </div>
            <button v-if="selectedMethod !== 'telegram'" class="submit-button" @click="submitMethod">Отправить</button>

            <div v-if="selectedMethod === 'telegram'" class="telegram-info">
                <p>Откройте чат с ботом и введите команду <strong>/confirm</strong>:</p>
                <a href="https://t.me/VerifyAssistantBot" target="_blank" @click.prevent="openChat">Открыть чат с ботом</a>
            </div>

            <!-- Условный рендеринг для SMS -->
            <div v-if="submitted && selectedMethod === 'sms'" class="sms-info">
                <p>Введите код, полученный по SMS:</p>
                <input type="text" v-model="smsCode" class="sms-code-input">
                <button class="submit-button" @click="verifyCode">Подтвердить</button>
            </div>
        </div>
        <confirmation-code-input v-else :method="selectedMethod" @code-confirmed="handleCodeConfirmed" @back="handleBack"></confirmation-code-input>
    </div>
</template>

<script>
import axios from "axios";
import ConfirmationCodeInput from './ConfirmationCodeInput.vue';

export default {
    components: {
        ConfirmationCodeInput
    },
    data() {
        return {
            selectedMethod: '',
            telegramBotLink: 'https://t.me/VerifyAssistantBot',
            chatOpened: false,
            telegramCode: '',
            smsCode: '',
            emailCode: '',
            submitted: false,
            showCodeInput: false
        };
    },
    methods: {
        async userStore() {
            const token = localStorage.getItem('accessToken');
            await axios.post('http://localhost:8084/api/save', {
                method: this.selectedMethod,
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            this.chatOpened = true;
        },
        async submitMethod() {
            const token = localStorage.getItem('accessToken');
            await axios.post('http://localhost:8084/api/send', {
                method: this.selectedMethod,
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            this.submitted = true;
            this.showCodeInput = true;
        },
        async verifyCode() {
            const token = localStorage.getItem('accessToken');
            const code = this.selectedMethod === 'telegram' ? this.telegramCode : this.selectedMethod === 'sms' ? this.smsCode : this.emailCode;
            await axios.post('http://localhost:8084/api/verify', {
                code,
                method: this.selectedMethod
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
        },
        async openChat() {
            try {
                await this.userStore();
                window.open(this.telegramBotLink, '_blank');
                this.showCodeInput = true;
            } catch (error) {
                console.error('Error opening chat with bot:', error);
            }
        },
        handleCodeConfirmed(code) {
            console.log('Код подтвержден:', code);
            // Добавьте логику для подтверждения кода
        },
        handleBack() {
            this.showCodeInput = false;
        }
    }
}
</script>

<style scoped>
.container {
    background-color: #F0F1F3;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    width: 100vw;
}

.confirmation-method-select {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #ffffff;
    border-radius: 20px;
    padding: 20px;
    text-align: center;
    width: fit-content;
}

.card-header {
    font-size: 28px;
    font-weight: 700;
    font-family: 'Montserrat-Bold';
    margin-bottom: 25px;
}

.radio-option {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    position: relative;
}

.radio-option input[type="radio"] {
    opacity: 0;
    position: absolute;
}

.radio-option label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 16px;
    font-family: 'Montserrat-Regular';
    font-weight: 500;
    line-height: 120%;
    color: #063a82;
}

.radio-option label::before {
    content: '';
    display: inline-block;
    width: 20px;
    height: 20px;
    margin-right: 10px;
    border: 2px solid #063a82;
    border-radius: 50%;
    background-color: #fff;
    transition: background-color 0.3s, border-color 0.3s;
}

.radio-option input[type="radio"]:checked + label::before {
    background-color: #063a82;
    border-color: #063a82;
}

.submit-button {
    background-color: #005BD1; /* Цвет кнопки */
    color: white; /* Белый цвет текста */
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
}

.submit-button:hover {
    background-color: #1E90FF; /* Темнее лазурный при наведении */
}

.telegram-info,
.sms-info {
    margin-top: 20px;
    padding: 10px;
    background-color: #ffffff;
    border-radius: 5px;
    border: 1px solid #063a82;
}

.telegram-info p,
.sms-info p {
    margin-bottom: 10px;
}

.telegram-info a,
.sms-info a {
    color: #005BD1;
    text-decoration: none;
    font-weight: bold;
    font-family: 'Montserrat-Regular';
    font-size: 18px;
    color: #063a82;
}

.telegram-info a:hover,
.sms-info a:hover {
    text-decoration: underline;
    font-family: 'Montserrat-Regular';
    font-size: 18px;
    color: #063a82;
}

.telegram-code-input,
.sms-code-input {
    margin-top: 10px;
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
    width: 200px;
    text-align: center;
}
</style>
