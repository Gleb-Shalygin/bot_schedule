<template>
    <el-dialog v-model="dialogTableVisible" title="Редактировать расписание">
        <h1>Группа ИС439</h1>
        <el-table :data="dataTable" border>
            <el-table-column label="Пара" prop="name" width="80" />
            <el-table-column label="Название пары" prop="state" />
            <el-table-column label="Препод" width="160" prop="city"/>
            <el-table-column label="Кабинет" width="120" prop="address"/>
            <el-table-column label="Действия" width="100">
                <template #default="scope">
                    <div>
                        <el-button type="danger" size="default" @click="deleteColumn(scope.$index)"><el-icon><Delete /></el-icon></el-button>
                    </div>
                </template>
            </el-table-column>
        </el-table>
        <el-button type="success" style="margin-top: 10px;" @click="addColumn()" :disabled="dataTable.length === 6">Добавить колонку</el-button>
        <template #footer>
          <span class="dialog-footer">
            <el-button @click="dialogTableVisible = false">Отмена</el-button>
            <el-button type="success" @click="dialogTableVisible = false">
                Сохранить изменения
            </el-button>
          </span>
        </template>
    </el-dialog>
</template>

<script>
export default {
    name: "ScheduleEditModal",
    data() {
        return {
            dialogTableVisible: false,
            dataTable: [
                {
                    id: 1,
                    name: '1 пара',
                    state: 'Экономика и науч деятельность',
                    city: 'Диогенов И.И.',
                    address: 319,
                },
                {
                    name: 'Spike',
                    state: 'California',
                    city: 'San Francisco',
                    address: '3650 21st St, San Francisco',
                    zip: 'CA 94114',
                },
                {
                    name: 'Tyke',
                    state: 'California',
                    city: 'San Francisco',
                    address: '3650 21st St, San Francisco',
                    zip: 'CA 94114',
                },
            ]
        }
    },
    methods: {
        open(id) {
            this.dialogTableVisible = true;
        },
        addColumn() {
            if(this.dataTable.length !== 6)
                this.dataTable.push({
                    name: null,
                    state: null,
                    city: null,
                    address: null,
                    zip: null,
                });
        },
        deleteColumn(index) {
            this.dataTable.splice(index, 1);
        }
    }
}
</script>

<style scoped>

</style>
