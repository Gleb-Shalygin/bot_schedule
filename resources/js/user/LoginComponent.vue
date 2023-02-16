<template>
    <div class="container text-center">
        <div class="row align-middle" style="margin-top: 15%;">
            <div class="col"></div>
            <div class="col-5">
                <el-card class="clearfix">
                    <div slot="header" class="clearfix">
                        <h2>Авторизация пользователя</h2>
                    </div>
                    <div class="row d-flex flex-column mt-4 mb-3">
                        <div class="col-1 mt-2">
                            <h5>Логин</h5>
                        </div>
                        <div class="col-12">
                            <el-input  placeholder="Введите логин" v-model="user.login"></el-input>
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
                            <el-button type="info"
                                       size="medium"
                                       @click="redirectOnCancel">Назад</el-button>
                            <el-button type="success" size="medium">Войти</el-button>
                        </div>
                    </div>
                </el-card>
            </div>
            <div class="col"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "LoginComponent",
    data() {
        return {
            user: {
                password: null,
                login: null,
            }
        }
    },
    methods: {
        redirectOnCancel() {
            window.location.href = "/";
        }
    }
}
</script>

<style>
</style>
