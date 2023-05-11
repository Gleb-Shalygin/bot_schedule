<template>
    <div>
        <div class="d-flex">
            <h1>Преподаватели</h1>
            <el-button
                class="add_teacher_button"
                size="large"
                type="success"
                @click="addTeacher">Добавить преподавателя <el-icon style="margin-left: 10px"><CirclePlus /></el-icon></el-button>
        </div>

        <el-card class="box-card">
            <div>
                <el-table :data="tableData"
                          border style="width: 100%">
                    <el-table-column prop="id" width="50" label="ID" />
                    <el-table-column prop="name" label="Преподаватель" />
                    <el-table-column prop="date" label="Группа">
                        <template #default="scope">
                            <div class="d-flex">
                                <div v-for="(group, index) in scope.row.groups" class="badge_group" :key="index">
                                    {{ group.name}}
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column label="Действия"
                                     width="220" >
                        <template #default="scope">
                            <el-button type="success" size="small"
                            >Редактировать</el-button
                            >
                            <el-button
                                size="small"
                                type="danger"
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
            dialogVisible: false
        }
    },
    methods: {
        addTeacher() {
            this.$nextTick((e) => {
                this.$refs['teacher_modal'].show(12);
            })
        },
        getDataTable() {
            axios.get('/teachers/get-data-table')
                .then((response) => {
                    this.tableData = response.data;
            }).catch((response) => {

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

    .badge_group {
        background-color: #2c3e50;
        padding: 2px 15px;
        color: white;
        border-radius: calc(var(--el-border-radius-base) - 1px);
        margin-right: 10px;
    }
</style>
