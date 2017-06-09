<template>
  <select :name="name" :id="id" class="form-control">
    <optgroup v-for="producto_minimo in productos_minimos" :label="producto_minimo.nplan">
        <option v-for="tarea in producto_minimo.tareas" :value="tarea.ctarea"> {{ tarea.ntarea }} </option>
    </optgroup>
  </select>
</template>

<script>
export default {
  name: 'select-task',
  props: {
    name: {type : String,},
    id: {type : String,},
    productos_minimos: {type: Array,}
  },
  mounted (){this.$emit("mounted")}
}
</script>

<style>
</style>
