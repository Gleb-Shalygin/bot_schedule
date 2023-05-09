<template>
    <notifications />
    <div class="container text-center">
        <div class="row align-middle">
            <div class="col"></div>
            <div class="col-8">
                <el-card class="clearfix">
                    <div class="row d-flex flex-column mt-4 mb-3">
                        <div class="col-1 mt-2">
                            <h5>Имя</h5>
                        </div>
                        <div class="col-12">
                            <el-input  placeholder="Введите имя"
                                       v-model="messageData.name"></el-input>
                        </div>
                        <div class="col-1 mt-3">
                            <h5>Email</h5>
                        </div>
                        <div class="col-12">
                            <el-input  placeholder="Введите email"
                                       v-model="messageData.email"></el-input>
                        </div>
                        <div class="col-1 mt-3">
                            <h5>Телефон</h5>
                        </div>
                        <div class="col-12">
                            <el-input  placeholder="Введите ваш номер телефона"
                                       v-model="messageData.phone"></el-input>
                        </div>
                        <div class="col-1 mt-3">
                            <h5>Сообщение</h5>
                        </div>
                        <div class="col-12">
                            <el-input  placeholder="Введите сообщение"
                                       type="textarea"
                                       v-model="messageData.message"></el-input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col float-right">
                            <el-button type="success"
                                       @click="sendMessage">Отправить</el-button>
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
    name: "SupportFormComponent",
    data() {
        return {
            messageData: {
                name: null,
                email: null,
                phone: null,
                message: null,
            }
        }
    },
    methods: {
        redirectOnCancel() {
            window.location.href = "/";
        },
        sendMessage() {

            this.$notify({
                title: 'Уведомление',
                message: 'Ваше сообщение отправлено',
                type: 'success'
            });
        }
    }
}
</script>

<style scoped>

</style>
