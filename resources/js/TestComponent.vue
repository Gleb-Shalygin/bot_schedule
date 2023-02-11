<template>
    <h1>Hello component</h1>
    <el-input placeholder="Please input" v-model="input"></el-input>
</template>

<script>
export default {
    name: "TestComponent",
    data() {
        return {
            input: ''
        }
    }
}
</script>
