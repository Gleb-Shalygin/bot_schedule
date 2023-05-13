<template>
    <div>
        <div class="d-flex">
            <h1>Преподаватели</h1>
            <el-button
                class="add_teacher_button"
                size="large"
                type="success"
                @click="addTeacher()">Добавить преподавателя <el-icon style="margin-left: 10px"><CirclePlus /></el-icon></el-button>
            <el-input v-model="filter" class="custom_search" size="large" placeholder="Поиск преподавателя" />
        </div>

        <el-card class="box-card">
            <div>
                <el-table :data="tableData"
                          v-loading="loading"
                          border style="width: 100%">
                    <el-table-column prop="id" width="50" label="ID" />
                    <el-table-column prop="name" label="Преподаватель" />
                    <el-table-column prop="date" label="Группа">
                        <template #default="scope">
                            <div class="d-flex">
                                <div v-for="(group, index) in scope.row.groups" class="badge_group" :key="index">
                                    {{ group.name }}
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column label="Действия"
                                     width="220" >
                        <template #default="scope">
                            <el-button type="success"
                                       size="small"
                                       @click="getTeacher(scope.row.id)"
                            >Редактировать</el-button
                            >
                            <el-button
                                size="small"
                                type="danger"
                                @click="deleteTeacher(scope.row.id)"
                            >Удалить</el-button
                            >
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </el-card>

        <TeachersCreateAndEditModal
            @onUpdateTable="updateTable"
            ref="teacher_modal"/>
    </div>
</template>

<script>
import TeachersCreateAndEditModal from "@/user/admin/teachers/TeachersCreateAndEditModal.vue";

export default {
    name: "TeachersComponent",
    components: {TeachersCreateAndEditModal},
    data() {
        return {
            tableData: [],
            dialogVisible: false,
            loading: false,
            filter: '',
            searching: null
        }
    },
    watch: {
        filter(val) {
            if(this.searching)
                clearTimeout(this.searching)

            this.searching = setTimeout(() => {
                this.getDataTable();
            }, 600);

            setTimeout( () => this.searching, 10)
        }
    },
    methods: {
        addTeacher() {
            this.$nextTick((e) => {
                this.$refs['teacher_modal'].show();
            })
        },
        deleteTeacher(id) {
            this.$confirm(
                'Вы действительно хотите удалить преподавателя?',
                'Удалить преподавателя',
                {
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Отмена',
                    type: 'warning',
                }
            ).then(() => {
                axios.post('/teachers/delete-teacher', {id: id})
                    .then((response) => {
                        if (response.data.status === 203) {
                            this.$message({
                                type: 'success',
                                message: 'Преподаватель удален!',
                            })
                            this.loading = true;
                        }
                    }).catch((response) => {
                }).finally((response) => {
                    this.updateTable();
                })
            });
        },
        getTeacher(id) {
            this.$nextTick((e) => {
                this.$refs['teacher_modal'].show(id);
            })
        },
        getDataTable() {
            this.loading = true;

            axios.get('/teachers/get-data-table', {
                params: {filter: this.filter}
            })
                .then((response) => {
                    this.tableData = response.data;
            }).catch((response) => {

            }).finally((response) => {
                this.loading = false;
            })
        },
        updateTable() {
            setTimeout(() => {
                this.getDataTable();
            }, 1000);
        }
    },
    mounted() {
        this.getDataTable();
    }
}
</script>

<style scoped>
    .add_teacher_button {
        margin: 7px 0px 7px 14px;
    }

    .custom_search {
        margin-left: auto;
        width: 20%;
        height: 42px;
        margin-top: 5px;
    }

    .badge_group {
        background-color: #2c3e50;
        padding: 2px 15px;
        color: white;
        border-radius: calc(var(--el-border-radius-base) - 1px);
        margin-right: 10px;
    }
</style>
