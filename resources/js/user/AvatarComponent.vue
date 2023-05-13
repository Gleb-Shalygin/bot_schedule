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
                    <el-dropdown-item divided @click="logout()">Выйти</el-dropdown-item>
                </el-dropdown-menu>
            </template>
        </el-dropdown>
    </div>
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
    margin-left: 5px;
}
</style>
