<template>
    <div>
        <div class="d-flex">
            <h1>Расписание</h1>
            <el-button
                style="margin: 7px 0px 7px 14px;"
                size="default"
                type="success">Добавить расписание<el-icon style="margin-left: 10px"><CirclePlus /></el-icon></el-button>
        </div>
        <el-row :gutter="20">
            <el-col :span="7">
                <div class="filter">
                    <span>Дата</span>

                    <el-date-picker
                        v-model="value2"
                        type="date"
                        value-format="YYYY-MM-DD"
                        placeholder="Выберите день"
                    />
                </div>
            </el-col>
            <el-col :span="6">
                <div class="filter">
                    <span>Группа</span>
                    <el-select v-model="input"
                               size="default"
                               filterable placeholder="Группа">
                        <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        />
                    </el-select>
                </div>
            </el-col>
            <el-col :span="4">
                <div class="filter">
                    <el-button type="success" style="margin-top: 28px;" size="default">Поиск</el-button>
                </div>
            </el-col>
        </el-row>


        <el-card class="box-card" style="margin-top: 40px">
            <el-table :data="tableData" border style="width: 100%" ref="tableDataSchedule">
                <el-table-column type="expand" label="Пары" width="70">
                    <template #default="props">
                        <div>
                            <el-table :data="props.row.family" border>
                                <el-table-column label="Пара" prop="name" width="80" />
                                <el-table-column label="Название пары" prop="state" />
                                <el-table-column label="Препод" width="160" prop="city"/>
                                <el-table-column label="Кабинет" width="120" prop="address"/>
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
                <el-table-column label="День недели" prop="name" />
                <el-table-column label="Группа" prop="name" />
                <el-table-column label="Действия">
                    <template #default="scope">
                        <el-button type="success"
                                   size="default"
                                   @click="showModalEdit(scope.row.id)">Редакитровать</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </el-card>

        <ScheduleEditModal ref="schedule_edit_modal" />

    </div>
</template>

<script>
import ScheduleEditModal from "@/user/admin/schedule/ScheduleEditModal.vue";

export default {
    name: "ScheduleComponent",
    components: { ScheduleEditModal },
    data() {
        return {
            input: null,
            value1: '',
            value2: '',
            options: [
                {
                    value: 'Option1',
                    label: 'Option1',
                },
                {
                    value: 'Option2',
                    label: 'Option2',
                },
                {
                    value: 'Option3',
                    label: 'Option3',
                },
                {
                    value: 'Option4',
                    label: 'Option4',
                },
                {
                    value: 'Option5',
                    label: 'Option5',
                },
            ],
            dialogTableVisible: false,
            tableData: [
                {
                    id: 1,
                    date: '2016-05-03',
                    name: 'Tom',
                    state: 'California',
                    city: 'San Francisco',
                    address: '3650 21st St, San Francisco',
                    zip: 'CA 94114',
                    family: [
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
                    ],
                },
                {
                    id: 2,
                    date: '2016-05-02',
                    name: 'Tom',
                    state: 'California',
                    city: 'San Francisco',
                    address: '3650 21st St, San Francisco',
                    zip: 'CA 94114',
                    family: [
                        {
                            name: 'Jerry',
                            state: 'California',
                            city: 'San Francisco',
                            address: '3650 21st St, San Francisco',
                            zip: 'CA 94114',
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
                    ],
                },
            ]
        }
    },
    watch: {
        value2(val) {
        }
    },
    methods: {
        showModalEdit(id) {
            this.$nextTick((response) => {
                this.$refs['schedule_edit_modal'].open(id);
            })
        },
        save() {

        },
        addColumn(index) {
            // console.log(index);
            this.tableData[index.$index].family.push({
                "name": "Tyke",
                "state": "California",
                "city": "San Francisco",
                "address": "3650 21st St, San Francisco",
                "zip": "CA 94114"
            });
            this.$refs['tableDataSchedule'].toggleRowExpansion(index, 'expand')


        }
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
