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
<!--                    <el-dropdown-item>Преподаватели</el-dropdown-item>-->
<!--                    <el-dropdown-item>Расписание занятий</el-dropdown-item>-->
<!--                    <el-dropdown-item>Расписание звонков</el-dropdown-item>-->
<!--                    <el-dropdown-item disabled>Action 4</el-dropdown-item>-->
                    <el-dropdown-item divided @click="logout()">Выйти</el-dropdown-item>
                </el-dropdown-menu>
            </template>
        </el-dropdown>
    </div>
<!--    <el-menu-->
<!--        :default-active="activeIndex"-->
<!--        class="el-menu-demo"-->
<!--        mode="horizontal"-->
<!--        @select="handleSelect"-->
<!--        background-color="rgba(var(&#45;&#45;bs-secondary-rgb), var(&#45;&#45;bs-bg-opacity))"-->
<!--    >-->
<!--        <el-menu-item index="1">Processing Center</el-menu-item>-->
<!--        <el-sub-menu index="2">-->
<!--            <template #title>Workspace</template>-->
<!--            <el-menu-item index="2-1">item one</el-menu-item>-->
<!--            <el-menu-item index="2-2">item two</el-menu-item>-->
<!--            <el-menu-item index="2-3">item three</el-menu-item>-->
<!--            <el-sub-menu index="2-4">-->
<!--                <template #title>item four</template>-->
<!--                <el-menu-item index="2-4-1">item one</el-menu-item>-->
<!--                <el-menu-item index="2-4-2">item two</el-menu-item>-->
<!--                <el-menu-item index="2-4-3">item three</el-menu-item>-->
<!--            </el-sub-menu>-->
<!--        </el-sub-menu>-->
<!--        <el-menu-item index="3" disabled>Info</el-menu-item>-->
<!--        <el-menu-item index="4">Orders</el-menu-item>-->
<!--    </el-menu>-->
</template>

<script>
export default {
    name: "AvatarComponent",
    data() {
        return {
            activeIndex: 1
        }
    },
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
        },
        handleSelect() {

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
