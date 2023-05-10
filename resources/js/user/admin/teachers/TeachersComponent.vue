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
                <el-table :data="tableData" border style="width: 100%">
                    <el-table-column prop="date" label="Преподаватель" />
                    <el-table-column prop="name" label="Группа" />
                    <el-table-column prop="address" label="Кабинет" />
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

        <TeachersCreateAndEditModal ref="teacher_modal"/>
    </div>
</template>

<script>
import TeachersCreateAndEditModal from "@/user/admin/teachers/TeachersCreateAndEditModal.vue";

export default {
    name: "TeachersComponent",
    components: {TeachersCreateAndEditModal},
    data() {
        return {
            tableData: [
                {
                    date: '2016-05-03',
                    name: 'Tom',
                    address: 'No. 189, Grove St, Los Angeles',
                },
                {
                    date: '2016-05-02',
                    name: 'Tom',
                    address: 'No. 189, Grove St, Los Angeles',
                },
                {
                    date: '2016-05-04',
                    name: 'Tom',
                    address: 'No. 189, Grove St, Los Angeles',
                },
                {
                    date: '2016-05-01',
                    name: 'Tom',
                    address: 'No. 189, Grove St, Los Angeles',
                },
            ],
            dialogVisible: false
        }
    },
    methods: {
        addTeacher() {
            this.$nextTick((e) => {
                this.$refs['teacher_modal'].show(12);
            })
        }
    }
}
</script>

<style scoped>
    .add_teacher_button {
        margin: 7px 0px 7px 14px;
    }
</style>
