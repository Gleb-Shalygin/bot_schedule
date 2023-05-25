<template>
    <div>
        <div class="d-flex">
            <h1>Расписание</h1>
            <el-button
                style="margin: 7px 0px 7px 14px;"
                size="default"
                @click="showModalEdit()"
                type="success">Добавить расписание<el-icon style="margin-left: 10px"><CirclePlus /></el-icon></el-button>
        </div>
        <el-row :gutter="20">
            <el-col :span="6">
                <div class="filter">
                    <span>Дата</span>

                    <el-date-picker
                        v-model="currentDate"
                        type="date"
                        value-format="YYYY-MM-DD"
                        placeholder="Выберите день"
                    />
                </div>
            </el-col>
            <el-col :span="6">
                <div class="filter">
                    <span>Группа</span>
                    <el-select v-model="currentGroup"
                               size="default"
                               filterable placeholder="Группа">
                        <el-option
                            v-for="(group, index) in groups"
                            :key="index"
                            :label="group.name"
                            :value="group.id"
                        />
                    </el-select>
                </div>
            </el-col>
        </el-row>

        <el-card class="box-card" style="margin-top: 40px" v-show="isShowTable">
            <el-table :data="tableData" border style="width: 100%" ref="tableDataSchedule" v-loading="loading">
                <el-table-column type="expand" label="Пары" width="70">
                    <template #default="props">
                        <div>
                            <el-table :data="props.row.pairs" border>
                                <el-table-column label="Пара" prop="pair" width="80" />
                                <el-table-column label="Название пары" prop="predmet" />
                                <el-table-column label="Препод" width="160" prop="teacher_name"/>
                                <el-table-column label="Кабинет" width="120" prop="office"/>
                            </el-table>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column label="Дата" prop="date">
                    <template #default="scope">
                        <div style="display: flex; align-items: center">
                            <el-icon><timer /></el-icon>
                            <div class="custom_date_schedule_column">
                                {{ scope.row.date }}
                            </div>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column label="День недели" prop="week_day" />
                <el-table-column label="Группа" prop="group_name" />
                <el-table-column label="Действия">
                    <template #default="scope">
                        <el-button type="success"
                                   size="default"
                                   @click="showModalEdit(scope.row.id_group, scope.row.date)">Редактировать</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </el-card>

        <ScheduleEditModal ref="schedule_edit_modal"
                           :couples="couples"
                           :teachers="teachers"
                           :groups="groups"
                           :calls="calls"
                           @onCloseModal="onCloseModal"/>

    </div>
</template>

<script>
import ScheduleEditModal from "@/user/admin/schedule/ScheduleEditModal.vue";

export default {
    name: "ScheduleComponent",
    components: { ScheduleEditModal },
    data() {
        return {
            loading: false,
            currentDate: '',
            currentGroup: '',
            groups: [],
            couples: [],
            teachers: [],
            calls: [],
            dialogTableVisible: false,
            tableData: []
        }
    },
    watch: {
        currentDate(val) {
            if(this.isShowTable)
                this.getDataTable();
        },
        currentGroup(val) {
            if(this.isShowTable)
                this.getDataTable();
        }
    },
    computed: {
        isShowTable() {
            return this.currentDate && this.currentGroup;
        }
    },
    methods: {
        showModalEdit(group = null, date = null) {
            this.$nextTick((response) => {
                this.$refs['schedule_edit_modal'].open(group, date);
            })
        },
        onCloseModal(val) {
            if(this.isShowTable)
                this.getDataTable();
        },
        getDataTable() {
            this.loading = true;

            axios.get('/schedule/get-data-table', {
                params: {group: this.currentGroup, date: this.currentDate}
            }).then((response) => {
                    this.tableData = response.data;
                }).catch((error) => {
                    console.error(error);
                }).finally(() => {
                    this.loading = false;
                })
        },
        addColumn(index) {
            this.tableData[index.$index].family.push({
                "name": "Tyke",
                "state": "California",
                "city": "San Francisco",
                "address": "3650 21st St, San Francisco",
                "zip": "CA 94114"
            });
            this.$refs['tableDataSchedule'].toggleRowExpansion(index, 'expand')
        },
        getBasicData() {
            axios.get('/get-basic-data')
                .then((response) => {
                    this.groups = response.data.groups;
                    this.couples = response.data.couples;
                    this.teachers = response.data.teachers;
                    this.calls = response.data.calls;
                }).catch((error) => {
                    console.log(error);
            }).finally(() => {

            })
        }
    },
    mounted() {
        this.getBasicData();
    }
}
</script>

<style scoped lang="scss">
.filter {
    display: grid;
    font-size: 19px;
}

.custom_date {
    font-size: 18px;
    margin-left: 10px;
    background-color: #1abc9c;
    color: white;
    font-weight: 700;
    padding: 5px 15px;
    border-radius: 5px;
}

.card_schedule {
    margin-top: 10px
}

.custom_card_schedule {
    flex: 1 0 25%;
    width: 300px;
    margin-right: 30px;
    min-width: 100px;
}

.main_content_for_card_schedule {
    display:flex;
    flex-wrap: wrap;
    width: 100%;
}

.custom_date_schedule_column {
    margin-left: 5px;
    background-color: rgb(26, 188, 156);
    padding: 5px 10px;
    color: white;
    font-weight: 800;
    border-radius: var(--el-border-radius-base);
}
/*.custom_nedelya {*/
/*    background-color: #2c3e50;*/
/*    color: white;*/
/*    padding: 20px 10px;*/
/*    width: 35%;*/
/*    border-radius: 10px;*/
/*}*/
</style>
