<template>
    <el-dialog
        v-model="dialogVisible"
        title="Добавить преподавателя"
        width="30%"
        close-on-press-escape
        @close="onClose"
    >
        <el-row>
            <el-col :span="10">
               <span class="text_content_model">Фамилия и инициалы преподавателя</span>
            </el-col>
            <el-col :span="14">
                <el-input v-model="modal.name"
                          size="large"
                          title="Введите имя преподавателя, которое будет отображаться"
                          placeholder="Введите" />
            </el-col>
        </el-row>
        <el-row style="margin-top: 20px">
            <el-col :span="10">
                <span class="text_content_model">Почта</span>
            </el-col>
            <el-col :span="14">
                <el-input v-model="modal.email"
                          type="email"
                          size="large"
                          title="Придумайте логин"
                          placeholder="Введите" />
            </el-col>
        </el-row>
        <el-row style="margin-top: 20px">
            <el-col :span="10">
                <span class="text_content_model">Пароль</span>
            </el-col>
            <el-col :span="14">
                <el-input v-model="modal.password"
                          size="large"
                          type="password"
                          title="Придумайте пароль"
                          placeholder="Введите" />
            </el-col>
        </el-row>
        <el-row style="margin-top: 20px">
            <el-col :span="10">
                <span class="text_content_model">Группа</span>
            </el-col>
            <el-col :span="14">
                <el-table :data="modal.groups"
                          height="140">
                    <el-table-column prop="name" label="Группа" />
                    <el-table-column prop="date" width="80" label="Удалить" >
                        <template #default="scope">
                            <el-button type="danger"
                                       @click="removeGroup(scope.$index)"
                                       size="small"><el-icon><Close /></el-icon></el-button>
                        </template>
                    </el-table-column>
                </el-table>
                <div class="d-flex mt-3">
                    <el-input v-model="nameGroup"
                              title="Привяжите группу к преподавателю"
                              placeholder="Введите" />
                    <el-button style="margin-left: 20px"
                               @click="addGroup"
                               type="success">Добавить</el-button>
                </div>
            </el-col>
        </el-row>


        <template #footer>
      <span class="dialog-footer">
        <el-button @click="dialogVisible = false">Cancel</el-button>
        <el-button type="success"
                   @click="addTeacher">
          Сохранить
        </el-button>
      </span>
        </template>
    </el-dialog>
</template>

<script>
export default {
    name: "TeachersCreateAndEditModal",
    data() {
        return {
            dialogVisible: false,
            modal: {
                name: '',
                email: '',
                password: '',
                groups: []
            },
            nameGroup: ''
        }
    },
    methods: {
        show(id) {
            this.dialogVisible = true;
        },
        removeGroup(index) {
            this.modal.groups.splice(index, 1);
        },
        addGroup() {
            this.modal.groups.push({'name': this.nameGroup});

            this.nameGroup = '';
        },
        addTeacher() {
            axios.post('/teachers/add-teacher', this.modal)
                .then((response) => {
                    if(response.data.status === 201)
                        this.$notify({
                            title: 'Успешно',
                            message: 'Преподаватель успешно добавлен!',
                            type: 'success',
                        })
                }).catch((response) => {

            })
            this.dialogVisible = false;
        },
        onClose() {
            this.modal.name = '';
            this.modal.groups = [];
            this.$emit('onUpdateTable');
        }
    }
}
</script>

<style scoped>
    .text_content_model {
        font-size: 17px;
    }
</style>
