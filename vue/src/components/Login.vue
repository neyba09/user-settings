<template>
    <div class="container">
        <div class="card">
            <h1 class="card-header">Вход</h1>
            <p>Рады вас видеть</p>
            <div class="card-body">
                <div class="ruls">
                    {{ state.response }}
                </div>
                <form class="general-block" @submit.prevent="login">
                    <div>
                        <input
                            v-model.trim="state.email"
                            type="email"
                            placeholder="E-mail*"/>
                    </div>
                    <div class="showPassword">
                        <input
                            v-model.trim="state.password"
                            :type="showPass ? 'text' : 'password'"
                            placeholder="Пароль*"/>
                        <div @click="showPass = !showPass" class="show" :class="{ hiden: !showPass }"></div>
                    </div>
                    <button
                        type="submit"
                        class="buttonLog">Войти
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            state: {
                errLog: false,
                response: '',
                email: '',
                password: ''
            },
            showPass: false
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('http://localhost:8084/api/login', {
                    email: this.state.email,
                    password: this.state.password
                });

                if (response.data.status) {
                    // Сохранение токена в локальном хранилище
                    localStorage.setItem('accessToken', response.data.token);
                    // Редирект на страницу /confirmation-process
                    this.$router.push('/confirmation-process');
                } else {
                    // Дополнительные действия в случае ошибки входа
                    this.state.errLog = true;
                    this.state.response = response.data.message;
                }
            } catch (error) {
                console.error('Ошибка входа:', error);
            }
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

p {
    font-size: 16px;
    font-family: 'Montserrat-Regular';
    font-weight: 500;
    line-height: 120%;
    color: #919399;
}

.redir {
    cursor: pointer;
}

.card-body {
    margin-top: 24px;
    width: 100%;
}

.buttonLog {
    background-color: #005BD1;
    color: white;
    padding: 12px 0; /* Padding adjusted */
    width: 100%;
    border-radius: 10px;
    height: 47px;
    margin-bottom: 26px;
    font-family: 'Montserrat-Regular';
    cursor: pointer;
}

input {
    font-family: 'Montserrat-Regular';
    font-size: 14px;
    /* height: 48px; */
    margin-bottom: 12px;
    width: 90%;
    padding: 12px 16px;
    border: 1px solid #DBDEE4;
    border-radius: 9px;
    outline: none;
    background-color: #F0F1F3;
    background-repeat: no-repeat;
    background-position-x: 16px;
    background-size: 16px;
}

.showPassword {
    position: relative;
}

.show {
    position: absolute;
    cursor: pointer;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    width: 30px;
    height: 30px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
}
</style>
