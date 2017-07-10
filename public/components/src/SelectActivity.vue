<template>
  <select :name="name" :id="id" :required="required" class="form-control">
    <option value=""> Seleccione una Actividad... </option>
      <template v-for="activity in activities">
          <option :value="activity.cactividad"> {{ activity.nactividad }} </option>
      </template>

  </select>
</template>

<script>
export default {
  name: 'select-activity',
  props: {
    name: {type : String,},
    id: {type : String,},
    required: {type : String,},
    activities: {type: Array,}
  },
  mounted (){this.$emit("mounted")}
}
</script>

<style>
</style>
