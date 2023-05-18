<template>
    <div>
<!--        <h1>Расписание</h1>-->
        <div class="d-flex">
            <h1>Расписание</h1>
            <el-button
                style="margin: 7px 0px 7px 14px;"
                size="large"
                type="success">Добавить расписание<el-icon style="margin-left: 10px"><CirclePlus /></el-icon></el-button>
        </div>
        <el-row :gutter="20">
            <el-col :span="7">
                <div class="filter">
                    <span>Дата</span>
<!--                    <el-date-picker-->
<!--                        v-model="value1"-->
<!--                        type="daterange"-->
<!--                        range-separator="To"-->
<!--                        start-placeholder="Начало"-->
<!--                        end-placeholder="Конец"-->
<!--                        size="default"-->
<!--                    />-->
                    <el-date-picker
                        v-model="value2"
                        type="week"
                        format="[Неделя] ww"
                        placeholder="Неделя"
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
        <div style="margin-top: 40px">
            <el-card class="box-card">
                <div class="main_content_for_card_schedule">
                    <el-card class="box-card custom_card_schedule" style="margin-bottom: 10px" v-for="item in 5">
                        <div>
                            <div class="d-flex custom_nedelya">
                                <h4>Первый четверг</h4>
                                <div class="custom_date">
                                    15.05.2023
                                </div>
                            </div>
                            <hr>
                            <div v-for="item in 6">
                                <div class="d-flex">
                                    <span>Пара: </span>
                                    <el-input v-model="input"
                                              style="width: 7%; margin-left: 10px;"
                                              placeholder="Число" />
                                </div>
                                <div class="d-flex card_schedule">
                                    <span>Название пары: </span>
                                    <el-select v-model="value1" style="margin-left: 10px;" filterable placeholder="Название">
                                        <el-option
                                            v-for="item in options"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value"
                                        />
                                    </el-select>
                                </div>
                                <div class="d-flex card_schedule">
                                    <span>Препод: </span>
                                    <el-select v-model="value1" style="margin-left: 10px;" filterable placeholder="Фамилия">
                                        <el-option
                                            v-for="item in options"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value"
                                        />
                                    </el-select>
                                </div>
                                <div class="d-flex card_schedule">
                                    <span>Кабинет: </span>
                                    <el-input v-model="input"
                                              size="default"
                                              style="width: 7%; margin-left: 10px;"
                                              placeholder="Число" />

                                </div>
                                <hr>
                            </div>
                            <div style="margin-left: auto">
                                <el-button type="danger" style="margin-left: auto"
                                           size="default"
                                           @click="save()">Удалить</el-button>
                                <el-button type="success"
                                           size="default"
                                           @click="save()">Сохранить</el-button>
                            </div>
                        </div>
                    </el-card>
                </div>
                <el-button type="success"
                           size="default"
                           @click="save()">Сохранить все изменения</el-button>
            </el-card>
        </div>
    </div>
</template>

<script>
export default {
    name: "ScheduleComponent",
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
            ]
        }
    },
    watch: {
        value2(val) {
            console.log(val);
        }
    },
    methods: {
        save() {

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


/*.custom_nedelya {*/
/*    background-color: #2c3e50;*/
/*    color: white;*/
/*    padding: 20px 10px;*/
/*    width: 35%;*/
/*    border-radius: 10px;*/
/*}*/
</style>
