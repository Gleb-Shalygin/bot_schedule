<template>
    <el-dialog
        v-model="dialogVisible"
        title="Tips"
        width="30%"
    >
        <span>This is a message</span>
        <template #footer>
      <span class="dialog-footer">
        <el-button @click="dialogVisible = false">Cancel</el-button>
        <el-button type="primary" @click="dialogVisible = false">
          Confirm
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
            dialogVisible: false
        }
    },
    methods: {
        show(id) {
            console.log(id);
            this.dialogVisible = true;
        }
    }
}
</script>

<style scoped>

</style>
