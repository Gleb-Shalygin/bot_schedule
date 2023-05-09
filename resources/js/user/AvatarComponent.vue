<template>
    <div class="avatar-custom">
        <el-dropdown>
            <span class="el-dropdown-link">
              <el-avatar
                  :size="30"
                  src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"
              />
            </span>
            <template #dropdown>
                <el-dropdown-menu>
                    <el-dropdown-item><el-icon><User /></el-icon>
                        <a href="/admin">Профиль</a></el-dropdown-item>
                    <el-dropdown-item>Преподаватели</el-dropdown-item>
                    <el-dropdown-item>Расписание занятий</el-dropdown-item>
                    <el-dropdown-item>Расписание звонков</el-dropdown-item>
<!--                    <el-dropdown-item disabled>Action 4</el-dropdown-item>-->
                    <el-dropdown-item divided @click="logout()">Выйти</el-dropdown-item>
                </el-dropdown-menu>
            </template>
        </el-dropdown>
    </div>
</template>

<script>
export default {
    name: "AvatarComponent",
    methods: {
        logout() {
            axios.post('/logout', {
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }).then((response) => {
                if(response.status === 204)
                    window.location.href = "/";
            }).catch((response) => {
                console.log(response);
            })
        }
    }
}
</script>

<style scoped>
.avatar-custom {
    margin-top: 12px;
    /*display: flex;*/
}
</style>
