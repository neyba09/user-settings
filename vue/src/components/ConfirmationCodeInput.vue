<template>
    <div class="container">
        <div class="card">
            <h2 class="card-header">Введите код подтверждения</h2>
            <div class="card-body">
                <input
                    v-model="confirmationCode"
                    type="text"
                    placeholder="Код подтверждения*"
                    class="confirmation-input"/>
                <button @click="verifyCode" class="buttonLog">Подтвердить</button>
                <button @click="goBack" class="buttonBack">Назад</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: {
        method: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            confirmationCode: '',
        };
    },
    methods: {
        async verifyCode() {
            try {
                const token = localStorage.getItem('accessToken');
                await axios.post('http://localhost:8084/api/verify', {
                    code: this.confirmationCode,
                    method: this.method
                }, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
            } catch (error) {
                console.error('Error verifying code:', error);
            }
        },
        goBack() {
            this.$emit('back');
        }
    }
};
</script>

<style scoped>
.container {
    display: flex;
    justify-content: center;
    background-color: #F0F1F3;
    height: 100vh;
    align-items: center;
}

.card {
    display: flex;
    align-items: center;
    flex-direction: column;
    background-color: white;
    border-radius: 20px;
    height: fit-content;
    padding: 42px 32px;
    width: 454px;
}

.card-header {
    justify-content: center;
    align-self: stretch;
    text-align: center;
    font-size: 32px;
    font-weight: 700;
    line-height: 120%;
    font-family: 'Montserrat-Bold';
    margin-bottom: 13px;
}

.card-body {
    margin-top: 24px;
    width: 100%;
}

.confirmation-input {
    font-family: 'Montserrat-Regular';
    font-size: 14px;
    margin-bottom: 12px;
    width: -webkit-fill-available;
    padding: 12px 16px;
    border: 1px solid #DBDEE4;
    border-radius: 9px;
    outline: none;
    background-color: #F0F1F3;
    background-repeat: no-repeat;
    background-position-x: 16px;
    background-size: 16px;
}

.buttonLog {
    background-color: #005BD1;
    color: white;
    padding: 12px 0;
    width: 100%;
    border-radius: 10px;
    height: 47px;
    margin-bottom: 10px;
    font-family: 'Montserrat-Regular';
    cursor: pointer;
}

.buttonBack {
    background-color: #ccc;
    color: black;
    padding: 12px 0;
    width: 100%;
    border-radius: 10px;
    height: 47px;
    margin-bottom: 26px;
    font-family: 'Montserrat-Regular';
    cursor: pointer;
}

.buttonLog:hover {
    background-color: #1E90FF;
}

.buttonBack:hover {
    background-color: #bbb;
}
</style>
