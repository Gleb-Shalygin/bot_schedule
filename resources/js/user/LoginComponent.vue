<template>
    <div class="container text-center">
        <div class="row align-middle">
            <div class="col"></div>
            <div class="col-6">
                <el-card class="clearfix text-secondary" :style="{'margin-top': 25 + '%'}">
                    <div slot="header" class="clearfix">
                        <h2>Авторизация пользователя</h2>
                    </div>
                    <div class="row d-flex flex-column mt-4 mb-3">
                        <div class="col-1 mt-2">
                            <h5>Логин</h5>
                        </div>
                        <div class="col-12">
                            <el-input  placeholder="Введите логин" v-model="user.email"></el-input>
                        </div>
                        <div class="col-1 mt-3">
                            <h5>Пароль</h5>
                        </div>
                        <div class="col-12">
                            <el-input  placeholder="Введите пароль" v-model="user.password" show-password></el-input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col float-right">
                            <el-button class="bg-secondary text-white"
                                       @click="redirectOnCancel">Назад</el-button>
                            <el-button type="success" @click="login">Войти</el-button>
                        </div>
                    </div>
                </el-card>
            </div>
            <div class="col"></div>
        </div>
    </div>
</template>

<script>
import {ElNotification} from "element-plus";

export default {
    name: "LoginComponent",
    data() {
        return {
            user: {
                password: null,
                email: null,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }
    },
    methods: {
        redirectOnCancel() {
            window.location.href = "/";
        },
        login() {
            axios.post('login', this.user)
                .then((response) => {
                    if(response.data.status === 203) {
                        window.location.href = '/admin';
                        return;
                    }

                    this.$notify({
                        title: 'Ошибка',
                        message: 'Не правильный логин или пароль',
                        type: 'error',
                    })
                }).catch((error) => {
                    this.$notify({
                        title: 'Ошибка',
                        message: 'Не правильный логин или пароль',
                        type: 'error',
                    })
            })
        }
    }
}
</script>

<style>
</style>
