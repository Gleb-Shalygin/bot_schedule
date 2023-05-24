<template>
    <el-dialog v-model="dialogTableVisible" @close="onClose">
        <template #header>
            <div class="d-flex">
                <span>{{ isEditModal === true ? 'Редактировать расписание' : 'Новое расписание' }}</span>
                <el-select v-model="dataTable.id_group" filterable
                           :disabled="isEditModal"
                           title="При редактировании изменить группу нельзя"
                           style="margin-left: 5px"
                           placeholder="Группа">
                    <el-option
                        v-for="(group, index) in groups"
                        :key="index"
                        :label="group.name"
                        :value="group.id"
                    />
                </el-select>
                <el-select v-model="dataTable.id_call" filterable
                           title="При редактировании изменить день недели нельзя"
                           :disabled="isEditModal"
                           style="margin-left: 5px"
                           placeholder="День недели">
                    <el-option
                        v-for="(call, index) in calls"
                        :key="index"
                        :label="call.week_day"
                        :value="call.id"
                    />
                </el-select>
                <el-date-picker
                    v-model="dataTable.date"
                    :disabled="isEditModal"
                    title="При редактировании изменить дату нельзя"
                    type="date"
                    style="margin-left: 5px"
                    value-format="YYYY-MM-DD"
                    placeholder="Выберите день"
                />
            </div>
        </template>
        <el-table :data="dataTable.pairs"
                  v-loading="loading"
                  border>
            <el-table-column label="Пара" width="80" >
                <template #default="scope">
                    <el-input v-model="scope.row.pair" placeholder="Число"/>
                </template>
            </el-table-column>
            <el-table-column label="Название пары" prop="state">
                <template #default="scope">
                    <el-select v-model="scope.row.id_couples" filterable placeholder="Выбрать">
                        <el-option
                            v-for="(couple, index) in couples"
                            :key="index"
                            :label="couple.name"
                            :value="couple.id"
                        />
                    </el-select>
                </template>
            </el-table-column>
            <el-table-column label="Препод" width="160" >
                <template #default="scope">
                    <el-select v-model="scope.row.id_user" filterable placeholder="Выбрать">
                        <el-option
                            v-for="(teacher, index) in teachers"
                            :key="index"
                            :label="teacher.name"
                            :value="teacher.id"
                        />
                    </el-select>
                </template>
            </el-table-column>
            <el-table-column label="Кабинет" width="120" prop="address">
                <template #default="scope">
                    <el-input v-model="scope.row.office" placeholder="Число"/>
                </template>
            </el-table-column>
            <el-table-column label="Действия" width="100">
                <template #default="scope">
                    <div>
                        <el-button type="danger" size="default" @click="deleteColumn(scope.$index)"><el-icon><Delete /></el-icon></el-button>
                    </div>
                </template>
            </el-table-column>
        </el-table>
        <el-button type="success" style="margin-top: 10px;" @click="addColumn()" :disabled="isActiveAddColumn">Добавить колонку</el-button>
        <template #footer>
          <span class="dialog-footer">
            <el-button @click="dialogTableVisible = false">Отмена</el-button>
            <el-button type="success" :disabled="!dataTable.pairs" @click="createAndEditSchedule()">
                {{ isEditModal === true ? 'Сохранить изменения' : 'Создать расписание' }}
            </el-button>
          </span>
        </template>
    </el-dialog>
</template>

<script>
export default {
    name: "ScheduleEditModal",
    props: [ 'teachers', 'couples', 'calls', 'groups' ],
    data() {
        return {
            dialogTableVisible: false,
            dataTable: [],
            loading: false,
            isEditModal: false,
        }
    },
    computed: {
        isActiveAddColumn() {
            return !this.dataTable.id_group || !this.dataTable.id_call ||
                !this.dataTable.date || (this.dataTable.pairs && this.dataTable.pairs.length === 6);
        }
    },
    methods: {
        onClose() {
            this.isEditModal = false;
            this.dataTable = [];
            this.$emit('onCloseModal', [true]);
        },
        open(group, date) {
            this.dialogTableVisible = true;
            this.loading = true;

            // console.log(this.loading);
            if(group && date) {
                this.getDataById(group, date);
                this.isEditModal = true;
            }
        },
        addColumn() {
            if(!this.dataTable.pairs)
                this.dataTable.pairs = [];

            if(this.dataTable.pairs.length !== 6)
                this.dataTable.pairs.push({
                    name: null,
                    state: null,
                    city: null,
                    address: null,
                    zip: null,
                });
        },
        getDataById(group, date) {
            this.loading = true;

            axios.get('/schedule/get-data-table', {
                params: {group: group, date: date}
            }).then((response) => {
                    this.dataTable = response.data[0];
            }).catch((error) => {
                console.error(error);
            }).finally(() => {
                this.loading = false;
            })
        },
        createAndEditSchedule() {
            let error = false;
            let paramsValidate = [
                'id_couples',
                'id_user',
                'office',
                'pair'
            ];
            let arrayForQuery = [];
            let url = (this.isEditModal) ? 'edit-schedule' : 'create-schedule';

            for (let l = 0; l < this.dataTable.pairs.length; l++) {
                for (let i = 0; i < paramsValidate.length; i++) {
                    if(!this.dataTable.pairs[l][paramsValidate[i]]) {
                        this.$notify({
                            title: 'Ошибка',
                            message: 'Не все поля заполнены!',
                            type: 'error'
                        });
                        error = true;
                        break;
                    }
                }
                if(error)
                    break;

                arrayForQuery.push({
                    'id': (this.dataTable.pairs[l]['id']) ? this.dataTable.pairs[l]['id'] : null,
                    'id_couples': this.dataTable.pairs[l]['id_couples'],
                    'id_user': this.dataTable.pairs[l]['id_user'],
                    'office': this.dataTable.pairs[l]['office'],
                    'pair': this.dataTable.pairs[l]['pair'],
                    'date': this.dataTable['date'] + ' 00:00:00',
                    'id_group': this.dataTable['id_group'],
                    'id_call': this.dataTable['id_call'],
                });
            }

            axios.post('/schedule/' + url, arrayForQuery)
                .then((response) => {
                    if(response.data.status === 203)
                        this.$notify({
                            title: 'Успешно',
                            message: (this.isEditModal) ? 'Расписание успешно отредактировано!' : 'Расписание успешно добавлено!',
                            type: 'success',
                        })
                    this.dialogTableVisible = false;
                }).catch((error) => {
                    console.error(error);
            }).finally(() => {

            })
        },
        deleteColumn(index) {
            this.dataTable.pairs.splice(index, 1);
        }
    }
}
</script>

<style scoped>

</style>
